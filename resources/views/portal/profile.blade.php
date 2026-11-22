@extends('layouts.portal', [
    'title' => 'Thông tin cá nhân · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'profile'
])

@section('content')
<div class="space-y-7">
    <!-- Header Title & Subtitle -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="text-[12.5px] font-semibold text-[#6B7280] mb-1 flex items-center gap-1.5">
                <span>Cổng cư dân</span>
                <span>/</span>
                <span class="text-[#111827]">Tòa A</span>
            </div>
            <h1 class="text-[26px] font-bold text-[#111827] tracking-tight">
                Thông tin cá nhân
            </h1>
            <p class="mt-1 text-[13.5px] text-[#6B7280]">
                resident01 · Nguyễn An
            </p>
        </div>

        <a href="{{ route('portal.profile.edit') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[10px] shadow-xs transition-colors shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            <span>Cập nhật liên hệ</span>
        </a>
    </div>

    <!-- Thông tin chi tiết -->
    <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-5 sm:p-7 shadow-xs space-y-6">
        <!-- Profile Top Card -->
        <div class="flex items-center gap-4 pb-6 border-b border-[#F3F4F6]">
            <div class="w-14 h-14 rounded-[12px] bg-[#E4EFE9] text-[#0E4D3C] flex items-center justify-center font-bold text-xl border border-[#B8D5C7]">
                NA
            </div>
            <div>
                <div class="flex items-center gap-2.5">
                    <h2 class="text-[20px] font-bold text-[#111827]">
                        Nguyễn Văn An
                    </h2>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11.5px] font-semibold bg-[#E4EFE9] text-[#0E4D3C]">
                        Cư dân chính chủ
                    </span>
                </div>
                <div class="text-[13px] text-[#6B7280] mt-0.5">
                    Tài khoản: <strong class="text-[#111827] font-mono">resident01</strong> · Vai trò: Cư dân
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pb-6 border-b border-[#F3F4F6]">
            <!-- Họ và tên -->
            <div class="p-5 rounded-[12px] bg-[#F8FAF8] border border-[#E5E7EB]/60">
                <div class="text-[11.5px] font-semibold text-[#6B7280] uppercase tracking-wider">
                    Họ và tên
                </div>
                <div class="text-[15px] font-bold text-[#111827] mt-1">
                    Nguyễn Văn An
                </div>
            </div>

            <!-- Căn cước -->
            <div class="p-5 rounded-[12px] bg-[#F8FAF8] border border-[#E5E7EB]/60">
                <div class="text-[11.5px] font-semibold text-[#6B7280] uppercase tracking-wider">
                    Số CCCD / CMND
                </div>
                <div class="text-[15px] font-mono font-bold text-[#111827] mt-1">
                    079000000010
                </div>
            </div>

            <!-- Liên hệ -->
            <div class="p-5 rounded-[12px] bg-[#F8FAF8] border border-[#E5E7EB]/60">
                <div class="text-[11.5px] font-semibold text-[#6B7280] uppercase tracking-wider">
                    Thông tin liên hệ
                </div>
                <div class="text-[13.5px] text-[#111827] mt-2 space-y-1.5">
                    <div class="flex items-center gap-2 font-mono font-medium">
                        <svg class="w-4 h-4 text-[#0E4D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>0910000010</span>
                    </div>
                    <div class="flex items-center gap-2 font-mono font-medium">
                        <svg class="w-4 h-4 text-[#0E4D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>nguyenan123@gmail.com</span>
                    </div>
                    <span class="sr-only">0910000010 / nguyenan123@gmail.com</span>
                </div>
            </div>

            <!-- Cư trú hiện tại -->
            <div class="p-5 rounded-[12px] bg-[#F8FAF8] border border-[#E5E7EB]/60">
                <div class="text-[11.5px] font-semibold text-[#6B7280] uppercase tracking-wider">
                    Cư trú hiện tại
                </div>
                <div class="text-[13.5px] text-[#111827] mt-1 space-y-1">
                    <div class="font-bold text-[#0E4D3C]">Tòa A · Tầng 1 · Căn 0101</div>
                    <div class="text-[12px] text-[#6B7280]">Từ 01/01/2024 · Đang cư trú</div>
                </div>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="flex items-center space-x-3 pt-2">
            <a href="{{ route('portal.dashboard') }}" class="px-5 py-2.5 border border-[#E5E7EB] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[13px] font-semibold rounded-[10px] transition-colors">
                Về trang chủ
            </a>
            <a href="{{ route('portal.profile.edit') }}" class="px-5 py-2.5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[10px] shadow-xs transition-colors">
                Cập nhật liên hệ
            </a>
        </div>
    </div>
</div>
@endsection
