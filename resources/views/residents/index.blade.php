@extends('layouts.app', [
    'title' => 'Danh bạ cư dân · GGMB',
    'active' => 'residents',
    'breadcrumbs' => ['GGMB', 'Cư dân']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    @if (session('success'))
        <div class="p-4 bg-[#e6f5ec] border border-[#c3e6cb] text-[#16734b] text-[14px] rounded-[4px] flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#16734b] font-bold text-lg leading-none cursor-pointer">&times;</button>
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 text-[14px] rounded-[4px] flex items-center justify-between">
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-700 font-bold text-lg leading-none cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Header Title & Subtitle -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
            Danh bạ cư dân
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#334b5d]">
            Thông tin tài khoản cư dân và quan hệ cư trú
        </p>
    </div>

    <!-- Filters & Action Button Row -->
    <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-4 pt-2">
        <!-- 3 Filter Dropdowns -->
        <form method="GET" action="{{ route('residents.index') }}" class="flex flex-wrap items-end gap-3 sm:gap-4 flex-1">
            <!-- Filter 1: Họ tên / CCCD / SĐT -->
            <div class="space-y-1.5 w-full sm:w-[260px]">
                <label for="keywordInput" class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Họ tên / CCCD / SĐT
                </label>
                <div class="relative">
                    <input
                        type="text"
                        id="keywordInput"
                        name="keyword"
                        value="{{ request('keyword') }}"
                        placeholder="Nhập từ khóa…"
                        class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                    />
                    @if (request('keyword'))
                        <a href="{{ route('residents.index', request()->except('keyword')) }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                            &times;
                        </a>
                    @endif
                </div>
            </div>

            <!-- Filter 2: Căn hộ · ApartmentId -->
            <div class="space-y-1.5 w-full sm:w-[260px]">
                <label for="apartmentIdSelect" class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Căn hộ · ApartmentId
                </label>
                <div class="relative">
                    <select
                        id="apartmentIdSelect"
                        name="apartment_id"
                        onchange="this.form.submit()"
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

            <!-- Filter 3: Trạng thái cư trú -->
            <div class="space-y-1.5 w-full sm:w-[260px]">
                <label for="statusSelect" class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Trạng thái cư trú
                </label>
                <div class="relative">
                    <select
                        id="statusSelect"
                        name="status"
                        onchange="this.form.submit()"
                        class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                    >
                        <option value="">Tất cả ▾</option>
                        <option value="ACTIVE" {{ request('status') === 'ACTIVE' ? 'selected' : '' }}>Đang cư trú</option>
                        <option value="INACTIVE" {{ request('status') === 'INACTIVE' ? 'selected' : '' }}>Đã rời đi</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                        ▾
                    </div>
                </div>
            </div>

            <button type="submit" class="hidden">Tìm</button>
        </form>

        <!-- Right: Nút ＋ Tiếp nhận cư dân -->
        <div class="shrink-0">
            <button
                type="button"
                onclick="openCreateResidentModal()"
                class="w-full sm:w-[196px] h-[40px] px-5 bg-[#2864ad] hover:bg-[#205391] border border-solid border-[#2864ad] rounded-[4px] text-[14px] font-semibold text-white transition-colors cursor-pointer flex items-center justify-center whitespace-nowrap"
            >
                ＋ Tiếp nhận cư dân
            </button>
        </div>
    </div>

    <!-- Data Table (Bảng dữ liệu: ôm 100% màn hình như Danh sách căn hộ) -->
    <div class="bg-white border border-solid border-[#d9e4ec] overflow-hidden" data-name="Bảng dữ liệu">
        <!-- Table Header (Tiêu đề cột: h=40px, bg=#e4edf3, border-b=#d9e4ec) -->
        <div class="bg-[#e4edf3] border-b border-[#d9e4ec] flex h-[40px] items-center text-[#334b5d] text-[12px] leading-[18px] font-semibold select-none">
            <!-- UserId: w=80px -->
            <div class="w-[80px] min-w-[80px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                UserId
            </div>
            <!-- Họ tên: flex-1 -->
            <div class="flex-1 min-w-[160px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Họ tên
            </div>
            <!-- CCCD: w=180px -->
            <div class="w-[180px] min-w-[160px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                CCCD
            </div>
            <!-- Điện thoại: w=160px -->
            <div class="w-[160px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Điện thoại
            </div>
            <!-- Căn hộ: w=100px -->
            <div class="w-[100px] min-w-[100px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Căn hộ
            </div>
            <!-- Cư trú: w=140px -->
            <div class="w-[140px] min-w-[130px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Cư trú
            </div>
            <!-- Thao tác: w=240px -->
            <div class="w-[240px] min-w-[220px] px-3 h-full flex items-center">
                Thao tác
            </div>
        </div>

        <!-- Table Rows (h=48px, text=[14px] #334b5d) -->
        @php
            $residentsMap = [];
        @endphp
        @forelse ($residents as $index => $resident)
            @php
                $activeResidency = $resident->apartmentResidents instanceof \Illuminate\Support\Collection
                    ? $resident->apartmentResidents->firstWhere('Status', 'ACTIVE')
                    : null;
                $apartmentNum = $resident->apartment_number 
                    ?? ($activeResidency?->apartment?->ApartmentNumber ?? ($resident->apartmentResidents?->first()?->apartment?->ApartmentNumber ?? '—'));
                $isResidentActive = ($resident->residence_status ?? ($activeResidency?->Status ?? ($resident->Status ?? 'ACTIVE'))) === 'ACTIVE';
                $startDate = $resident->StartDate 
                    ?? ($activeResidency?->StartDate ? \Carbon\Carbon::parse($activeResidency->StartDate)->format('d/m/Y') : '—');
                
                $jsData = [
                    'userId' => $resident->UserId,
                    'fullName' => $resident->FullName,
                    'citizenId' => $resident->CitizenId,
                    'phone' => $resident->Phone,
                    'email' => $resident->Email ?? 'Chưa cập nhật',
                    'apartmentNumber' => $apartmentNum,
                    'buildingName' => $activeResidency?->apartment?->floor?->building?->BuildingName ?? 'Tòa A',
                    'floorNumber' => $activeResidency?->apartment?->floor?->FloorNumber ?? '1',
                    'startDate' => $startDate,
                    'residenceStatus' => $isResidentActive ? 'ACTIVE' : 'INACTIVE',
                ];
                $residentsMap[$resident->UserId] = $jsData;
            @endphp
            <div
                class="bg-white border-b last:border-b-0 border-[#d9e4ec] flex h-[48px] items-center text-[#334b5d] text-[14px] leading-[20px] hover:bg-[#f8fbfd] transition-colors cursor-pointer"
                onclick="if(!event.target.closest('a') && !event.target.closest('button')) openResidentDetailDrawer({{ $resident->UserId }})"
            >
                <!-- UserId: 80px -->
                <div class="w-[80px] min-w-[80px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">
                    {{ $resident->UserId }}
                </div>

                <!-- Họ tên: flex-1 -->
                <div class="flex-1 min-w-[160px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal truncate">
                    {{ $resident->FullName }}
                </div>

                <!-- CCCD: 180px -->
                <div class="w-[180px] min-w-[160px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal truncate">
                    {{ $resident->CitizenId }}
                </div>

                <!-- Điện thoại: 160px -->
                <div class="w-[160px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal truncate">
                    {{ $resident->Phone }}
                </div>

                <!-- Căn hộ: 100px -->
                <div class="w-[100px] min-w-[100px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">
                    {{ $apartmentNum }}
                </div>

                <!-- Cư trú: 140px (Bấm để thay đổi trạng thái theo SCR-RES-05) -->
                <div class="w-[140px] min-w-[130px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openStatusResidentModal({{ $resident->UserId }})"
                        title="Bấm để thay đổi trạng thái cư trú"
                        class="inline-block px-2 py-0.5 text-xs font-semibold rounded hover:opacity-80 transition-opacity cursor-pointer {{ $isResidentActive ? 'text-[#16734b] bg-[#e6f5ec]' : 'text-[#52697c] bg-gray-100' }}"
                    >
                        {{ $isResidentActive ? 'Đang cư trú' : 'Đã rời đi' }}
                    </button>
                </div>

                <!-- Thao tác: 240px (Xem hồ sơ / Sửa / Đổi trạng thái) -->
                <div class="w-[240px] min-w-[220px] px-3 h-full flex items-center space-x-2 text-[14px]">
                    <a
                        href="{{ route('residents.show', $resident->UserId) }}"
                        onclick="if (!event.ctrlKey && !event.metaKey) { event.preventDefault(); openResidentDetailDrawer({{ $resident->UserId }}); }"
                        class="text-[#2864ad] hover:text-[#205391] hover:underline font-medium cursor-pointer transition-colors"
                    >
                        Xem hồ sơ
                    </a>
                    <span class="text-[#52697c]">/</span>
                    <a
                        href="{{ route('residents.edit', $resident->UserId) }}"
                        onclick="event.stopPropagation()"
                        class="text-[#2864ad] hover:text-[#205391] hover:underline font-medium cursor-pointer transition-colors"
                    >
                        Sửa
                    </a>
                    <span class="text-[#52697c]">/</span>
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openStatusResidentModal({{ $resident->UserId }})"
                        class="text-[#2864ad] hover:text-[#205391] hover:underline font-medium cursor-pointer transition-colors"
                    >
                        Đổi trạng thái
                    </button>
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center text-[#52697c]">
                <p class="text-[15px] font-medium">Không tìm thấy cư dân nào phù hợp</p>
                <p class="text-[13px] mt-1 text-[#8a9ba8]">Vui lòng thử lại với bộ lọc hoặc từ khóa khác</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Controls (Right aligned box: ‹  1  2  3  ›) -->
    <div class="flex justify-end pt-1 pb-6">
        @if ($residents->hasPages())
            <nav class="w-[196px] h-[40px] bg-white border border-[#d9e4ec] rounded-[4px] flex items-center justify-between px-3 select-none text-[14px] text-[#334b5d]" aria-label="Phân trang">
                {{-- Nút Trước ‹ --}}
                @if ($residents->onFirstPage())
                    <span class="text-[#a6bece] cursor-not-allowed">‹</span>
                @else
                    <a href="{{ $residents->previousPageUrl() }}" class="text-[#334b5d] hover:text-[#2864ad] transition-colors" rel="prev">‹</a>
                @endif

                {{-- Các số trang --}}
                @php
                    $currentPage = $residents->currentPage();
                    $lastPage = $residents->lastPage();
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
                        <a href="{{ $residents->url($page) }}" class="text-[#334b5d] hover:text-[#2864ad] transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endfor

                {{-- Nút Sau › --}}
                @if ($residents->hasMorePages())
                    <a href="{{ $residents->nextPageUrl() }}" class="text-[#334b5d] hover:text-[#2864ad] transition-colors" rel="next">›</a>
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

<!-- Partials: Chi tiết cư dân Drawer, Tiếp nhận cư dân Modal & Đổi trạng thái Modal -->
@include('residents.partials.detail-drawer')
@include('residents.partials.create-modal')
@include('residents.partials.status-modal')

<script>
    window.residentsMap = @json($residentsMap ?? []);
</script>
@endsection
