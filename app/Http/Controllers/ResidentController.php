<?php

namespace App\Http\Controllers;

use App\DTOs\ResidentDTO;
use App\Http\Requests\Resident\StoreResidentRequest;
use App\Http\Requests\Resident\UpdateResidentRequest;
use App\Http\Requests\Resident\UpdateResidentStatusRequest;
use App\Models\Apartment;
use App\Models\ApartmentResident;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ResidentController extends Controller
{
    /**
     * Hiển thị danh bạ cư dân (SCR-RES-01).
     */
    public function index(Request $request): View
    {
        $apartments = Apartment::where('IsDeleted', false)
            ->orderBy('ApartmentNumber')
            ->get();

        $query = User::with(['apartmentResidents.apartment.floor.building'])
            ->where('IsDeleted', false)
            ->where(function ($q): void {
                $q->where('Role', 'RESIDENT')
                    ->orWhereHas('apartmentResidents');
            });

        // Lọc theo từ khóa: Họ tên / CCCD / SĐT
        if ($request->filled('keyword')) {
            $kw = trim((string) $request->input('keyword'));
            $query->where(function ($q) use ($kw): void {
                $q->where('FullName', 'like', "%{$kw}%")
                    ->orWhere('CitizenId', 'like', "%{$kw}%")
                    ->orWhere('Phone', 'like', "%{$kw}%")
                    ->orWhere('Email', 'like', "%{$kw}%");
            });
        }

        // Lọc theo Căn hộ (ApartmentId)
        if ($request->filled('apartment_id')) {
            $aptId = (int) $request->input('apartment_id');
            $query->whereHas('apartmentResidents', function ($q) use ($aptId): void {
                $q->where('ApartmentId', $aptId)
                    ->where('IsDeleted', false);
            });
        }

        // Lọc theo Trạng thái cư trú
        if ($request->filled('status')) {
            $status = (string) $request->input('status');
            if ($status === 'ACTIVE') {
                $query->whereHas('apartmentResidents', function ($q): void {
                    $q->where('Status', 'ACTIVE')->where('IsDeleted', false);
                });
            } elseif ($status === 'INACTIVE') {
                $query->where(function ($q): void {
                    $q->whereDoesntHave('apartmentResidents', function ($sub): void {
                        $sub->where('Status', 'ACTIVE')->where('IsDeleted', false);
                    })->orWhere('Status', 'INACTIVE');
                });
            }
        }

        $residents = $query->orderBy('UserId')->paginate(10)->withQueryString();

        return view('residents.index', [
            'residents' => $residents,
            'apartments' => $apartments,
        ]);
    }

    /**
     * Chi tiết cư dân (SCR-RES-02).
     */
    public function show(int $id): JsonResponse|View
    {
        $resident = User::with(['apartmentResidents.apartment.floor.building'])
            ->where('UserId', $id)
            ->where('IsDeleted', false)
            ->firstOrFail();

        $activeResidency = $resident->apartmentResidents instanceof Collection
            ? $resident->apartmentResidents->firstWhere('Status', 'ACTIVE')
            : null;

        if (request()->wantsJson()) {
            return response()->json([
                'user_id' => $resident->UserId,
                'full_name' => $resident->FullName,
                'citizen_id' => $resident->CitizenId,
                'phone' => $resident->Phone,
                'email' => $resident->Email,
                'apartment_number' => $activeResidency?->apartment?->ApartmentNumber ?? '—',
                'building_name' => $activeResidency?->apartment?->floor?->building?->BuildingName ?? '—',
                'floor_number' => $activeResidency?->apartment?->floor?->FloorNumber ?? '—',
                'start_date' => $activeResidency?->StartDate ? Carbon::parse($activeResidency->StartDate)->format('d/m/Y') : '—',
                'residence_status' => $activeResidency?->Status ?? 'INACTIVE',
            ]);
        }

        return view('residents.show', [
            'resident' => $resident,
            'activeResidency' => $activeResidency,
        ]);
    }

    /**
     * Màn hình tạo cư dân mới (SCR-RES-03).
     */
    public function create(): View
    {
        $apartments = Apartment::where('IsDeleted', false)
            ->orderBy('ApartmentNumber')
            ->get();

        $residents = User::with(['apartmentResidents.apartment'])
            ->where('Role', 'RESIDENT')
            ->where('IsDeleted', false)
            ->orderByDesc('UserId')
            ->paginate(10);

        return view('residents.create', [
            'apartments' => $apartments,
            'residents' => $residents,
        ]);
    }

    /**
     * Tiếp nhận cư dân mới vào hệ thống (SCR-RES-03).
     */
    public function store(StoreResidentRequest $request): RedirectResponse|JsonResponse
    {
        $dto = ResidentDTO::fromStoreRequest($request);

        return DB::transaction(function () use ($dto, $request) {
            $userData = $dto->toUserArray();

            // Tự tạo UserName nếu chưa có
            if (empty($userData['UserName'])) {
                $userData['UserName'] = 'resident_'.Str::random(6);
            }
            if (empty($userData['PasswordHash'])) {
                $userData['PasswordHash'] = bcrypt('password123');
            }

            $user = User::create($userData);

            // Gắn vào căn hộ nếu có ApartmentId
            if ($dto->apartmentId) {
                ApartmentResident::create([
                    'ApartmentId' => $dto->apartmentId,
                    'UserId' => $user->UserId,
                    'StartDate' => $dto->startDate ?? now()->toDateString(),
                    'EndDate' => $dto->endDate,
                    'Status' => $dto->status ?? 'ACTIVE',
                    'IsDeleted' => false,
                ]);

                Apartment::where('ApartmentId', $dto->apartmentId)->update([
                    'Status' => 'OCCUPIED',
                ]);
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tiếp nhận cư dân thành công!',
                    'resident' => $user,
                ]);
            }

            return redirect()->route('residents.index')
                ->with('success', "Tiếp nhận cư dân {$user->FullName} thành công!");
        });
    }

    /**
     * Màn hình chỉnh sửa thông tin cư dân (SCR-RES-04).
     */
    public function edit(int $id): View
    {
        $resident = User::with(['apartmentResidents.apartment.floor.building'])
            ->where('UserId', $id)
            ->where('IsDeleted', false)
            ->firstOrFail();

        $apartments = Apartment::where('IsDeleted', false)
            ->orderBy('ApartmentNumber')
            ->get();

        $activeResidency = $resident->apartmentResidents instanceof Collection
            ? $resident->apartmentResidents->firstWhere('Status', 'ACTIVE')
            : null;

        return view('residents.edit', [
            'resident' => $resident,
            'apartments' => $apartments,
            'activeResidency' => $activeResidency,
        ]);
    }

    /**
     * Cập nhật thông tin cư dân (SCR-RES-04).
     */
    public function update(UpdateResidentRequest $request, int $id): RedirectResponse
    {
        $resident = User::where('UserId', $id)
            ->where('IsDeleted', false)
            ->firstOrFail();

        $dto = ResidentDTO::fromUpdateRequest($request);

        return DB::transaction(function () use ($resident, $dto, $request) {
            $resident->update([
                'FullName' => $dto->fullName,
                'CitizenId' => $dto->citizenId ?? $resident->CitizenId,
                'Phone' => $dto->phone ?? $resident->Phone,
                'Email' => $dto->email ?? $resident->Email,
            ]);

            if ($dto->apartmentId) {
                $currentActive = ApartmentResident::where('UserId', $resident->UserId)
                    ->where('Status', 'ACTIVE')
                    ->where('IsDeleted', false)
                    ->first();

                if (! $currentActive || $currentActive->ApartmentId !== $dto->apartmentId) {
                    if ($currentActive) {
                        $currentActive->update([
                            'Status' => 'INACTIVE',
                            'EndDate' => now()->toDateString(),
                        ]);
                    }

                    ApartmentResident::create([
                        'ApartmentId' => $dto->apartmentId,
                        'UserId' => $resident->UserId,
                        'StartDate' => $dto->startDate ?? now()->toDateString(),
                        'EndDate' => $dto->endDate,
                        'Status' => 'ACTIVE',
                        'IsDeleted' => false,
                    ]);

                    Apartment::where('ApartmentId', $dto->apartmentId)->update([
                        'Status' => 'OCCUPIED',
                    ]);
                }
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật thông tin cư dân thành công!',
                    'data' => $resident,
                ]);
            }

            return redirect()->route('residents.show', $resident->UserId)
                ->with('success', 'Cập nhật thông tin cư dân thành công!');
        });
    }

    /**
     * Cập nhật trạng thái cư trú của cư dân.
     */
    public function updateStatus(UpdateResidentStatusRequest $request, int $id): RedirectResponse
    {
        $resident = User::where('UserId', $id)
            ->where('IsDeleted', false)
            ->firstOrFail();

        $newStatus = (string) $request->validated('Status');

        DB::transaction(function () use ($resident, $newStatus): void {
            $resident->update(['Status' => $newStatus]);

            ApartmentResident::where('UserId', $resident->UserId)
                ->where('IsDeleted', false)
                ->update([
                    'Status' => $newStatus,
                    'EndDate' => $newStatus === 'INACTIVE' ? now()->toDateString() : null,
                ]);
        });

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã cập nhật trạng thái cư trú của {$resident->FullName} thành công.",
                'data' => $resident,
            ]);
        }

        return redirect()->route('residents.index')
            ->with('success', "Đã cập nhật trạng thái cư trú của {$resident->FullName} thành công.");
    }
}
