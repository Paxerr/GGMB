@extends('layouts.portal', [
    'title' => 'Thông báo riêng căn hộ 0101 · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'dashboard'
])

@section('content')
<div class="space-y-6">
    <!-- Subtitle & Page Heading -->
    <div>
        <div class="text-[12.5px] font-medium text-[#6B7280] mb-1">
            Cổng cư dân / Tòa A
        </div>
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Chi tiết thông báo
        </h1>
        <span class="sr-only">Thông báo riêng căn hộ 0101</span>
        <p class="mt-0.5 text-[13px] text-[#6B7280]">
            Thông báo #{{ $id ?? 4 }} · Gửi tới căn hộ của bạn
        </p>
    </div>

    <!-- 2 Columns Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Left: Thông tin chi tiết (8 cols) -->
        <div class="lg:col-span-8 bg-white border border-[#E5E7EB] rounded-[16px] p-6 shadow-none">
            <h2 class="text-[15px] font-bold text-[#111827] mb-5">
                Thông tin chi tiết
            </h2>

            <!-- Row 1: Người gửi & Ngày gửi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-4">
                <div>
                    <div class="text-[12px] text-[#6B7280]">
                        Người gửi
                    </div>
                    <div class="text-[13px] font-medium text-[#111827] mt-1">
                        Nguyễn Minh Quản lý · Ban quản lý
                    </div>
                </div>

                <div>
                    <div class="text-[12px] text-[#6B7280]">
                        Ngày gửi
                    </div>
                    <div class="text-[13px] font-medium text-[#111827] mt-1">
                        20/02/2026 09:00
                    </div>
                </div>
            </div>

            <!-- Row 2: Nội dung thông báo -->
            <div class="py-4 border-t border-[#E5E7EB]">
                <div class="text-[12px] text-[#6B7280]">
                    Nội dung thông báo
                </div>
                <div class="text-[13.5px] text-[#111827] mt-1 leading-relaxed">
                    Vui lòng liên hệ ban quản lý để xác nhận thông tin cư trú.
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center space-x-3 pt-4 border-t border-[#E5E7EB]">
                <a href="{{ route('portal.dashboard') }}" class="px-5 py-2 border border-[#E5E7EB] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[13px] font-medium rounded-[8px] transition-colors">
                    Về bảng tin
                </a>
                <a href="{{ route('portal.tickets') }}" class="px-5 py-2 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-medium rounded-[8px] transition-colors">
                    Liên hệ hỗ trợ
                </a>
            </div>
        </div>

        <!-- Right: Lưu ý nghiệp vụ (4 cols) -->
        <div class="lg:col-span-4 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[16px] p-6 shadow-none text-[13px] text-[#4B5563] space-y-3">
            <h3 class="font-semibold text-[#111827] text-[14px]">
                Lưu ý nghiệp vụ
            </h3>
            <p class="leading-relaxed">
                Khi cần trao đổi, gửi yêu cầu hỗ trợ cho ban quản lý; không gửi trả lời vào nội dung thông báo.
            </p>
        </div>
    </div>
</div>
@endsection
