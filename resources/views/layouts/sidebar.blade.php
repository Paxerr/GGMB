@props(['active' => 'overview'])

@php
    $menuItems = [
        ['id' => 'overview', 'name' => 'Tổng quan', 'route' => route('dashboard'), 'icon' => 'grid'],
        ['id' => 'buildings', 'name' => 'Tòa & tầng', 'route' => route('buildings.index'), 'icon' => 'building'],
        ['id' => 'apartments', 'name' => 'Căn hộ', 'route' => route('apartments.index'), 'icon' => 'home'],
        ['id' => 'residents', 'name' => 'Cư dân', 'route' => route('residents.index'), 'icon' => 'users'],
        ['id' => 'vehicles', 'name' => 'Xe & đăng ký', 'route' => route('vehicles.index'), 'icon' => 'car'],
        ['id' => 'utilities', 'name' => 'Điện & nước', 'route' => route('utilities.index'), 'icon' => 'bolt'],
        ['id' => 'invoices', 'name' => 'Hóa đơn', 'route' => route('invoices.index'), 'icon' => 'receipt'],
        ['id' => 'tickets', 'name' => 'Yêu cầu hỗ trợ', 'route' => route('tickets.index'), 'icon' => 'headset'],
        ['id' => 'notifications', 'name' => 'Thông báo', 'route' => route('notifications.index'), 'icon' => 'bell'],
        ['id' => 'fee-rates', 'name' => 'Biểu phí', 'route' => route('fee-rates.index'), 'icon' => 'credit-card'],
        ['id' => 'accounts', 'name' => 'Tài khoản', 'route' => route('accounts.index'), 'icon' => 'user'],
    ];
@endphp

<aside id="mainSidebar" class="w-[240px] min-w-[240px] bg-white border-r border-[#eaeaea] flex flex-col shrink-0 select-none h-screen sticky top-0 py-5 px-3.5 transition-all duration-300 z-20 overflow-hidden">
    <!-- Brand / Header with Logo & Toggle Button -->
    <div class="px-1 pt-1 pb-2 shrink-0">
        <!-- Khi mở rộng: Logo + Tên thương hiệu + Nút 3 gạch thu gọn bên phải -->
        <div class="sidebar-full-only flex items-center justify-between gap-2">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group min-w-0" title="GGMB Quản lý chung cư">
                <div class="w-9 h-9 shrink-0 flex items-center justify-center">
                    <svg class="w-9 h-9 drop-shadow-xs" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 33V18C10 13.5 13.5 11.5 16.5 14L24 21.5L31.5 14C34.5 11.5 38 13.5 38 18V33" stroke="url(#sidebar_logo_grad)" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                        <defs>
                            <linearGradient id="sidebar_logo_grad" x1="10" y1="12" x2="38" y2="33" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#00D2FF"/>
                                <stop offset="0.5" stop-color="#0066FF"/>
                                <stop offset="1" stop-color="#0040E0"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="min-w-0">
                    <h1 class="text-[20px] leading-none font-bold text-[#0e4d3c] tracking-tight truncate">
                        GGMB
                    </h1>
                    <p class="text-[11px] leading-normal font-medium text-[#6b7280] mt-1 truncate">
                        Quản lý chung cư
                    </p>
                    <span class="sr-only">QUẢN LÝ CHUNG CƯ</span>
                </div>
            </a>
            <button type="button" class="js-sidebar-toggle p-1.5 text-[#6b7280] hover:text-[#111827] hover:bg-[#f3f4f6] rounded-[8px] transition-colors cursor-pointer shrink-0" title="Thu gọn thanh bên">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="sr-only">Thu gọn thanh bên</span>
            </button>
        </div>

        <!-- Khi thu gọn: Logo và Nút 3 gạch căn giữa (chỉ hiển thị khi thu gọn) -->
        <div class="sidebar-collapsed-only flex-col items-center gap-2" style="display: none;">
            <a href="{{ route('dashboard') }}" class="w-9 h-9 flex items-center justify-center group mb-0.5" title="GGMB Quản lý chung cư">
                <svg class="w-9 h-9 drop-shadow-xs" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 33V18C10 13.5 13.5 11.5 16.5 14L24 21.5L31.5 14C34.5 11.5 38 13.5 38 18V33" stroke="url(#sidebar_logo_grad_col)" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                    <defs>
                        <linearGradient id="sidebar_logo_grad_col" x1="10" y1="12" x2="38" y2="33" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#00D2FF"/>
                            <stop offset="0.5" stop-color="#0066FF"/>
                            <stop offset="1" stop-color="#0040E0"/>
                        </linearGradient>
                    </defs>
                </svg>
            </a>
            <button type="button" class="js-sidebar-toggle p-1.5 text-[#6b7280] hover:text-[#111827] hover:bg-[#f3f4f6] rounded-[8px] transition-colors cursor-pointer flex items-center justify-center w-8 h-8" title="Mở rộng thanh bên">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="sr-only">Mở rộng thanh bên</span>
            </button>
        </div>
    </div>

    <!-- Image Card (ảnh anh.png theo thiết kế - ẩn khi thu gọn) -->
    <div class="sidebar-full-only my-3 rounded-[12px] overflow-hidden border border-[#E5E7EB] shadow-xs shrink-0">
        <img src="{{ asset('images/anh.png') }}" alt="GGMB Residence" class="w-full h-[115px] object-cover" />
        <span class="sr-only">GGMB Residence Tòa A · 5 tầng · 40 căn hộ</span>
    </div>

    <!-- VẬN HÀNH Section Label / Divider -->
    <div class="sidebar-full-only text-[11px] font-semibold text-[#9ca3af] tracking-wider uppercase px-2 mb-2 mt-1 shrink-0">
        VẬN HÀNH
    </div>
    <div class="sidebar-collapsed-only border-t border-[#e5e7eb] my-2 w-8 mx-auto shrink-0"></div>

    <!-- Navigation List (Bo góc 10px, giữ nguyên hệ màu) -->
    <nav class="flex-1 space-y-1 overflow-y-auto min-h-0 pr-0.5">
        @foreach ($menuItems as $item)
            @php
                $isActive = ($active === $item['id']);
            @endphp

            @if ($isActive)
                <div class="sidebar-nav-item h-[38px] bg-[#e4efe9] text-[#0e4d3c] font-semibold rounded-[10px] px-3 flex items-center gap-3 text-[13.5px] cursor-default" data-name="Đang xem" title="{{ $item['name'] }}">
                    @include('layouts.partials.sidebar-icon', ['icon' => $item['icon'], 'class' => 'text-[#0e4d3c]'])
                    <span class="truncate sidebar-full-only">{{ $item['name'] }}</span>
                </div>
            @else
                <a href="{{ $item['route'] }}" class="sidebar-nav-item h-[38px] text-[#4b5563] hover:text-[#111827] hover:bg-[#f4f7f5] font-normal rounded-[10px] px-3 flex items-center gap-3 text-[13.5px] transition-colors" title="{{ $item['name'] }}">
                    @include('layouts.partials.sidebar-icon', ['icon' => $item['icon'], 'class' => 'text-[#6b7280]'])
                    <span class="truncate sidebar-full-only">{{ $item['name'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>
</aside>
