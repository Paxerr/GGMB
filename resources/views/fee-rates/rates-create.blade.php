@extends('layouts.app', [
    'title' => 'Thêm đơn giá mới · GGMB',
    'active' => 'fee-rates',
    'breadcrumbs' => ['GGMB', 'Biểu phí']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    <!-- Tiêu đề & Phụ đề (Bám sát Ảnh Thêm đơn giá mới) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-bold text-[#122d40]">
            Thêm đơn giá mới
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#52697c]">
            {{ $feeRate->name ?? 'Điện' }} · Không chồng khoảng hiệu lực với đơn giá đã lưu.
        </p>
    </div>

    <!-- Form container (Bám sát Ảnh Thêm đơn giá mới) -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 sm:p-7 w-full max-w-[688px] space-y-6 shadow-xs">
        <form method="POST" action="{{ route('fee-rates.rates.store', $feeRate->id ?? 1) }}" onsubmit="event.preventDefault(); if(window.showToast) window.showToast('Đã lưu đơn giá mới thành công.'); setTimeout(() => window.location.href='{{ route('fee-rates.show', $feeRate->id ?? 1) }}', 600);">
            @csrf
            <div class="space-y-5">
                <!-- Hàng 1: Loại phí * & Đơn giá (VND) * -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Loại phí *
                        </label>
                        <input
                            type="text"
                            readonly
                            value="{{ $feeRate->name ?? 'Điện' }} · chỉ đọc"
                            class="w-full h-[42px] px-3 bg-[#f8fafc] border border-[#d9e4ec] text-[14px] text-[#52697c] focus:outline-none cursor-not-allowed"
                        />
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Đơn giá (VND) *
                        </label>
                        <input
                            type="number"
                            required
                            min="0"
                            placeholder="Nhập đơn giá không âm"
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        />
                    </div>
                </div>

                <!-- Hàng 2: Hiệu lực từ * & Hiệu lực đến -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Hiệu lực từ *
                        </label>
                        <input
                            type="text"
                            required
                            placeholder="dd/mm/yyyy"
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        />
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Hiệu lực đến
                        </label>
                        <input
                            type="text"
                            placeholder="Để trống nếu không giới hạn"
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        />
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="flex items-center gap-4 pt-6 mt-6 border-t border-[#d9e4ec]">
                <a
                    href="{{ route('fee-rates.show', $feeRate->id ?? 1) }}"
                    class="h-[40px] px-8 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer select-none"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-8 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer select-none shadow-sm ml-auto"
                >
                    Lưu đơn giá
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
