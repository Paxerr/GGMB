<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    /**
     * Quản lý hóa đơn (33 · SCR-INV-01).
     */
    public function index(Request $request): View
    {
        $apartments = Apartment::where('IsDeleted', false)
            ->orderBy('ApartmentNumber')
            ->get();

        $sample = collect([
            (object) [
                'id' => 1,
                'apartment' => '0101',
                'period' => '01/2026',
                'amount' => 842500,
                'due_date' => '10/02/2026',
                'status' => 'PENDING',
                'status_label' => 'Chờ thanh toán',
                'items' => [
                    ['name' => 'Điện (kWh)', 'qty' => 35, 'price' => 3500, 'total' => 122500],
                    ['name' => 'Phí quản lý (m²)', 'qty' => 60, 'price' => 12000, 'total' => 720000],
                ],
            ],
            (object) [
                'id' => 2,
                'apartment' => '0102',
                'period' => '01/2026',
                'amount' => 860000,
                'due_date' => '10/02/2026',
                'status' => 'PENDING',
                'status_label' => 'Chờ thanh toán',
                'items' => [
                    ['name' => 'Điện (kWh)', 'qty' => 40, 'price' => 3500, 'total' => 140000],
                    ['name' => 'Phí quản lý (m²)', 'qty' => 60, 'price' => 12000, 'total' => 720000],
                ],
            ],
            (object) [
                'id' => 3,
                'apartment' => '0103',
                'period' => '01/2026',
                'amount' => 877500,
                'due_date' => '10/02/2026',
                'status' => 'PENDING',
                'status_label' => 'Chờ thanh toán',
                'items' => [
                    ['name' => 'Điện (kWh)', 'qty' => 45, 'price' => 3500, 'total' => 157500],
                    ['name' => 'Phí quản lý (m²)', 'qty' => 60, 'price' => 12000, 'total' => 720000],
                ],
            ],
            (object) [
                'id' => 4,
                'apartment' => '0104',
                'period' => '01/2026',
                'amount' => 895000,
                'due_date' => '10/02/2026',
                'status' => 'PAID',
                'status_label' => 'Đã thanh toán',
                'items' => [
                    ['name' => 'Điện (kWh)', 'qty' => 50, 'price' => 3500, 'total' => 175000],
                    ['name' => 'Phí quản lý (m²)', 'qty' => 60, 'price' => 12000, 'total' => 720000],
                ],
            ],
            (object) [
                'id' => 5,
                'apartment' => '0105',
                'period' => '01/2026',
                'amount' => 912500,
                'due_date' => '10/02/2026',
                'status' => 'PENDING',
                'status_label' => 'Chờ thanh toán',
                'items' => [
                    ['name' => 'Điện (kWh)', 'qty' => 55, 'price' => 3500, 'total' => 192500],
                    ['name' => 'Phí quản lý (m²)', 'qty' => 60, 'price' => 12000, 'total' => 720000],
                ],
            ],
            (object) [
                'id' => 6,
                'apartment' => '0106',
                'period' => '01/2026',
                'amount' => 930000,
                'due_date' => '10/02/2026',
                'status' => 'PENDING',
                'status_label' => 'Chờ thanh toán',
                'items' => [
                    ['name' => 'Điện (kWh)', 'qty' => 60, 'price' => 3500, 'total' => 210000],
                    ['name' => 'Phí quản lý (m²)', 'qty' => 60, 'price' => 12000, 'total' => 720000],
                ],
            ],
        ]);

        $invoices = new LengthAwarePaginator($sample, 40, 6, 1, ['path' => url('/invoices')]);

        return view('invoices.index', [
            'invoices' => $invoices,
            'apartments' => $apartments,
            'debtCount' => 28,
            'debtTotal' => '24.920.000 đ',
            'paidCount' => 8,
            'paidTotal' => '6.880.000 đ',
            'overdueCount' => 5,
            'overdueTotal' => '4.457.500 đ',
        ]);
    }

    /**
     * Xem & in hóa đơn A4 (SCR-INV-02).
     */
    public function show(int $id): View
    {
        $invoice = (object) [
            'id' => $id,
            'apartment' => '0101',
            'building' => 'Tòa A',
            'period' => '01/2026',
            'due_date' => '10/02/2026',
            'status' => 'PENDING',
            'status_label' => 'Chờ thanh toán',
            'creator' => 'Nguyễn Minh Quản lý',
            'items' => [
                ['name' => 'Điện (kWh)', 'qty' => 35, 'price' => 3500, 'total' => 122500],
                ['name' => 'Phí quản lý (m²)', 'qty' => 60, 'price' => 12000, 'total' => 720000],
            ],
            'total_amount' => 842500,
        ];

        return view('invoices.show', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * Lập hóa đơn mới (SCR-INV-03).
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('invoices.index')->with('success', 'Lập hóa đơn mới thành công.');
    }

    /**
     * Thu tiền tại quầy (SCR-INV-04).
     */
    public function collect(int $id, Request $request): RedirectResponse
    {
        return redirect()->route('invoices.index')->with('success', "Đã xác nhận thu tiền cho hóa đơn #{$id} thành công.");
    }

    /**
     * Hủy hóa đơn (Bám sát Ảnh 1).
     */
    public function cancel(int $id, Request $request): RedirectResponse
    {
        return redirect()->route('invoices.index')->with('success', "Đã xác nhận hủy hóa đơn #{$id} thành công.");
    }
}
