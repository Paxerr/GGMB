@extends('layouts.app', [
    'title' => 'Chi tiết loại phí và lịch sử đơn giá · GGMB',
    'active' => 'fee-rates',
    'breadcrumbs' => ['GGMB', 'Biểu phí']
])

@section('content')
<div class="max-w-[760px] mx-auto space-y-6 pb-12">
    <!-- Breadcrumb (Bám sát Ảnh 7) -->
    <nav class="flex items-center text-[13px] leading-[18px] text-[#52697c] space-x-2">
        <a href="{{ route('dashboard') }}" class="hover:text-[#2864ad] transition-colors">GGMB</a>
        <span>/</span>
        <a href="{{ route('fee-rates.index') }}" class="hover:text-[#2864ad] transition-colors">Biểu phí</a>
    </nav>

    <!-- Header (Bám sát Ảnh 7) -->
    <div class="space-y-1">
        <h1 class="text-[26px] leading-[32px] font-bold text-[#122d40]">
            Chi tiết loại phí và lịch sử đơn giá
        </h1>
        <p class="text-[14px] leading-[20px] text-[#52697c]">
            {{ $feeRate->name }} · {{ $feeRate->status_label }}
        </p>
    </div>

    <!-- Card Container (Bám sát Ảnh 7) -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 shadow-xs space-y-6">
        <!-- Hàng 1: Tên loại phí & Mã định danh (2 cols) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c]">Tên loại phí</span>
                <span class="block text-[15px] font-medium text-[#122d40] mt-1">{{ $feeRate->name }}</span>
            </div>
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c]">Mã định danh</span>
                <span class="block text-[15px] font-medium text-[#122d40] mt-1">{{ $feeRate->code }}</span>
            </div>
        </div>

        <!-- Hàng 2: Mô tả & Trạng thái (2 cols) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c]">Mô tả</span>
                <span class="block text-[14px] text-[#334b5d] mt-1">{{ $feeRate->description }}</span>
            </div>
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c]">Trạng thái</span>
                <span class="block text-[14px] font-medium text-[#122d40] mt-1">{{ $feeRate->status_label }}</span>
            </div>
        </div>

        <!-- Section: ĐƠN GIÁ ĐÃ LƯU (Bám sát Ảnh 7) -->
        <div>
            <h4 class="text-[12px] font-bold text-slate-500 uppercase tracking-wider mb-2">
                ĐƠN GIÁ ĐÃ LƯU
            </h4>
            <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-4 flex items-center justify-between">
                <div>
                    <span class="text-[14px] font-semibold text-[#122d40]">
                        {{ number_format($feeRate->price, 0, ',', '.') }} đ
                    </span>
                    <span class="text-[13px] text-[#52697c] ml-1">
                        · Từ {{ $feeRate->effective_from }} · Chưa có ngày kết thúc
                    </span>
                </div>
                <button
                    type="button"
                    onclick="openEditRateModal({name: '{{ $feeRate->name }}', price: {{ $feeRate->price }}, effective_from: '{{ $feeRate->effective_from }}'})"
                    class="text-[13px] font-medium text-[#2864ad] hover:text-[#205391] hover:underline cursor-pointer"
                >
                    Sửa đơn giá ➔
                </button>
            </div>
        </div>

        <!-- Footer Buttons (Về danh mục bên trái, Thêm đơn giá bên phải - Bám sát Ảnh 7) -->
        <div class="pt-6 border-t border-[#d9e4ec] flex items-center justify-between">
            <a
                href="{{ route('fee-rates.index') }}"
                class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none flex items-center justify-center"
            >
                Về danh mục
            </a>
            <div class="flex items-center gap-3">
                <a
                    href="{{ route('fee-rates.deactivate', $feeRate->id) }}"
                    class="h-[40px] px-5 bg-white border border-[#d9e4ec] hover:bg-rose-50 text-rose-600 text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none flex items-center justify-center"
                >
                    Ngừng sử dụng
                </a>
                <a
                    href="{{ route('fee-rates.rates.create', $feeRate->id) }}"
                    class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm flex items-center justify-center"
                >
                    Thêm đơn giá
                </a>
            </div>
        </div>
    </div>
</div>

@include('fee-rates.partials.rate-modal')
@endsection
