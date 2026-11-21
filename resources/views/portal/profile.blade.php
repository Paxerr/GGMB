@extends('layouts.portal', [
    'title' => 'Thông tin cá nhân · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'dashboard'
])

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-[26px] font-semibold text-[#122d40] leading-tight">
            Thông tin cá nhân
        </h1>
        <p class="mt-1 text-[14px] text-[#52697c]">
            resident01 · Nguyễn An
        </p>
    </div>

    <!-- Profile Details Card -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 sm:p-8 max-w-2xl shadow-sm space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Họ và tên -->
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c] uppercase tracking-wide">
                    Họ và tên
                </span>
                <div class="mt-1 text-[14px] font-medium text-[#122d40]">
                    Nguyễn Văn An
                </div>
            </div>

            <!-- Căn cước -->
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c] uppercase tracking-wide">
                    Căn cước
                </span>
                <div class="mt-1 text-[14px] font-medium text-[#122d40]">
                    079000000010
                </div>
            </div>

            <!-- Liên hệ -->
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c] uppercase tracking-wide">
                    Liên hệ
                </span>
                <div class="mt-1 text-[14px] text-[#122d40]">
                    0910000010 / nguyenan123@gmail.com
                </div>
            </div>

            <!-- Cư trú -->
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c] uppercase tracking-wide">
                    Cư trú
                </span>
                <div class="mt-1 text-[14px] text-[#122d40]">
                    Tòa A · Tầng 1 · Căn 0101 · Từ 01/01/2024 · Đang cư trú
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center space-x-3 pt-4 border-t border-[#d9e4ec]">
            <a href="{{ route('portal.dashboard') }}" class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-slate-50 text-[#334b5d] font-medium text-[14px] rounded-[4px] flex items-center transition-colors">
                Về trang chủ
            </a>
            <a href="{{ route('portal.profile.edit') }}" class="h-[40px] px-6 bg-[#2864AD] hover:bg-[#1e4d87] text-white font-medium text-[14px] rounded-[4px] flex items-center transition-colors shadow-sm">
                Cập nhật liên hệ
            </a>
        </div>
    </div>
</div>
@endsection
