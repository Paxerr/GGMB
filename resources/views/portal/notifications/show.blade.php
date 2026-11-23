@extends('layouts.portal', [
    'title' => 'Thông báo riêng căn hộ 0101 · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'dashboard'
])

@section('content')
<div class="space-y-8 sm:space-y-10">
    <!-- Header Title & Subtitle -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="text-[12.5px] font-semibold text-[#6B7280] mb-1.5 flex items-center gap-1.5">
                <a href="{{ route('portal.dashboard') }}" class="hover:text-[#0E4D3C] transition-colors">Bảng tin</a>
                <span>/</span>
                <span class="text-[#111827]">Chi tiết thông báo</span>
            </div>
            <h1 class="text-[26px] font-bold text-[#111827] tracking-tight">
                Chi tiết thông báo
            </h1>
            <span class="sr-only">Thông báo riêng căn hộ 0101</span>
            <p class="mt-1.5 text-[13.5px] text-[#6B7280]">
                Thông báo #{{ $id ?? 4 }} · Gửi tới căn hộ của bạn
            </p>
        </div>

        <a href="{{ route('portal.dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 border border-[#E5E7EB] bg-white hover:bg-[#F9FBFA] text-[#374151] hover:text-[#0E4D3C] text-[13px] font-semibold rounded-[10px] transition-colors shrink-0">
            <span>← Quay lại bảng tin</span>
        </a>
    </div>

    <!-- Thông tin chi tiết -->
    <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-6 sm:p-8 shadow-xs space-y-8">
        <div class="flex items-center justify-between pb-6 border-b border-[#F3F4F6]">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-[8px] bg-[#E4EFE9] text-[#0E4D3C] flex items-center justify-center font-bold">
                    <svg class="w-4 h-4 text-[#0E4D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <h2 class="text-[17px] font-bold text-[#111827]">
                    Thông báo riêng căn hộ 0101
                </h2>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11.5px] font-semibold bg-emerald-50 text-emerald-700">
                Đã xem
            </span>
        </div>

        <!-- Row 1: Người gửi & Ngày gửi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6 border-b border-[#F3F4F6] text-[13px]">
            <div class="p-5.5 bg-[#F8FAF8] rounded-[14px] border border-[#E5E7EB]/60">
                <div class="text-[11.5px] font-semibold text-[#6B7280] uppercase tracking-wider">Người gửi thông báo</div>
                <div class="font-bold text-[#111827] mt-1.5 text-[14px]">
                    Nguyễn Minh Quản lý · Ban quản lý
                </div>
            </div>

            <div class="p-5.5 bg-[#F8FAF8] rounded-[14px] border border-[#E5E7EB]/60">
                <div class="text-[11.5px] font-semibold text-[#6B7280] uppercase tracking-wider">Thời gian gửi</div>
                <div class="font-bold text-[#111827] mt-1.5 text-[14px]">
                    20/02/2026 09:00
                </div>
            </div>
        </div>

        <!-- Row 2: Nội dung thông báo -->
        <div class="space-y-2.5">
            <div class="text-[11.5px] font-semibold text-[#6B7280] uppercase tracking-wider">
                Nội dung thông báo
            </div>
            <div class="p-5.5 bg-[#F8FAF8] rounded-[14px] border border-[#E5E7EB] text-[14px] text-[#111827] leading-relaxed">
                Vui lòng liên hệ ban quản lý để xác nhận thông tin cư trú.
            </div>
        </div>

        <!-- Action buttons -->
        <div class="flex items-center space-x-3 pt-5 border-t border-[#F3F4F6]">
            <a href="{{ route('portal.dashboard') }}" class="px-5 py-2.5 border border-[#E5E7EB] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[13px] font-semibold rounded-[10px] transition-colors">
                Về bảng tin
            </a>
            <a href="{{ route('portal.tickets') }}" class="px-5 py-2.5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[10px] shadow-xs transition-colors">
                Liên hệ hỗ trợ
            </a>
        </div>
    </div>
</div>
@endsection
