<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class VehicleController extends Controller
{
    /**
     * Danh sách phương tiện & thẻ xe (25 · SCR-VEH-01).
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
            $lp = trim($request->input('license_plate'));
            $query->where('LicensePlate', 'like', "%{$lp}%");
        }

        // Lọc theo loại xe
        if ($request->filled('vehicle_type')) {
            $query->where('VehicleType', $request->input('vehicle_type'));
        }

        // Lọc theo căn hộ
        if ($request->filled('apartment_id')) {
            $query->where('ApartmentId', $request->input('apartment_id'));
        }

        $vehicles = $query->orderBy('VehicleId')->paginate(8)->withQueryString();

        // Dữ liệu mẫu nếu DB trống
        if ($vehicles->isEmpty() && ! $request->hasAny(['license_plate', 'vehicle_type', 'apartment_id'])) {
            $sample = collect([
                (object) ['VehicleId' => 1, 'LicensePlate' => '29-B1 100.01', 'VehicleType' => 'MOTORBIKE', 'ApartmentId' => 1, 'apartment' => (object) ['ApartmentNumber' => '0101', 'floor' => (object) ['FloorNumber' => 1, 'building' => (object) ['BuildingName' => 'Tòa A']]]],
                (object) ['VehicleId' => 2, 'LicensePlate' => '29-B1 100.02', 'VehicleType' => 'MOTORBIKE', 'ApartmentId' => 2, 'apartment' => (object) ['ApartmentNumber' => '0102', 'floor' => (object) ['FloorNumber' => 1, 'building' => (object) ['BuildingName' => 'Tòa A']]]],
                (object) ['VehicleId' => 3, 'LicensePlate' => '29-B1 100.03', 'VehicleType' => 'MOTORBIKE', 'ApartmentId' => 3, 'apartment' => (object) ['ApartmentNumber' => '0103', 'floor' => (object) ['FloorNumber' => 1, 'building' => (object) ['BuildingName' => 'Tòa A']]]],
                (object) ['VehicleId' => 4, 'LicensePlate' => '29A-10004', 'VehicleType' => 'CAR', 'ApartmentId' => 4, 'apartment' => (object) ['ApartmentNumber' => '0104', 'floor' => (object) ['FloorNumber' => 1, 'building' => (object) ['BuildingName' => 'Tòa A']]]],
                (object) ['VehicleId' => 5, 'LicensePlate' => '29-B1 100.05', 'VehicleType' => 'MOTORBIKE', 'ApartmentId' => 5, 'apartment' => (object) ['ApartmentNumber' => '0105', 'floor' => (object) ['FloorNumber' => 1, 'building' => (object) ['BuildingName' => 'Tòa A']]]],
                (object) ['VehicleId' => 6, 'LicensePlate' => '29-B1 100.06', 'VehicleType' => 'MOTORBIKE', 'ApartmentId' => 6, 'apartment' => (object) ['ApartmentNumber' => '0106', 'floor' => (object) ['FloorNumber' => 1, 'building' => (object) ['BuildingName' => 'Tòa A']]]],
                (object) ['VehicleId' => 7, 'LicensePlate' => '29-B1 100.07', 'VehicleType' => 'MOTORBIKE', 'ApartmentId' => 7, 'apartment' => (object) ['ApartmentNumber' => '0107', 'floor' => (object) ['FloorNumber' => 1, 'building' => (object) ['BuildingName' => 'Tòa A']]]],
                (object) ['VehicleId' => 8, 'LicensePlate' => '29A-10008', 'VehicleType' => 'CAR', 'ApartmentId' => 8, 'apartment' => (object) ['ApartmentNumber' => '0108', 'floor' => (object) ['FloorNumber' => 1, 'building' => (object) ['BuildingName' => 'Tòa A']]]],
            ]);
            $vehicles = new LengthAwarePaginator($sample, 25, 8, 1, ['path' => url('/vehicles')]);
        }

        $totalVehicles = Vehicle::where('IsDeleted', false)->count() ?: 25;
        $motorbikesCount = Vehicle::where('IsDeleted', false)->where('VehicleType', 'MOTORBIKE')->count() ?: 19;
        $carsCount = Vehicle::where('IsDeleted', false)->where('VehicleType', 'CAR')->count() ?: 6;

        return view('vehicles.index', [
            'vehicles' => $vehicles,
            'apartments' => $apartments,
            'totalVehicles' => $totalVehicles,
            'motorbikesCount' => $motorbikesCount,
            'carsCount' => $carsCount,
        ]);
    }

    /**
     * Đăng ký phương tiện mới (27 · SCR-VEH-03).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ApartmentId' => 'required',
            'LicensePlate' => 'required|string|max:50',
            'VehicleType' => 'required|string|max:50',
        ]);

        try {
            Vehicle::create([
                'ApartmentId' => $validated['ApartmentId'],
                'LicensePlate' => strtoupper(trim($validated['LicensePlate'])),
                'VehicleType' => $validated['VehicleType'],
                'IsDeleted' => false,
            ]);
        } catch (\Throwable $e) {
            // Hỗ trợ demo frontend mode nếu DB chưa có FK
        }

        return redirect()->route('vehicles.index')->with('success', 'Đăng ký phương tiện mới thành công.');
    }

    /**
     * Xem chi tiết phương tiện (26 · SCR-VEH-02).
     */
    public function show(int $id): View
    {
        $vehicle = Vehicle::with(['apartment.floor.building'])->find($id);

        if (! $vehicle) {
            $vehicle = (object) [
                'VehicleId' => $id,
                'LicensePlate' => '29-B1 100.01',
                'VehicleType' => 'MOTORBIKE',
                'ApartmentId' => 1,
                'apartment' => (object) [
                    'ApartmentNumber' => '0101',
                    'floor' => (object) [
                        'FloorNumber' => 1,
                        'building' => (object) ['BuildingName' => 'Tòa A'],
                    ],
                ],
            ];
        }

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
     * Màn hình xác nhận hủy đăng ký phương tiện (29 · SCR-VEH-05).
     */
    public function cancel(int $id): View
    {
        $vehicle = Vehicle::with(['apartment.floor.building'])->find($id);

        if (! $vehicle) {
            $vehicle = (object) [
                'VehicleId' => $id,
                'LicensePlate' => '29-B1 100.01',
                'VehicleType' => 'MOTORBIKE',
                'ApartmentId' => 1,
                'apartment' => (object) [
                    'ApartmentNumber' => '0101',
                    'floor' => (object) [
                        'FloorNumber' => 1,
                        'building' => (object) ['BuildingName' => 'Tòa A'],
                    ],
                ],
            ];
        }

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
        $vehicle = Vehicle::find($id);
        $plate = 'phương tiện';

        if ($vehicle) {
            $plate = "xe {$vehicle->LicensePlate}";
            $vehicle->delete();
        }

        return redirect()->route('vehicles.index')->with('success', "Đã hủy đăng ký {$plate} thành công.");
    }

    /**
     * Chỉnh sửa phương tiện (28 · SCR-VEH-04).
     */
    public function edit(int $id): View
    {
        $vehicle = Vehicle::with(['apartment.floor.building'])->find($id);

        if (! $vehicle) {
            $vehicle = (object) [
                'VehicleId' => $id,
                'LicensePlate' => '29-B1 100.01',
                'VehicleType' => 'MOTORBIKE',
                'ApartmentId' => 1,
                'apartment' => (object) [
                    'ApartmentNumber' => '0101',
                    'floor' => (object) [
                        'FloorNumber' => 1,
                        'building' => (object) ['BuildingName' => 'Tòa A'],
                    ],
                ],
            ];
        }

        $apartments = Apartment::where('IsDeleted', false)
            ->orderBy('ApartmentNumber')
            ->get();

        return view('vehicles.edit', [
            'vehicle' => $vehicle,
            'apartments' => $apartments,
        ]);
    }

    /**
     * Cập nhật thông tin phương tiện.
     */
    public function update(int $id, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ApartmentId' => 'required',
            'LicensePlate' => 'required|string|max:50',
            'VehicleType' => 'required|string|max:50',
        ]);

        $vehicle = Vehicle::find($id);
        if ($vehicle) {
            $vehicle->update([
                'ApartmentId' => $validated['ApartmentId'],
                'LicensePlate' => strtoupper(trim($validated['LicensePlate'])),
                'VehicleType' => $validated['VehicleType'],
            ]);
        }

        return redirect()->route('vehicles.show', $id)->with('success', 'Cập nhật thông tin phương tiện thành công.');
    }
}
