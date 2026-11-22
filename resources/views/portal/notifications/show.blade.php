@extends('layouts.portal', [
    'title' => 'Thông báo riêng căn hộ 0101 · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'dashboard'
])

@section('content')
<div class="space-y-7">
    <!-- Header Title & Subtitle -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="text-[12.5px] font-semibold text-[#6B7280] mb-1 flex items-center gap-1.5">
                <a href="{{ route('portal.dashboard') }}" class="hover:text-[#0E4D3C] transition-colors">Bảng tin</a>
                <span>/</span>
                <span class="text-[#111827]">Chi tiết thông báo</span>
            </div>
            <h1 class="text-[26px] font-bold text-[#111827] tracking-tight">
                Chi tiết thông báo
            </h1>
            <span class="sr-only">Thông báo riêng căn hộ 0101</span>
            <p class="mt-1 text-[13.5px] text-[#6B7280]">
                Thông báo #{{ $id ?? 4 }} · Gửi tới căn hộ của bạn
            </p>
        </div>

        <a href="{{ route('portal.dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 border border-[#E5E7EB] bg-white hover:bg-[#F9FBFA] text-[#374151] hover:text-[#0E4D3C] text-[13px] font-semibold rounded-[10px] transition-colors shrink-0">
            <span>← Quay lại bảng tin</span>
        </a>
    </div>

    <!-- Thông tin chi tiết -->
    <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-5 sm:p-7 shadow-xs space-y-6">
            <div class="flex items-center justify-between pb-5 border-b border-[#F3F4F6]">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-[8px] bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                        📢
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
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-5 border-b border-[#F3F4F6] text-[13px]">
                <div class="p-4 sm:p-5 bg-[#F8FAF8] rounded-[12px] border border-[#E5E7EB]/60">
                    <div class="text-[12px] text-[#6B7280] font-medium">Người gửi thông báo</div>
                    <div class="font-bold text-[#111827] mt-1 text-[14px]">
                        Nguyễn Minh Quản lý · Ban quản lý
                    </div>
                </div>

                <div class="p-4 sm:p-5 bg-[#F8FAF8] rounded-[12px] border border-[#E5E7EB]/60">
                    <div class="text-[12px] text-[#6B7280] font-medium">Thời gian gửi</div>
                    <div class="font-bold text-[#111827] mt-1 text-[14px]">
                        20/02/2026 09:00
                    </div>
                </div>
            </div>

            <!-- Row 2: Nội dung thông báo -->
            <div class="space-y-2">
                <div class="text-[12px] font-bold text-[#6B7280] uppercase tracking-wider">
                    Nội dung thông báo
                </div>
                <div class="p-5 bg-[#F8FAF8] rounded-[14px] border border-[#E5E7EB] text-[14px] text-[#111827] leading-relaxed">
                    Vui lòng liên hệ ban quản lý để xác nhận thông tin cư trú.
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center space-x-3 pt-3 border-t border-[#F3F4F6]">
                <a href="{{ route('portal.dashboard') }}" class="px-5 py-2.5 border border-[#E5E7EB] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[13px] font-semibold rounded-[10px] transition-colors">
                    Về bảng tin
                </a>
                <a href="{{ route('portal.tickets') }}" class="px-5 py-2.5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[10px] shadow-xs transition-colors">
                    Liên hệ hỗ trợ
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
