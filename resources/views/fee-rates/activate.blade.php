@extends('layouts.app', [
    'title' => 'Kích hoạt lại loại phí · GGMB',
    'active' => 'fee-rates',
    'breadcrumbs' => ['Quản trị', 'Biểu phí', 'Kích hoạt lại']
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
        <span class="text-[#0E4D3C] font-medium">Kích hoạt lại</span>
    </nav>

    <!-- Tiêu đề & Phụ đề -->
    <div class="space-y-0.5">
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Kích hoạt lại loại phí
        </h1>
        <p class="text-[13.5px] text-[#6B7280]">
            Chỉ áp dụng khi loại phí đang ngừng sử dụng.
        </p>
    </div>

    <!-- Khối thẻ xác nhận -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-6 shadow-none">
        <form method="POST" action="{{ route('fee-rates.confirm-activate', $feeRate->id ?? 1) }}">
            @csrf
            <!-- 2 Cột thông tin -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6">
                <div>
                    <span class="block text-[12px] font-semibold text-[#6B7280]">
                        Loại phí
                    </span>
                    <span class="block text-[15px] text-[#111827] mt-1 font-semibold">
                        {{ $feeRate->name ?? 'Điện' }}
                    </span>
                </div>
                <div>
                    <span class="block text-[12px] font-semibold text-[#6B7280]">
                        Sau xác nhận
                    </span>
                    <span class="inline-block mt-1 px-2.5 py-0.5 rounded-[6px] text-xs font-semibold bg-[#E4EFE9] text-[#0E4D3C]">
                        Đang sử dụng
                    </span>
                </div>
            </div>

            <!-- 2 Nút hành động -->
            <div class="flex items-center justify-between pt-6 border-t border-[#E5E7EB]">
                <a
                    href="{{ route('fee-rates.index') }}"
                    class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-medium rounded-[8px] transition-colors flex items-center justify-center cursor-pointer select-none"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors flex items-center justify-center cursor-pointer select-none shadow-sm ml-auto"
                >
                    Kích hoạt lại
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
