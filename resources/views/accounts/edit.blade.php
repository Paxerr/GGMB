@extends('layouts.app', [
    'title' => 'Chỉnh sửa tài khoản · GGMB',
    'active' => 'accounts',
    'breadcrumbs' => ['GGMB', 'Tài khoản']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    <!-- Tiêu đề & Phụ đề (Bám sát Ảnh Chỉnh sửa tài khoản) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-bold text-[#122d40]">
            Chỉnh sửa tài khoản
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#52697c]">
            {{ $account->name }} · Tên đăng nhập {{ $account->username }} được giữ nguyên.
        </p>
    </div>

    <!-- Form chỉnh sửa (Bám sát Ảnh Chỉnh sửa tài khoản) -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 sm:p-7 w-full max-w-[688px] space-y-6 shadow-xs">
        <form method="POST" action="{{ route('accounts.update', $account->id) }}" onsubmit="event.preventDefault(); if(window.showToast) window.showToast('Lưu thay đổi thành công.'); setTimeout(() => window.location.href='{{ route('accounts.show', $account->id) }}', 600);">
            @csrf
            @method('PUT')
            <div class="space-y-5">
                <!-- Hàng 1: Họ và tên * & Điện thoại -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Họ và tên *
                        </label>
                        <input
                            type="text"
                            required
                            value="{{ $account->name }}"
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        />
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Điện thoại
                        </label>
                        <input
                            type="text"
                            value="{{ $account->phone }}"
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        />
                    </div>
                </div>

                <!-- Hàng 2: Email & Căn cước -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Email
                        </label>
                        <input
                            type="email"
                            value="{{ $account->email }}"
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        />
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Căn cước
                        </label>
                        <input
                            type="text"
                            placeholder="Nhập căn cước nếu có"
                            value="{{ $account->citizen_id ?? '' }}"
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        />
                    </div>
                </div>

                <!-- Hàng 3: Vai trò * & Bộ phận -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Vai trò *
                        </label>
                        <div class="relative">
                            <select class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                                <option value="Quản lý" {{ $account->role === 'Quản lý' ? 'selected' : '' }}>Quản lý</option>
                                <option value="Hỗ trợ" {{ $account->role === 'Hỗ trợ' ? 'selected' : '' }}>Hỗ trợ ▾</option>
                                <option value="Kỹ thuật" {{ $account->role === 'Kỹ thuật' ? 'selected' : '' }}>Kỹ thuật</option>
                                <option value="Bảo vệ" {{ $account->role === 'Bảo vệ' ? 'selected' : '' }}>Bảo vệ</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#52697c]">▾</div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Bộ phận
                        </label>
                        <input
                            type="text"
                            placeholder="Nhập bộ phận nếu có"
                            value="{{ $account->department ?? '' }}"
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        />
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="flex items-center gap-4 pt-6 mt-6 border-t border-[#d9e4ec]">
                <a
                    href="{{ route('accounts.show', $account->id) }}"
                    class="h-[40px] px-8 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer select-none"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-8 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer select-none shadow-sm ml-auto"
                >
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
