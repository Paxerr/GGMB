<?php

namespace App\Http\Controllers;

use App\DTOs\FeeRateDTO;
use App\DTOs\FeeTypeDTO;
use App\Http\Requests\FeeRate\StoreFeeRateRequest;
use App\Http\Requests\FeeRate\StoreFeeTypeRequest;
use App\Http\Requests\FeeRate\UpdateFeeTypeRequest;
use App\Models\FeeRate;
use App\Models\FeeType;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class FeeRateController extends Controller
{
    /**
     * Cấu hình biểu phí (SCR-FEE-01).
     */
    public function index(Request $request): View
    {
        $query = FeeType::with(['rates' => function ($q): void {
            $q->orderByDesc('EffectiveFrom')->orderByDesc('FeeRateId');
        }])->orderBy('FeeTypeId');

        if ($request->filled('status') && $request->input('status') !== 'ALL') {
            $isActive = $request->input('status') === 'ACTIVE';
            $query->where('IsActive', $isActive);
        }

        if ($request->filled('keyword')) {
            $kw = trim((string) $request->input('keyword'));
            $query->where(function ($q) use ($kw): void {
                $q->where('Name', 'like', "%{$kw}%")
                    ->orWhere('Code', 'like', "%{$kw}%");
            });
        }

        $feeTypes = $query->get();

        $feeRates = $feeTypes->map(function (FeeType $ft) {
            $latestRate = $ft->rates->first();

            $unit = match (strtoupper($ft->Code)) {
                'ELEC', 'DIEN' => 'kWh',
                'WATER', 'NUOC' => 'm³',
                'MGMT', 'QL' => 'm²/tháng',
                'PARK', 'XE' => 'xe/tháng',
                default => 'tháng',
            };

            return (object) [
                'id' => $ft->FeeTypeId,
                'rate_id' => $latestRate?->FeeRateId ?? $ft->FeeTypeId,
                'unit' => $unit,
                'name' => $ft->Name,
                'code' => $ft->Code,
                'description' => $ft->Description ?? 'Biểu phí dịch vụ',
                'status' => $ft->IsActive ? 'ACTIVE' : 'INACTIVE',
                'status_label' => $ft->IsActive ? 'Áp dụng' : 'Tạm dừng',
                'price' => $latestRate?->UnitPrice ?? 0,
                'effective_from' => $latestRate?->EffectiveFrom ? Carbon::parse($latestRate->EffectiveFrom)->format('d/m/Y') : '01/01/2025',
                'effective_to' => $latestRate?->EffectiveTo ? Carbon::parse($latestRate->EffectiveTo)->format('d/m/Y') : null,
            ];
        });

        return view('fee-rates.index', [
            'feeRates' => $feeRates,
        ]);
    }

    /**
     * Chi tiết loại phí và lịch sử đơn giá (SCR-FEE-02).
     */
    public function show(int $id): View
    {
        $feeType = FeeType::with(['rates' => function ($q): void {
            $q->orderByDesc('EffectiveFrom')->orderByDesc('FeeRateId');
        }])->findOrFail($id);

        $latestRate = $feeType->rates->first();

        $feeRate = (object) [
            'id' => $feeType->FeeTypeId,
            'name' => $feeType->Name,
            'code' => $feeType->Code,
            'description' => $feeType->Description ?? '',
            'status' => $feeType->IsActive ? 'ACTIVE' : 'INACTIVE',
            'status_label' => $feeType->IsActive ? 'Đang sử dụng' : 'Đã ngừng sử dụng',
            'price' => $latestRate?->UnitPrice ?? 0,
            'effective_from' => $latestRate?->EffectiveFrom ? Carbon::parse($latestRate->EffectiveFrom)->format('d/m/Y') : '01/01/2025',
            'effective_to' => $latestRate?->EffectiveTo ? Carbon::parse($latestRate->EffectiveTo)->format('d/m/Y') : null,
            'history' => $feeType->rates,
        ];

        return view('fee-rates.show', [
            'feeRate' => $feeRate,
        ]);
    }

    /**
     * Mở form thêm loại phí mới (SCR-FEE-03).
     */
    public function create(): View
    {
        return view('fee-rates.create');
    }

    /**
     * Lưu loại phí mới vào cơ sở dữ liệu.
     */
    public function store(StoreFeeTypeRequest $request): RedirectResponse
    {
        $dto = FeeTypeDTO::fromStoreRequest($request);

        $feeType = FeeType::create($dto->toModelArray());

        if ($dto->initialPrice !== null) {
            FeeRate::create([
                'FeeTypeId' => $feeType->FeeTypeId,
                'UnitPrice' => $dto->initialPrice,
                'EffectiveFrom' => now()->toDateString(),
                'EffectiveTo' => null,
                'CreatedAt' => now(),
            ]);
        }

        Cache::forget('cache_lookup_fee_types');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Thêm loại phí '{$feeType->Name}' thành công.",
                'data' => $feeType,
            ]);
        }

        return redirect()->route('fee-rates.index')
            ->with('success', "Thêm loại phí '{$feeType->Name}' thành công.");
    }

    /**
     * Chỉnh sửa loại phí (SCR-FEE-04).
     */
    public function edit(int $id): View
    {
        $feeType = FeeType::findOrFail($id);

        $feeRate = (object) [
            'id' => $feeType->FeeTypeId,
            'name' => $feeType->Name,
            'code' => $feeType->Code,
            'description' => $feeType->Description ?? '',
            'status' => $feeType->IsActive ? 'ACTIVE' : 'INACTIVE',
            'status_label' => $feeType->IsActive ? 'Đang sử dụng' : 'Đã ngừng',
        ];

        return view('fee-rates.edit', [
            'feeRate' => $feeRate,
        ]);
    }

    /**
     * Cập nhật thông tin loại phí.
     */
    public function update(int $id, UpdateFeeTypeRequest $request): RedirectResponse
    {
        $feeType = FeeType::findOrFail($id);

        $dto = FeeTypeDTO::fromUpdateRequest($request, $feeType->Code);
        $feeType->update($dto->toModelArray());

        Cache::forget('cache_lookup_fee_types');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Cập nhật thông tin loại phí '{$feeType->Name}' thành công.",
                'data' => $feeType,
            ]);
        }

        return redirect()->route('fee-rates.show', $id)
            ->with('success', "Cập nhật thông tin loại phí '{$feeType->Name}' thành công.");
    }

    /**
     * Màn hình Ngừng sử dụng loại phí (SCR-FEE-05).
     */
    public function deactivate(int $id): View
    {
        $feeType = FeeType::findOrFail($id);

        $feeRate = (object) [
            'id' => $feeType->FeeTypeId,
            'name' => $feeType->Name,
            'code' => $feeType->Code,
            'status' => $feeType->IsActive ? 'ACTIVE' : 'INACTIVE',
            'status_label' => $feeType->IsActive ? 'Đang sử dụng' : 'Đã ngừng',
        ];

        return view('fee-rates.deactivate', [
            'feeRate' => $feeRate,
        ]);
    }

    /**
     * Xác nhận ngừng sử dụng loại phí.
     */
    public function confirmDeactivate(int $id, Request $request): RedirectResponse
    {
        $feeType = FeeType::findOrFail($id);
        $feeType->update(['IsActive' => false]);

        Cache::forget('cache_lookup_fee_types');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã ngừng áp dụng loại phí '{$feeType->Name}'.",
                'data' => $feeType,
            ]);
        }

        return redirect()->route('fee-rates.index')
            ->with('success', "Đã ngừng áp dụng loại phí '{$feeType->Name}'.");
    }

    /**
     * Màn hình Kích hoạt lại loại phí (SCR-FEE-06).
     */
    public function activate(int $id): View
    {
        $feeType = FeeType::findOrFail($id);

        $feeRate = (object) [
            'id' => $feeType->FeeTypeId,
            'name' => $feeType->Name,
            'code' => $feeType->Code,
            'status' => $feeType->IsActive ? 'ACTIVE' : 'INACTIVE',
            'status_label' => $feeType->IsActive ? 'Đang sử dụng' : 'Đã ngừng',
        ];

        return view('fee-rates.activate', [
            'feeRate' => $feeRate,
        ]);
    }

    /**
     * Xác nhận kích hoạt lại loại phí.
     */
    public function confirmActivate(int $id, Request $request): RedirectResponse
    {
        $feeType = FeeType::findOrFail($id);
        $feeType->update(['IsActive' => true]);

        Cache::forget('cache_lookup_fee_types');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã kích hoạt áp dụng lại loại phí '{$feeType->Name}'.",
                'data' => $feeType,
            ]);
        }

        return redirect()->route('fee-rates.index')
            ->with('success', "Đã kích hoạt áp dụng lại loại phí '{$feeType->Name}'.");
    }

    /**
     * Màn hình Thêm đơn giá mới cho loại phí.
     */
    public function createRate(int $id): View
    {
        $feeType = FeeType::findOrFail($id);

        return view('fee-rates.rates-create', [
            'feeType' => $feeType,
        ]);
    }

    /**
     * Lưu đơn giá mới cho loại phí.
     */
    public function storeRate(int $id, StoreFeeRateRequest $request): RedirectResponse
    {
        $feeType = FeeType::findOrFail($id);

        $dto = FeeRateDTO::fromStoreRequest($request, $feeType->FeeTypeId);
        $rate = FeeRate::create($dto->toModelArray());

        Cache::forget('cache_lookup_fee_types');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã thêm đơn giá mới cho loại phí '{$feeType->Name}'.",
                'data' => $rate,
            ]);
        }

        return redirect()->route('fee-rates.index')
            ->with('success', "Đã thêm đơn giá mới cho loại phí '{$feeType->Name}'.");
    }
}
