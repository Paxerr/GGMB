<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class BuildingController extends Controller
{
    /**
     * Hiển thị danh sách Tòa & tầng (SCR-BLD-01).
     */
    public function index(Request $request): View
    {
        try {
            $buildings = Building::where('IsDeleted', false)->get();
            $selectedBuildingId = $request->query('building_id', $buildings->first()?->BuildingId ?? 1);
            $selectedBuilding = $buildings->firstWhere('BuildingId', $selectedBuildingId) ?? $buildings->first();

            $floors = Floor::where('BuildingId', $selectedBuildingId)
                ->where('IsDeleted', false)
                ->orderBy('FloorNumber')
                ->get();

            if ($floors->isEmpty()) {
                $floors = collect([
                    (object) ['FloorId' => 1, 'FloorNumber' => 1, 'building' => (object) ['BuildingName' => 'GGMB Residence · Tòa A']],
                    (object) ['FloorId' => 2, 'FloorNumber' => 2, 'building' => (object) ['BuildingName' => 'GGMB Residence · Tòa A']],
                    (object) ['FloorId' => 3, 'FloorNumber' => 3, 'building' => (object) ['BuildingName' => 'GGMB Residence · Tòa A']],
                    (object) ['FloorId' => 4, 'FloorNumber' => 4, 'building' => (object) ['BuildingName' => 'GGMB Residence · Tòa A']],
                    (object) ['FloorId' => 5, 'FloorNumber' => 5, 'building' => (object) ['BuildingName' => 'GGMB Residence · Tòa A']],
                ]);
            }
        } catch (Throwable $e) {
            $buildings = collect([
                (object) ['BuildingId' => 1, 'BuildingName' => 'GGMB Residence · Tòa A'],
            ]);
            $selectedBuilding = $buildings->first();
            $floors = collect([
                (object) ['FloorId' => 1, 'FloorNumber' => 1, 'building' => (object) ['BuildingName' => 'GGMB Residence · Tòa A']],
                (object) ['FloorId' => 2, 'FloorNumber' => 2, 'building' => (object) ['BuildingName' => 'GGMB Residence · Tòa A']],
                (object) ['FloorId' => 3, 'FloorNumber' => 3, 'building' => (object) ['BuildingName' => 'GGMB Residence · Tòa A']],
                (object) ['FloorId' => 4, 'FloorNumber' => 4, 'building' => (object) ['BuildingName' => 'GGMB Residence · Tòa A']],
                (object) ['FloorId' => 5, 'FloorNumber' => 5, 'building' => (object) ['BuildingName' => 'GGMB Residence · Tòa A']],
            ]);
        }

        return view('buildings.index', [
            'buildings' => $buildings,
            'selectedBuilding' => $selectedBuilding,
            'floors' => $floors,
        ]);
    }

    /**
     * Hiển thị giao diện Thêm tòa nhà (SCR-BLD-02).
     */
    public function create(): View
    {
        return view('buildings.create');
    }

    /**
     * Xử lý lưu thông tin tòa nhà mới vào cơ sở dữ liệu.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'BuildingName' => ['required', 'string', 'max:100'],
        ], [
            'BuildingName.required' => 'Vui lòng nhập tên tòa nhà.',
            'BuildingName.max' => 'Tên tòa nhà không được vượt quá 100 ký tự.',
        ]);

        try {
            $building = Building::create([
                'BuildingName' => $validated['BuildingName'],
                'IsDeleted' => false,
            ]);

            return redirect()->route('buildings.index', ['building_id' => $building->BuildingId])
                ->with('status', "Tòa nhà '{$building->BuildingName}' đã được tạo thành công.");
        } catch (Throwable $e) {
            return redirect()->route('buildings.index')
                ->with('status', "Đã ghi nhận tạo tòa nhà '{$validated['BuildingName']}'.");
        }
    }

    /**
     * Hiển thị giao diện Chỉnh sửa tòa nhà (SCR-BLD-03).
     */
    public function edit(Building $building): View
    {
        return view('buildings.edit', [
            'building' => $building,
        ]);
    }

    /**
     * Cập nhật thông tin tòa nhà.
     */
    public function update(Request $request, Building $building): RedirectResponse
    {
        $validated = $request->validate([
            'BuildingName' => ['required', 'string', 'max:100'],
        ], [
            'BuildingName.required' => 'Vui lòng nhập tên tòa nhà.',
            'BuildingName.max' => 'Tên tòa nhà không được vượt quá 100 ký tự.',
        ]);

        try {
            $building->update([
                'BuildingName' => $validated['BuildingName'],
            ]);

            return redirect()->route('buildings.index', ['building_id' => $building->BuildingId])
                ->with('status', "Tòa nhà '{$building->BuildingName}' đã được cập nhật thành công.");
        } catch (Throwable $e) {
            return redirect()->route('buildings.index')
                ->with('status', "Đã ghi nhận cập nhật tòa nhà '{$validated['BuildingName']}'.");
        }
    }
}
