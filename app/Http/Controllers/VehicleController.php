<?php

namespace App\Http\Controllers;

use App\DTOs\VehicleDTO;
use App\Exceptions\BusinessException;
use App\Http\Requests\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Vehicle\UpdateVehicleRequest;
use App\Models\Apartment;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleController extends Controller
{
    /**
     * Danh sách phương tiện & thẻ xe (SCR-VEH-01).
     */
    public function index(Request $request): View
    {
        $apartments = Apartment::where('IsDeleted', false)
            ->orderBy('ApartmentNumber')
            ->get();

        $query = Vehicle::with(['apartment.floor.building'])
            ->where('IsDeleted', false);

        // Lọc theo biển số xe
        if ($request->filled('license_plate')) {
            $lp = trim((string) $request->input('license_plate'));
            $query->where('LicensePlate', 'like', "%{$lp}%");
        }

        // Lọc theo loại xe
        if ($request->filled('vehicle_type')) {
            $vt = (string) $request->input('vehicle_type');
            $query->where('VehicleType', $vt);
        }

        // Lọc theo căn hộ
        if ($request->filled('apartment_id')) {
            $query->where('ApartmentId', (int) $request->input('apartment_id'));
        }

        $vehicles = $query->orderBy('VehicleId')->paginate(10)->withQueryString();

        $vehiclesMap = $vehicles->getCollection()->mapWithKeys(function (Vehicle $v) {
            $typeName = match ($v->VehicleType ?? '') {
                'CAR' => 'Ô tô',
                'ELECTRIC_BIKE' => 'Xe máy điện',
                'BICYCLE' => 'Xe đạp',
                default => 'Xe máy',
            };

            return [$v->VehicleId => [
                'vehicleId' => $v->VehicleId,
                'licensePlate' => $v->LicensePlate,
                'vehicleType' => $v->VehicleType,
                'typeName' => $typeName,
                'apartmentId' => $v->ApartmentId,
                'apartmentNumber' => $v->apartment?->ApartmentNumber ?? '—',
                'buildingName' => $v->apartment?->floor?->building?->BuildingName ?? 'Tòa A',
                'floorNumber' => $v->apartment?->floor?->FloorNumber ?? 1,
            ]];
        })->toArray();

        $totalVehicles = Vehicle::where('IsDeleted', false)->count();
        $motorbikesCount = Vehicle::where('IsDeleted', false)->where('VehicleType', 'MOTORBIKE')->count();
        $carsCount = Vehicle::where('IsDeleted', false)->where('VehicleType', 'CAR')->count();

        return view('vehicles.index', [
            'vehicles' => $vehicles,
            'vehiclesMap' => $vehiclesMap,
            'apartments' => $apartments,
            'totalVehicles' => $totalVehicles,
            'motorbikesCount' => $motorbikesCount,
            'carsCount' => $carsCount,
        ]);
    }

    /**
     * Đăng ký phương tiện mới (SCR-VEH-03).
     */
    public function store(StoreVehicleRequest $request): RedirectResponse
    {
        $dto = VehicleDTO::fromStoreRequest($request);

        // Quy tắc nghiệp vụ: Kiểm tra trùng biển số xe
        $exists = Vehicle::where('LicensePlate', $dto->licensePlate)
            ->where('IsDeleted', false)
            ->exists();

        if ($exists) {
            throw new BusinessException("Biển số xe '{$dto->licensePlate}' đã tồn tại trong danh sách đăng ký của tòa nhà.");
        }

        $vehicle = Vehicle::create($dto->toModelArray());

        return redirect()->route('vehicles.index')
            ->with('success', "Đăng ký phương tiện biển số {$vehicle->LicensePlate} thành công.");
    }

    /**
     * Xem chi tiết phương tiện (SCR-VEH-02).
     */
    public function show(int $id): View
    {
        $vehicle = Vehicle::with(['apartment.floor.building'])
            ->where('IsDeleted', false)
            ->findOrFail($id);

        $typeName = match ($vehicle->VehicleType ?? '') {
            'CAR' => 'Xe ô tô',
            'ELECTRIC_BIKE' => 'Xe máy điện',
            'BICYCLE' => 'Xe đạp',
            default => 'Xe máy',
        };

        $aptNum = $vehicle->apartment?->ApartmentNumber ?? ('010'.($vehicle->ApartmentId ?? '1'));
        $floorNum = $vehicle->apartment?->floor?->FloorNumber ?? '1';
        $bldgName = $vehicle->apartment?->floor?->building?->BuildingName ?? 'Tòa A';
        $buildingText = "{$bldgName} · Tầng {$floorNum} · {$aptNum}";

        return view('vehicles.show', [
            'vehicle' => $vehicle,
            'typeName' => $typeName,
            'buildingText' => $buildingText,
            'apartmentNumber' => $aptNum,
        ]);
    }

    /**
     * Chỉnh sửa phương tiện (SCR-VEH-04).
     */
    public function edit(int $id): View
    {
        $vehicle = Vehicle::with(['apartment.floor.building'])
            ->where('IsDeleted', false)
            ->findOrFail($id);

        $apartments = Apartment::where('IsDeleted', false)
            ->orderBy('ApartmentNumber')
            ->get();

        return view('vehicles.edit', [
            'vehicle' => $vehicle,
            'apartments' => $apartments,
        ]);
    }

    /**
     * Cập nhật thông tin phương tiện (SCR-VEH-04).
     */
    public function update(UpdateVehicleRequest $request, int $id): RedirectResponse
    {
        $vehicle = Vehicle::where('IsDeleted', false)->findOrFail($id);

        $dto = VehicleDTO::fromUpdateRequest($request);

        // Quy tắc nghiệp vụ: Không trùng biển số với xe khác
        $exists = Vehicle::where('LicensePlate', $dto->licensePlate)
            ->where('IsDeleted', false)
            ->where('VehicleId', '!=', $vehicle->VehicleId)
            ->exists();

        if ($exists) {
            throw new BusinessException("Biển số xe '{$dto->licensePlate}' đã được đăng ký cho một phương tiện khác.");
        }

        $vehicle->update($dto->toModelArray());

        return redirect()->route('vehicles.index')
            ->with('success', "Cập nhật thông tin phương tiện biển số {$vehicle->LicensePlate} thành công.");
    }

    /**
     * Màn hình xác nhận hủy đăng ký phương tiện (SCR-VEH-05).
     */
    public function cancel(int $id): View
    {
        $vehicle = Vehicle::with(['apartment.floor.building'])
            ->where('IsDeleted', false)
            ->findOrFail($id);

        $typeName = match ($vehicle->VehicleType ?? '') {
            'CAR' => 'Xe ô tô',
            'ELECTRIC_BIKE' => 'Xe máy điện',
            'BICYCLE' => 'Xe đạp',
            default => 'Xe máy',
        };

        $aptNum = $vehicle->apartment?->ApartmentNumber ?? ('010'.($vehicle->ApartmentId ?? '1'));
        $floorNum = $vehicle->apartment?->floor?->FloorNumber ?? '1';
        $bldgName = $vehicle->apartment?->floor?->building?->BuildingName ?? 'Tòa A';
        $buildingText = "{$bldgName} · Tầng {$floorNum} · {$aptNum}";

        return view('vehicles.cancel', [
            'vehicle' => $vehicle,
            'typeName' => $typeName,
            'buildingText' => $buildingText,
            'apartmentNumber' => $aptNum,
        ]);
    }

    /**
     * Thực hiện hủy đăng ký phương tiện (Soft delete).
     */
    public function confirmCancel(int $id, Request $request): RedirectResponse
    {
        $vehicle = Vehicle::where('IsDeleted', false)->findOrFail($id);
        $plate = $vehicle->LicensePlate;

        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', "Đã hủy đăng ký phương tiện biển số {$plate} thành công.");
    }
}
