@extends('layouts.app', [
    'title' => 'Hủy đăng ký phương tiện · GGMB',
    'active' => 'vehicles',
    'breadcrumbs' => ['GGMB', 'Xe & đăng ký']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    <!-- Tiêu đề & Phụ đề màu đỏ (29 · SCR-VEH-05) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#b91c1c]">
            Hủy đăng ký phương tiện
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#e05252]">
            Xác nhận hủy đăng ký xe {{ $vehicle->LicensePlate ?? '29-B1 100.01' }} khỏi căn hộ {{ $apartmentNumber ?? '0101' }}.
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

        <!-- Hàng 3: 2 nút hành động (Giữ đăng ký / Xác nhận hủy) -->
        <form method="POST" action="{{ route('vehicles.confirm-cancel', $vehicle->VehicleId ?? 1) }}" class="flex flex-col sm:flex-row items-center gap-3 pt-2">
            @csrf
            <a
                href="{{ route('vehicles.show', $vehicle->VehicleId ?? 1) }}"
                class="w-full sm:w-[204px] h-[40px] bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center whitespace-nowrap cursor-pointer select-none"
            >
                Giữ đăng ký
            </a>
            <button
                type="submit"
                class="w-full sm:w-[204px] h-[40px] bg-[#b91c1c] hover:bg-[#991b1b] text-white text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center whitespace-nowrap cursor-pointer select-none shadow-sm"
            >
                Xác nhận hủy
            </button>
        </form>
    </div>
</div>
@endsection
