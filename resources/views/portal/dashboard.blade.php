@extends('layouts.portal', [
    'title' => 'Cổng cư dân · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'dashboard'
])

@section('content')
<div class="space-y-6">
    <!-- Header Greeting -->
    <div>
        <h1 class="text-[26px] font-semibold text-[#122d40] leading-tight">
            Xin chào, Nguyễn An
        </h1>
        <p class="mt-1 text-[14px] text-[#52697c]">
            Tòa A · Căn 0101 · Chỉ hiển thị căn hộ, hóa đơn và yêu cầu liên quan đến bạn.
        </p>
    </div>

    <!-- 3 Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Stat Card 1 -->
        <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 shadow-sm">
            <span class="block text-[12px] font-semibold text-[#52697c] tracking-wider uppercase">
                HÓA ĐƠN CHỜ THANH TOÁN
            </span>
            <div class="text-[24px] font-bold text-[#122d40] mt-2">
                1.685.000 đ
            </div>
            <div class="mt-3 text-[13px] text-[#52697c] space-y-1">
                <div>01/2026 · #1 842.500 đ · Chờ thanh toán</div>
                <div>02/2026 · #21 842.500 đ · Chờ thanh toán</div>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 shadow-sm">
            <span class="block text-[12px] font-semibold text-[#52697c] tracking-wider uppercase">
                HỒ SƠ CĂN HỘ 0101
            </span>
            <div class="text-[24px] font-bold text-[#122d40] mt-2">
                01 cư dân · 01 xe
            </div>
            <div class="mt-3 text-[13px] text-[#52697c] space-y-1">
                <div>Nguyễn An · Đang cư trú</div>
                <div>29-B1 100.01 · Xe máy</div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 shadow-sm">
            <span class="block text-[12px] font-semibold text-[#52697c] tracking-wider uppercase">
                YÊU CẦU ĐANG MỞ
            </span>
            <div class="text-[24px] font-bold text-[#122d40] mt-2">
                04 yêu cầu
            </div>
            <div class="mt-3 text-[13px] text-[#52697c] space-y-1">
                <div>#1 · #31 · #61 · #91</div>
                <div>Chờ xử lý · Chưa được phân công</div>
            </div>
        </div>
    </div>

    <!-- Main Content 2 Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Announcements for resident (2/3 width) -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-[14px] font-semibold text-[#122d40] uppercase tracking-wide">
                    THÔNG BÁO DÀNH CHO BẠN
                </h2>
                <span class="text-[12px] text-[#52697c] font-medium">3 chưa đọc</span>
            </div>

            <div class="space-y-3">
                <!-- Notification 1 -->
                <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-5 shadow-sm hover:border-[#2864ad] transition-colors">
                    <h3 class="font-semibold text-[#122d40] text-[14px]">
                        #2 · Nhắc thanh toán phí tháng 02/2026
                    </h3>
                    <p class="text-[13px] text-[#334b5d] mt-1.5">
                        Vui lòng hoàn tất thanh toán trước ngày 10/03/2026.
                    </p>
                    <div class="text-[12px] text-[#52697c] mt-3">
                        01/03/2026 08:00 · Chưa đọc · <a href="{{ route('portal.notifications.show', 2) }}" class="text-[#2864ad] hover:underline font-medium">Xem nội dung</a>
                    </div>
                </div>

                <!-- Notification 2 -->
                <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-5 shadow-sm hover:border-[#2864ad] transition-colors">
                    <h3 class="font-semibold text-[#122d40] text-[14px]">
                        #4 · Thông báo riêng căn hộ 0101
                    </h3>
                    <p class="text-[13px] text-[#334b5d] mt-1.5">
                        Vui lòng liên hệ ban quản lý để xác nhận thông tin cư trú.
                    </p>
                    <div class="text-[12px] text-[#52697c] mt-3">
                        20/02/2026 09:00 · Chưa đọc · <a href="{{ route('portal.notifications.show', 4) }}" class="text-[#2864ad] hover:underline font-medium">Xem nội dung</a>
                    </div>
                </div>

                <!-- Notification 3 -->
                <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-5 shadow-sm hover:border-[#2864ad] transition-colors">
                    <h3 class="font-semibold text-[#122d40] text-[14px]">
                        #1 · Thông báo lịch bảo trì thang máy
                    </h3>
                    <p class="text-[13px] text-[#334b5d] mt-1.5">
                        Thang máy tòa A bảo trì ngày 08/02/2026, 08:00–11:00.
                    </p>
                    <div class="text-[12px] text-[#52697c] mt-3">
                        01/02/2026 08:00 · Chưa đọc · <a href="{{ route('portal.notifications.show', 1) }}" class="text-[#2864ad] hover:underline font-medium">Xem nội dung</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Quick actions (1/3 width) -->
        <div class="lg:col-span-1 space-y-4">
            <div>
                <h2 class="text-[14px] font-semibold text-[#122d40] uppercase tracking-wide">
                    THAO TÁC NHANH
                </h2>
            </div>

            <div class="space-y-3">
                <a href="{{ route('portal.invoices') }}" class="block w-full text-center py-2.5 px-4 bg-white border border-[#d9e4ec] text-[#334b5d] font-medium text-[14px] rounded-[4px] hover:bg-slate-50 transition-colors shadow-sm">
                    Xem hóa đơn
                </a>
                <a href="{{ route('portal.tickets') }}" class="block w-full text-center py-2.5 px-4 bg-[#2864AD] text-white font-medium text-[14px] rounded-[4px] hover:bg-[#1e4d87] transition-colors shadow-sm">
                    Gửi yêu cầu hỗ trợ
                </a>
                <a href="{{ route('portal.profile') }}" class="block w-full text-center py-2.5 px-4 bg-[#2864AD] text-white font-medium text-[14px] rounded-[4px] hover:bg-[#1e4d87] transition-colors shadow-sm">
                    Thông tin cá nhân
                </a>
            </div>

            <!-- Dashed Notice Box -->
            <div class="mt-6 p-4 border border-dashed border-[#d9e4ec] bg-[#f8fafc] rounded-[4px] text-[13px] text-[#52697c] space-y-1.5">
                <p class="font-medium text-[#334b5d]">Cần cập nhật cư trú hoặc phương tiện?</p>
                <p>Gửi yêu cầu tại mục Hỗ trợ để ban quản lý kiểm tra.</p>
                <p>Thông tin liên hệ có thể sửa tại hồ sơ cá nhân.</p>
            </div>
        </div>
    </div>
</div>
@endsection
