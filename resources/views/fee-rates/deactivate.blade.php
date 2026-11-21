@extends('layouts.app', [
    'title' => 'Ngừng sử dụng loại phí · GGMB',
    'active' => 'fee-rates',
    'breadcrumbs' => ['GGMB', 'Biểu phí']
])

@section('content')
<div class="max-w-[760px] mx-auto space-y-6 pb-12">
    <!-- Breadcrumb (Bám sát Ảnh 10) -->
    <nav class="flex items-center text-[13px] leading-[18px] text-[#52697c] space-x-2">
        <a href="{{ route('dashboard') }}" class="hover:text-[#2864ad] transition-colors">GGMB</a>
        <span>/</span>
        <a href="{{ route('fee-rates.index') }}" class="hover:text-[#2864ad] transition-colors">Biểu phí</a>
    </nav>

    <!-- Header (Bám sát Ảnh 10) -->
    <div class="space-y-1">
        <h1 class="text-[26px] leading-[32px] font-bold text-[#b91c1c]">
            Ngừng sử dụng loại phí
        </h1>
        <p class="text-[14px] leading-[20px] text-[#52697c]">
            {{ $feeRate->name }} · Xác nhận ngừng dùng cho lần lập hóa đơn tiếp theo.
        </p>
    </div>

    <!-- Card Container (Bám sát Ảnh 10) -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 shadow-xs">
        <form method="POST" action="{{ route('fee-rates.confirm-deactivate', $feeRate->id) }}">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6">
                <div>
                    <span class="block text-[12px] font-semibold text-[#52697c]">Hiện tại</span>
                    <span class="block text-[15px] font-medium text-[#122d40] mt-1">{{ $feeRate->status_label }}</span>
                </div>
                <div>
                    <span class="block text-[12px] font-semibold text-[#52697c]">Sau xác nhận</span>
                    <span class="block text-[15px] font-medium text-[#b91c1c] mt-1">Ngừng sử dụng</span>
                </div>
            </div>

            <!-- Footer Buttons (Hủy bên trái, Ngừng sử dụng bên phải - Bám sát Ảnh 10) -->
            <div class="pt-6 border-t border-[#d9e4ec] flex items-center justify-between">
                <a
                    href="{{ route('fee-rates.show', $feeRate->id) }}"
                    class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none flex items-center justify-center"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-6 bg-[#b91c1c] hover:bg-[#991b1b] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm flex items-center justify-center"
                >
                    Ngừng sử dụng
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
