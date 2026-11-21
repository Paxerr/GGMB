@extends('layouts.app', [
    'title' => 'Chỉnh sửa cư dân · ' . $resident->FullName . ' · GGMB',
    'active' => 'residents',
    'breadcrumbs' => ['GGMB', 'Cư dân', 'Chỉnh sửa thông tin cư dân']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 text-[14px] rounded-[4px] flex items-center justify-between">
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-700 font-bold text-lg leading-none cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Header Title & Subtitle (19 · SCR-RES-04) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
            Chỉnh sửa thông tin cư dân
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#334b5d]">
            {{ $resident->FullName }} · Chỉ cập nhật hồ sơ cá nhân.
        </p>
    </div>

    <!-- Biểu mẫu và hướng dẫn -->
    <div class="flex flex-col lg:flex-row items-start gap-6 pt-2">
        <!-- Cột trái: Form Thông tin nghiệp vụ (w=688px chuẩn Figma) -->
        <div class="w-full lg:w-[688px] bg-white border border-solid border-[#d9e4ec] rounded-[4px] p-6 shrink-0">
            <form action="{{ route('residents.update', $resident->UserId) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-5">
                    <!-- Hàng 1: Họ và tên & Mật khẩu mới -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="full_name" class="block text-[12px] leading-[17px] font-semibold text-[#334b5d] mb-1.5">
                                Họ và tên <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="text"
                                id="full_name"
                                name="full_name"
                                value="{{ old('full_name', $resident->FullName) }}"
                                required
                                class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                        <div>
                            <label for="password" class="block text-[12px] leading-[17px] font-semibold text-[#334b5d] mb-1.5">
                                Mật khẩu mới (bỏ trống nếu giữ nguyên)
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="••••••••"
                                class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 2: Điện thoại & Email -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-[12px] leading-[17px] font-semibold text-[#334b5d] mb-1.5">
                                Điện thoại
                            </label>
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                value="{{ old('phone', $resident->Phone) }}"
                                class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                        <div>
                            <label for="email" class="block text-[12px] leading-[17px] font-semibold text-[#334b5d] mb-1.5">
                                Email
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $resident->Email) }}"
                                class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 3: Căn cước & Căn hộ -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="citizen_id" class="block text-[12px] leading-[17px] font-semibold text-[#334b5d] mb-1.5">
                                Căn cước
                            </label>
                            <input
                                type="text"
                                id="citizen_id"
                                name="citizen_id"
                                value="{{ old('citizen_id', $resident->CitizenId) }}"
                                class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                        <div>
                            <label for="apartment_id" class="block text-[12px] leading-[17px] font-semibold text-[#334b5d] mb-1.5">
                                Căn hộ
                            </label>
                            <div class="relative">
                                <select
                                    id="apartment_id"
                                    name="apartment_id"
                                    class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                                >
                                    <option value="">-- Giữ nguyên căn hộ hiện tại --</option>
                                    @foreach ($apartments as $apt)
                                        <option value="{{ $apt->ApartmentId }}" {{ (old('apartment_id', $activeResidency?->ApartmentId) == $apt->ApartmentId) ? 'selected' : '' }}>
                                            Căn {{ $apt->ApartmentNumber }} (Tầng {{ $apt->floor?->FloorNumber ?? '1' }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                                    ▾
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hàng thao tác (Nút Hủy và Nút Lưu thay đổi) -->
                    <div class="pt-6 border-t border-[#d9e4ec] flex items-center justify-between gap-4">
                        <a
                            href="{{ route('residents.index') }}"
                            class="w-[204px] h-[40px] px-4 bg-white border border-solid border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-medium rounded-[4px] transition-colors flex items-center justify-center cursor-pointer"
                        >
                            Hủy
                        </a>

                        <button
                            type="submit"
                            class="w-[204px] h-[40px] px-4 bg-[#2864ad] hover:bg-[#205391] border border-solid border-[#2864ad] text-white text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer"
                        >
                            Lưu thay đổi
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Cột phải: Lưu ý chỉnh sửa (w=440px) -->
        <div class="w-full lg:w-[440px] space-y-4">
            <div class="bg-white border border-solid border-[#d9e4ec] rounded-[4px] p-6 space-y-4">
                <h3 class="text-[12px] leading-[17px] font-semibold text-[#52697c] tracking-wider uppercase">
                    LƯU Ý KHI CHỈNH SỬA
                </h3>

                <div class="p-3 bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] space-y-1">
                    <h4 class="text-[13px] font-semibold text-[#122d40]">Thông tin cá nhân</h4>
                    <p class="text-[13px] leading-[19px] text-[#52697c]">
                        Họ và tên, CCCD và số điện thoại cần chính xác để đối chiếu thông tin trong trường hợp bàn giao tài sản hoặc cấp thẻ cư dân.
                    </p>
                </div>

                <div class="p-3 bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] space-y-1">
                    <h4 class="text-[13px] font-semibold text-[#122d40]">Đổi căn hộ cư trú</h4>
                    <p class="text-[13px] leading-[19px] text-[#52697c]">
                        Nếu chuyển sang căn hộ mới, quan hệ cư trú tại căn hộ cũ sẽ tự động được đóng lại và tạo quan hệ cư trú mới.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
