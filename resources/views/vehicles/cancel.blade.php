@extends('layouts.app', [
    'title' => 'Hủy đăng ký phương tiện · GGMB',
    'active' => 'vehicles',
    'breadcrumbs' => ['Quản trị', 'Xe & đăng ký', 'Hủy đăng ký']
])

@section('content')
<div class="space-y-6">
    <span class="sr-only">GGMB</span>

    <!-- Tiêu đề & Phụ đề màu đỏ -->
    <div>
        <nav class="flex items-center text-[12px] text-[#6B7280] space-x-1.5 mb-1.5">
            <span>Quản trị</span>
            <span>/</span>
            <a href="{{ route('vehicles.index') }}" class="hover:text-[#0E4D3C]">Xe & đăng ký</a>
            <span>/</span>
            <span class="text-[#B91C1C] font-medium">Hủy đăng ký</span>
        </nav>
        <h1 class="text-[24px] font-bold text-[#B91C1C] tracking-tight">
            Hủy đăng ký phương tiện
        </h1>
        <p class="mt-0.5 text-[13.5px] text-[#B91C1C]">
            Xác nhận hủy đăng ký xe {{ $vehicle->LicensePlate ?? '29-B1 100.01' }} khỏi căn hộ {{ $apartmentNumber ?? '0101' }}.
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

        <!-- Hàng 3: 2 nút hành động (Giữ đăng ký / Xác nhận hủy) -->
        <form method="POST" action="{{ route('vehicles.confirm-cancel', $vehicle->VehicleId ?? 1) }}" class="flex flex-col sm:flex-row items-center gap-3 pt-2">
            @csrf
            <a
                href="{{ route('vehicles.show', $vehicle->VehicleId ?? 1) }}"
                class="w-full sm:w-[204px] h-[40px] bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-medium rounded-[8px] transition-colors flex items-center justify-center whitespace-nowrap cursor-pointer select-none"
            >
                Giữ đăng ký
            </a>
            <button
                type="submit"
                class="w-full sm:w-[204px] h-[40px] bg-[#B91C1C] hover:bg-[#991B1B] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors flex items-center justify-center whitespace-nowrap cursor-pointer select-none shadow-sm"
            >
                Xác nhận hủy
            </button>
        </form>
    </div>
</div>
@endsection
