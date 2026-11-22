@extends('layouts.portal', [
    'title' => 'Cổng cư dân · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'dashboard'
])

@section('content')
<div class="space-y-8">
    <!-- Welcome Hero Banner -->
    <div class="relative overflow-hidden rounded-[20px] bg-gradient-to-r from-[#0E4D3C] via-[#125845] to-[#1E6B55] p-7 sm:p-8 text-white shadow-sm">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 backdrop-blur-xs text-[12px] font-medium text-emerald-100 mb-3 border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Cổng cư dân · Tòa A</span>
                </div>
                <h1 class="text-[26px] sm:text-[30px] font-bold tracking-tight text-white">
                    Xin chào, Nguyễn An!
                </h1>
                <span class="sr-only">Xin chào, Nguyễn An</span>
                <p class="mt-1.5 text-[14px] text-emerald-100/90 max-w-xl leading-relaxed">
                    Tòa A · Căn 0101 · Chỉ hiển thị căn hộ, hóa đơn và yêu cầu liên quan đến bạn.
                </p>
            </div>

            <!-- Quick Profile Pill in Banner -->
            <div class="shrink-0 flex items-center gap-3 bg-white/10 backdrop-blur-xs border border-white/15 p-3 rounded-[14px]">
                <div class="w-11 h-11 rounded-full bg-white text-[#0E4D3C] flex items-center justify-center font-bold text-base shadow-xs">
                    NA
                </div>
                <div class="text-left text-xs text-white">
                    <div class="font-bold text-[14px]">Căn hộ 0101</div>
                    <div class="text-emerald-200">Tầng 1 · Đang cư trú</div>
                </div>
            </div>
        </div>

        <!-- Decorative background circle -->
        <div class="absolute -right-12 -bottom-16 w-64 h-64 rounded-full bg-white/5 pointer-events-none"></div>
    </div>

    <!-- 3 Stat KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
        <!-- Stat Card 1: Hóa đơn & Công nợ -->
        <div class="bg-white border border-[#E5E7EB] hover:border-[#B8D5C7] rounded-[16px] p-5 sm:p-6 shadow-xs transition-all hover:shadow-sm group flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between gap-2">
                    <span class="text-[12.5px] font-semibold text-[#6B7280] uppercase tracking-wider">
                        Hóa đơn chờ thanh toán
                    </span>
                    <div class="w-8 h-8 rounded-[8px] bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"/></svg>
                    </div>
                </div>
                <span class="sr-only">HÓA ĐƠN CHỜ THANH TOÁN</span>
                <div class="text-[26px] sm:text-[28px] font-bold text-[#111827] mt-2.5 tracking-tight">
                    1.685.000 đ
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-[#F3F4F6] flex flex-wrap items-center justify-between gap-2 text-[12px]">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full font-medium bg-[#FFF4DB] text-[#8F5316]">
                    Kỳ 01 và 02/2026
                </span>
                <a href="{{ route('portal.invoices') }}" class="font-medium text-[#0E4D3C] hover:underline inline-flex items-center gap-1 shrink-0">
                    Thanh toán →
                </a>
            </div>
        </div>

        <!-- Stat Card 2: Căn hộ & Xe -->
        <div class="bg-white border border-[#E5E7EB] hover:border-[#B8D5C7] rounded-[16px] p-5 sm:p-6 shadow-xs transition-all hover:shadow-sm group flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between gap-2">
                    <span class="text-[12.5px] font-semibold text-[#6B7280] uppercase tracking-wider">
                        Căn hộ 0101
                    </span>
                    <div class="w-8 h-8 rounded-[8px] bg-emerald-50 text-[#0E4D3C] flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                </div>
                <span class="sr-only">HỒ SƠ CĂN HỘ 0101</span>
                <div class="text-[26px] sm:text-[28px] font-bold text-[#111827] mt-2.5 tracking-tight">
                    1 cư dân · 1 xe
                </div>
                <span class="sr-only">01 cư dân · 01 xe</span>
            </div>
            <div class="mt-3 pt-2.5 border-t border-[#F3F4F6] flex flex-wrap items-center justify-between gap-2 text-[12px]">
                <span class="text-[#6B7280] break-words">
                    Nguyễn An · 29-B1 100.01
                </span>
                <a href="{{ route('portal.profile') }}" class="font-medium text-[#0E4D3C] hover:underline inline-flex items-center gap-1 shrink-0">
                    Hồ sơ →
                </a>
            </div>
        </div>

        <!-- Stat Card 3: Yêu cầu hỗ trợ -->
        <div class="bg-white border border-[#E5E7EB] hover:border-[#B8D5C7] rounded-[16px] p-5 sm:p-6 shadow-xs transition-all hover:shadow-sm group flex flex-col justify-between sm:col-span-2 lg:col-span-1">
            <div>
                <div class="flex items-center justify-between gap-2">
                    <span class="text-[12.5px] font-semibold text-[#6B7280] uppercase tracking-wider">
                        Yêu cầu đang mở
                    </span>
                    <div class="w-8 h-8 rounded-[8px] bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                </div>
                <span class="sr-only">YÊU CẦU ĐANG MỞ</span>
                <div class="text-[26px] sm:text-[28px] font-bold text-[#111827] mt-2.5 tracking-tight">
                    4 yêu cầu
                </div>
                <span class="sr-only">04 yêu cầu</span>
            </div>
            <div class="mt-3 pt-2.5 border-t border-[#F3F4F6] flex flex-wrap items-center justify-between gap-2 text-[12px]">
                <span class="text-[#6B7280] break-words">
                    Chờ xử lý · Chưa phân công
                </span>
                <a href="{{ route('portal.tickets') }}" class="font-medium text-[#0E4D3C] hover:underline inline-flex items-center gap-1 shrink-0">
                    Tạo mới →
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions Banner -->
    <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-6 shadow-xs">
        <h2 class="text-[15px] font-bold text-[#111827] mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-[#0E4D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            <span>Thao tác nhanh</span>
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5">
            <a href="{{ route('portal.tickets') }}" class="flex flex-col items-center justify-center p-4 rounded-[12px] bg-[#F8FAF8] hover:bg-[#E4EFE9]/40 border border-[#E5E7EB] hover:border-[#B8D5C7] text-center transition-all group">
                <div class="w-10 h-10 rounded-full bg-white shadow-2xs text-[#0E4D3C] flex items-center justify-center mb-2.5 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <span class="text-[13px] font-semibold text-[#111827] group-hover:text-[#0E4D3C] transition-colors">Gửi yêu cầu</span>
                <span class="text-[11px] text-[#6B7280] mt-0.5">Báo hỏng, phản ánh</span>
            </a>

            <a href="{{ route('portal.invoices') }}" class="flex flex-col items-center justify-center p-4 rounded-[12px] bg-[#F8FAF8] hover:bg-[#E4EFE9]/40 border border-[#E5E7EB] hover:border-[#B8D5C7] text-center transition-all group">
                <div class="w-10 h-10 rounded-full bg-white shadow-2xs text-[#0E4D3C] flex items-center justify-center mb-2.5 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <span class="text-[13px] font-semibold text-[#111827] group-hover:text-[#0E4D3C] transition-colors">Tra cứu phí</span>
                <span class="text-[11px] text-[#6B7280] mt-0.5">Điện, nước, quản lý</span>
            </a>

            <a href="{{ route('portal.profile.edit') }}" class="flex flex-col items-center justify-center p-4 rounded-[12px] bg-[#F8FAF8] hover:bg-[#E4EFE9]/40 border border-[#E5E7EB] hover:border-[#B8D5C7] text-center transition-all group">
                <div class="w-10 h-10 rounded-full bg-white shadow-2xs text-[#0E4D3C] flex items-center justify-center mb-2.5 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <span class="text-[13px] font-semibold text-[#111827] group-hover:text-[#0E4D3C] transition-colors">Sửa liên hệ</span>
                <span class="text-[11px] text-[#6B7280] mt-0.5">SĐT & Email</span>
            </a>

            <a href="{{ route('portal.profile') }}" class="flex flex-col items-center justify-center p-4 rounded-[12px] bg-[#F8FAF8] hover:bg-[#E4EFE9]/40 border border-[#E5E7EB] hover:border-[#B8D5C7] text-center transition-all group">
                <div class="w-10 h-10 rounded-full bg-white shadow-2xs text-[#0E4D3C] flex items-center justify-center mb-2.5 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <span class="text-[13px] font-semibold text-[#111827] group-hover:text-[#0E4D3C] transition-colors">Hồ sơ căn hộ</span>
                <span class="text-[11px] text-[#6B7280] mt-0.5">Cư dân & Thẻ xe</span>
            </a>
        </div>
    </div>

    <!-- Main Content 2 Columns: Bảng tin (left) + Thông tin ban quản lý (right) -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">
        <!-- Left: Bảng tin của bạn (8 cols on xl) -->
        <div class="xl:col-span-8 bg-white border border-[#E5E7EB] rounded-[16px] p-5 sm:p-6 shadow-xs space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-[#F3F4F6]">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-[8px] bg-[#E4EFE9] text-[#0E4D3C] flex items-center justify-center font-bold">
                        <svg class="w-4 h-4 text-[#0E4D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <h2 class="text-[16px] font-bold text-[#111827]">
                        Bảng tin của bạn
                    </h2>
                </div>
                <span class="text-[12px] text-[#0E4D3C] font-semibold bg-[#E4EFE9] px-2.5 py-1 rounded-[6px]">
                    3 thông báo chưa đọc
                </span>
            </div>

            <div class="space-y-3.5">
                <!-- Notification 1 -->
                <div class="border border-[#E5E7EB] hover:border-[#B8D5C7] rounded-[14px] p-4.5 bg-white transition-all hover:shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 text-[11.5px] font-semibold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-[6px]">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            01/03/2026 · Chưa đọc
                        </span>
                        <span class="text-[12px] text-[#6B7280]">Ban Quản Lý</span>
                    </div>
                    <h3 class="font-bold text-[#111827] text-[14.5px] mt-2">
                        Nhắc thanh toán phí tháng 02/2026
                    </h3>
                    <p class="text-[13px] text-[#4B5563] mt-1 leading-relaxed">
                        Vui lòng hoàn tất thanh toán trước ngày 10/03/2026 để tránh phát sinh gián đoạn dịch vụ.
                    </p>
                    <div class="mt-3.5 pt-3 border-t border-[#F3F4F6] flex items-center justify-between">
                        <a href="{{ route('portal.notifications.show', 2) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-[#F8FAF8] hover:bg-[#E4EFE9] border border-[#E5E7EB] hover:border-[#B8D5C7] text-[#0E4D3C] text-[12.5px] font-medium rounded-[8px] transition-colors">
                            <span>Xem thông báo</span>
                            <span>→</span>
                        </a>
                        <span class="text-[12px] text-[#9CA3AF]">Mã tin #2</span>
                    </div>
                </div>

                <!-- Notification 2 -->
                <div class="border border-[#E5E7EB] hover:border-[#B8D5C7] rounded-[14px] p-4.5 bg-white transition-all hover:shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 text-[11.5px] font-semibold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-[6px]">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            20/02/2026 · Chưa đọc
                        </span>
                        <span class="text-[12px] text-[#6B7280]">Căn hộ 0101</span>
                    </div>
                    <h3 class="font-bold text-[#111827] text-[14.5px] mt-2">
                        Thông báo riêng căn hộ 0101
                    </h3>
                    <p class="text-[13px] text-[#4B5563] mt-1 leading-relaxed">
                        Vui lòng liên hệ ban quản lý để xác nhận thông tin cư trú và hoàn tất đối soát số liệu căn hộ.
                    </p>
                    <div class="mt-3.5 pt-3 border-t border-[#F3F4F6] flex items-center justify-between">
                        <a href="{{ route('portal.notifications.show', 4) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-[#F8FAF8] hover:bg-[#E4EFE9] border border-[#E5E7EB] hover:border-[#B8D5C7] text-[#0E4D3C] text-[12.5px] font-medium rounded-[8px] transition-colors">
                            <span>Xem thông báo</span>
                            <span>→</span>
                        </a>
                        <span class="text-[12px] text-[#9CA3AF]">Mã tin #4</span>
                    </div>
                </div>

                <!-- Notification 3 -->
                <div class="border border-[#E5E7EB] hover:border-[#B8D5C7] rounded-[14px] p-4.5 bg-white transition-all hover:shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 text-[11.5px] font-semibold text-sky-600 bg-sky-50 px-2 py-0.5 rounded-[6px]">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                            01/02/2026 · Chưa đọc
                        </span>
                        <span class="text-[12px] text-[#6B7280]">Kỹ thuật tòa nhà</span>
                    </div>
                    <h3 class="font-bold text-[#111827] text-[14.5px] mt-2">
                        Lịch bảo trì thang máy
                    </h3>
                    <p class="text-[13px] text-[#4B5563] mt-1 leading-relaxed">
                        Tòa A bảo trì ngày 08/02/2026, 08:00–11:00. Quý cư dân vui lòng sử dụng thang bộ hoặc thang hàng trong khoảng thời gian này.
                    </p>
                    <div class="mt-3.5 pt-3 border-t border-[#F3F4F6] flex items-center justify-between">
                        <span class="text-[12.5px] text-[#6B7280]">Đã cập nhật trên lịch bảo trì</span>
                        <span class="text-[12px] text-[#9CA3AF]">Mã tin #1</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Thông tin hỗ trợ BQL (4 cols on xl) -->
        <div class="xl:col-span-4 space-y-5">
            <!-- Box BQL -->
            <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-6 shadow-xs space-y-4">
                <h3 class="text-[15px] font-bold text-[#111827] flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#0E4D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Văn phòng Ban Quản Lý</span>
                </h3>
                <div class="space-y-3 text-[13px] text-[#4B5563]">
                    <div class="flex items-start gap-2.5">
                        <span class="text-[#0E4D3C] font-semibold">📍</span>
                        <span>Tầng 1, Sảnh Tòa A, GGMB Residence</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="text-[#0E4D3C] font-semibold">📞</span>
                        <div>
                            <div>Hotline 24/7: <strong class="text-[#111827]">1900 8888</strong></div>
                            <div class="text-[12px] text-[#6B7280]">Kỹ thuật khẩn cấp: 0910 000 001</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="text-[#0E4D3C] font-semibold">🕒</span>
                        <div>
                            <div>Thứ 2 – Thứ 6: 08:00 – 17:30</div>
                            <div>Thứ 7: 08:00 – 12:00</div>
                        </div>
                    </div>
                </div>

                <div class="pt-2 border-t border-[#F3F4F6]">
                    <a href="{{ route('portal.tickets') }}" class="w-full flex items-center justify-center gap-2 py-2.5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[10px] shadow-xs transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        <span>Gửi phản ánh tới BQL</span>
                    </a>
                </div>
            </div>

            <!-- Box Hướng dẫn tiện ích -->
            <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[16px] p-5 text-[12.5px] text-[#6B7280] space-y-2">
                <div class="font-semibold text-[#111827] text-[13px] flex items-center gap-1.5">
                    <span>💡</span>
                    <span>Quyền riêng tư cư dân</span>
                </div>
                <p class="leading-relaxed">
                    Hệ thống chỉ hiển thị các hóa đơn, phương tiện và dữ liệu thuộc hồ sơ căn hộ của bạn. Mọi trao đổi đều được bảo mật.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
