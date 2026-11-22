@extends('layouts.app', [
    'title' => 'Chỉnh sửa cư dân · ' . $resident->FullName . ' · GGMB',
    'active' => 'residents',
    'breadcrumbs' => ['Quản trị', 'Cư dân', 'Chỉnh sửa thông tin cư dân']
])

@section('content')
<div class="space-y-6">
    <span class="sr-only">GGMB</span>
    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 text-[13.5px] rounded-[8px] flex items-center justify-between">
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-700 font-bold text-lg leading-none cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Header Title & Subtitle -->
    <div>
        <nav class="flex items-center text-[12px] text-[#6B7280] space-x-1.5 mb-1.5">
            <span>Quản trị</span>
            <span>/</span>
            <a href="{{ route('residents.index') }}" class="hover:text-[#0E4D3C]">Cư dân</a>
            <span>/</span>
            <span class="text-[#111827] font-medium">Chỉnh sửa</span>
        </nav>
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Chỉnh sửa thông tin cư dân
        </h1>
        <p class="mt-0.5 text-[13.5px] text-[#6B7280]">
            {{ $resident->FullName }} · Chỉ cập nhật hồ sơ cá nhân.
        </p>
    </div>

    <!-- Biểu mẫu và hướng dẫn -->
    <div class="flex flex-col lg:flex-row items-start gap-6 pt-2">
        <!-- Cột trái: Form Thông tin nghiệp vụ -->
        <div class="w-full lg:w-[688px] bg-white border border-[#E5E7EB] rounded-[14px] p-6 shrink-0 shadow-none">
            <form action="{{ route('residents.update', $resident->UserId) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <!-- Hàng 1: Họ và tên & Mật khẩu mới -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="full_name" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Họ và tên <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="text"
                                id="full_name"
                                name="full_name"
                                value="{{ old('full_name', $resident->FullName) }}"
                                required
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                        <div>
                            <label for="password" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Mật khẩu mới (bỏ trống nếu giữ nguyên)
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="••••••••"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 2: Điện thoại & Email -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Điện thoại
                            </label>
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                value="{{ old('phone', $resident->Phone) }}"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                        <div>
                            <label for="email" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Email
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $resident->Email) }}"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 3: Căn cước & Căn hộ -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="citizen_id" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Căn cước
                            </label>
                            <input
                                type="text"
                                id="citizen_id"
                                name="citizen_id"
                                value="{{ old('citizen_id', $resident->CitizenId) }}"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                        <div>
                            <label for="apartment_id" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Căn hộ
                            </label>
                            <div class="relative">
                                <select
                                    id="apartment_id"
                                    name="apartment_id"
                                    class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                                >
                                    <option value="">-- Giữ nguyên căn hộ hiện tại --</option>
                                    @foreach ($apartments as $apt)
                                        <option value="{{ $apt->ApartmentId }}" {{ (old('apartment_id', $activeResidency?->ApartmentId) == $apt->ApartmentId) ? 'selected' : '' }}>
                                            Căn {{ $apt->ApartmentNumber }} (Tầng {{ $apt->floor?->FloorNumber ?? '1' }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">
                                    ▾
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hàng thao tác -->
                    <div class="pt-4 border-t border-[#E5E7EB] flex items-center justify-between gap-4">
                        <a
                            href="{{ route('residents.index') }}"
                            class="px-5 h-[40px] bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-medium rounded-[8px] transition-colors flex items-center justify-center cursor-pointer"
                        >
                            Hủy
                        </a>

                        <button
                            type="submit"
                            class="px-6 h-[40px] bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors flex items-center justify-center cursor-pointer shadow-sm"
                        >
                            Lưu thay đổi
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Cột phải: Lưu ý chỉnh sửa -->
        <div class="w-full lg:w-[440px] space-y-4">
            <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-6 space-y-4 shadow-none">
                <h3 class="text-[12px] font-bold text-[#111827] tracking-wider uppercase">
                    LƯU Ý KHI CHỈNH SỬA
                </h3>

                <div class="p-3.5 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[10px] space-y-1">
                    <h4 class="text-[13px] font-bold text-[#111827]">Thông tin cá nhân</h4>
                    <p class="text-[12.5px] leading-[19px] text-[#6B7280]">
                        Họ và tên, CCCD và số điện thoại cần chính xác để đối chiếu thông tin trong trường hợp bàn giao tài sản hoặc cấp thẻ cư dân.
                    </p>
                </div>

                <div class="p-3.5 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[10px] space-y-1">
                    <h4 class="text-[13px] font-bold text-[#111827]">Đổi căn hộ cư trú</h4>
                    <p class="text-[12.5px] leading-[19px] text-[#6B7280]">
                        Nếu chuyển sang căn hộ mới, quan hệ cư trú tại căn hộ cũ sẽ tự động được đóng lại và tạo quan hệ cư trú mới.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
