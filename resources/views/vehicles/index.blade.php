@extends('layouts.app', [
    'title' => 'Quản lý xe & thẻ · GGMB',
    'active' => 'vehicles',
    'breadcrumbs' => ['GGMB', 'Xe & đăng ký']
])

@section('content')
<div class="w-full space-y-6">
    @if (session('success'))
        <div class="p-4 bg-[#e6f5ec] border border-[#c3e6cb] text-[#16734b] text-[14px] rounded-[4px] flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#16734b] font-bold text-lg leading-none cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Header Title & Subtitle -->
    <div>
        <h1 class="text-[26px] leading-[34px] font-bold text-[#111827] tracking-tight">
            Quản lý xe & đăng ký
            <span class="sr-only">Đăng ký xe mới</span>
        </h1>
        <p class="mt-1 text-[13px] leading-[20px] text-[#6b7280]">
            Thêm phương tiện gắn với căn hộ.
        </p>
    </div>

    <!-- Heading & Action Button Row -->
    <div class="flex items-center justify-between">
        <h2 class="text-[16px] font-bold text-[#111827]">
            Danh sách phương tiện
        </h2>
        <button
            type="button"
            onclick="openCreateVehicleModal()"
            class="px-4 py-2 bg-[#0e4d3c] hover:bg-[#0a3d2f] text-white rounded-[8px] text-[13.5px] font-semibold transition-colors cursor-pointer flex items-center gap-1.5 shadow-sm"
        >
            ＋ Đăng ký xe
        </button>
    </div>

    <!-- Filter Card: 3 Filter Fields -->
    <div class="bg-white border border-[#e5e7eb] rounded-[14px] p-4 shadow-none">
        <form method="GET" action="{{ route('vehicles.index') }}" class="flex flex-wrap items-center gap-3 sm:gap-4 flex-1">
            <!-- Filter 1: Biển số -->
            <div class="flex-1 min-w-[200px]">
                <label for="plateInput" class="sr-only">
                    Biển số
                </label>
                <div class="relative">
                    <input
                        type="text"
                        id="plateInput"
                        name="license_plate"
                        value="{{ request('license_plate') }}"
                        placeholder="Tìm kiếm biển số xe…"
                        class="w-full h-[40px] px-3 bg-white border border-[#e5e7eb] rounded-[8px] text-[13.5px] text-[#111827] placeholder:text-[#9ca3af] focus:outline-none focus:border-[#0e4d3c] focus:ring-1 focus:ring-[#0e4d3c]"
                    />
                    @if (request('license_plate'))
                        <a href="{{ route('vehicles.index', request()->except('license_plate')) }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                            &times;
                        </a>
                    @endif
                </div>
            </div>

            <!-- Filter 2: Loại xe -->
            <div class="flex-1 min-w-[200px]">
                <label for="typeSelect" class="sr-only">
                    Loại xe
                </label>
                <div class="relative">
                    <select
                        id="typeSelect"
                        name="vehicle_type"
                        onchange="this.form.submit()"
                        class="w-full h-[40px] px-3 bg-white border border-[#e5e7eb] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0e4d3c] focus:ring-1 focus:ring-[#0e4d3c] cursor-pointer"
                    >
                        <option value="">Tất cả loại xe</option>
                        <option value="MOTORBIKE" {{ request('vehicle_type') === 'MOTORBIKE' ? 'selected' : '' }}>Xe máy</option>
                        <option value="CAR" {{ request('vehicle_type') === 'CAR' ? 'selected' : '' }}>Ô tô</option>
                        <option value="ELECTRIC_BIKE" {{ request('vehicle_type') === 'ELECTRIC_BIKE' ? 'selected' : '' }}>Xe máy điện</option>
                        <option value="BICYCLE" {{ request('vehicle_type') === 'BICYCLE' ? 'selected' : '' }}>Xe đạp</option>
                    </select>
                </div>
            </div>

            <!-- Filter 3: Căn hộ -->
            <div class="flex-1 min-w-[200px]">
                <label for="apartmentIdSelect" class="sr-only">
                    Căn hộ
                </label>
                <div class="relative">
                    <select
                        id="apartmentIdSelect"
                        name="apartment_id"
                        onchange="this.form.submit()"
                        class="w-full h-[40px] px-3 bg-white border border-[#e5e7eb] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0e4d3c] focus:ring-1 focus:ring-[#0e4d3c] cursor-pointer"
                    >
                        <option value="">Tất cả</option>
                        @foreach ($apartments as $apt)
                            <option value="{{ $apt->ApartmentId }}" {{ request('apartment_id') == $apt->ApartmentId ? 'selected' : '' }}>
                                {{ $apt->ApartmentNumber }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button
                    type="submit"
                    class="h-[40px] px-4 bg-white border border-[#e5e7eb] hover:bg-[#f9fafb] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer"
                >
                    Lọc
                </button>
                <a
                    href="{{ route('vehicles.index') }}"
                    class="h-[40px] px-4 bg-[#f3f4f6] hover:bg-[#e5e7eb] rounded-[8px] text-[13px] font-medium text-[#374151] transition-colors inline-flex items-center justify-center"
                >
                    Đặt lại
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table (Bảng dữ liệu) -->
    <div class="bg-white border border-[#e5e7eb] rounded-[14px] overflow-hidden shadow-none" data-name="Bảng dữ liệu">
        <!-- Table Header (Tiêu đề cột) -->
        <div class="bg-[#f2f6f4] border-b border-[#e5e7eb] flex h-[44px] items-center text-[#374151] text-[12px] font-semibold select-none px-4">
            <div class="w-[100px] min-w-[90px]">
                Mã xe
            </div>
            <div class="w-[240px] min-w-[200px]">
                Biển số
            </div>
            <div class="w-[220px] min-w-[180px]">
                Loại xe
            </div>
            <div class="w-[160px] min-w-[130px]">
                Căn hộ
            </div>
            <div class="flex-1 min-w-[200px] text-[#0e4d3c]">
                Thao tác
            </div>
        </div>

        <!-- Table Rows (h=48px, text=[14px] #334b5d) -->
        @php
            $vehiclesMap = [];
        @endphp
        @forelse ($vehicles as $veh)
            @php
                $aptNumber = $veh->apartment?->ApartmentNumber ?? ('010' . $veh->ApartmentId);
                $building = $veh->apartment?->floor?->building?->BuildingName ?? 'Tòa A';
                $floorNum = $veh->apartment?->floor?->FloorNumber ?? '1';
                $isCar = ($veh->VehicleType === 'CAR');
                $isElec = ($veh->VehicleType === 'ELECTRIC_BIKE');
                $isBike = ($veh->VehicleType === 'BICYCLE');

                $typeLabel = match($veh->VehicleType) {
                    'CAR' => 'CAR · Ô tô',
                    'ELECTRIC_BIKE' => 'ELECTRIC · Xe điện',
                    'BICYCLE' => 'BICYCLE · Xe đạp',
                    default => 'MOTORBIKE · Xe máy',
                };

                $jsData = [
                    'vehicleId' => $veh->VehicleId,
                    'licensePlate' => $veh->LicensePlate,
                    'vehicleType' => $veh->VehicleType,
                    'typeName' => $typeLabel,
                    'apartmentId' => $veh->ApartmentId,
                    'apartmentNumber' => $aptNumber,
                    'buildingName' => $building,
                    'floorNumber' => $floorNum,
                    'createdAt' => !empty($veh->CreatedAt) ? \Carbon\Carbon::parse($veh->CreatedAt)->format('d/m/Y') : '01/01/2026',
                ];
                $vehiclesMap[$veh->VehicleId] = $jsData;
            @endphp
            <div
                id="vehicle_row_{{ $veh->VehicleId }}"
                data-plate="{{ $veh->LicensePlate }}"
                data-type="{{ $veh->VehicleType }}"
                data-apt="{{ $veh->ApartmentId }}"
                class="vehicle-row border-b last:border-b-0 border-[#e5e7eb] flex h-[52px] items-center text-[#374151] text-[13.5px] hover:bg-[#f9fbfa] transition-colors cursor-pointer px-4"
                onclick="if(!event.target.closest('a') && !event.target.closest('button')) openVehicleDetailModal({{ $veh->VehicleId }})"
            >
                <!-- VehicleId: 100px -->
                <div class="w-[100px] min-w-[90px] font-normal">
                    {{ $veh->VehicleId }}
                </div>

                <!-- Biển số: 240px -->
                <div class="w-[240px] min-w-[200px] font-semibold text-[#111827] font-mono tracking-wide">
                    {{ $veh->LicensePlate }}
                </div>

                <!-- Loại xe: 220px -->
                <div class="w-[220px] min-w-[180px]">
                    @if ($isCar)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-[6px] text-xs font-semibold bg-[#e6efe9] text-[#0e4d3c]">
                            Ô tô
                            <span class="sr-only">CAR</span>
                        </span>
                    @elseif ($isElec)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-[6px] text-xs font-semibold bg-[#f0edfa] text-[#6a51ae]">
                            Xe máy điện
                            <span class="sr-only">ELECTRIC_BIKE</span>
                        </span>
                    @elseif ($isBike)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-[6px] text-xs font-semibold bg-gray-100 text-[#6b7280]">
                            Xe đạp
                            <span class="sr-only">BICYCLE</span>
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-[6px] text-xs font-semibold bg-[#e8f1ff] text-[#2864ad]">
                            Xe máy
                            <span class="sr-only">MOTORBIKE</span>
                        </span>
                    @endif
                </div>

                <!-- Căn hộ: 160px -->
                <div class="w-[160px] min-w-[130px] font-medium text-[#111827]">
                    {{ $aptNumber }}
                </div>

                <!-- Thao tác: flex-1 -->
                <div class="flex-1 min-w-[200px] flex items-center gap-1.5 text-[13px]">
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openVehicleDetailModal({{ $veh->VehicleId }});"
                        title="Xem chi tiết"
                        class="p-1.5 text-[#0e4d3c] hover:bg-[#e4efe9] rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span class="sr-only">Xem Chi tiết</span>
                    </button>
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openEditVehicleModal({{ $veh->VehicleId }});"
                        title="Chỉnh sửa"
                        class="p-1.5 text-[#374151] hover:text-[#0e4d3c] hover:bg-[#f3f4f6] rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="sr-only">Sửa</span>
                    </button>
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openCancelVehicleModal({{ $veh->VehicleId }});"
                        title="Hủy đăng ký / Hủy thẻ"
                        class="p-1.5 text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span class="sr-only">Hủy thẻ Hủy đăng ký</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center text-[#52697c]">
                <p class="text-[15px] font-medium">Không tìm thấy phương tiện nào phù hợp</p>
                <p class="text-[13px] mt-1 text-[#8a9ba8]">Vui lòng thử lại với biển số hoặc bộ lọc khác</p>
            </div>
        @endforelse
    </div>

    <!-- Bottom Info & Pagination Controls (Bám sát ảnh 2) -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1 pb-6">
        <div class="text-[13px] leading-[18px] text-[#52697c]">
            Hiển thị {{ $vehicles->firstItem() ?? 1 }}–{{ $vehicles->lastItem() ?? $vehicles->count() }} trong {{ $totalVehicles ?? 25 }} xe · {{ $motorbikesCount ?? 19 }} xe máy và {{ $carsCount ?? 6 }} ô tô
        </div>

        @include('layouts.partials.pagination', ['paginator' => $vehicles])
    </div>
</div>

<!-- Partials: Chi tiết phương tiện Modal, Đăng ký Modal, Sửa Modal & Hủy đăng ký Modal (Cả 3 ảnh đều chuyển thành dạng Popup Modal) -->
@include('vehicles.partials.detail-modal')
@include('vehicles.partials.create-modal')
@include('vehicles.partials.edit-modal')
@include('vehicles.partials.cancel-modal')

<script>
    window.vehiclesMap = @json($vehiclesMap ?? []);

    function filterVehiclesRealtime() {
        const query = (document.getElementById('plateInput')?.value || '').toLowerCase().trim();
        const type = document.getElementById('typeSelect')?.value || '';
        const apt = document.getElementById('apartmentIdSelect')?.value || '';

        const rows = document.querySelectorAll('.vehicle-row');
        rows.forEach(row => {
            const plate = (row.getAttribute('data-plate') || '').toLowerCase();
            const rowType = row.getAttribute('data-type') || '';
            const rowApt = row.getAttribute('data-apt') || '';

            const matchPlate = !query || plate.includes(query);
            const matchType = !type || rowType === type;
            const matchApt = !apt || rowApt === apt;

            if (matchPlate && matchType && matchApt) {
                row.style.display = 'flex';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function removeVehicleRowRealtime(id) {
        const row = document.getElementById(`vehicle_row_${id}`);
        if (row) {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '0';
            row.style.backgroundColor = '#fdf2f2';
            setTimeout(() => {
                row.remove();
            }, 300);
        }
    }
</script>
@endsection
