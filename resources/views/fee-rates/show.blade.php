@extends('layouts.app', [
    'title' => 'Chi tiết loại phí và lịch sử đơn giá · GGMB',
    'active' => 'fee-rates',
    'breadcrumbs' => ['Quản trị', 'Biểu phí', 'Chi tiết']
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
        <span class="text-[#111827] font-medium">Chi tiết loại phí</span>
    </nav>

    <!-- Header -->
    <div class="space-y-0.5">
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Chi tiết loại phí và lịch sử đơn giá
        </h1>
        <p class="text-[13.5px] text-[#6B7280]">
            {{ $feeRate->name }} · {{ $feeRate->status_label }}
        </p>
    </div>

    <!-- Card Container -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-6 shadow-none space-y-6">
        <!-- Hàng 1: Tên loại phí & Mã định danh (2 cols) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="block text-[12px] font-semibold text-[#6B7280]">Tên loại phí</span>
                <span class="block text-[15px] font-bold text-[#111827] mt-1">{{ $feeRate->name }}</span>
            </div>
            <div>
                <span class="block text-[12px] font-semibold text-[#6B7280]">Mã định danh</span>
                <span class="block text-[15px] font-semibold text-[#111827] mt-1 font-mono">{{ $feeRate->code }}</span>
            </div>
        </div>

        <!-- Hàng 2: Mô tả & Trạng thái (2 cols) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="block text-[12px] font-semibold text-[#6B7280]">Mô tả</span>
                <span class="block text-[14px] text-[#374151] mt-1">{{ $feeRate->description }}</span>
            </div>
            <div>
                <span class="block text-[12px] font-semibold text-[#6B7280]">Trạng thái</span>
                <span class="inline-block mt-1 px-2.5 py-0.5 rounded-[6px] text-xs font-semibold bg-[#E4EFE9] text-[#0E4D3C]">{{ $feeRate->status_label }}</span>
            </div>
        </div>

        <!-- Section: ĐƠN GIÁ ĐÃ LƯU -->
        <div>
            <h4 class="text-[12px] font-bold text-[#111827] uppercase tracking-wider mb-2">
                ĐƠN GIÁ ĐÃ LƯU
            </h4>
            <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[10px] p-4 flex items-center justify-between">
                <div>
                    <span class="text-[15px] font-bold text-[#111827] font-mono">
                        {{ number_format($feeRate->price, 0, ',', '.') }} đ
                    </span>
                    <span class="text-[13px] text-[#6B7280] ml-1">
                        · Từ {{ $feeRate->effective_from }} · Chưa có ngày kết thúc
                    </span>
                </div>
                <button
                    type="button"
                    onclick="openEditRateModal({name: '{{ $feeRate->name }}', price: {{ $feeRate->price }}, effective_from: '{{ $feeRate->effective_from }}'})"
                    class="text-[13px] font-semibold text-[#0E4D3C] hover:underline cursor-pointer"
                >
                    Sửa đơn giá ➔
                </button>
            </div>
        </div>

        <!-- Footer Buttons -->
        <div class="pt-6 border-t border-[#E5E7EB] flex items-center justify-between">
            <a
                href="{{ route('fee-rates.index') }}"
                class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-medium rounded-[8px] transition-colors cursor-pointer select-none flex items-center justify-center"
            >
                Về danh mục
            </a>
            <div class="flex items-center gap-3">
                <a
                    href="{{ route('fee-rates.deactivate', $feeRate->id) }}"
                    class="h-[40px] px-4 bg-white border border-[#E5E7EB] hover:bg-rose-50 text-rose-600 text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none flex items-center justify-center"
                >
                    Ngừng sử dụng
                </a>
                <a
                    href="{{ route('fee-rates.rates.create', $feeRate->id) }}"
                    class="h-[40px] px-5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm flex items-center justify-center"
                >
                    Thêm đơn giá
                </a>
            </div>
        </div>
    </div>
</div>

@include('fee-rates.partials.rate-modal')
@endsection
