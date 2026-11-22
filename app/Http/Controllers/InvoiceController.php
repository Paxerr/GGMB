<?php

namespace App\Http\Controllers;

use App\DTOs\InvoiceDTO;
use App\Exceptions\BusinessException;
use App\Http\Requests\Invoice\CancelInvoiceRequest;
use App\Http\Requests\Invoice\CollectInvoiceRequest;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Models\Apartment;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    /**
     * Quản lý hóa đơn (SCR-INV-01).
     */
    public function index(Request $request): View
    {
        $apartments = Apartment::where('IsDeleted', false)
            ->orderBy('ApartmentNumber')
            ->get();

        $query = Invoice::with(['apartment.floor.building', 'items.feeType', 'creator']);

        // Lọc theo trạng thái
        if ($request->filled('status') && $request->input('status') !== 'ALL') {
            $query->where('Status', $request->input('status'));
        }

        // Lọc theo căn hộ
        if ($request->filled('apartment_id')) {
            $query->where('ApartmentId', (int) $request->input('apartment_id'));
        }

        // Lọc theo kỳ
        if ($request->filled('period')) {
            $query->where('BillingPeriod', trim((string) $request->input('period')));
        }

        $paginated = $query->orderByDesc('BillingPeriod')->orderBy('InvoiceId')->paginate(10)->withQueryString();

        $mappedInvoices = $paginated->getCollection()->map(function (Invoice $inv) {
            $statusLabel = match ($inv->Status) {
                'PAID' => 'Đã thanh toán',
                'OVERDUE' => 'Quá hạn',
                'CANCELLED' => 'Đã hủy',
                default => 'Chờ thanh toán',
            };

            $items = $inv->items->map(function (InvoiceItem $item) {
                return [
                    'name' => $item->feeType?->Name ?? 'Dịch vụ',
                    'qty' => (float) $item->Quantity,
                    'price' => (float) $item->UnitPrice,
                    'total' => (float) $item->Amount,
                ];
            })->toArray();

            return (object) [
                'id' => $inv->InvoiceId,
                'apartment' => $inv->apartment?->ApartmentNumber ?? '—',
                'period' => $inv->BillingPeriod,
                'amount' => (float) $inv->TotalAmount,
                'due_date' => $inv->DueDate ? Carbon::parse($inv->DueDate)->format('d/m/Y') : '—',
                'status' => $inv->Status,
                'status_label' => $statusLabel,
                'items' => $items,
            ];
        });

        $invoices = new LengthAwarePaginator(
            $mappedInvoices,
            $paginated->total(),
            $paginated->perPage(),
            $paginated->currentPage(),
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        // Tính toán KPI thực tế từ MySQL
        $debtQuery = Invoice::whereIn('Status', ['PENDING', 'UNPAID', 'OVERDUE']);
        $debtCount = $debtQuery->count();
        $debtTotal = $debtQuery->sum('TotalAmount');

        $paidQuery = Invoice::where('Status', 'PAID');
        $paidCount = $paidQuery->count();
        $paidTotal = $paidQuery->sum('TotalAmount');

        $overdueQuery = Invoice::where('Status', 'OVERDUE');
        $overdueCount = $overdueQuery->count();
        $overdueTotal = $overdueQuery->sum('TotalAmount');

        return view('invoices.index', [
            'invoices' => $invoices,
            'apartments' => $apartments,
            'debtCount' => $debtCount,
            'debtTotal' => number_format($debtTotal, 0, ',', '.').' đ',
            'paidCount' => $paidCount,
            'paidTotal' => number_format($paidTotal, 0, ',', '.').' đ',
            'overdueCount' => $overdueCount,
            'overdueTotal' => number_format($overdueTotal, 0, ',', '.').' đ',
        ]);
    }

    /**
     * Xem & in hóa đơn A4 (SCR-INV-02).
     */
    public function show(int $id): View
    {
        $inv = Invoice::with(['apartment.floor.building', 'items.feeType', 'creator'])->findOrFail($id);

        $statusLabel = match ($inv->Status) {
            'PAID' => 'Đã thanh toán',
            'OVERDUE' => 'Quá hạn',
            'CANCELLED' => 'Đã hủy',
            default => 'Chờ thanh toán',
        };

        $items = $inv->items->map(function (InvoiceItem $item) {
            return [
                'name' => $item->feeType?->Name ?? 'Dịch vụ',
                'qty' => (float) $item->Quantity,
                'price' => (float) $item->UnitPrice,
                'total' => (float) $item->Amount,
            ];
        })->toArray();

        $invoice = (object) [
            'id' => $inv->InvoiceId,
            'apartment' => $inv->apartment?->ApartmentNumber ?? '—',
            'building' => $inv->apartment?->floor?->building?->BuildingName ?? 'Tòa A',
            'period' => $inv->BillingPeriod,
            'due_date' => $inv->DueDate ? Carbon::parse($inv->DueDate)->format('d/m/Y') : '—',
            'status' => $inv->Status,
            'status_label' => $statusLabel,
            'creator' => $inv->creator?->FullName ?? 'Ban quản lý',
            'items' => $items,
            'total_amount' => (float) $inv->TotalAmount,
        ];

        return view('invoices.show', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * Lập hóa đơn mới (SCR-INV-03).
     */
    public function store(StoreInvoiceRequest $request): RedirectResponse
    {
        $dto = InvoiceDTO::fromStoreRequest($request, auth()->id() ?? 1);

        // Kiểm tra trùng kỳ cho cùng căn hộ
        $exists = Invoice::where('ApartmentId', $dto->apartmentId)
            ->where('BillingPeriod', $dto->billingPeriod)
            ->where('Status', '!=', 'CANCELLED')
            ->exists();

        if ($exists) {
            throw new BusinessException("Căn hộ này đã có hóa đơn cho kỳ {$dto->billingPeriod}.");
        }

        $createdInvoice = null;
        DB::transaction(function () use ($dto, &$createdInvoice): void {
            $createdInvoice = Invoice::create($dto->toModelArray());

            foreach ($dto->items as $item) {
                InvoiceItem::create([
                    'InvoiceId' => $createdInvoice->InvoiceId,
                    'FeeTypeId' => $item['fee_type_id'],
                    'FeeRateId' => null,
                    'Quantity' => $item['quantity'],
                    'UnitPrice' => $item['unit_price'],
                    'Amount' => $item['amount'],
                ]);
            }
        });

        Cache::forget('dashboard_stats');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Lập hóa đơn mới thành công.',
                'data' => $createdInvoice,
            ]);
        }

        return redirect()->route('invoices.index')
            ->with('success', 'Lập hóa đơn mới thành công.');
    }

    /**
     * Thu tiền hóa đơn (SCR-INV-04).
     */
    public function collect(int $id, CollectInvoiceRequest $request): RedirectResponse
    {
        $invoice = Invoice::findOrFail($id);

        if ($invoice->Status === 'PAID') {
            throw new BusinessException('Hóa đơn này đã được thu tiền trước đó.');
        }

        if ($invoice->Status === 'CANCELLED') {
            throw new BusinessException('Không thể thu tiền hóa đơn đã bị hủy.');
        }

        $paymentType = (string) $request->validated('PaymentType');
        $normalizedPayment = in_array($paymentType, ['Tiền mặt', 'CASH'], true) ? 'CASH' : 'TRANSFER';

        $invoice->update([
            'Status' => 'PAID',
            'PaymentType' => $normalizedPayment,
            'PaidAt' => now(),
        ]);

        Cache::forget('dashboard_stats');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Xác nhận thu tiền hóa đơn #{$invoice->InvoiceId} thành công.",
                'data' => $invoice,
            ]);
        }

        return redirect()->route('invoices.index')
            ->with('success', "Xác nhận thu tiền hóa đơn #{$invoice->InvoiceId} thành công.");
    }

    /**
     * Hủy hóa đơn (SCR-INV-05).
     */
    public function cancel(int $id, CancelInvoiceRequest $request): RedirectResponse|JsonResponse
    {
        $invoice = Invoice::findOrFail($id);

        if ($invoice->Status === 'PAID') {
            throw new BusinessException('Không thể hủy hóa đơn đã thanh toán. Vui lòng lập phiếu hoàn tiền nếu cần.');
        }

        $invoice->update([
            'Status' => 'CANCELLED',
        ]);

        Cache::forget('dashboard_stats');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã hủy hóa đơn #{$invoice->InvoiceId} thành công.",
                'data' => $invoice,
            ]);
        }

        return redirect()->route('invoices.index')
            ->with('success', "Đã hủy hóa đơn #{$invoice->InvoiceId} thành công.");
    }
}
