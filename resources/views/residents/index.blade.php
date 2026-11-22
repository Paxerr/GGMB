@extends('layouts.app', [
    'title' => 'Danh bạ cư dân · GGMB',
    'active' => 'residents',
    'breadcrumbs' => ['GGMB', 'Cư dân']
])

@section('content')
<div class="w-full space-y-6">
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
        <h1 class="text-[26px] leading-[34px] font-bold text-[#111827] tracking-tight">
            Danh bạ cư dân
        </h1>
        <p class="mt-1 text-[13px] leading-[20px] text-[#6b7280]">
            Thông tin tài khoản cư dân và quan hệ cư trú
        </p>
    </div>

    <!-- Heading & Action Button Row -->
    <div class="flex items-center justify-between">
        <h2 class="text-[16px] font-bold text-[#111827]">
            Danh sách cư dân
        </h2>
        <button
            type="button"
            onclick="openCreateResidentModal()"
            class="px-4 py-2 bg-[#0e4d3c] hover:bg-[#0a3d2f] text-white rounded-[8px] text-[13.5px] font-semibold transition-colors cursor-pointer flex items-center gap-1.5 shadow-sm"
        >
            ＋ Tiếp nhận cư dân
        </button>
    </div>

    <!-- Filter Card: 3 Filter Dropdowns -->
    <div class="bg-white border border-[#e5e7eb] rounded-[14px] p-4 shadow-none">
        <form method="GET" action="{{ route('residents.index') }}" class="flex flex-wrap items-center gap-3 sm:gap-4 flex-1">
            <!-- Filter 1: Họ tên / CCCD / SĐT -->
            <div class="flex-1 min-w-[200px]">
                <label for="keywordInput" class="sr-only">
                    Họ tên / CCCD / SĐT
                </label>
                <div class="relative">
                    <input
                        type="text"
                        id="keywordInput"
                        name="keyword"
                        value="{{ request('keyword') }}"
                        placeholder="Tìm kiếm cư dân (Họ tên, SĐT, CCCD)..."
                        class="w-full h-[40px] px-3 bg-white border border-[#e5e7eb] rounded-[8px] text-[13.5px] text-[#111827] placeholder:text-[#9ca3af] focus:outline-none focus:border-[#0e4d3c] focus:ring-1 focus:ring-[#0e4d3c]"
                    />
                    @if (request('keyword'))
                        <a href="{{ route('residents.index', request()->except('keyword')) }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                            &times;
                        </a>
                    @endif
                </div>
            </div>

            <!-- Filter 2: Căn hộ · ApartmentId -->
            <div class="flex-1 min-w-[200px]">
                <label for="apartmentIdSelect" class="sr-only">
                    Căn hộ · ApartmentId
                </label>
                <div class="relative">
                    <select
                        id="apartmentIdSelect"
                        name="apartment_id"
                        onchange="this.form.submit()"
                        class="w-full h-[40px] px-3 bg-white border border-[#e5e7eb] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0e4d3c] focus:ring-1 focus:ring-[#0e4d3c] cursor-pointer"
                    >
                        <option value="">Tất cả căn hộ</option>
                        @foreach ($apartments as $apt)
                            <option value="{{ $apt->ApartmentId }}" {{ request('apartment_id') == $apt->ApartmentId ? 'selected' : '' }}>
                                {{ $apt->ApartmentNumber }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Filter 3: Trạng thái cư trú -->
            <div class="flex-1 min-w-[200px]">
                <label for="statusSelect" class="sr-only">
                    Trạng thái cư trú
                </label>
                <div class="relative">
                    <select
                        id="statusSelect"
                        name="status"
                        onchange="this.form.submit()"
                        class="w-full h-[40px] px-3 bg-white border border-[#e5e7eb] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0e4d3c] focus:ring-1 focus:ring-[#0e4d3c] cursor-pointer"
                    >
                        <option value="">Tất cả trạng thái</option>
                        <option value="ACTIVE" {{ request('status') === 'ACTIVE' ? 'selected' : '' }}>Đang cư trú</option>
                        <option value="INACTIVE" {{ request('status') === 'INACTIVE' ? 'selected' : '' }}>Đã rời đi</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a
                    href="{{ route('residents.index') }}"
                    class="h-[40px] px-4 bg-[#f3f4f6] hover:bg-[#e5e7eb] rounded-[8px] text-[13px] font-medium text-[#374151] transition-colors inline-flex items-center justify-center"
                >
                    Đặt lại
                </a>
            </div>

            <button type="submit" class="hidden">Tìm</button>
        </form>
    </div>

    <!-- Data Table (Bảng dữ liệu) -->
    <div class="bg-white border border-[#e5e7eb] rounded-[14px] overflow-x-auto shadow-none" data-name="Bảng dữ liệu">
        <!-- Table Header (Tiêu đề cột) -->
        <div class="bg-[#f2f6f4] border-b border-[#d9e4ec] flex h-[44px] items-center text-[#374151] text-[12px] font-semibold select-none">
            <div class="w-[80px] min-w-[80px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                UserId
            </div>
            <div class="flex-1 min-w-[160px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Họ tên
            </div>
            <div class="w-[180px] min-w-[160px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                CCCD
            </div>
            <div class="w-[160px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Điện thoại
            </div>
            <div class="w-[100px] min-w-[100px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Căn hộ
            </div>
            <div class="w-[140px] min-w-[130px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Cư trú
            </div>
            <div class="w-[180px] min-w-[160px] px-3 h-full flex items-center text-[#0e4d3c]">
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

                <!-- Cư trú: 140px -->
                <div class="w-[140px] min-w-[130px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openStatusResidentModal({{ $resident->UserId }})"
                        title="Bấm để thay đổi trạng thái cư trú"
                        class="inline-block px-2.5 py-1 text-xs font-semibold rounded-[6px] transition-opacity cursor-pointer {{ $isResidentActive ? 'text-[#0e4d3c] bg-[#e4efe9]' : 'text-[#6b7280] bg-[#f3f4f6]' }}"
                    >
                        {{ $isResidentActive ? 'Đang cư trú' : 'Đã rời đi' }}
                    </button>
                </div>

                <!-- Thao tác: 180px -->
                <div class="w-[180px] min-w-[160px] px-3 h-full flex items-center gap-1.5 text-[13px]">
                    <a
                        href="{{ route('residents.show', $resident->UserId) }}"
                        onclick="if (!event.ctrlKey && !event.metaKey) { event.preventDefault(); openResidentDetailDrawer({{ $resident->UserId }}); }"
                        title="Xem hồ sơ cư dân"
                        class="p-1.5 text-[#0E4D3C] hover:bg-[#E4EFE9] rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span class="sr-only">Xem hồ sơ</span>
                    </a>
                    <a
                        href="{{ route('residents.edit', $resident->UserId) }}"
                        onclick="event.stopPropagation()"
                        title="Chỉnh sửa thông tin cư dân"
                        class="p-1.5 text-[#374151] hover:text-[#0E4D3C] hover:bg-[#F3F4F6] rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="sr-only">Sửa</span>
                    </a>
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openStatusResidentModal({{ $resident->UserId }})"
                        title="Đổi trạng thái cư trú"
                        class="p-1.5 text-[#8F5316] hover:bg-amber-50 rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        <span class="sr-only">Đổi trạng thái</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center text-[#6b7280]">
                <p class="text-[15px] font-medium">Không tìm thấy cư dân nào phù hợp</p>
                <p class="text-[13px] mt-1 text-[#9ca3af]">Vui lòng thử lại với bộ lọc hoặc từ khóa khác</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Controls (Trang trước / Trang sau hoặc số trang bo góc 8px) -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1 pb-6">
        <div class="text-[12px] text-[#6b7280]">
            Trang {{ $residents->currentPage() }}/{{ $residents->lastPage() }} · {{ $residents->total() }} bản ghi hiện có
        </div>

        @include('layouts.partials.pagination', ['paginator' => $residents])
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
