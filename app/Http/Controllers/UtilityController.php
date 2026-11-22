<?php

namespace App\Http\Controllers;

use App\DTOs\MeterReadingDTO;
use App\Exceptions\BusinessException;
use App\Http\Requests\Utility\CorrectMeterReadingRequest;
use App\Http\Requests\Utility\StoreFirstTimeReadingRequest;
use App\Models\Apartment;
use App\Models\MeterReading;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class UtilityController extends Controller
{
    /**
     * Sổ chỉ số điện nước (SCR-MTR-01).
     */
    public function index(Request $request): View
    {
        $apartments = Apartment::where('IsDeleted', false)
            ->orderBy('ApartmentNumber')
            ->get();

        $query = MeterReading::with(['apartment', 'feeType', 'recordedBy']);

        // Lọc theo loại phí (Điện / Nước)
        if ($request->filled('type') && $request->input('type') !== 'ALL') {
            $typeInput = trim((string) $request->input('type'));
            $query->whereHas('feeType', function ($q) use ($typeInput): void {
                $q->where('Name', 'like', "%{$typeInput}%")
                    ->orWhere('Code', 'like', "%{$typeInput}%");
            });
        }

        // Lọc theo Căn hộ
        if ($request->filled('apartment_id')) {
            $query->where('ApartmentId', (int) $request->input('apartment_id'));
        }

        // Lọc theo Kỳ ghi
        if ($request->filled('period')) {
            $query->where('BillingPeriod', trim((string) $request->input('period')));
        }

        $paginated = $query->orderByDesc('BillingPeriod')->orderBy('ApartmentId')->paginate(10)->withQueryString();

        $mappedItems = $paginated->getCollection()->map(function (MeterReading $mr) {
            $isElec = str_contains(strtolower($mr->feeType?->Name ?? ''), 'điện') || str_contains(strtoupper($mr->feeType?->Code ?? ''), 'ELEC');
            $unit = $isElec ? 'kWh' : 'm³';

            return (object) [
                'id' => $mr->MeterReadingId,
                'apartment' => $mr->apartment?->ApartmentNumber ?? '—',
                'type' => $mr->feeType?->Name ?? ($isElec ? 'Điện' : 'Nước'),
                'period' => $mr->BillingPeriod,
                'old_num' => (float) $mr->PreviousReading,
                'new_num' => (float) $mr->CurrentReading,
                'usage' => (float) $mr->Consumption,
                'recorder' => $mr->recordedBy ? "{$mr->recordedBy->UserId} · {$mr->recordedBy->UserName}" : 'Hệ thống',
                'unit' => $unit,
                'recorded_at' => $mr->RecordedAt ? $mr->RecordedAt->format('d/m/Y H:i') : '—',
            ];
        });

        $readings = new LengthAwarePaginator(
            $mappedItems,
            $paginated->total(),
            $paginated->perPage(),
            $paginated->currentPage(),
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        return view('utilities.index', [
            'readings' => $readings,
            'apartments' => $apartments,
        ]);
    }

    /**
     * Lưu đính chính chỉ số (SCR-MTR-04).
     */
    public function correct(CorrectMeterReadingRequest $request): RedirectResponse
    {
        $id = (int) $request->validated('MeterReadingId');
        $meterReading = MeterReading::findOrFail($id);

        $prev = (float) $request->validated('PreviousReading');
        $curr = (float) $request->validated('CurrentReading');

        if ($curr < $prev) {
            throw new BusinessException('Chỉ số mới không được nhỏ hơn chỉ số cũ.');
        }

        $meterReading->update([
            'PreviousReading' => $prev,
            'CurrentReading' => $curr,
            'Consumption' => $curr - $prev,
            'RecordedByUserId' => auth()->id() ?? $meterReading->RecordedByUserId,
            'RecordedAt' => now(),
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã đính chính chỉ số cho căn hộ {$meterReading->apartment?->ApartmentNumber} thành công.",
                'data' => $meterReading,
            ]);
        }

        return redirect()->route('utilities.index')
            ->with('success', "Đã đính chính chỉ số cho căn hộ {$meterReading->apartment?->ApartmentNumber} thành công.");
    }

    /**
     * Lưu nhập chỉ số lần đầu (SCR-MTR-05).
     */
    public function firstTime(StoreFirstTimeReadingRequest $request): RedirectResponse
    {
        $aptId = (int) $request->validated('ApartmentId');
        $feeTypeId = (int) $request->validated('FeeTypeId');
        $period = (string) $request->validated('BillingPeriod');

        $exists = MeterReading::where('ApartmentId', $aptId)
            ->where('FeeTypeId', $feeTypeId)
            ->where('BillingPeriod', $period)
            ->exists();

        if ($exists) {
            throw new BusinessException("Chỉ số kỳ {$period} của căn hộ này đã được ghi nhận trước đó.");
        }

        $dto = MeterReadingDTO::fromFirstTimeRequest($request, auth()->id() ?? 1);
        $reading = MeterReading::create($dto->toModelArray());

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Nhập chỉ số ban đầu thành công.',
                'data' => $reading,
            ]);
        }

        return redirect()->route('utilities.index')
            ->with('success', 'Nhập chỉ số ban đầu thành công.');
    }
}
