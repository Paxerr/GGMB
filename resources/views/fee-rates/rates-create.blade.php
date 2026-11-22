@extends('layouts.app', [
    'title' => 'Thêm đơn giá mới · GGMB',
    'active' => 'fee-rates',
    'breadcrumbs' => ['Quản trị', 'Biểu phí', 'Thêm đơn giá']
])

@section('content')
<div class="max-w-[760px] mx-auto space-y-6 pb-12">
    <span class="sr-only">GGMB</span>
    <!-- Breadcrumb -->
    <nav class="flex items-center text-[12px] text-[#6B7280] space-x-1.5 mb-1.5">
        <span>Quản trị</span>
        <span>/</span>
        <a href="{{ route('fee-rates.index') }}" class="hover:text-[#0E4D3C]">Biểu phí</a>
        <span>/</span>
        <span class="text-[#111827] font-medium">Thêm đơn giá mới</span>
    </nav>

    <!-- Tiêu đề & Phụ đề -->
    <div class="space-y-0.5">
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Thêm đơn giá mới
        </h1>
        <p class="text-[13.5px] text-[#6B7280]">
            {{ $feeRate->name ?? 'Điện' }} · Không chồng khoảng hiệu lực với đơn giá đã lưu.
        </p>
    </div>

    <!-- Form container -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-6 shadow-none">
        <form method="POST" action="{{ route('fee-rates.rates.store', $feeRate->id ?? 1) }}" onsubmit="event.preventDefault(); if(window.showToast) window.showToast('Đã lưu đơn giá mới thành công.'); setTimeout(() => window.location.href='{{ route('fee-rates.show', $feeRate->id ?? 1) }}', 600);">
            @csrf
            <div class="space-y-4">
                <!-- Hàng 1: Loại phí * & Đơn giá (VND) * -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Loại phí *
                        </label>
                        <input
                            type="text"
                            readonly
                            value="{{ $feeRate->name ?? 'Điện' }} · chỉ đọc"
                            class="w-full h-[40px] px-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#6B7280] focus:outline-none cursor-not-allowed"
                        />
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Đơn giá (VND) *
                        </label>
                        <input
                            type="number"
                            required
                            min="0"
                            placeholder="Nhập đơn giá không âm"
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        />
                    </div>
                </div>

                <!-- Hàng 2: Hiệu lực từ * & Hiệu lực đến -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Hiệu lực từ *
                        </label>
                        <input
                            type="text"
                            required
                            placeholder="dd/mm/yyyy"
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        />
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Hiệu lực đến (bỏ trống nếu đang áp dụng)
                        </label>
                        <input
                            type="text"
                            placeholder="dd/mm/yyyy"
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        />
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-6 mt-6 border-t border-[#E5E7EB] flex items-center justify-between">
                <a
                    href="{{ route('fee-rates.show', $feeRate->id ?? 1) }}"
                    class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-medium rounded-[8px] transition-colors flex items-center justify-center cursor-pointer select-none"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors flex items-center justify-center cursor-pointer select-none shadow-sm ml-auto"
                >
                    Lưu đơn giá
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
