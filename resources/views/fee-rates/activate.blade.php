@extends('layouts.app', [
    'title' => 'Kích hoạt lại loại phí · GGMB',
    'active' => 'fee-rates',
    'breadcrumbs' => ['GGMB', 'Biểu phí']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    <!-- Tiêu đề & Phụ đề (Bám sát Ảnh Kích hoạt lại loại phí) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-bold text-[#122d40]">
            Kích hoạt lại loại phí
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#52697c]">
            Chỉ áp dụng khi loại phí đang ngừng sử dụng.
        </p>
    </div>

    <!-- Khối thẻ xác nhận (Bám sát Ảnh Kích hoạt lại loại phí) -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 sm:p-7 w-full max-w-[688px] space-y-6 shadow-xs">
        <form method="POST" action="{{ route('fee-rates.confirm-activate', $feeRate->id ?? 1) }}" onsubmit="event.preventDefault(); if(window.showToast) window.showToast('Đã kích hoạt lại loại phí thành công.'); setTimeout(() => window.location.href='{{ route('fee-rates.index') }}', 600);">
            @csrf
            <!-- 2 Cột thông tin -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                        Loại phí
                    </span>
                    <span class="block text-[14px] leading-[20px] text-[#122d40] mt-1.5 font-medium">
                        {{ $feeRate->name ?? 'Điện' }}
                    </span>
                </div>
                <div>
                    <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                        Sau xác nhận
                    </span>
                    <span class="block text-[14px] leading-[20px] text-[#122d40] mt-1.5 font-medium">
                        Đang sử dụng
                    </span>
                </div>
            </div>

            <!-- 2 Nút hành động (Hủy bên trái, Kích hoạt lại bên phải) -->
            <div class="flex items-center gap-4 pt-6 mt-6">
                <a
                    href="{{ route('fee-rates.index') }}"
                    class="h-[40px] px-8 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer select-none"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-8 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer select-none shadow-sm ml-auto"
                >
                    Kích hoạt lại
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
