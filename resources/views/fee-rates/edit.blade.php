@extends('layouts.app', [
    'title' => 'Chỉnh sửa loại phí · GGMB',
    'active' => 'fee-rates',
    'breadcrumbs' => ['GGMB', 'Biểu phí']
])

@section('content')
<div class="max-w-[760px] mx-auto space-y-6 pb-12">
    <!-- Breadcrumb (Bám sát Ảnh 9) -->
    <nav class="flex items-center text-[13px] leading-[18px] text-[#52697c] space-x-2">
        <a href="{{ route('dashboard') }}" class="hover:text-[#2864ad] transition-colors">GGMB</a>
        <span>/</span>
        <a href="{{ route('fee-rates.index') }}" class="hover:text-[#2864ad] transition-colors">Biểu phí</a>
    </nav>

    <!-- Header (Bám sát Ảnh 9) -->
    <div class="space-y-1">
        <h1 class="text-[26px] leading-[32px] font-bold text-[#122d40]">
            Chỉnh sửa loại phí
        </h1>
        <p class="text-[14px] leading-[20px] text-[#52697c]">
            {{ $feeRate->name }} · Chỉnh sửa thông tin danh mục.
        </p>
    </div>

    <!-- Form Container (Bám sát Ảnh 9) -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 shadow-xs">
        <form method="POST" action="{{ route('fee-rates.update', $feeRate->id) }}">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <!-- Hàng 1: Mã định danh - chỉ đọc & Tên loại phí * (2 cols) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="edit_fee_code" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Mã định danh - chỉ đọc
                        </label>
                        <input
                            type="text"
                            id="edit_fee_code"
                            readonly
                            value="{{ $feeRate->code }}"
                            class="w-full h-[42px] px-3 bg-slate-50 border border-[#d9e4ec] text-[14px] text-[#52697c] focus:outline-none cursor-not-allowed select-none"
                        />
                    </div>
                    <div>
                        <label for="edit_fee_name" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Tên loại phí *
                        </label>
                        <input
                            type="text"
                            id="edit_fee_name"
                            name="name"
                            required
                            value="{{ $feeRate->name }}"
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        />
                    </div>
                </div>

                <!-- Hàng 2: Mô tả (1 col) -->
                <div>
                    <label for="edit_fee_desc" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                        Mô tả
                    </label>
                    <input
                        type="text"
                        id="edit_fee_desc"
                        name="description"
                        value="{{ $feeRate->description }}"
                        class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                    />
                </div>
            </div>

            <!-- Footer Buttons (Hủy bên trái, Lưu thay đổi bên phải - Bám sát Ảnh 9) -->
            <div class="pt-6 mt-6 border-t border-[#d9e4ec] flex items-center justify-between">
                <a
                    href="{{ route('fee-rates.show', $feeRate->id) }}"
                    class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none flex items-center justify-center"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm flex items-center justify-center"
                >
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
