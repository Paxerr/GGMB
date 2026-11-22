@extends('layouts.app', [
    'title' => 'Chỉnh sửa loại phí · GGMB',
    'active' => 'fee-rates',
    'breadcrumbs' => ['Quản trị', 'Biểu phí', 'Chỉnh sửa']
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
        <span class="text-[#111827] font-medium">Chỉnh sửa</span>
    </nav>

    <!-- Header -->
    <div class="space-y-0.5">
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Chỉnh sửa loại phí
        </h1>
        <p class="text-[13.5px] text-[#6B7280]">
            {{ $feeRate->name }} · Chỉnh sửa thông tin danh mục.
        </p>
    </div>

    <!-- Form Container -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-6 shadow-none">
        <form method="POST" action="{{ route('fee-rates.update', $feeRate->id) }}">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <!-- Hàng 1: Mã định danh - chỉ đọc & Tên loại phí * (2 cols) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="edit_fee_code" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Mã định danh - chỉ đọc
                        </label>
                        <input
                            type="text"
                            id="edit_fee_code"
                            readonly
                            value="{{ $feeRate->code }}"
                            class="w-full h-[40px] px-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#6B7280] font-mono focus:outline-none cursor-not-allowed select-none"
                        />
                    </div>
                    <div>
                        <label for="edit_fee_name" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Tên loại phí *
                        </label>
                        <input
                            type="text"
                            id="edit_fee_name"
                            name="name"
                            required
                            value="{{ $feeRate->name }}"
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        />
                    </div>
                </div>

                <!-- Hàng 2: Mô tả & Trạng thái * (2 cols) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="edit_fee_desc" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Mô tả
                        </label>
                        <input
                            type="text"
                            id="edit_fee_desc"
                            name="description"
                            value="{{ $feeRate->description }}"
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        />
                    </div>
                    <div>
                        <label for="edit_fee_status" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Trạng thái *
                        </label>
                        <div class="relative">
                            <select
                                id="edit_fee_status"
                                name="status"
                                required
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] cursor-pointer"
                            >
                                <option value="ACTIVE" {{ $feeRate->status === 'ACTIVE' ? 'selected' : '' }}>Đang sử dụng ▾</option>
                                <option value="INACTIVE" {{ $feeRate->status === 'INACTIVE' ? 'selected' : '' }}>Ngừng sử dụng</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-6 mt-6 border-t border-[#E5E7EB] flex items-center justify-between">
                <a
                    href="{{ route('fee-rates.show', $feeRate->id) }}"
                    class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-medium rounded-[8px] transition-colors cursor-pointer select-none flex items-center justify-center"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm flex items-center justify-center"
                >
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
