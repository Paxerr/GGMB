@extends('layouts.app', [
    'title' => 'Chi tiết phương tiện · GGMB',
    'active' => 'vehicles',
    'breadcrumbs' => ['Quản trị', 'Xe & đăng ký']
])

@section('content')
<div class="space-y-6">
    <span class="sr-only">GGMB</span>
    @if (session('success'))
        <div class="p-4 bg-[#E4EFE9] border border-[#B8D5C7] text-[#0E4D3C] text-[13.5px] rounded-[8px] flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#0E4D3C] font-bold text-lg leading-none cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Tiêu đề & Phụ đề -->
    <div>
        <nav class="flex items-center text-[12px] text-[#6B7280] space-x-1.5 mb-1.5">
            <span>Quản trị</span>
            <span>/</span>
            <a href="{{ route('vehicles.index') }}" class="hover:text-[#0E4D3C]">Xe & đăng ký</a>
            <span>/</span>
            <span class="text-[#111827] font-medium">Chi tiết</span>
        </nav>
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Chi tiết phương tiện
        </h1>
        <p class="mt-0.5 text-[13.5px] text-[#6B7280]">
            Biển số {{ $vehicle->LicensePlate ?? '29-B1 100.01' }} · {{ $typeName ?? 'Xe máy' }}
        </p>
    </div>

    <!-- Khối thẻ thông tin nghiệp vụ: 688px -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-6 sm:p-[25px] w-full max-w-[688px] space-y-6 shadow-none">
        <!-- Hàng 1: Biển số & Loại xe -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <span class="block text-[12px] font-semibold text-[#6B7280]">
                    Biển số
                </span>
                <span class="block text-[15px] font-bold text-[#111827] mt-1 font-mono">
                    {{ $vehicle->LicensePlate ?? '29-B1 100.01' }}
                </span>
            </div>
            <div>
                <span class="block text-[12px] font-semibold text-[#6B7280]">
                    Loại xe
                </span>
                <span class="block text-[14px] font-medium text-[#111827] mt-1">
                    {{ $typeName ?? 'Xe máy' }}
                </span>
            </div>
        </div>

        <!-- Hàng 2: Căn hộ liên kết -->
        <div>
            <span class="block text-[12px] font-semibold text-[#6B7280]">
                Căn hộ liên kết
            </span>
            <span class="block text-[14px] font-medium text-[#111827] mt-1">
                {{ $buildingText ?? 'Tòa A · Tầng 1 · 0101' }}
            </span>
        </div>

        <!-- Hàng 3: 3 nút hành động -->
        <div class="flex flex-col sm:flex-row items-center gap-3 pt-2">
            <a
                href="{{ route('vehicles.index') }}"
                class="w-full sm:flex-1 h-[40px] bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-medium rounded-[8px] transition-colors flex items-center justify-center whitespace-nowrap cursor-pointer select-none"
            >
                Về danh sách
            </a>
            <a
                href="{{ route('vehicles.edit', $vehicle->VehicleId ?? 1) }}"
                class="w-full sm:flex-1 h-[40px] bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors flex items-center justify-center whitespace-nowrap cursor-pointer select-none shadow-sm"
            >
                Chỉnh sửa
            </a>
            <a
                href="{{ route('vehicles.cancel', $vehicle->VehicleId ?? 1) }}"
                class="w-full sm:flex-1 h-[40px] bg-white border border-[#E5E7EB] hover:bg-rose-50 text-[#B91C1C] text-[13.5px] font-semibold rounded-[8px] transition-colors flex items-center justify-center whitespace-nowrap cursor-pointer select-none"
            >
                Hủy đăng ký
            </a>
        </div>
    </div>
</div>
@endsection
