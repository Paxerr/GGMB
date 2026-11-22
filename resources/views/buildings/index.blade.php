@extends('layouts.app', [
    'title' => 'Quản lý tòa và tầng · GGMB',
    'active' => 'buildings',
    'breadcrumbs' => ['Quản trị', 'Tòa & tầng']
])

@section('content')
<div class="max-w-[1240px] mx-auto space-y-6">
    <!-- Breadcrumb & Header Title -->
    <div>
        <nav class="text-[12px] font-normal text-[#6b7280] mb-1" aria-label="Breadcrumb">
            <span>Quản trị</span>
            <span class="mx-1 text-[#9ca3af]">/</span>
            <span class="text-[#374151]">Tòa & tầng</span>
        </nav>
        <h1 class="text-[26px] leading-[34px] font-bold text-[#111827] tracking-tight">
            Quản lý tòa và tầng
        </h1>
        <p class="mt-1 text-[13px] leading-[20px] text-[#6b7280]">
            Quản lý cấu trúc chung cư &rarr; tòa nhà &rarr; tầng &rarr; căn hộ.
        </p>
    </div>

    <!-- Thông báo kết quả thao tác -->
    @if (session('status'))
        <div class="p-3 bg-emerald-50 border border-emerald-200 text-[#115e43] text-[13px] rounded-[8px] flex items-center justify-between">
            <span>{{ session('status') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#115e43] text-xs hover:underline cursor-pointer">
                Đóng
            </button>
        </div>
    @endif

    <!-- Danh sách tầng heading & Nút + Thêm tòa nhà -->
    <div class="flex items-center justify-between">
        <h2 class="text-[16px] font-bold text-[#111827]">
            Danh sách {{ count($floors) }} tầng
        </h2>
        <button
            type="button"
            onclick="openBuildingModal()"
            class="px-4 py-2 bg-[#0e4d3c] hover:bg-[#0a3d2f] text-white rounded-[8px] text-[13.5px] font-semibold transition-colors cursor-pointer flex items-center gap-1.5 shadow-sm"
        >
            + Thêm tòa nhà
        </button>
    </div>

    <!-- Filter Card: Tòa nhà dropdown & Buttons Áp dụng, Đặt lại -->
    <div class="bg-white border border-[#e5e7eb] rounded-[14px] p-4 shadow-none">
        <form method="GET" action="{{ route('buildings.index') }}" class="flex flex-col sm:flex-row items-end gap-3">
            <div class="flex-1 w-full space-y-1.5">
                <label for="buildingSelect" class="block text-[12px] leading-[18px] font-semibold text-[#374151]">
                    Tòa nhà
                </label>
                <div class="relative">
                    <select
                        id="buildingSelect"
                        name="building_id"
                        class="w-full h-[40px] px-3 bg-white border border-[#e5e7eb] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0e4d3c] focus:ring-1 focus:ring-[#0e4d3c] cursor-pointer"
                    >
                        @foreach ($buildings as $b)
                            <option value="{{ $b->BuildingId }}" {{ (isset($selectedBuilding) && $selectedBuilding->BuildingId == $b->BuildingId) ? 'selected' : '' }}>
                                {{ $b->BuildingId }} · {{ $b->BuildingName }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6b7280]">
                        ▾
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2.5 w-full sm:w-auto">
                <button
                    type="submit"
                    class="h-[40px] px-4 bg-white hover:bg-[#f9fafb] border border-[#e5e7eb] rounded-[8px] text-[13px] font-medium text-[#374151] transition-colors cursor-pointer"
                >
                    Áp dụng
                </button>
                <a
                    href="{{ route('buildings.index') }}"
                    class="h-[40px] px-4 bg-[#f3f4f6] hover:bg-[#e5e7eb] rounded-[8px] text-[13px] font-medium text-[#374151] transition-colors inline-flex items-center justify-center"
                >
                    Đặt lại
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table (Bo góc 14px, header xanh nhạt #f2f6f4) -->
    <div class="bg-white border border-[#e5e7eb] rounded-[14px] overflow-hidden shadow-none" data-name="Bảng dữ liệu">
        <!-- Table Header -->
        <div class="bg-[#f2f6f4] border-b border-[#e5e7eb] flex h-[44px] items-center text-[#374151] text-[12px] font-semibold select-none px-4">
            <div class="w-[100px] min-w-[100px]">
                Mã tầng
            </div>
            <div class="flex-1">
                Tòa nhà
            </div>
            <div class="w-[180px] min-w-[180px]">
                Số tầng
            </div>
            <div class="w-[220px] min-w-[220px] text-[#0e4d3c]">
                Căn hộ / Thao tác
            </div>
        </div>

        <!-- Table Rows -->
        @forelse ($floors as $floor)
            <div id="floor-row-{{ $floor->FloorId }}" class="border-b last:border-b-0 border-[#e5e7eb] flex h-[52px] items-center text-[#374151] text-[13.5px] hover:bg-[#f9fbfa] transition-colors px-4">
                <div class="w-[100px] min-w-[100px] font-normal">
                    {{ $floor->FloorId }}
                </div>
                <div class="flex-1 font-normal truncate">
                    {{ $floor->building->BuildingName ?? ($selectedBuilding->BuildingName ?? 'GGMB Residence · Tòa A') }}
                </div>
                <div class="w-[180px] min-w-[180px] font-normal floor-num">
                    {{ $floor->FloorNumber }}
                </div>
                <div class="w-[220px] min-w-[220px] flex items-center gap-1.5 text-[13px]">
                    <button
                        type="button"
                        onclick="openDetailFloorModal('{{ $floor->FloorId }}', '{{ $floor->FloorNumber }}', '{{ addslashes($floor->building->BuildingName ?? ($selectedBuilding->BuildingName ?? 'GGMB Residence · Tòa A')) }}')"
                        title="Xem chi tiết tầng"
                        class="p-1.5 text-[#0E4D3C] hover:bg-[#E4EFE9] rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span class="sr-only">Xem Chi tiết</span>
                    </button>
                    <button
                        type="button"
                        onclick="openEditFloorModal('{{ $floor->FloorId }}', '{{ $floor->FloorNumber }}')"
                        title="Sửa tầng"
                        class="p-1.5 text-[#374151] hover:text-[#0E4D3C] hover:bg-[#F3F4F6] rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="sr-only">Sửa</span>
                    </button>
                    <button
                        type="button"
                        onclick="openDeleteFloorModal('{{ $floor->FloorId }}', '{{ $floor->FloorNumber }}')"
                        title="Xóa tầng"
                        class="p-1.5 text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span class="sr-only">Xóa</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-sm text-[#6b7280]">
                Chưa có dữ liệu tầng cho tòa nhà này.
            </div>
        @endforelse
    </div>

    <!-- Phân trang theo mẫu ảnh -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1">
        <div class="text-[12px] text-[#6b7280]">
            Trang 1/1 · {{ count($floors) }} bản ghi hiện có
        </div>
        <div class="flex items-center space-x-2">
            <button type="button" class="px-4 py-2 bg-white border border-[#e5e7eb] rounded-[8px] text-[13px] font-medium text-[#374151] hover:bg-[#f9fafb] transition-colors cursor-pointer">
                Trang trước
            </button>
            <button type="button" class="px-4 py-2 bg-white border border-[#e5e7eb] rounded-[8px] text-[13px] font-medium text-[#374151] hover:bg-[#f9fafb] transition-colors cursor-pointer">
                Trang sau
            </button>
        </div>
    </div>

    <!-- Bottom Secondary Actions (Chỉnh sửa tòa, Thêm tầng) -->
    <div class="flex items-center gap-3 pt-2">
        <button
            type="button"
            onclick="openEditBuildingModal('{{ $selectedBuilding->BuildingId ?? 1 }}', '{{ addslashes($selectedBuilding->BuildingName ?? 'GGMB Residence · Tòa A') }}')"
            class="px-4 py-2 bg-white hover:bg-[#f9fafb] border border-[#e5e7eb] rounded-[8px] text-[13px] font-medium text-[#374151] transition-colors cursor-pointer"
        >
            Chỉnh sửa tòa {{ $selectedBuilding->BuildingName ?? 'A' }}
            <span class="sr-only">Chỉnh sửa tòa</span>
        </button>

        <button
            type="button"
            onclick="openCreateFloorModal()"
            class="px-4 py-2 bg-white hover:bg-[#f9fafb] border border-[#e5e7eb] rounded-[8px] text-[13px] font-medium text-[#374151] transition-colors cursor-pointer"
        >
            Thêm tầng
            <span class="sr-only">＋ Thêm tầng mới</span>
        </button>

        <button
            type="button"
            onclick="openDeleteBuildingModal()"
            class="px-3.5 py-2 bg-white hover:bg-rose-50 border border-rose-200 rounded-[8px] text-[13px] font-medium text-rose-600 transition-colors cursor-pointer ml-auto"
        >
            Xóa tòa
        </button>
    </div>
</div>

<!-- Modal Popup: Thêm tòa nhà (SCR-BLD-02) -->
@include('buildings.partials.create-modal')

<!-- Modal Popup: Chỉnh sửa tòa nhà (SCR-BLD-03) -->
@include('buildings.partials.edit-modal')

<!-- Modal Popups: Thao tác Tầng & Xóa tòa -->
@include('buildings.partials.floor-modal')
@endsection
