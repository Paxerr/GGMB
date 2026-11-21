@extends('layouts.app', [
    'title' => 'Chi tiết phương tiện · GGMB',
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

    <!-- Tiêu đề & Phụ đề (26 · SCR-VEH-02) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
            Chi tiết phương tiện
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#334b5d]">
            Biển số {{ $vehicle->LicensePlate ?? '29-B1 100.01' }} · {{ $typeName ?? 'Xe máy' }}
        </p>
    </div>

    <!-- Khối thẻ thông tin nghiệp vụ: 688px (bám sát ảnh chụp màn hình) -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 sm:p-[25px] w-full max-w-[688px] space-y-6">
        <!-- Hàng 1: Biển số & Loại xe -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <span class="block text-[12px] leading-[17px] font-semibold text-[#334b5d]">
                    Biển số
                </span>
                <span class="block text-[14px] leading-[20px] text-[#122d40] mt-1 font-normal">
                    {{ $vehicle->LicensePlate ?? '29-B1 100.01' }}
                </span>
            </div>
            <div>
                <span class="block text-[12px] leading-[17px] font-semibold text-[#334b5d]">
                    Loại xe
                </span>
                <span class="block text-[14px] leading-[20px] text-[#122d40] mt-1 font-normal">
                    {{ $typeName ?? 'Xe máy' }}
                </span>
            </div>
        </div>

        <!-- Hàng 2: Căn hộ liên kết -->
        <div>
            <span class="block text-[12px] leading-[17px] font-semibold text-[#334b5d]">
                Căn hộ liên kết
            </span>
            <span class="block text-[14px] leading-[20px] text-[#122d40] mt-1 font-normal">
                {{ $buildingText ?? 'Tòa A · Tầng 1 · 0101' }}
            </span>
        </div>

        <!-- Hàng 3: 3 nút hành động (Về danh sách / Chỉnh sửa / Hủy đăng ký) -->
        <div class="flex flex-col sm:flex-row items-center gap-3 pt-2">
            <a
                href="{{ route('vehicles.index') }}"
                class="w-full sm:flex-1 h-[40px] bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center whitespace-nowrap cursor-pointer select-none"
            >
                Về danh sách
            </a>
            <a
                href="{{ route('vehicles.edit', $vehicle->VehicleId ?? 1) }}"
                class="w-full sm:flex-1 h-[40px] bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center whitespace-nowrap cursor-pointer select-none shadow-sm"
            >
                Chỉnh sửa
            </a>
            <a
                href="{{ route('vehicles.cancel', $vehicle->VehicleId ?? 1) }}"
                class="w-full sm:flex-1 h-[40px] bg-white border border-[#d9e4ec] hover:bg-rose-50 text-[#b91c1c] text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center whitespace-nowrap cursor-pointer select-none"
            >
                Hủy đăng ký
            </a>
        </div>
    </div>
</div>
@endsection
