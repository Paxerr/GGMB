<?php

namespace App\Http\Controllers;

use App\DTOs\ApartmentDTO;
use App\Exceptions\BusinessException;
use App\Http\Requests\Apartment\StoreApartmentRequest;
use App\Http\Requests\Apartment\UpdateApartmentRequest;
use App\Http\Requests\Apartment\UpdateApartmentStatusRequest;
use App\Models\Apartment;
use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ApartmentController extends Controller
{
    /**
     * Hiển thị danh sách Căn hộ (SCR-APT-01) kèm Drawer chi tiết và Modal thao tác.
     */
    public function index(Request $request): View
    {
        $buildings = Building::where('IsDeleted', false)->orderBy('BuildingId')->get();
        $floors = Floor::with('building')->where('IsDeleted', false)->orderBy('FloorNumber')->get();

        $query = Apartment::with([
            'floor.building',
            'residents.user',
            'vehicles',
            'meterReadings.feeType',
            'invoices',
        ])->where('IsDeleted', false);

        // Lọc theo Tòa nhà
        if ($request->filled('building_id')) {
            $buildingId = (int) $request->query('building_id');
            $query->whereHas('floor', function ($q) use ($buildingId): void {
                $q->where('BuildingId', $buildingId);
            });
        }

        // Lọc theo Tầng
        if ($request->filled('floor_id')) {
            $query->where('FloorId', (int) $request->query('floor_id'));
        }

        // Lọc theo Trạng thái
        if ($request->filled('status')) {
            $query->where('Status', (string) $request->query('status'));
        }

        // Lọc theo số căn hộ (từ khóa)
        if ($request->filled('keyword')) {
            $kw = trim((string) $request->query('keyword'));
            $query->where(function ($q) use ($kw): void {
                $q->where('ApartmentNumber', 'like', "%{$kw}%")
                    ->orWhere('Description', 'like', "%{$kw}%");
            });
        }

        $apartments = $query->orderBy('ApartmentNumber')->paginate(10)->withQueryString();

        // Xử lý nạp model khi giao diện yêu cầu mở Drawer/Modal
        $selectedApartment = null;
        if ($request->filled('selected_id')) {
            $selectedApartment = Apartment::with([
                'floor.building',
                'residents.user',
                'vehicles',
                'meterReadings.feeType',
                'invoices',
            ])->where('IsDeleted', false)->find($request->query('selected_id'));
        }

        $editApartment = null;
        if ($request->filled('edit_id')) {
            $editApartment = Apartment::with([
                'floor.building',
                'residents.user',
                'vehicles',
            ])->where('IsDeleted', false)->find($request->query('edit_id'));
        }

        $statusApartment = null;
        if ($request->filled('status_id')) {
            $statusApartment = Apartment::with([
                'floor.building',
                'residents',
                'vehicles',
                'invoices',
            ])->where('IsDeleted', false)->find($request->query('status_id'));
        }

        return view('apartments.index', [
            'apartments' => $apartments,
            'buildings' => $buildings,
            'floors' => $floors,
            'selectedApartment' => $selectedApartment,
            'editApartment' => $editApartment,
            'statusApartment' => $statusApartment,
        ]);
    }

    /**
     * Màn hình Thêm căn hộ dạng trang độc lập (SCR-APT-04).
     */
    public function create(): View
    {
        $buildings = Building::where('IsDeleted', false)->orderBy('BuildingId')->get();
        $floors = Floor::with('building')->where('IsDeleted', false)->orderBy('FloorNumber')->get();

        return view('apartments.create', [
            'buildings' => $buildings,
            'floors' => $floors,
        ]);
    }

    /**
     * Lưu căn hộ mới vào cơ sở dữ liệu (SCR-APT-04).
     */
    public function store(StoreApartmentRequest $request): RedirectResponse|JsonResponse
    {
        $dto = ApartmentDTO::fromStoreRequest($request);

        $apartment = Apartment::create($dto->toModelArray());

        Cache::forget('dashboard_stats');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã tạo căn hộ {$apartment->ApartmentNumber} thành công.",
                'data' => $apartment,
            ]);
        }

        return redirect()->route('apartments.index')
            ->with('success', "Đã tạo căn hộ {$apartment->ApartmentNumber} thành công.");
    }

    /**
     * Chi tiết Căn hộ (SCR-APT-03).
     */
    public function show(Request $request, Apartment $apartment): View|JsonResponse
    {
        $apartment->loadMissing([
            'floor.building',
            'residents.user',
            'vehicles',
            'meterReadings.feeType',
            'invoices',
        ]);

        if ($request->wantsJson()) {
            return response()->json($apartment);
        }

        $request->merge(['selected_id' => $apartment->ApartmentId]);

        return $this->index($request);
    }

    /**
     * Màn hình Chỉnh sửa căn hộ dạng trang độc lập (SCR-APT-05).
     */
    public function edit(Apartment $apartment): View
    {
        $apartment->loadMissing([
            'floor.building',
            'residents.user',
            'vehicles',
        ]);

        return view('apartments.edit', [
            'apartment' => $apartment,
        ]);
    }

    /**
     * Cập nhật thông tin căn hộ (SCR-APT-05).
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment): RedirectResponse|JsonResponse
    {
        $dto = ApartmentDTO::fromUpdateRequest($request, $apartment->FloorId);

        // Quy tắc nghiệp vụ: Nếu đổi sang trạng thái trống, không được còn cư dân ACTIVE
        if (in_array($dto->status, ['AVAILABLE', 'VACANT'], true)) {
            $hasActiveResidents = $apartment->residents()
                ->where('Status', 'ACTIVE')
                ->where('IsDeleted', false)
                ->exists();

            if ($hasActiveResidents) {
                throw new BusinessException("Căn hộ {$apartment->ApartmentNumber} hiện có cư dân đang cư trú, không thể chuyển sang trạng thái trống.");
            }
        }

        $apartment->update($dto->toModelArray());

        Cache::forget('dashboard_stats');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã cập nhật căn hộ {$apartment->ApartmentNumber} thành công.",
                'data' => $apartment,
            ]);
        }

        return redirect()->route('apartments.index')
            ->with('success', "Đã cập nhật căn hộ {$apartment->ApartmentNumber} thành công.");
    }

    /**
     * Thay đổi trạng thái căn hộ (SCR-APT-06).
     */
    public function updateStatus(UpdateApartmentStatusRequest $request, Apartment $apartment): RedirectResponse|JsonResponse
    {
        $newStatus = (string) $request->validated('Status');

        // Quy tắc nghiệp vụ: Nếu đổi sang trạng thái trống, không được còn cư dân ACTIVE
        if (in_array($newStatus, ['AVAILABLE', 'VACANT'], true)) {
            $hasActiveResidents = $apartment->residents()
                ->where('Status', 'ACTIVE')
                ->where('IsDeleted', false)
                ->exists();

            if ($hasActiveResidents) {
                throw new BusinessException("Căn hộ {$apartment->ApartmentNumber} hiện có cư dân đang cư trú, không thể chuyển sang trạng thái trống.");
            }
        }

        $apartment->update([
            'Status' => $newStatus,
        ]);

        Cache::forget('dashboard_stats');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã thay đổi trạng thái căn hộ {$apartment->ApartmentNumber} thành {$newStatus}.",
                'data' => $apartment,
            ]);
        }

        return redirect()->route('apartments.index')
            ->with('success', "Đã thay đổi trạng thái căn hộ {$apartment->ApartmentNumber} thành {$newStatus}.");
    }
}
