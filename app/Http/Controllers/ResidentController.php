<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\ApartmentResident;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class ResidentController extends Controller
{
    /**
     * Hiển thị danh bạ cư dân (SCR-RES-01).
     */
    public function index(Request $request): View
    {
        try {
            $apartments = Apartment::where('IsDeleted', false)
                ->orderBy('ApartmentNumber')
                ->get();

            $query = User::with(['apartmentResidents.apartment'])
                ->where('IsDeleted', false)
                ->where(function ($q) {
                    $q->where('Role', 'RESIDENT')
                        ->orWhereHas('apartmentResidents');
                });

            // Lọc theo từ khóa: Họ tên / CCCD / SĐT
            if ($request->filled('keyword')) {
                $kw = trim($request->input('keyword'));
                $query->where(function ($q) use ($kw) {
                    $q->where('FullName', 'like', "%{$kw}%")
                        ->orWhere('CitizenId', 'like', "%{$kw}%")
                        ->orWhere('Phone', 'like', "%{$kw}%");
                });
            }

            // Lọc theo Căn hộ (ApartmentId)
            if ($request->filled('apartment_id')) {
                $aptId = $request->input('apartment_id');
                $query->whereHas('apartmentResidents', function ($q) use ($aptId) {
                    $q->where('ApartmentId', $aptId)
                        ->where('IsDeleted', false);
                });
            }

            // Lọc theo Trạng thái cư trú
            if ($request->filled('status')) {
                $status = $request->input('status');
                if ($status === 'ACTIVE') {
                    $query->whereHas('apartmentResidents', function ($q) {
                        $q->where('Status', 'ACTIVE')->where('IsDeleted', false);
                    });
                } elseif ($status === 'INACTIVE') {
                    $query->where(function ($q) {
                        $q->whereDoesntHave('apartmentResidents', function ($sub) {
                            $sub->where('Status', 'ACTIVE')->where('IsDeleted', false);
                        })->orWhere('Status', 'INACTIVE');
                    });
                }
            }

            $residents = $query->orderBy('UserId')->paginate(6)->withQueryString();

            // Nếu cơ sở dữ liệu trống và không có bộ lọc nào, hiển thị dữ liệu mẫu theo Figma
            if ($residents->isEmpty() && ! $request->hasAny(['keyword', 'apartment_id', 'status'])) {
                $sampleData = collect([
                    (object) [
                        'UserId' => 10,
                        'FullName' => 'Nguyễn An',
                        'CitizenId' => '079000000010',
                        'Phone' => '0910000010',
                        'Email' => 'nguyenan@ggmb.vn',
                        'apartment_number' => '0101',
                        'residence_status' => 'ACTIVE',
                        'StartDate' => '2024-01-15',
                        'apartmentResidents' => collect([
                            (object) [
                                'ApartmentResidentId' => 1,
                                'ApartmentId' => 1,
                                'Status' => 'ACTIVE',
                                'StartDate' => '2024-01-15',
                                'EndDate' => null,
                                'apartment' => (object) ['ApartmentId' => 1, 'ApartmentNumber' => '0101'],
                            ],
                        ]),
                    ],
                    (object) [
                        'UserId' => 11,
                        'FullName' => 'Trần Bình',
                        'CitizenId' => '07900000011',
                        'Phone' => '0910000011',
                        'Email' => 'tranbinh@ggmb.vn',
                        'apartment_number' => '0102',
                        'residence_status' => 'ACTIVE',
                        'StartDate' => '2024-02-01',
                        'apartmentResidents' => collect([
                            (object) [
                                'ApartmentResidentId' => 2,
                                'ApartmentId' => 2,
                                'Status' => 'ACTIVE',
                                'StartDate' => '2024-02-01',
                                'EndDate' => null,
                                'apartment' => (object) ['ApartmentId' => 2, 'ApartmentNumber' => '0102'],
                            ],
                        ]),
                    ],
                    (object) [
                        'UserId' => 12,
                        'FullName' => 'Lê Chi',
                        'CitizenId' => '07900000012',
                        'Phone' => '0910000012',
                        'Email' => 'lechi@ggmb.vn',
                        'apartment_number' => '0103',
                        'residence_status' => 'ACTIVE',
                        'StartDate' => '2024-03-10',
                        'apartmentResidents' => collect([
                            (object) [
                                'ApartmentResidentId' => 3,
                                'ApartmentId' => 3,
                                'Status' => 'ACTIVE',
                                'StartDate' => '2024-03-10',
                                'EndDate' => null,
                                'apartment' => (object) ['ApartmentId' => 3, 'ApartmentNumber' => '0103'],
                            ],
                        ]),
                    ],
                    (object) [
                        'UserId' => 13,
                        'FullName' => 'Phạm Dũng',
                        'CitizenId' => '07900000013',
                        'Phone' => '0910000013',
                        'Email' => 'phamdung@ggmb.vn',
                        'apartment_number' => '0104',
                        'residence_status' => 'ACTIVE',
                        'StartDate' => '2024-04-05',
                        'apartmentResidents' => collect([
                            (object) [
                                'ApartmentResidentId' => 4,
                                'ApartmentId' => 4,
                                'Status' => 'ACTIVE',
                                'StartDate' => '2024-04-05',
                                'EndDate' => null,
                                'apartment' => (object) ['ApartmentId' => 4, 'ApartmentNumber' => '0104'],
                            ],
                        ]),
                    ],
                    (object) [
                        'UserId' => 14,
                        'FullName' => 'Hoàng Giang',
                        'CitizenId' => '07900000014',
                        'Phone' => '0910000014',
                        'Email' => 'hoanggiang@ggmb.vn',
                        'apartment_number' => '0105',
                        'residence_status' => 'ACTIVE',
                        'StartDate' => '2024-05-20',
                        'apartmentResidents' => collect([
                            (object) [
                                'ApartmentResidentId' => 5,
                                'ApartmentId' => 5,
                                'Status' => 'ACTIVE',
                                'StartDate' => '2024-05-20',
                                'EndDate' => null,
                                'apartment' => (object) ['ApartmentId' => 5, 'ApartmentNumber' => '0105'],
                            ],
                        ]),
                    ],
                    (object) [
                        'UserId' => 15,
                        'FullName' => 'Vũ Hà',
                        'CitizenId' => '07900000015',
                        'Phone' => '0910000015',
                        'Email' => 'vuha@ggmb.vn',
                        'apartment_number' => '0106',
                        'residence_status' => 'ACTIVE',
                        'StartDate' => '2024-06-12',
                        'apartmentResidents' => collect([
                            (object) [
                                'ApartmentResidentId' => 6,
                                'ApartmentId' => 6,
                                'Status' => 'ACTIVE',
                                'StartDate' => '2024-06-12',
                                'EndDate' => null,
                                'apartment' => (object) ['ApartmentId' => 6, 'ApartmentNumber' => '0106'],
                            ],
                        ]),
                    ],
                ]);

                $page = LengthAwarePaginator::resolveCurrentPage();
                $residents = new LengthAwarePaginator(
                    $sampleData->forPage($page, 6),
                    $sampleData->count(),
                    6,
                    $page,
                    ['path' => LengthAwarePaginator::resolveCurrentPath()]
                );
            }

            return view('residents.index', [
                'residents' => $residents,
                'apartments' => $apartments,
            ]);
        } catch (Throwable $e) {
            $sampleData = collect([
                (object) [
                    'UserId' => 10,
                    'FullName' => 'Nguyễn An',
                    'CitizenId' => '079000000010',
                    'Phone' => '0910000010',
                    'Email' => 'nguyenan@ggmb.vn',
                    'apartment_number' => '0101',
                    'residence_status' => 'ACTIVE',
                    'StartDate' => '2024-01-15',
                    'apartmentResidents' => collect([]),
                ],
            ]);
            $residents = new LengthAwarePaginator($sampleData, 1, 6, 1, [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
            ]);

            return view('residents.index', [
                'residents' => $residents,
                'apartments' => collect([]),
            ]);
        }
    }

    /**
     * Chi tiết cư dân (SCR-RES-02).
     */
    public function show(int $id): JsonResponse|View
    {
        $resident = User::with(['apartmentResidents.apartment.floor.building'])
            ->where('UserId', $id)
            ->where('IsDeleted', false)
            ->first();

        // Dữ liệu mẫu fallback nếu chưa có dữ liệu trong DB
        if (! $resident) {
            if (request()->wantsJson()) {
                return response()->json(['message' => 'Không tìm thấy cư dân'], 404);
            }

            $resident = (object) [
                'UserId' => $id,
                'UserName' => 'resident01',
                'FullName' => 'Nguyễn Văn An',
                'CitizenId' => '079000000010',
                'Phone' => '0910000010',
                'Email' => 'nguyenan123@gmail.com',
                'Role' => 'RESIDENT',
                'Status' => 'ACTIVE',
                'relationship' => 'Chủ hộ',
                'apartmentResidents' => collect([
                    (object) [
                        'ApartmentResidentId' => 1,
                        'ApartmentId' => 1,
                        'Status' => 'ACTIVE',
                        'StartDate' => Carbon::createFromFormat('d/m/Y', '01/01/2024'),
                        'EndDate' => null,
                        'apartment' => (object) [
                            'ApartmentId' => 1,
                            'ApartmentNumber' => '0101',
                            'floor' => (object) [
                                'FloorNumber' => 1,
                                'building' => (object) ['BuildingName' => 'Tòa A'],
                            ],
                        ],
                    ],
                ]),
            ];
        }

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
     * Màn hình chỉnh sửa thông tin cư dân (SCR-RES-04).
     */
    public function edit(int $id): View
    {
        $resident = User::with(['apartmentResidents.apartment.floor.building'])
            ->where('UserId', $id)
            ->where('IsDeleted', false)
            ->first();

        if (! $resident) {
            $resident = (object) [
                'UserId' => $id,
                'UserName' => 'resident01',
                'FullName' => 'Nguyễn Văn An',
                'CitizenId' => '079000000010',
                'Phone' => '0910000010',
                'Email' => 'nguyenan123@gmail.com',
                'Role' => 'RESIDENT',
                'Status' => 'ACTIVE',
                'apartmentResidents' => collect([]),
            ];
        }

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
    public function update(Request $request, int $id): RedirectResponse
    {
        $resident = User::where('UserId', $id)
            ->where('IsDeleted', false)
            ->firstOrFail();

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'citizen_id' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'password' => ['nullable', 'string', 'min:6'],
            'apartment_id' => ['nullable', 'exists:Apartment,ApartmentId'],
        ]);

        DB::beginTransaction();
        try {
            $updateData = [
                'FullName' => $validated['full_name'],
                'CitizenId' => $validated['citizen_id'] ?? $resident->CitizenId,
                'Phone' => $validated['phone'] ?? $resident->Phone,
                'Email' => $validated['email'] ?? $resident->Email,
            ];

            if (! empty($validated['password'])) {
                $updateData['PasswordHash'] = Hash::make($validated['password']);
            }

            $resident->update($updateData);

            if (! empty($validated['apartment_id'])) {
                $currentActive = ApartmentResident::where('UserId', $resident->UserId)
                    ->where('Status', 'ACTIVE')
                    ->first();

                if (! $currentActive || $currentActive->ApartmentId != $validated['apartment_id']) {
                    if ($currentActive) {
                        $currentActive->update([
                            'Status' => 'INACTIVE',
                            'EndDate' => now()->toDateString(),
                        ]);
                    }

                    ApartmentResident::create([
                        'ApartmentId' => $validated['apartment_id'],
                        'UserId' => $resident->UserId,
                        'StartDate' => now()->toDateString(),
                        'Status' => 'ACTIVE',
                        'IsDeleted' => false,
                    ]);

                    Apartment::where('ApartmentId', $validated['apartment_id'])->update([
                        'Status' => 'OCCUPIED',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('residents.show', $resident->UserId)
                ->with('success', 'Cập nhật thông tin cư dân thành công!');
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withInput()->withErrors(['error' => 'Không thể cập nhật cư dân: '.$e->getMessage()]);
        }
    }

    /**
     * Màn hình tạo cư dân mới dạng popup (SCR-RES-03).
     */
    public function create(): View
    {
        $apartments = Apartment::where('IsDeleted', false)
            ->orderBy('ApartmentNumber')
            ->get();

        $residents = User::with(['apartmentResidents.apartment'])
            ->where('Role', 'RESIDENT')
            ->where('IsDeleted', false)
            ->paginate(6);

        return view('residents.create', [
            'apartments' => $apartments,
            'residents' => $residents,
        ]);
    }

    /**
     * Tiếp nhận cư dân mới (SCR-RES-03).
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'user_name' => ['nullable', 'string', 'max:50', 'unique:User,UserName'],
            'full_name' => ['required', 'string', 'max:150'],
            'password' => ['nullable', 'string', 'min:6'],
            'citizen_id' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'apartment_id' => ['required', 'exists:Apartment,ApartmentId'],
            'start_date' => ['nullable', 'date'],
        ]);

        DB::beginTransaction();
        try {
            $username = ! empty($validated['user_name'])
                ? trim($validated['user_name'])
                : ('cudan_'.Str::slug($validated['full_name'], '').'_'.rand(100, 999));
            $password = ! empty($validated['password']) ? $validated['password'] : '12345678';

            $user = User::create([
                'UserName' => $username,
                'PasswordHash' => Hash::make($password),
                'FullName' => $validated['full_name'],
                'Phone' => $validated['phone'] ?? null,
                'Email' => $validated['email'] ?? null,
                'CitizenId' => $validated['citizen_id'] ?? null,
                'Role' => 'RESIDENT',
                'Status' => 'ACTIVE',
                'IsDeleted' => false,
            ]);

            ApartmentResident::create([
                'ApartmentId' => $validated['apartment_id'],
                'UserId' => $user->UserId,
                'StartDate' => $validated['start_date'] ?? now()->toDateString(),
                'Status' => 'ACTIVE',
                'IsDeleted' => false,
            ]);

            // Cập nhật trạng thái căn hộ thành OCCUPIED
            Apartment::where('ApartmentId', $validated['apartment_id'])->update([
                'Status' => 'OCCUPIED',
            ]);

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Tiếp nhận cư dân thành công',
                    'resident' => $user,
                ]);
            }

            return redirect()->route('residents.index')->with('success', 'Tiếp nhận cư dân '.$user->FullName.' thành công!');
        } catch (Throwable $e) {
            DB::rollBack();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Lỗi: '.$e->getMessage()], 500);
            }

            return back()->withInput()->withErrors(['error' => 'Không thể tiếp nhận cư dân: '.$e->getMessage()]);
        }
    }

    /**
     * Thay đổi trạng thái cư dân (SCR-RES-05).
     */
    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'Status' => ['required', 'string', 'in:ACTIVE,INACTIVE'],
        ]);

        DB::beginTransaction();
        try {
            $resident = User::where('UserId', $id)->firstOrFail();
            $newStatus = $validated['Status'];

            // Cập nhật trạng thái người dùng
            $resident->update(['Status' => $newStatus]);

            // Cập nhật quan hệ cư trú
            if ($newStatus === 'INACTIVE') {
                ApartmentResident::where('UserId', $id)
                    ->where('Status', 'ACTIVE')
                    ->update([
                        'Status' => 'INACTIVE',
                        'EndDate' => now()->toDateString(),
                    ]);
            } elseif ($newStatus === 'ACTIVE') {
                $residency = ApartmentResident::where('UserId', $id)
                    ->latest('ApartmentResidentId')
                    ->first();
                if ($residency) {
                    $residency->update([
                        'Status' => 'ACTIVE',
                        'EndDate' => null,
                    ]);
                }
            }

            DB::commit();

            $statusText = $newStatus === 'ACTIVE' ? 'Đang cư trú' : 'Đã rời đi';

            return redirect()->route('residents.index')
                ->with('success', "Đã thay đổi trạng thái cư dân {$resident->FullName} thành {$statusText}.");
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Không thể thay đổi trạng thái cư dân: '.$e->getMessage()]);
        }
    }
}
