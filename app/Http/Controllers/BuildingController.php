<?php

namespace App\Http\Controllers;

use App\DTOs\BuildingDTO;
use App\Exceptions\BusinessException;
use App\Http\Requests\Building\StoreBuildingRequest;
use App\Http\Requests\Building\UpdateBuildingRequest;
use App\Models\Apartment;
use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class BuildingController extends Controller
{
    /**
     * Hiển thị danh sách Tòa & tầng (SCR-BLD-01).
     */
    public function index(Request $request): View
    {
        $buildings = Cache::remember('cache_lookup_buildings', 3600, fn () => Building::where('IsDeleted', false)->orderBy('BuildingId')->get());
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
    public function store(StoreBuildingRequest $request): RedirectResponse|JsonResponse
    {
        $dto = BuildingDTO::fromRequest($request);

        $building = Building::create($dto->toModelArray());

        Cache::forget('cache_lookup_buildings');
        Cache::forget('dashboard_stats');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Tòa nhà '{$building->BuildingName}' đã được tạo thành công.",
                'data' => $building,
            ]);
        }

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
    public function update(UpdateBuildingRequest $request, Building $building): RedirectResponse|JsonResponse
    {
        $dto = BuildingDTO::fromRequest($request);

        $building->update($dto->toModelArray());

        Cache::forget('cache_lookup_buildings');
        Cache::forget('dashboard_stats');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Tòa nhà '{$building->BuildingName}' đã được cập nhật thành công.",
                'data' => $building,
            ]);
        }

        return redirect()->route('buildings.index', ['building_id' => $building->BuildingId])
            ->with('status', "Tòa nhà '{$building->BuildingName}' đã được cập nhật thành công.");
    }

    /**
     * Xóa tòa nhà (SCR-BLD-04).
     */
    public function destroy(Building $building): RedirectResponse|JsonResponse
    {
        $hasApartments = Apartment::whereHas('floor', function ($q) use ($building): void {
            $q->where('BuildingId', $building->BuildingId)->where('IsDeleted', false);
        })->where('IsDeleted', false)->exists();

        if ($hasApartments) {
            throw new BusinessException("Không thể xóa tòa nhà '{$building->BuildingName}': Vẫn còn căn hộ trực thuộc.");
        }

        $name = $building->BuildingName;
        $building->delete();

        Cache::forget('cache_lookup_buildings');
        Cache::forget('dashboard_stats');

        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã xóa tòa nhà '{$name}' thành công.",
            ]);
        }

        return redirect()->route('buildings.index')
            ->with('status', "Đã xóa tòa nhà '{$name}' thành công.");
    }

    /**
     * Thêm tầng mới cho tòa nhà.
     */
    public function storeFloor(Request $request, Building $building): RedirectResponse|JsonResponse
    {
        $floorNumber = (int) $request->input('floor_number', $request->input('FloorNumber'));
        if ($floorNumber <= 0) {
            throw new BusinessException('Số tầng không hợp lệ.');
        }

        $exists = Floor::where('BuildingId', $building->BuildingId)
            ->where('FloorNumber', $floorNumber)
            ->where('IsDeleted', false)
            ->exists();

        if ($exists) {
            throw new BusinessException("Tầng {$floorNumber} đã tồn tại trong tòa {$building->BuildingName}.");
        }

        $floor = Floor::create([
            'BuildingId' => $building->BuildingId,
            'FloorNumber' => $floorNumber,
            'IsDeleted' => false,
        ]);

        Cache::forget('cache_lookup_buildings');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã thêm Tầng {$floorNumber} vào tòa {$building->BuildingName} thành công.",
                'data' => $floor,
            ]);
        }

        return redirect()->route('buildings.index', ['building_id' => $building->BuildingId])
            ->with('status', "Đã thêm Tầng {$floorNumber} vào tòa {$building->BuildingName} thành công.");
    }

    /**
     * Cập nhật thông tin tầng.
     */
    public function updateFloor(Request $request, Floor $floor): RedirectResponse|JsonResponse
    {
        $floorNumber = (int) $request->input('floor_number', $request->input('FloorNumber'));
        if ($floorNumber <= 0) {
            throw new BusinessException('Số tầng không hợp lệ.');
        }

        $exists = Floor::where('BuildingId', $floor->BuildingId)
            ->where('FloorNumber', $floorNumber)
            ->where('FloorId', '!=', $floor->FloorId)
            ->where('IsDeleted', false)
            ->exists();

        if ($exists) {
            throw new BusinessException("Tầng {$floorNumber} đã tồn tại trong tòa nhà này.");
        }

        $floor->update(['FloorNumber' => $floorNumber]);

        Cache::forget('cache_lookup_buildings');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã cập nhật Tầng {$floorNumber} thành công.",
                'data' => $floor,
            ]);
        }

        return redirect()->route('buildings.index', ['building_id' => $floor->BuildingId])
            ->with('status', "Đã cập nhật Tầng {$floorNumber} thành công.");
    }

    /**
     * Xóa tầng.
     */
    public function destroyFloor(Floor $floor): RedirectResponse|JsonResponse
    {
        $hasApartments = Apartment::where('FloorId', $floor->FloorId)
            ->where('IsDeleted', false)
            ->exists();

        if ($hasApartments) {
            throw new BusinessException("Không thể xóa Tầng {$floor->FloorNumber}: Vẫn còn căn hộ trên tầng này.");
        }

        $bldId = $floor->BuildingId;
        $num = $floor->FloorNumber;
        $floor->delete();

        Cache::forget('cache_lookup_buildings');

        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã xóa Tầng {$num} thành công.",
            ]);
        }

        return redirect()->route('buildings.index', ['building_id' => $bldId])
            ->with('status', "Đã xóa Tầng {$num} thành công.");
    }
}
