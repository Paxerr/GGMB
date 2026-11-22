@extends('layouts.app', [
    'title' => 'Tạo cư dân mới · GGMB',
    'active' => 'residents',
    'breadcrumbs' => ['Quản trị', 'Cư dân', 'Tạo cư dân mới']
])

@section('content')
<div class="space-y-6 relative">
    <span class="sr-only">GGMB</span>

    <!-- Modal Popup Backdrop -->
    <div
        class="fixed inset-0 z-50 bg-[#000000]/40 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto"
        onclick="if(event.target === this) window.location.href='{{ route('residents.index') }}'"
    >
        <!-- Modal Popup Panel (688px chuẩn) -->
        <div class="relative w-full max-w-[688px] bg-white border border-[#E5E7EB] rounded-[16px] shadow-2xl my-8 overflow-hidden transform transition-all text-left">
            <!-- Modal Header -->
            <div class="px-7 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <a
                        href="{{ route('residents.index') }}"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </a>
                </div>
                <h3 class="text-[20px] font-bold text-[#111827] mt-1">
                    Tạo cư dân mới
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-0.5">
                    Tạo tài khoản cư dân và tiếp nhận vào căn hộ; * là trường bắt buộc.
                </p>
            </div>

            @if ($errors->any())
                <div class="mx-7 my-3 p-3 bg-rose-50 border border-rose-200 text-rose-700 text-[13px] rounded-[8px]">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Modal Form -->
            <form action="{{ route('residents.store') }}" method="POST">
                @csrf
                <div class="px-7 py-5 space-y-4">
                    <!-- Hàng 1: Tên đăng nhập * & Họ và tên * (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="user_name" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Tên đăng nhập <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="text"
                                id="user_name"
                                name="user_name"
                                value="{{ old('user_name') }}"
                                required
                                placeholder="Ví dụ: cudan01"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                        <div>
                            <label for="full_name" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Họ và tên <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="text"
                                id="full_name"
                                name="full_name"
                                value="{{ old('full_name') }}"
                                required
                                placeholder="Ví dụ: Nguyễn Văn An"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 2: Mật khẩu ban đầu * & Căn cước (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Mật khẩu ban đầu <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                placeholder="Tối thiểu 6 ký tự"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                        <div>
                            <label for="citizen_id" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Căn cước
                            </label>
                            <input
                                type="text"
                                id="citizen_id"
                                name="citizen_id"
                                value="{{ old('citizen_id') }}"
                                placeholder="Số CCCD 12 chữ số"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 3: Điện thoại & Email (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Điện thoại
                            </label>
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="Ví dụ: 0910000010"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
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
                                value="{{ old('email') }}"
                                placeholder="nguyenan@email.com"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 4: Căn hộ tiếp nhận & Ngày bắt đầu cư trú (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="apartment_id" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Căn hộ <span class="text-rose-600">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    id="apartment_id"
                                    name="apartment_id"
                                    required
                                    class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                                >
                                    <option value="" disabled selected>Chọn căn hộ tiếp nhận…</option>
                                    @foreach ($apartments as $apt)
                                        <option value="{{ $apt->ApartmentId }}" {{ old('apartment_id') == $apt->ApartmentId ? 'selected' : '' }}>
                                            Căn {{ $apt->ApartmentNumber }} · Tầng {{ $apt->floor->FloorNumber ?? $apt->FloorId }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">
                                    ▾
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="start_date" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Ngày bắt đầu cư trú
                            </label>
                            <input
                                type="date"
                                id="start_date"
                                name="start_date"
                                value="{{ old('start_date', date('Y-m-d')) }}"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <!-- Khối thông tin liên quan -->
                    <div class="pt-2">
                        <details class="group bg-[#F8FAF8] border border-[#E5E7EB] rounded-[10px] p-3 text-[13px] text-[#6B7280]">
                            <summary class="font-semibold text-[#374151] cursor-pointer select-none flex items-center justify-between">
                                <span class="tracking-wide uppercase text-[11px] font-bold text-[#111827]">THÔNG TIN LIÊN QUAN</span>
                                <span class="text-xs transition-transform group-open:rotate-180">▾</span>
                            </summary>
                            <div class="mt-2.5 space-y-2 text-[12.5px] leading-[18px] border-t border-[#E5E7EB] pt-2">
                                <p>• <strong>Tài khoản cư dân:</strong> Tài khoản cư trú sẽ có hiệu lực ngay sau khi tiếp nhận thành công vào căn hộ.</p>
                                <p>• <strong>Quy tắc nhập liệu:</strong> Tên đăng nhập duy nhất; căn cước 12 số nếu có; mật khẩu tối thiểu 6 ký tự.</p>
                            </div>
                        </details>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-7 py-4 border-t border-[#E5E7EB] flex items-center justify-between rounded-b-[16px] bg-white">
                    <a
                        href="{{ route('residents.index') }}"
                        class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-semibold rounded-[8px] transition-colors flex items-center justify-center cursor-pointer select-none"
                    >
                        Hủy / Quay lại
                    </a>
                    <button
                        type="submit"
                        class="h-[40px] px-5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Tạo cư dân
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
