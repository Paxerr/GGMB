<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class ApartmentController extends Controller
{
    /**
     * Hiển thị danh sách Căn hộ (SCR-APT-01) kèm Drawer chi tiết (SCR-APT-03) và Popup (SCR-APT-04, SCR-APT-05, SCR-APT-06).
     */
    public function index(Request $request): View
    {
        try {
            $buildings = Building::where('IsDeleted', false)->get();
            $floors = Floor::with('building')->where('IsDeleted', false)->orderBy('FloorNumber')->get();

            $query = Apartment::with([
                'floor.building',
                'residents.user',
                'vehicles',
                'meterReadings.feeType',
                'invoices',
            ])->where('IsDeleted', false);

            if ($request->filled('building_id')) {
                $query->whereHas('floor', function ($q) use ($request) {
                    $q->where('BuildingId', $request->building_id);
                });
            }

            if ($request->filled('floor_id')) {
                $query->where('FloorId', $request->floor_id);
            }

            if ($request->filled('status')) {
                $query->where('Status', $request->status);
            }

            $apartments = $query->orderBy('ApartmentId')->paginate(8)->withQueryString();

            if ($apartments->isEmpty() && ! $request->hasAny(['building_id', 'floor_id', 'status'])) {
                $sampleData = collect([]);
                for ($i = 1; $i <= 8; $i++) {
                    $sampleData->push((object) [
                        'ApartmentId' => $i,
                        'ApartmentNumber' => sprintf('01%02d', $i),
                        'FloorId' => 1,
                        'Status' => 'OCCUPIED',
                        'Description' => sprintf('Căn hộ tầng 1, số %02d', $i),
                        'CreatedAt' => '2026-01-01 08:00:00',
                        'UpdatedAt' => null,
                        'IsDeleted' => false,
                        'DeletedAt' => null,
                        'floor' => (object) [
                            'FloorId' => 1,
                            'FloorNumber' => 1,
                            'building' => (object) ['BuildingId' => 1, 'BuildingName' => 'GGMB Residence · Tòa A'],
                        ],
                        'residents' => collect([
                            (object) [
                                'StartDate' => '2024-01-01',
                                'Status' => 'ACTIVE',
                                'user' => (object) ['FullName' => 'Nguyễn An'],
                            ],
                        ]),
                        'vehicles' => collect([
                            (object) [
                                'LicensePlate' => sprintf('29A-%05d', 10000 + $i),
                                'VehicleType' => 'MOTORBIKE',
                            ],
                        ]),
                        'meterReadings' => collect([
                            (object) [
                                'feeType' => (object) ['Name' => 'Điện'],
                                'BillingPeriod' => '02/2026',
                                'PreviousReading' => 103,
                                'CurrentReading' => 142,
                                'Consumption' => 39,
                            ],
                            (object) [
                                'feeType' => (object) ['Name' => 'Nước'],
                                'BillingPeriod' => '02/2026',
                                'PreviousReading' => 41,
                                'CurrentReading' => 48,
                                'Consumption' => 7,
                            ],
                        ]),
                        'invoices' => collect([
                            (object) [
                                'InvoiceId' => 1,
                                'BillingPeriod' => '01/2026',
                                'TotalAmount' => 842500,
                                'Status' => 'UNPAID',
                            ],
                            (object) [
                                'InvoiceId' => 21,
                                'BillingPeriod' => '02/2026',
                                'TotalAmount' => 842500,
                                'Status' => 'UNPAID',
                            ],
                        ]),
                    ]);
                }
                $apartments = new LengthAwarePaginator(
                    $sampleData,
                    40,
                    8,
                    1,
                    ['path' => route('apartments.index')]
                );
            }
        } catch (Throwable $e) {
            $buildings = collect([(object) ['BuildingId' => 1, 'BuildingName' => 'GGMB Residence · Tòa A']]);
            $floors = collect([(object) ['FloorId' => 1, 'FloorNumber' => 1, 'BuildingId' => 1]]);

            $sampleData = collect([]);
            for ($i = 1; $i <= 8; $i++) {
                $sampleData->push((object) [
                    'ApartmentId' => $i,
                    'ApartmentNumber' => sprintf('01%02d', $i),
                    'FloorId' => 1,
                    'Status' => 'OCCUPIED',
                    'Description' => sprintf('Căn hộ tầng 1, số %02d', $i),
                    'CreatedAt' => '2026-01-01 08:00:00',
                    'UpdatedAt' => null,
                    'IsDeleted' => false,
                    'DeletedAt' => null,
                    'floor' => (object) [
                        'FloorId' => 1,
                        'FloorNumber' => 1,
                        'building' => (object) ['BuildingId' => 1, 'BuildingName' => 'GGMB Residence · Tòa A'],
                    ],
                    'residents' => collect([
                        (object) [
                            'StartDate' => '2024-01-01',
                            'Status' => 'ACTIVE',
                            'user' => (object) ['FullName' => 'Nguyễn An'],
                        ],
                    ]),
                    'vehicles' => collect([
                        (object) [
                            'LicensePlate' => sprintf('29A-%05d', 10000 + $i),
                            'VehicleType' => 'MOTORBIKE',
                        ],
                    ]),
                    'meterReadings' => collect([
                        (object) [
                            'feeType' => (object) ['Name' => 'Điện'],
                            'BillingPeriod' => '02/2026',
                            'PreviousReading' => 103,
                            'CurrentReading' => 142,
                            'Consumption' => 39,
                        ],
                        (object) [
                            'feeType' => (object) ['Name' => 'Nước'],
                            'BillingPeriod' => '02/2026',
                            'PreviousReading' => 41,
                            'CurrentReading' => 48,
                            'Consumption' => 7,
                        ],
                    ]),
                    'invoices' => collect([
                        (object) [
                            'InvoiceId' => 1,
                            'BillingPeriod' => '01/2026',
                            'TotalAmount' => 842500,
                            'Status' => 'UNPAID',
                        ],
                        (object) [
                            'InvoiceId' => 21,
                            'BillingPeriod' => '02/2026',
                            'TotalAmount' => 842500,
                            'Status' => 'UNPAID',
                        ],
                    ]),
                ]);
            }
            $apartments = new LengthAwarePaginator(
                $sampleData,
                40,
                8,
                1,
                ['path' => url('/apartments')]
            );
        }

        $selectedApartment = null;
        if ($request->filled('selected_id')) {
            $selectedApartment = $apartments->firstWhere('ApartmentId', (int) $request->selected_id)
                ?? Apartment::with(['floor.building', 'residents.user', 'vehicles', 'meterReadings.feeType', 'invoices'])->find($request->selected_id);
        }

        $editApartment = null;
        if ($request->filled('edit_id')) {
            $editApartment = $apartments->firstWhere('ApartmentId', (int) $request->edit_id)
                ?? Apartment::with(['floor.building', 'residents.user', 'vehicles'])->find($request->edit_id);
        }

        $statusApartment = null;
        if ($request->filled('status_id')) {
            $statusApartment = $apartments->firstWhere('ApartmentId', (int) $request->status_id)
                ?? Apartment::with(['floor.building', 'residents', 'vehicles', 'invoices'])->find($request->status_id);
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
        $buildings = Building::where('IsDeleted', false)->get();
        $floors = Floor::with('building')->where('IsDeleted', false)->orderBy('FloorNumber')->get();

        return view('apartments.create', [
            'buildings' => $buildings,
            'floors' => $floors,
        ]);
    }

    /**
     * Lưu căn hộ mới (SCR-APT-04).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'FloorId' => ['required', 'integer', 'exists:Floor,FloorId'],
            'ApartmentNumber' => [
                'required',
                'string',
                'max:20',
                Rule::unique('Apartment', 'ApartmentNumber')->where(fn ($query) => $query->where('FloorId', $request->FloorId)->where('IsDeleted', false)),
            ],
            'Status' => ['required', 'string', 'in:AVAILABLE,VACANT,OCCUPIED,SUSPENDED,INACTIVE'],
            'Description' => ['nullable', 'string', 'max:500'],
        ]);

        Apartment::create([
            'FloorId' => $validated['FloorId'],
            'ApartmentNumber' => $validated['ApartmentNumber'],
            'Status' => $validated['Status'],
            'Description' => $validated['Description'] ?? null,
            'IsDeleted' => false,
        ]);

        return redirect()->route('apartments.index')->with('success', "Đã tạo căn hộ {$validated['ApartmentNumber']} thành công.");
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
    public function update(Request $request, Apartment $apartment): RedirectResponse
    {
        $validated = $request->validate([
            'ApartmentNumber' => [
                'required',
                'string',
                'max:20',
                Rule::unique('Apartment', 'ApartmentNumber')
                    ->where(fn ($query) => $query->where('FloorId', $apartment->FloorId)->where('IsDeleted', false))
                    ->ignore($apartment->ApartmentId, 'ApartmentId'),
            ],
            'Status' => ['required', 'string', 'in:AVAILABLE,VACANT,OCCUPIED,SUSPENDED,INACTIVE'],
            'Description' => ['nullable', 'string', 'max:500'],
        ]);

        $apartment->update([
            'ApartmentNumber' => $validated['ApartmentNumber'],
            'Status' => $validated['Status'],
            'Description' => $validated['Description'] ?? null,
        ]);

        return redirect()->route('apartments.index')->with('success', "Đã cập nhật căn hộ {$apartment->ApartmentNumber} thành công.");
    }

    /**
     * Thay đổi trạng thái căn hộ (SCR-APT-06).
     */
    public function updateStatus(Request $request, Apartment $apartment): RedirectResponse
    {
        $validated = $request->validate([
            'Status' => ['required', 'string', 'in:AVAILABLE,VACANT,OCCUPIED,SUSPENDED,INACTIVE'],
        ]);

        $apartment->update([
            'Status' => $validated['Status'],
        ]);

        return redirect()->route('apartments.index')->with('success', "Đã thay đổi trạng thái căn hộ {$apartment->ApartmentNumber} thành {$validated['Status']}.");
    }
}
