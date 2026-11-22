@extends('layouts.portal', [
    'title' => 'Cổng cư dân · GGMB',
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
            Trang chủ
        </h1>
        <span class="sr-only">Xin chào, Nguyễn An</span>
        <p class="mt-0.5 text-[13px] text-[#6B7280]">
            Tòa A · Căn 0101 · Chỉ hiển thị căn hộ, hóa đơn và yêu cầu liên quan đến bạn.
        </p>
    </div>

    <!-- 3 Stat KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Stat Card 1 -->
        <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-5 shadow-none">
            <span class="block text-[13px] font-medium text-[#6B7280]">
                Hóa đơn chờ thanh toán
            </span>
            <span class="sr-only">HÓA ĐƠN CHỜ THANH TOÁN</span>
            <div class="text-[26px] font-bold text-[#111827] mt-1">
                1.685.000 đ
            </div>
            <div class="mt-1 text-[12px] text-[#6B7280]">
                Kỳ 01 và 02/2026
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-5 shadow-none">
            <span class="block text-[13px] font-medium text-[#6B7280]">
                Căn hộ 0101
            </span>
            <span class="sr-only">HỒ SƠ CĂN HỘ 0101</span>
            <div class="text-[26px] font-bold text-[#111827] mt-1">
                1 cư dân · 1 xe
            </div>
            <span class="sr-only">01 cư dân · 01 xe</span>
            <div class="mt-1 text-[12px] text-[#6B7280]">
                Nguyễn An · 29-B1 100.01
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-5 shadow-none">
            <span class="block text-[13px] font-medium text-[#6B7280]">
                Yêu cầu đang mở
            </span>
            <span class="sr-only">YÊU CẦU ĐANG MỞ</span>
            <div class="text-[26px] font-bold text-[#111827] mt-1">
                4 yêu cầu
            </div>
            <span class="sr-only">04 yêu cầu</span>
            <div class="mt-1 text-[12px] text-[#6B7280]">
                Chờ xử lý · Chưa phân công
            </div>
        </div>
    </div>

    <!-- Main Content 2 Columns: Bảng tin (left) + Thao tác nhanh (right) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Left: Bảng tin của bạn (8 cols) -->
        <div class="lg:col-span-8 bg-white border border-[#E5E7EB] rounded-[16px] p-6 shadow-none space-y-5">
            <div class="flex items-center justify-between">
                <h2 class="text-[15px] font-bold text-[#111827]">
                    Bảng tin của bạn
                </h2>
                <span class="text-[12px] text-[#0E4D3C] font-semibold bg-[#E4EFE9] px-2.5 py-0.5 rounded-[6px]">
                    3 thông báo chưa đọc
                </span>
            </div>

            <div class="space-y-3">
                <!-- Notification 1 -->
                <div class="border border-[#E5E7EB] rounded-[12px] p-4 bg-white hover:border-[#0E4D3C] transition-colors">
                    <div class="text-[12px] text-[#6B7280]">
                        01/03/2026 · Chưa đọc
                    </div>
                    <h3 class="font-bold text-[#111827] text-[14px] mt-1">
                        Nhắc thanh toán phí tháng 02/2026
                    </h3>
                    <p class="text-[13px] text-[#4B5563] mt-1 leading-relaxed">
                        Vui lòng hoàn tất thanh toán trước ngày 10/03/2026.
                    </p>
                    <div class="mt-3">
                        <a href="{{ route('portal.notifications.show', 2) }}" class="inline-flex items-center px-3.5 py-1.5 border border-[#E5E7EB] rounded-[8px] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[12.5px] font-medium transition-colors shadow-none">
                            Xem thông báo
                        </a>
                    </div>
                </div>

                <!-- Notification 2 -->
                <div class="border border-[#E5E7EB] rounded-[12px] p-4 bg-white hover:border-[#0E4D3C] transition-colors">
                    <div class="text-[12px] text-[#6B7280]">
                        20/02/2026 · Chưa đọc
                    </div>
                    <h3 class="font-bold text-[#111827] text-[14px] mt-1">
                        Thông báo riêng căn hộ 0101
                    </h3>
                    <p class="text-[13px] text-[#4B5563] mt-1 leading-relaxed">
                        Vui lòng liên hệ ban quản lý để xác nhận thông tin cư trú.
                    </p>
                    <div class="mt-3">
                        <a href="{{ route('portal.notifications.show', 4) }}" class="inline-flex items-center px-3.5 py-1.5 border border-[#E5E7EB] rounded-[8px] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[12.5px] font-medium transition-colors shadow-none">
                            Xem thông báo
                        </a>
                    </div>
                </div>

                <!-- Notification 3 -->
                <div class="border border-[#E5E7EB] rounded-[12px] p-4 bg-white hover:border-[#0E4D3C] transition-colors">
                    <div class="text-[12px] text-[#6B7280]">
                        01/02/2026 · Chưa đọc
                    </div>
                    <h3 class="font-bold text-[#111827] text-[14px] mt-1">
                        Lịch bảo trì thang máy
                    </h3>
                    <p class="text-[13px] text-[#4B5563] mt-1 leading-relaxed">
                        Tòa A bảo trì ngày 08/02/2026, 08:00–11:00.
                    </p>
                    <div class="mt-3">
                        <a href="{{ route('portal.notifications.show', 1) }}" class="inline-flex items-center px-3.5 py-1.5 border border-[#E5E7EB] rounded-[8px] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[12.5px] font-medium transition-colors shadow-none">
                            Xem thông báo
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Thao tác nhanh (4 cols) -->
        <div class="lg:col-span-4 bg-white border border-[#E5E7EB] rounded-[16px] p-6 shadow-none">
            <h2 class="text-[15px] font-bold text-[#111827] mb-4">
                Thao tác nhanh
            </h2>

            <div class="space-y-2.5">
                <a href="{{ route('portal.invoices') }}" class="block w-full py-2 px-4 border border-[#E5E7EB] rounded-[8px] text-center text-[#374151] hover:bg-[#F9FBFA] font-medium text-[13px] transition-colors shadow-none">
                    Xem hóa đơn
                </a>
                <a href="{{ route('portal.tickets') }}" class="block w-full py-2 px-4 border border-[#E5E7EB] rounded-[8px] text-center text-[#374151] hover:bg-[#F9FBFA] font-medium text-[13px] transition-colors shadow-none">
                    Gửi yêu cầu hỗ trợ
                </a>
                <a href="{{ route('portal.profile') }}" class="block w-full py-2 px-4 border border-[#E5E7EB] rounded-[8px] text-center text-[#374151] hover:bg-[#F9FBFA] font-medium text-[13px] transition-colors shadow-none">
                    Thông tin cá nhân
                </a>
            </div>

            <p class="text-[12.5px] text-[#6B7280] leading-relaxed mt-5">
                Cần đổi cư trú hoặc phương tiện? Gửi yêu cầu để ban quản lý kiểm tra. Bạn có thể tự cập nhật thông tin liên hệ.
            </p>
        </div>
    </div>
</div>
@endsection
