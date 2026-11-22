@extends('layouts.app', [
    'title' => 'Chỉnh sửa tài khoản · GGMB',
    'active' => 'accounts',
    'breadcrumbs' => ['Quản trị', 'Tài khoản', 'Chỉnh sửa']
])

@section('content')
<div class="space-y-6">
    <span class="sr-only">GGMB</span>

    <!-- Tiêu đề & Phụ đề -->
    <div>
        <nav class="flex items-center text-[12px] text-[#6B7280] space-x-1.5 mb-1.5">
            <span>Quản trị</span>
            <span>/</span>
            <a href="{{ route('accounts.index') }}" class="hover:text-[#0E4D3C]">Tài khoản</a>
            <span>/</span>
            <span class="text-[#111827] font-medium">Chỉnh sửa</span>
        </nav>
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Chỉnh sửa tài khoản
        </h1>
        <p class="mt-0.5 text-[13.5px] text-[#6B7280]">
            {{ $account->name }} · Tên đăng nhập {{ $account->username }} được giữ nguyên.
        </p>
    </div>

    <!-- Form chỉnh sửa -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-6 sm:p-7 w-full max-w-[688px] space-y-6 shadow-none">
        <form method="POST" action="{{ route('accounts.update', $account->id) }}" onsubmit="event.preventDefault(); if(window.showToast) window.showToast('Lưu thay đổi thành công.'); setTimeout(() => window.location.href='{{ route('accounts.show', $account->id) }}', 600);">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <!-- Hàng 1: Họ và tên * & Điện thoại -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Họ và tên *
                        </label>
                        <input
                            type="text"
                            required
                            value="{{ $account->name }}"
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        />
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Điện thoại
                        </label>
                        <input
                            type="text"
                            value="{{ $account->phone }}"
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        />
                    </div>
                </div>

                <!-- Hàng 2: Email & Căn cước -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Email
                        </label>
                        <input
                            type="email"
                            value="{{ $account->email }}"
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        />
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Căn cước
                        </label>
                        <input
                            type="text"
                            placeholder="Nhập căn cước nếu có"
                            value="{{ $account->citizen_id ?? '' }}"
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        />
                    </div>
                </div>

                <!-- Hàng 3: Vai trò * & Bộ phận -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Vai trò *
                        </label>
                        <div class="relative">
                            <select class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] cursor-pointer">
                                <option value="Quản lý" {{ $account->role === 'Quản lý' ? 'selected' : '' }}>Quản lý</option>
                                <option value="Hỗ trợ" {{ $account->role === 'Hỗ trợ' ? 'selected' : '' }}>Hỗ trợ ▾</option>
                                <option value="Kỹ thuật" {{ $account->role === 'Kỹ thuật' ? 'selected' : '' }}>Kỹ thuật</option>
                                <option value="Bảo vệ" {{ $account->role === 'Bảo vệ' ? 'selected' : '' }}>Bảo vệ</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Bộ phận
                        </label>
                        <input
                            type="text"
                            placeholder="Nhập bộ phận nếu có"
                            value="{{ $account->department ?? '' }}"
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        />
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="flex items-center gap-4 pt-6 mt-6 border-t border-[#E5E7EB]">
                <a
                    href="{{ route('accounts.show', $account->id) }}"
                    class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-medium rounded-[8px] transition-colors flex items-center justify-center cursor-pointer select-none"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors flex items-center justify-center cursor-pointer select-none shadow-sm ml-auto"
                >
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
