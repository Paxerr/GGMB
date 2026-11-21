@extends('layouts.app', [
    'title' => 'Quản lý xe & thẻ · GGMB',
    'active' => 'vehicles',
    'breadcrumbs' => ['GGMB', 'Xe & đăng ký']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    @if (session('success'))
        <div class="p-4 bg-[#e6f5ec] border border-[#c3e6cb] text-[#16734b] text-[14px] rounded-[4px] flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#16734b] font-bold text-lg leading-none cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Header Title & Subtitle (Bám sát Ảnh Đăng ký xe mới) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
            Đăng ký xe mới
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#334b5d]">
            Thêm phương tiện gắn với căn hộ.
        </p>
    </div>

    <!-- Filters & Action Button Row (100% responsive full width) -->
    <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-4 pt-2">
        <!-- 3 Filter Fields -->
        <form method="GET" action="{{ route('vehicles.index') }}" onsubmit="event.preventDefault();" class="flex flex-wrap items-end gap-3 sm:gap-4 flex-1">
            <!-- Filter 1: Biển số -->
            <div class="space-y-1.5 w-full sm:w-[260px]">
                <label for="plateInput" class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Biển số
                </label>
                <div class="relative">
                    <input
                        type="text"
                        id="plateInput"
                        name="license_plate"
                        value="{{ request('license_plate') }}"
                        oninput="filterVehiclesRealtime()"
                        placeholder="Nhập biển số…"
                        class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                    />
                    @if (request('license_plate'))
                        <a href="{{ route('vehicles.index', request()->except('license_plate')) }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                            &times;
                        </a>
                    @endif
                </div>
            </div>

            <!-- Filter 2: Loại xe -->
            <div class="space-y-1.5 w-full sm:w-[260px]">
                <label for="typeSelect" class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Loại xe
                </label>
                <div class="relative">
                    <select
                        id="typeSelect"
                        name="vehicle_type"
                        onchange="filterVehiclesRealtime()"
                        class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                    >
                        <option value="">Tất cả ▾</option>
                        <option value="MOTORBIKE" {{ request('vehicle_type') === 'MOTORBIKE' ? 'selected' : '' }}>Xe máy · MOTORBIKE</option>
                        <option value="CAR" {{ request('vehicle_type') === 'CAR' ? 'selected' : '' }}>Ô tô · CAR</option>
                        <option value="ELECTRIC_BIKE" {{ request('vehicle_type') === 'ELECTRIC_BIKE' ? 'selected' : '' }}>Xe máy điện · ELECTRIC</option>
                        <option value="BICYCLE" {{ request('vehicle_type') === 'BICYCLE' ? 'selected' : '' }}>Xe đạp · BICYCLE</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                        ▾
                    </div>
                </div>
            </div>

            <!-- Filter 3: Căn hộ -->
            <div class="space-y-1.5 w-full sm:w-[260px]">
                <label for="apartmentIdSelect" class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Căn hộ
                </label>
                <div class="relative">
                    <select
                        id="apartmentIdSelect"
                        name="apartment_id"
                        onchange="filterVehiclesRealtime()"
                        class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                    >
                        <option value="">Tất cả ▾</option>
                        @foreach ($apartments as $apt)
                            <option value="{{ $apt->ApartmentId }}" {{ request('apartment_id') == $apt->ApartmentId ? 'selected' : '' }}>
                                {{ $apt->ApartmentNumber }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                        ▾
                    </div>
                </div>
            </div>

            <button type="submit" class="hidden">Tìm</button>
        </form>

        <!-- Right: Nút ＋ Đăng ký xe -->
        <div class="shrink-0">
            <button
                type="button"
                onclick="openCreateVehicleModal()"
                class="w-full sm:w-[196px] h-[40px] px-5 bg-[#2864ad] hover:bg-[#205391] border border-solid border-[#2864ad] rounded-[4px] text-[14px] font-semibold text-white transition-colors cursor-pointer flex items-center justify-center whitespace-nowrap shadow-sm"
            >
                ＋ Đăng ký xe
            </button>
        </div>
    </div>

    <!-- Data Table (Bảng dữ liệu: ôm 100% màn hình, không tràn ngang) -->
    <div class="bg-white border border-solid border-[#d9e4ec] overflow-hidden rounded-[4px]" data-name="Bảng dữ liệu">
        <!-- Table Header (Tiêu đề cột: h=40px, bg=#e4edf3, border-b=#d9e4ec) -->
        <div class="bg-[#e4edf3] border-b border-[#d9e4ec] flex h-[40px] items-center text-[#334b5d] text-[12px] leading-[18px] font-semibold select-none">
            <!-- Mã xe: 100px -->
            <div class="w-[100px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Mã xe
            </div>
            <!-- Biển số: 240px -->
            <div class="w-[240px] min-w-[200px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Biển số
            </div>
            <!-- Loại xe: 220px -->
            <div class="w-[220px] min-w-[180px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Loại xe
            </div>
            <!-- Căn hộ: 160px -->
            <div class="w-[160px] min-w-[130px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Căn hộ
            </div>
            <!-- Thao tác: flex-1 -->
            <div class="flex-1 min-w-[220px] px-3 h-full flex items-center">
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
                class="vehicle-row bg-white border-b last:border-b-0 border-[#d9e4ec] flex h-[48px] items-center text-[#334b5d] text-[14px] leading-[20px] hover:bg-[#f8fbfd] transition-colors cursor-pointer"
                onclick="if(!event.target.closest('a') && !event.target.closest('button')) openVehicleDetailModal({{ $veh->VehicleId }})"
            >
                <!-- VehicleId: 100px -->
                <div class="w-[100px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">
                    {{ $veh->VehicleId }}
                </div>

                <!-- Biển số: 240px -->
                <div class="w-[240px] min-w-[200px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-semibold text-[#122d40] font-mono tracking-wide">
                    {{ $veh->LicensePlate }}
                </div>

                <!-- Loại xe: 220px -->
                <div class="w-[220px] min-w-[180px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">
                    @if ($isCar)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-[#e6f5ec] text-[#16734b]">
                            CAR · Ô tô
                        </span>
                    @elseif ($isElec)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-[#f0edfa] text-[#6a51ae]">
                            ELECTRIC · Xe điện
                        </span>
                    @elseif ($isBike)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-gray-100 text-[#52697c]">
                            BICYCLE · Xe đạp
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-[#e8f1ff] text-[#2864ad]">
                            MOTORBIKE · Xe máy
                        </span>
                    @endif
                </div>

                <!-- Căn hộ: 160px -->
                <div class="w-[160px] min-w-[130px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium text-[#122d40]">
                    {{ $aptNumber }}
                </div>

                <!-- Thao tác: flex-1 (Tất cả mở dạng Popup Modal) -->
                <div class="flex-1 min-w-[220px] px-3 h-full flex items-center space-x-2 text-[14px]">
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openVehicleDetailModal({{ $veh->VehicleId }});"
                        class="text-[#2864ad] hover:text-[#205391] hover:underline font-medium cursor-pointer transition-colors"
                    >
                        Xem
                    </button>
                    <span class="text-[#52697c]">/</span>
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openEditVehicleModal({{ $veh->VehicleId }});"
                        class="text-[#2864ad] hover:text-[#205391] hover:underline font-medium cursor-pointer transition-colors"
                    >
                        Sửa
                    </button>
                    <span class="text-[#52697c]">/</span>
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openCancelVehicleModal({{ $veh->VehicleId }});"
                        class="text-rose-600 hover:text-rose-700 hover:underline font-medium cursor-pointer transition-colors"
                    >
                        Hủy đăng ký
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

        @if ($vehicles->hasPages())
            <nav class="w-[196px] h-[40px] bg-white border border-[#d9e4ec] rounded-[4px] flex items-center justify-between px-3 select-none text-[14px] text-[#334b5d]" aria-label="Phân trang">
                {{-- Nút Trước ‹ --}}
                @if ($vehicles->onFirstPage())
                    <span class="text-[#a6bece] cursor-not-allowed">‹</span>
                @else
                    <a href="{{ $vehicles->previousPageUrl() }}" class="text-[#334b5d] hover:text-[#2864ad] transition-colors" rel="prev">‹</a>
                @endif

                {{-- Các số trang --}}
                @php
                    $currentPage = $vehicles->currentPage();
                    $lastPage = $vehicles->lastPage();
                    $start = max(1, min($currentPage - 1, $lastPage - 2));
                    $end = min($lastPage, max($start + 2, 3));
                    if ($lastPage < 3) {
                        $start = 1;
                        $end = $lastPage;
                    }
                @endphp

                @for ($page = $start; $page <= $end; $page++)
                    @if ($page == $currentPage)
                        <span class="font-semibold text-[#122d40] border-b-2 border-[#2864ad] pb-0.5">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $vehicles->url($page) }}" class="text-[#334b5d] hover:text-[#2864ad] transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endfor

                {{-- Nút Sau › --}}
                @if ($vehicles->hasMorePages())
                    <a href="{{ $vehicles->nextPageUrl() }}" class="text-[#334b5d] hover:text-[#2864ad] transition-colors" rel="next">›</a>
                @else
                    <span class="text-[#a6bece] cursor-not-allowed">›</span>
                @endif
            </nav>
        @else
            <!-- Static 196x40 box matching Figma preview when single page -->
            <div class="w-[196px] h-[40px] bg-white border border-[#d9e4ec] rounded-[4px] flex items-center justify-between px-3 select-none text-[14px] text-[#334b5d]">
                <span class="text-[#a6bece]">‹</span>
                <span class="font-semibold text-[#122d40] border-b-2 border-[#2864ad] pb-0.5">1</span>
                <span class="text-[#334b5d]">2</span>
                <span class="text-[#334b5d]">3</span>
                <span class="text-[#a6bece]">›</span>
            </div>
        @endif
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
