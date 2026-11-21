@extends('layouts.app', [
    'title' => 'Tòa & tầng · GGMB',
    'active' => 'buildings',
    'breadcrumbs' => ['GGMB', 'Tòa & tầng']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    <!-- Header Title & Subtitle -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
            Tòa & tầng
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#334b5d]">
            Quản lý cấu trúc chung cư → tòa nhà → tầng → căn hộ.
        </p>
    </div>

    <!-- Thông báo kết quả thao tác -->
    @if (session('status'))
        <div class="p-3 bg-emerald-50 border border-emerald-200 text-[#16734b] text-sm rounded flex items-center justify-between">
            <span>{{ session('status') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#16734b] text-xs hover:underline cursor-pointer">
                Đóng
            </button>
        </div>
    @endif

    <!-- Filters & Actions Toolbar -->
    <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-4 pt-2">
        <!-- Left: Tòa nhà dropdown & Building actions -->
        <div class="flex flex-wrap items-end gap-3 sm:gap-4">
            <!-- Dropdown Tòa nhà -->
            <div class="space-y-1.5 w-full sm:w-[320px]">
                <label for="buildingSelect" class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Tòa nhà
                </label>
                <div class="relative">
                    <select
                        id="buildingSelect"
                        onchange="if(this.value) window.location.href='{{ route('buildings.index') }}?building_id=' + this.value"
                        class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                    >
                        @foreach ($buildings as $b)
                            <option value="{{ $b->BuildingId }}" {{ (isset($selectedBuilding) && $selectedBuilding->BuildingId == $b->BuildingId) ? 'selected' : '' }}>
                                {{ $b->BuildingId }} · {{ $b->BuildingName }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                        ▾
                    </div>
                </div>
            </div>

            <!-- Nút Chỉnh sửa tòa (Kiểu=02) - Mở Edit Modal -->
            <button
                type="button"
                onclick="openEditBuildingModal('{{ $selectedBuilding->BuildingId ?? 1 }}', '{{ addslashes($selectedBuilding->BuildingName ?? 'GGMB Residence · Tòa A') }}')"
                class="h-[40px] px-5 bg-white hover:bg-gray-50 border border-solid border-[#d9e4ec] rounded-[8px] text-[14px] font-semibold text-[#334b5d] transition-colors cursor-pointer"
            >
                Chỉnh sửa tòa
            </button>

            <!-- Nút Thêm tòa nhà (Kiểu=02) - Mở Create Modal -->
            <button
                type="button"
                onclick="openBuildingModal()"
                class="h-[40px] px-5 bg-white hover:bg-gray-50 border border-solid border-[#d9e4ec] rounded-[8px] text-[14px] font-semibold text-[#334b5d] transition-colors cursor-pointer"
            >
                Thêm tòa nhà
            </button>

            <!-- Nút Xóa tòa nhà (Kiểu=02) - Mở Delete Modal -->
            <button
                type="button"
                onclick="openDeleteBuildingModal()"
                class="h-[40px] px-4 bg-white hover:bg-rose-50 border border-solid border-rose-300 rounded-[8px] text-[14px] font-semibold text-rose-600 transition-colors cursor-pointer"
            >
                Xóa tòa
            </button>
        </div>

        <!-- Right: Nút Thêm tầng mới (Kiểu=01) -->
        <div>
            <button
                type="button"
                onclick="openCreateFloorModal()"
                class="h-[40px] px-5 bg-[#2864ad] hover:bg-[#205391] border border-solid border-[#2864ad] rounded-[4px] text-[14px] font-semibold text-white transition-colors cursor-pointer flex items-center justify-center whitespace-nowrap shadow-sm"
            >
                ＋ Thêm tầng mới
            </button>
        </div>
    </div>

    <!-- Data Table (Bảng dữ liệu) -->
    <div class="bg-white border border-solid border-[#d9e4ec] overflow-hidden" data-name="Bảng dữ liệu">
        <!-- Table Header (Tiêu đề cột) -->
        <div class="bg-[#e4edf3] border-b border-[#d9e4ec] flex h-[40px] items-center text-[#334b5d] text-[12px] font-semibold select-none">
            <div class="w-[90px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Mã tầng
            </div>
            <div class="flex-1 px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Tòa nhà
            </div>
            <div class="w-[173px] min-w-[173px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Số tầng
            </div>
            <div class="w-[274px] min-w-[274px] px-3 h-full flex items-center">
                Căn hộ / Thao tác
            </div>
        </div>

        <!-- Table Rows -->
        @forelse ($floors as $floor)
            <div id="floor-row-{{ $floor->FloorId }}" class="bg-white border-b last:border-b-0 border-[#d9e4ec] flex h-[48px] items-center text-[#334b5d] text-[14px] hover:bg-[#f8fbfd] transition-all">
                <div class="w-[90px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">
                    {{ $floor->FloorId }}
                </div>
                <div class="flex-1 px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal truncate">
                    {{ $floor->building->BuildingName ?? ($selectedBuilding->BuildingName ?? 'GGMB Residence · Tòa A') }}
                </div>
                <div class="w-[173px] min-w-[173px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal floor-num">
                    {{ $floor->FloorNumber }}
                </div>
                <div class="w-[274px] min-w-[274px] px-3 h-full flex items-center space-x-2">
                    <button
                        type="button"
                        onclick="openDetailFloorModal('{{ $floor->FloorId }}', '{{ $floor->FloorNumber }}', '{{ addslashes($floor->building->BuildingName ?? ($selectedBuilding->BuildingName ?? 'GGMB Residence · Tòa A')) }}')"
                        class="text-[#2864ad] hover:underline cursor-pointer"
                    >
                        Xem
                    </button>
                    <span class="text-[#52697c]">/</span>
                    <button
                        type="button"
                        onclick="openEditFloorModal('{{ $floor->FloorId }}', '{{ $floor->FloorNumber }}')"
                        class="text-[#2864ad] hover:underline cursor-pointer"
                    >
                        Sửa
                    </button>
                    <span class="text-[#52697c]">/</span>
                    <button
                        type="button"
                        onclick="openDeleteFloorModal('{{ $floor->FloorId }}', '{{ $floor->FloorNumber }}')"
                        class="text-rose-600 hover:underline cursor-pointer"
                    >
                        Xóa
                    </button>
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-sm text-[#52697c]">
                Chưa có dữ liệu tầng cho tòa nhà này.
            </div>
        @endforelse
    </div>
</div>

<!-- Modal Popup: Thêm tòa nhà (SCR-BLD-02) -->
@include('buildings.partials.create-modal')

<!-- Modal Popup: Chỉnh sửa tòa nhà (SCR-BLD-03) -->
@include('buildings.partials.edit-modal')

<!-- Modal Popups: Thao tác Tầng & Xóa tòa (Thêm tầng, Sửa tầng, Xóa tầng, Chi tiết tầng, Xóa tòa) -->
@include('buildings.partials.floor-modal')
@endsection
