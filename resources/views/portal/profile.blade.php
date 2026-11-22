@extends('layouts.portal', [
    'title' => 'Thông tin cá nhân · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'profile'
])

@section('content')
<div class="space-y-6">
    <!-- Subtitle & Page Heading -->
    <div>
        <div class="text-[12.5px] font-medium text-[#6B7280] mb-1">
            Cổng cư dân / Tòa A
        </div>
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Thông tin cá nhân
        </h1>
        <p class="mt-0.5 text-[13px] text-[#6B7280]">
            resident01 · Nguyễn An
        </p>
    </div>

    <!-- 2 Columns Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Left: Thông tin chi tiết (8 cols) -->
        <div class="lg:col-span-8 bg-white border border-[#E5E7EB] rounded-[16px] p-6 shadow-none">
            <h2 class="text-[15px] font-bold text-[#111827] mb-5">
                Thông tin chi tiết
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-6 pb-6">
                <!-- Họ và tên -->
                <div>
                    <div class="text-[12px] text-[#6B7280]">
                        Họ và tên
                    </div>
                    <div class="text-[14px] font-medium text-[#111827] mt-1">
                        Nguyễn Văn An
                    </div>
                </div>

                <!-- Căn cước -->
                <div>
                    <div class="text-[12px] text-[#6B7280]">
                        Căn cước
                    </div>
                    <div class="text-[14px] font-medium text-[#111827] mt-1">
                        079000000010
                    </div>
                </div>

                <!-- Liên hệ -->
                <div>
                    <div class="text-[12px] text-[#6B7280]">
                        Liên hệ
                    </div>
                    <div class="text-[13px] text-[#111827] mt-1 space-y-0.5">
                        <div>0910000010</div>
                        <div>nguyenan123@gmail.com</div>
                        <span class="sr-only">0910000010 / nguyenan123@gmail.com</span>
                    </div>
                </div>

                <!-- Cư trú hiện tại -->
                <div>
                    <div class="text-[12px] text-[#6B7280]">
                        Cư trú hiện tại
                    </div>
                    <div class="text-[13px] text-[#111827] mt-1 space-y-0.5">
                        <div>Tòa A · Tầng 1 · Căn 0101</div>
                        <div class="text-[#6B7280]">Từ 01/01/2024 · Đang cư trú</div>
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center space-x-3 pt-4 border-t border-[#E5E7EB]">
                <a href="{{ route('portal.dashboard') }}" class="px-5 py-2 border border-[#E5E7EB] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[13px] font-medium rounded-[8px] transition-colors">
                    Về trang chủ
                </a>
                <a href="{{ route('portal.profile.edit') }}" class="px-5 py-2 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-medium rounded-[8px] transition-colors">
                    Cập nhật liên hệ
                </a>
            </div>
        </div>

        <!-- Right: Lưu ý nghiệp vụ (4 cols) -->
        <div class="lg:col-span-4 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[16px] p-6 shadow-none text-[13px] text-[#4B5563] space-y-3">
            <h3 class="font-semibold text-[#111827] text-[14px]">
                Lưu ý nghiệp vụ
            </h3>
            <p class="leading-relaxed">
                Bạn chỉ cập nhật thông tin liên hệ. Đổi họ tên, căn cước hoặc cư trú cần ban quản lý kiểm tra.
            </p>
        </div>
    </div>
</div>
@endsection
