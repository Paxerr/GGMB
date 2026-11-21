@extends('layouts.app', [
    'title' => 'Thêm loại phí · GGMB',
    'active' => 'fee-rates',
    'breadcrumbs' => ['GGMB', 'Biểu phí']
])

@section('content')
<div class="max-w-[760px] mx-auto space-y-6 pb-12">
    <!-- Breadcrumb (Bám sát Ảnh 8) -->
    <nav class="flex items-center text-[13px] leading-[18px] text-[#52697c] space-x-2">
        <a href="{{ route('dashboard') }}" class="hover:text-[#2864ad] transition-colors">GGMB</a>
        <span>/</span>
        <a href="{{ route('fee-rates.index') }}" class="hover:text-[#2864ad] transition-colors">Biểu phí</a>
    </nav>

    <!-- Header (Bám sát Ảnh 8) -->
    <div class="space-y-1">
        <h1 class="text-[26px] leading-[32px] font-bold text-[#122d40]">
            Thêm loại phí
        </h1>
        <p class="text-[14px] leading-[20px] text-[#52697c]">
            Tạo danh mục trước; cấu hình đơn giá sau.
        </p>
    </div>

    <!-- Form Container (Bám sát Ảnh 8) -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 shadow-xs">
        <form method="POST" action="{{ route('fee-rates.store') }}">
            @csrf
            <div class="space-y-4">
                <!-- Hàng 1: Mã loại phí * & Tên loại phí * (2 cols) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="create_fee_code" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Mã loại phí *
                        </label>
                        <input
                            type="text"
                            id="create_fee_code"
                            name="code"
                            required
                            placeholder="Nhập mã loại phí"
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        />
                    </div>
                    <div>
                        <label for="create_fee_name" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Tên loại phí *
                        </label>
                        <input
                            type="text"
                            id="create_fee_name"
                            name="name"
                            required
                            placeholder="Nhập tên loại phí"
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        />
                    </div>
                </div>

                <!-- Hàng 2: Mô tả & Trạng thái * (2 cols) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="create_fee_desc" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Mô tả
                        </label>
                        <input
                            type="text"
                            id="create_fee_desc"
                            name="description"
                            placeholder="Nhập mô tả cách thu phí"
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        />
                    </div>
                    <div>
                        <label for="create_fee_status" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Trạng thái *
                        </label>
                        <div class="relative">
                            <select
                                id="create_fee_status"
                                name="status"
                                required
                                class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer"
                            >
                                <option value="ACTIVE" selected>Đang sử dụng ▾</option>
                                <option value="INACTIVE">Ngừng sử dụng</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Buttons (Hủy bên trái, Tạo loại phí bên phải - Bám sát Ảnh 8) -->
            <div class="pt-6 mt-6 border-t border-[#d9e4ec] flex items-center justify-between">
                <a
                    href="{{ route('fee-rates.index') }}"
                    class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none flex items-center justify-center"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm flex items-center justify-center"
                >
                    Tạo loại phí
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
