<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class UtilityController extends Controller
{
    /**
     * Sổ chỉ số điện nước (30 · SCR-MTR-01).
     */
    public function index(Request $request): View
    {
        $apartments = Apartment::where('IsDeleted', false)
            ->orderBy('ApartmentNumber')
            ->get();

        // Dữ liệu mẫu chuẩn Figma (Ảnh 1 & 2)
        $sample = collect([
            (object) ['id' => 1, 'apartment' => '0101', 'type' => 'Điện', 'period' => '02/2026', 'old_num' => 103, 'new_num' => 142, 'usage' => 39, 'recorder' => '5 · tech01', 'unit' => 'kWh'],
            (object) ['id' => 2, 'apartment' => '0101', 'type' => 'Nước', 'period' => '02/2026', 'old_num' => 41, 'new_num' => 48, 'usage' => 7, 'recorder' => '5 · tech01', 'unit' => 'm³'],
            (object) ['id' => 3, 'apartment' => '0102', 'type' => 'Điện', 'period' => '02/2026', 'old_num' => 106, 'new_num' => 149, 'usage' => 43, 'recorder' => '5 · tech01', 'unit' => 'kWh'],
            (object) ['id' => 4, 'apartment' => '0102', 'type' => 'Nước', 'period' => '02/2026', 'old_num' => 42, 'new_num' => 51, 'usage' => 9, 'recorder' => '5 · tech01', 'unit' => 'm³'],
            (object) ['id' => 5, 'apartment' => '0103', 'type' => 'Điện', 'period' => '02/2026', 'old_num' => 109, 'new_num' => 156, 'usage' => 47, 'recorder' => '5 · tech01', 'unit' => 'kWh'],
            (object) ['id' => 6, 'apartment' => '0103', 'type' => 'Nước', 'period' => '02/2026', 'old_num' => 43, 'new_num' => 54, 'usage' => 11, 'recorder' => '5 · tech01', 'unit' => 'm³'],
            (object) ['id' => 7, 'apartment' => '0104', 'type' => 'Điện', 'period' => '02/2026', 'old_num' => 112, 'new_num' => 163, 'usage' => 51, 'recorder' => '5 · tech01', 'unit' => 'kWh'],
            (object) ['id' => 8, 'apartment' => '0104', 'type' => 'Nước', 'period' => '02/2026', 'old_num' => 44, 'new_num' => 57, 'usage' => 13, 'recorder' => '5 · tech01', 'unit' => 'm³'],
        ]);

        // Lọc theo loại nếu có
        if ($request->filled('type') && $request->input('type') !== 'ALL') {
            $type = $request->input('type');
            $sample = $sample->filter(fn ($item) => $item->type === $type);
        }

        $readings = new LengthAwarePaginator($sample, 60, 8, 1, ['path' => url('/utilities')]);

        return view('utilities.index', [
            'readings' => $readings,
            'apartments' => $apartments,
        ]);
    }

    /**
     * Lưu đính chính chỉ số (SCR-MTR-04).
     */
    public function correct(Request $request): RedirectResponse
    {
        return redirect()->route('utilities.index')->with('success', 'Đính chính chỉ số thành công.');
    }

    /**
     * Lưu nhập chỉ số lần đầu (SCR-MTR-05).
     */
    public function firstTime(Request $request): RedirectResponse
    {
        return redirect()->route('utilities.index')->with('success', 'Nhập chỉ số ban đầu thành công.');
    }
}
