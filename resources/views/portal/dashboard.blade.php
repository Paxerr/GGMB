@extends('layouts.portal', [
    'title' => 'Cổng cư dân · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'dashboard'
])

@section('content')
<div class="space-y-8 sm:space-y-10">
    <!-- Clean Resident Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-[#E5E7EB]">
        <div>
            <div class="flex items-center gap-2.5">
                <h1 class="text-[22px] sm:text-[26px] font-bold text-[#111827] tracking-tight">
                    Xin chào, Nguyễn An
                </h1>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[12px] font-semibold bg-[#E4EFE9] text-[#0E4D3C]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#0E4D3C]"></span>
                    Căn 0101 · Tòa A
                </span>
            </div>
            <p class="text-[13.5px] text-[#6B7280] mt-1.5">
                Khu căn hộ GGMB Residence · Thông tin dịch vụ và hóa đơn cho căn hộ của bạn
            </p>
        </div>
        <div class="flex items-center gap-2.5 shrink-0">
            <a href="{{ route('portal.tickets') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[8px] transition-colors shadow-2xs">
                <span>+ Gửi yêu cầu hỗ trợ</span>
            </a>
            <a href="{{ route('portal.invoices') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-[#F9FBFA] border border-[#E5E7EB] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors shadow-2xs">
                <span>Tra cứu hóa đơn</span>
            </a>
        </div>
    </div>

    <!-- 3 Stat KPI Cards (Bento-style clean typography) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Stat Card 1: Hóa đơn & Công nợ -->
        <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-6 sm:p-7 shadow-2xs hover:border-[#CBD5E1] transition-all flex flex-col justify-between">
            <div>
                <div class="text-[12px] font-semibold text-[#6B7280] uppercase tracking-wider">
                    Hóa đơn chờ thanh toán
                </div>
                <span class="sr-only">HÓA ĐƠN CHỜ THANH TOÁN</span>
                <div class="text-[28px] sm:text-[30px] font-bold text-[#111827] mt-2.5 font-mono tracking-tight">
                    1.685.000 đ
                </div>
            </div>
            <div class="mt-5 pt-4 border-t border-[#F3F4F6] flex items-center justify-between text-[12.5px]">
                <span class="text-[#6B7280]">
                    Kỳ 01 và 02/2026
                </span>
                <a href="{{ route('portal.invoices') }}" class="font-semibold text-[#0E4D3C] hover:underline inline-flex items-center gap-1">
                    Thanh toán →
                </a>
            </div>
        </div>

        <!-- Stat Card 2: Căn hộ & Xe -->
        <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-6 sm:p-7 shadow-2xs hover:border-[#CBD5E1] transition-all flex flex-col justify-between">
            <div>
                <div class="text-[12px] font-semibold text-[#6B7280] uppercase tracking-wider">
                    Hồ sơ căn hộ 0101
                </div>
                <span class="sr-only">HỒ SƠ CĂN HỘ 0101</span>
                <div class="text-[28px] sm:text-[30px] font-bold text-[#111827] mt-2.5 tracking-tight">
                    1 cư dân · 1 xe
                </div>
                <span class="sr-only">01 cư dân · 01 xe</span>
            </div>
            <div class="mt-5 pt-4 border-t border-[#F3F4F6] flex items-center justify-between text-[12.5px]">
                <span class="text-[#6B7280]">
                    Nguyễn An · 29-B1 100.01
                </span>
                <a href="{{ route('portal.profile') }}" class="font-semibold text-[#0E4D3C] hover:underline inline-flex items-center gap-1">
                    Chi tiết →
                </a>
            </div>
        </div>

        <!-- Stat Card 3: Yêu cầu hỗ trợ -->
        <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-6 sm:p-7 shadow-2xs hover:border-[#CBD5E1] transition-all flex flex-col justify-between sm:col-span-2 lg:col-span-1">
            <div>
                <div class="text-[12px] font-semibold text-[#6B7280] uppercase tracking-wider">
                    Yêu cầu đang mở
                </div>
                <span class="sr-only">YÊU CẦU ĐANG MỞ</span>
                <div class="text-[28px] sm:text-[30px] font-bold text-[#111827] mt-2.5 tracking-tight">
                    4 yêu cầu
                </div>
                <span class="sr-only">04 yêu cầu</span>
            </div>
            <div class="mt-5 pt-4 border-t border-[#F3F4F6] flex items-center justify-between text-[12.5px]">
                <span class="text-[#6B7280]">
                    Chờ tiếp nhận xử lý
                </span>
                <a href="{{ route('portal.tickets') }}" class="font-semibold text-[#0E4D3C] hover:underline inline-flex items-center gap-1">
                    Xem danh sách →
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content 2 Columns: Bảng tin (left) + Thông tin ban quản lý (right) -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
        <!-- Left: Bảng tin của bạn (8 cols on xl) -->
        <div class="xl:col-span-8 bg-white border border-[#E5E7EB] rounded-[16px] p-6 sm:p-8 shadow-2xs space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-[#F3F4F6]">
                <h2 class="text-[17px] font-bold text-[#111827] tracking-tight">
                    Bảng tin của bạn
                </h2>
                <span class="text-[12px] text-[#0E4D3C] font-semibold bg-[#E4EFE9] px-2.5 py-1 rounded-[6px]">
                    3 thông báo chưa đọc
                </span>
            </div>

            <div class="space-y-4">
                <!-- Notification 1 -->
                <div class="border border-[#E5E7EB] hover:border-[#B8D5C7] rounded-[14px] p-6 bg-white transition-all hover:shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 text-[11.5px] font-semibold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-[6px]">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            01/03/2026 · Chưa đọc
                        </span>
                        <span class="text-[12px] text-[#6B7280]">Ban Quản Lý</span>
                    </div>
                    <h3 class="font-bold text-[#111827] text-[15px] mt-2.5">
                        Nhắc thanh toán phí tháng 02/2026
                    </h3>
                    <p class="text-[13px] text-[#4B5563] mt-1.5 leading-relaxed">
                        Vui lòng hoàn tất thanh toán trước ngày 10/03/2026 để tránh phát sinh gián đoạn dịch vụ.
                    </p>
                    <div class="mt-4 pt-3.5 border-t border-[#F3F4F6] flex items-center justify-between text-[12.5px]">
                        <a href="{{ route('portal.notifications.show', 2) }}" class="inline-flex items-center gap-1 text-[#0E4D3C] font-semibold hover:underline">
                            <span>Xem thông báo</span>
                            <span>→</span>
                        </a>
                        <span class="text-[12px] text-[#9CA3AF]">Mã tin #2</span>
                    </div>
                </div>

                <!-- Notification 2 -->
                <div class="border border-[#E5E7EB] hover:border-[#B8D5C7] rounded-[14px] p-6 bg-white transition-all hover:shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 text-[11.5px] font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-[6px]">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            20/02/2026 · Chưa đọc
                        </span>
                        <span class="text-[12px] text-[#6B7280]">Căn hộ 0101</span>
                    </div>
                    <h3 class="font-bold text-[#111827] text-[15px] mt-2.5">
                        Thông báo riêng căn hộ 0101
                    </h3>
                    <p class="text-[13px] text-[#4B5563] mt-1.5 leading-relaxed">
                        Vui lòng liên hệ ban quản lý để xác nhận thông tin cư trú và hoàn tất đối soát số liệu căn hộ.
                    </p>
                    <div class="mt-4 pt-3.5 border-t border-[#F3F4F6] flex items-center justify-between text-[12.5px]">
                        <a href="{{ route('portal.notifications.show', 4) }}" class="inline-flex items-center gap-1 text-[#0E4D3C] font-semibold hover:underline">
                            <span>Xem thông báo</span>
                            <span>→</span>
                        </a>
                        <span class="text-[12px] text-[#9CA3AF]">Mã tin #4</span>
                    </div>
                </div>

                <!-- Notification 3 -->
                <div class="border border-[#E5E7EB] hover:border-[#B8D5C7] rounded-[14px] p-6 bg-white transition-all hover:shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 text-[11.5px] font-semibold text-sky-700 bg-sky-50 px-2 py-0.5 rounded-[6px]">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                            01/02/2026 · Chưa đọc
                        </span>
                        <span class="text-[12px] text-[#6B7280]">Kỹ thuật tòa nhà</span>
                    </div>
                    <h3 class="font-bold text-[#111827] text-[15px] mt-2.5">
                        Lịch bảo trì thang máy
                    </h3>
                    <p class="text-[13px] text-[#4B5563] mt-1.5 leading-relaxed">
                        Tòa A bảo trì ngày 08/02/2026, 08:00–11:00. Quý cư dân vui lòng sử dụng thang bộ hoặc thang hàng trong khoảng thời gian này.
                    </p>
                    <div class="mt-4 pt-3.5 border-t border-[#F3F4F6] flex items-center justify-between text-[12.5px]">
                        <span class="text-[#6B7280]">Đã cập nhật trên lịch bảo trì</span>
                        <span class="text-[12px] text-[#9CA3AF]">Mã tin #1</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Thông tin hỗ trợ BQL (4 cols on xl) -->
        <div class="xl:col-span-4 space-y-6">
            <!-- Box BQL -->
            <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-7 shadow-2xs space-y-5">
                <h3 class="text-[15px] font-bold text-[#111827] pb-4 border-b border-[#F3F4F6]">
                    Văn phòng Ban Quản Lý
                </h3>
                <div class="space-y-4 text-[13px] text-[#4B5563]">
                    <div>
                        <div class="text-[11.5px] font-semibold text-[#6B7280] uppercase tracking-wider mb-1">Địa chỉ văn phòng</div>
                        <div class="font-medium text-[#111827]">Tầng 1, Sảnh Tòa A, GGMB Residence</div>
                    </div>
                    <div>
                        <div class="text-[11.5px] font-semibold text-[#6B7280] uppercase tracking-wider mb-1">Đường dây nóng 24/7</div>
                        <div class="font-bold text-[#0E4D3C] text-[17px]">1900 8888</div>
                        <div class="text-[12px] text-[#6B7280] mt-1">Kỹ thuật khẩn cấp: 0910 000 001</div>
                    </div>
                    <div>
                        <div class="text-[11.5px] font-semibold text-[#6B7280] uppercase tracking-wider mb-1">Thời gian làm việc</div>
                        <div class="text-[#374151]">Thứ 2 – Thứ 6: 08:00 – 17:30</div>
                        <div class="text-[#374151] mt-0.5">Thứ 7: 08:00 – 12:00</div>
                    </div>
                </div>

                <div class="pt-4 border-t border-[#F3F4F6]">
                    <a href="{{ route('portal.tickets') }}" class="w-full flex items-center justify-center py-2.5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[8px] transition-colors shadow-2xs">
                        Gửi phản ánh tới BQL
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
