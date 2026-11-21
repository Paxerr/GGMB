@extends('layouts.app', [
    'title' => 'Tạo cư dân mới · GGMB',
    'active' => 'residents',
    'breadcrumbs' => ['GGMB', 'Cư dân', 'Tạo cư dân mới']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6 relative">
    <!-- Header Title & Subtitle (Nền mờ phía sau) -->
    <div class="opacity-40 pointer-events-none select-none">
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
            Danh bạ cư dân
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#334b5d]">
            Thông tin tài khoản cư dân và quan hệ cư trú
        </p>

        <!-- Dummy table background để tạo cảm giác modal popup đè lên danh sách -->
        <div class="mt-6 bg-white border border-[#d9e4ec] h-[360px] rounded-[4px]"></div>
    </div>

    <!-- Modal Popup Backdrop -->
    <div
        class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-[1px] flex items-center justify-center p-4 overflow-y-auto"
        onclick="if(event.target === this) window.location.href='{{ route('residents.index') }}'"
    >
        <!-- Modal Popup Panel (688px chuẩn Figma) -->
        <div class="relative w-full max-w-[688px] bg-white border border-[#d9e4ec] rounded-[4px] shadow-2xl my-8 overflow-hidden transform transition-all text-left">
            <!-- Modal Header -->
            <div class="px-7 pt-6 pb-4">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <a
                        href="{{ route('residents.index') }}"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </a>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1">
                    Tạo cư dân mới
                </h3>
                <p class="text-[13px] text-[#52697c] mt-1">
                    Tạo tài khoản cư dân và tiếp nhận vào căn hộ; * là trường bắt buộc.
                </p>
            </div>

            @if ($errors->any())
                <div class="mx-7 mb-3 p-3 bg-rose-50 border border-rose-200 text-rose-700 text-[13px] rounded-[4px]">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Modal Form -->
            <form action="{{ route('residents.store') }}" method="POST">
                @csrf
                <div class="px-7 pb-6 space-y-4">
                    <!-- Hàng 1: Tên đăng nhập * & Họ và tên * (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="user_name" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Tên đăng nhập <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="text"
                                id="user_name"
                                name="user_name"
                                value="{{ old('user_name') }}"
                                required
                                placeholder="Ví dụ: cudan01"
                                class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                        <div>
                            <label for="full_name" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Họ và tên <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="text"
                                id="full_name"
                                name="full_name"
                                value="{{ old('full_name') }}"
                                required
                                placeholder="Ví dụ: Nguyễn Văn An"
                                class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 2: Mật khẩu ban đầu * & Căn cước (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Mật khẩu ban đầu <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                placeholder="Tối thiểu 6 ký tự"
                                class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                        <div>
                            <label for="citizen_id" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Căn cước
                            </label>
                            <input
                                type="text"
                                id="citizen_id"
                                name="citizen_id"
                                value="{{ old('citizen_id') }}"
                                placeholder="Số CCCD 12 chữ số"
                                class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 3: Điện thoại & Email (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Điện thoại
                            </label>
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="Ví dụ: 0910000010"
                                class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                        <div>
                            <label for="email" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Email
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nguyenan@email.com"
                                class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 4: Căn hộ & Ngày bắt đầu cư trú (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="apartment_id" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Căn hộ <span class="text-rose-600">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    id="apartment_id"
                                    name="apartment_id"
                                    required
                                    class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                                >
                                    <option value="" disabled selected>Chọn căn hộ tiếp nhận…</option>
                                    @foreach ($apartments as $apt)
                                        <option value="{{ $apt->ApartmentId }}" {{ old('apartment_id') == $apt->ApartmentId ? 'selected' : '' }}>
                                            Căn {{ $apt->ApartmentNumber }} · Tầng {{ $apt->floor->FloorNumber ?? $apt->FloorId }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                                    ▾
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="start_date" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Ngày bắt đầu cư trú
                            </label>
                            <input
                                type="date"
                                id="start_date"
                                name="start_date"
                                value="{{ old('start_date', date('Y-m-d')) }}"
                                class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                    </div>

                    <!-- Khối thông tin liên quan (Accordion / Hướng dẫn nghiệp vụ) -->
                    <div class="pt-2">
                        <details class="group bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] p-3 text-[13px] text-[#52697c]">
                            <summary class="font-semibold text-[#334b5d] cursor-pointer select-none flex items-center justify-between">
                                <span class="tracking-wide uppercase text-[11px] font-bold text-slate-500">THÔNG TIN LIÊN QUAN</span>
                                <span class="text-xs transition-transform group-open:rotate-180">▾</span>
                            </summary>
                            <div class="mt-2.5 space-y-2 text-[12px] leading-[18px] border-t border-[#d9e4ec] pt-2">
                                <p>• <strong>Tài khoản cư dân:</strong> Tài khoản cư trú sẽ có hiệu lực ngay sau khi tiếp nhận thành công vào căn hộ.</p>
                                <p>• <strong>Quy tắc nhập liệu:</strong> Tên đăng nhập duy nhất; căn cước 12 số nếu có; mật khẩu tối thiểu 6 ký tự.</p>
                            </div>
                        </details>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-7 py-4 border-t border-[#d9e4ec] flex items-center justify-between">
                    <a
                        href="{{ route('residents.index') }}"
                        class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer select-none"
                    >
                        Hủy / Quay lại
                    </a>
                    <button
                        type="submit"
                        class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Tạo cư dân
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
