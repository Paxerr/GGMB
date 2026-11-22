@extends('layouts.portal', [
    'title' => 'Cập nhật liên hệ · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'profile'
])

@section('content')
<div class="space-y-7">
    <!-- Subtitle & Page Heading -->
    <div>
        <div class="text-[12.5px] font-semibold text-[#6B7280] mb-1 flex items-center gap-1.5">
            <a href="{{ route('portal.profile') }}" class="hover:text-[#0E4D3C] transition-colors">Thông tin cá nhân</a>
            <span>/</span>
            <span class="text-[#111827]">Cập nhật liên hệ</span>
        </div>
        <h1 class="text-[26px] font-bold text-[#111827] tracking-tight">
            Cập nhật liên hệ
        </h1>
        <p class="mt-1 text-[13.5px] text-[#6B7280]">
            Cập nhật cho tài khoản resident01.
        </p>
    </div>

    <!-- Form thông tin cần cung cấp -->
    <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-5 sm:p-7 shadow-xs">
            <div class="flex items-center gap-2.5 pb-5 border-b border-[#F3F4F6] mb-6">
                <div class="w-8 h-8 rounded-[8px] bg-[#E4EFE9] text-[#0E4D3C] flex items-center justify-center font-bold">
                    <svg class="w-4 h-4 text-[#0E4D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
                <h2 class="text-[16px] font-bold text-[#111827]">
                    Thông tin cần cung cấp
                </h2>
            </div>

            <form action="{{ route('portal.profile.update') }}" method="POST" class="space-y-5">
                @csrf
                <!-- Điện thoại -->
                <div>
                    <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">
                        Số điện thoại di động <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="phone" value="0910000010" required class="w-full h-[40px] px-3.5 bg-white border border-[#E5E7EB] focus:border-[#0E4D3C] rounded-[10px] text-[13.5px] text-[#111827] focus:outline-none transition-colors shadow-2xs font-mono">
                    <p class="text-[11.5px] text-[#6B7280] mt-1">Dùng để nhận tin nhắn thông báo phí và liên hệ khẩn cấp</p>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">
                        Địa chỉ Email nhận thông báo <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" name="email" value="nguyenan123@gmail.com" required class="w-full h-[40px] px-3.5 bg-white border border-[#E5E7EB] focus:border-[#0E4D3C] rounded-[10px] text-[13.5px] text-[#111827] focus:outline-none transition-colors shadow-2xs">
                    <p class="text-[11.5px] text-[#6B7280] mt-1">Dùng để nhận thông báo phí định kỳ hàng tháng</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-3 pt-3 border-t border-[#F3F4F6]">
                    <a href="{{ route('portal.profile') }}" class="px-5 py-2.5 border border-[#E5E7EB] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[13px] font-semibold rounded-[10px] transition-colors">
                        Hủy
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[10px] shadow-xs transition-colors cursor-pointer">
                        Lưu liên hệ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
