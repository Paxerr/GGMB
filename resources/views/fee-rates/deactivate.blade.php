@extends('layouts.app', [
    'title' => 'Ngừng sử dụng loại phí · GGMB',
    'active' => 'fee-rates',
    'breadcrumbs' => ['Quản trị', 'Biểu phí', 'Ngừng sử dụng']
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
        <span class="text-[#B91C1C] font-medium">Ngừng sử dụng</span>
    </nav>

    <!-- Header -->
    <div class="space-y-0.5">
        <h1 class="text-[24px] font-bold text-[#B91C1C] tracking-tight">
            Ngừng sử dụng loại phí
        </h1>
        <p class="text-[13.5px] text-[#6B7280]">
            {{ $feeRate->name }} · Xác nhận ngừng dùng cho lần lập hóa đơn tiếp theo.
        </p>
    </div>

    <!-- Card Container -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-6 shadow-none">
        <form method="POST" action="{{ route('fee-rates.confirm-deactivate', $feeRate->id) }}">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6">
                <div>
                    <span class="block text-[12px] font-semibold text-[#6B7280]">Hiện tại</span>
                    <span class="block text-[15px] font-medium text-[#111827] mt-1">{{ $feeRate->status_label }}</span>
                </div>
                <div>
                    <span class="block text-[12px] font-semibold text-[#6B7280]">Sau xác nhận</span>
                    <span class="block text-[15px] font-semibold text-[#B91C1C] mt-1">Ngừng sử dụng</span>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-6 border-t border-[#E5E7EB] flex items-center justify-between">
                <a
                    href="{{ route('fee-rates.show', $feeRate->id) }}"
                    class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-medium rounded-[8px] transition-colors cursor-pointer select-none flex items-center justify-center"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-6 bg-[#B91C1C] hover:bg-[#991B1B] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm flex items-center justify-center"
                >
                    Ngừng sử dụng
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
