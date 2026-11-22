<?php

namespace App\Http\Controllers;

use App\DTOs\BuildingDTO;
use App\Http\Requests\Building\StoreBuildingRequest;
use App\Http\Requests\Building\UpdateBuildingRequest;
use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BuildingController extends Controller
{
    /**
     * Hiển thị danh sách Tòa & tầng (SCR-BLD-01).
     */
    public function index(Request $request): View
    {
        $buildings = Building::where('IsDeleted', false)->orderBy('BuildingId')->get();
        $selectedBuildingId = $request->query('building_id', $buildings->first()?->BuildingId);

        $selectedBuilding = $selectedBuildingId
            ? ($buildings->firstWhere('BuildingId', (int) $selectedBuildingId) ?? $buildings->first())
            : null;

        $floors = $selectedBuilding
            ? Floor::with('building')
                ->where('BuildingId', $selectedBuilding->BuildingId)
                ->where('IsDeleted', false)
                ->orderBy('FloorNumber')
                ->get()
            : collect([]);

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
    public function store(StoreBuildingRequest $request): RedirectResponse
    {
        $dto = BuildingDTO::fromRequest($request);

        $building = Building::create($dto->toModelArray());

        return redirect()->route('buildings.index', ['building_id' => $building->BuildingId])
            ->with('status', "Tòa nhà '{$building->BuildingName}' đã được tạo thành công.");
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
    public function update(UpdateBuildingRequest $request, Building $building): RedirectResponse
    {
        $dto = BuildingDTO::fromRequest($request);

        $building->update($dto->toModelArray());

        return redirect()->route('buildings.index', ['building_id' => $building->BuildingId])
            ->with('status', "Tòa nhà '{$building->BuildingName}' đã được cập nhật thành công.");
    }
}
