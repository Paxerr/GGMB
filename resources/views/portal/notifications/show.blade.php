@extends('layouts.portal', [
    'title' => 'Thông báo riêng căn hộ 0101 · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'dashboard'
])

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-[26px] font-semibold text-[#122d40] leading-tight">
            Thông báo riêng căn hộ 0101
        </h1>
        <p class="mt-1 text-[14px] text-[#52697c]">
            Thông báo #{{ $id ?? 4 }} · Gửi tới căn hộ của bạn
        </p>
    </div>

    <!-- Notification Detail Card -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 sm:p-8 max-w-2xl shadow-sm space-y-6">
        <!-- Người gửi -->
        <div>
            <span class="block text-[12px] font-semibold text-[#52697c] uppercase tracking-wide">
                Người gửi
            </span>
            <div class="mt-1 text-[14px] font-medium text-[#122d40]">
                Nguyễn Minh Quản lý · Ban quản lý
            </div>
        </div>

        <!-- Ngày gửi -->
        <div>
            <span class="block text-[12px] font-semibold text-[#52697c] uppercase tracking-wide">
                Ngày gửi
            </span>
            <div class="mt-1 text-[14px] text-[#334b5d]">
                20/02/2026 09:00
            </div>
        </div>

        <!-- Nội dung thông báo -->
        <div>
            <span class="block text-[12px] font-semibold text-[#52697c] uppercase tracking-wide">
                Nội dung thông báo
            </span>
            <div class="mt-1 text-[14px] text-[#122d40] leading-relaxed">
                Vui lòng liên hệ ban quản lý để xác nhận thông tin cư trú.
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center space-x-3 pt-4 border-t border-[#d9e4ec]">
            <a href="{{ route('portal.dashboard') }}" class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-slate-50 text-[#334b5d] font-medium text-[14px] rounded-[4px] flex items-center transition-colors">
                Về bảng tin
            </a>
            <a href="{{ route('portal.tickets') }}" class="h-[40px] px-6 bg-[#2864AD] hover:bg-[#1e4d87] text-white font-medium text-[14px] rounded-[4px] flex items-center transition-colors shadow-sm">
                Liên hệ hỗ trợ
            </a>
        </div>
    </div>
</div>
@endsection
