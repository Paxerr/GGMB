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

<aside class="w-[240px] min-w-[240px] bg-white border-r border-[#eaeaea] flex flex-col shrink-0 select-none min-h-screen py-5 px-3.5">
    <!-- Brand / Header with Logo -->
    <div class="px-1 pt-1 pb-2">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
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
            <div>
                <h1 class="text-[20px] leading-none font-bold text-[#0e4d3c] tracking-tight">
                    GGMB
                </h1>
                <p class="text-[11px] leading-normal font-medium text-[#6b7280] mt-1">
                    Quản lý chung cư
                </p>
                <span class="sr-only">QUẢN LÝ CHUNG CƯ</span>
            </div>
        </a>
    </div>

    <!-- Image Card (ảnh anh.png theo thiết kế) -->
    <div class="my-3 rounded-[12px] overflow-hidden border border-[#E5E7EB] shadow-xs">
        <img src="{{ asset('images/anh.png') }}" alt="GGMB Residence" class="w-full h-[115px] object-cover" />
        <span class="sr-only">GGMB Residence Tòa A · 5 tầng · 40 căn hộ</span>
    </div>

    <!-- VẬN HÀNH Section Label -->
    <div class="text-[11px] font-semibold text-[#9ca3af] tracking-wider uppercase px-2 mb-2 mt-1">
        VẬN HÀNH
    </div>

    <!-- Navigation List (Bo góc 10px, giữ nguyên hệ màu) -->
    <nav class="flex-1 space-y-1">
        @foreach ($menuItems as $item)
            @php
                $isActive = ($active === $item['id']);
            @endphp

            @if ($isActive)
                <div class="h-[38px] bg-[#e4efe9] text-[#0e4d3c] font-semibold rounded-[10px] px-3 flex items-center gap-3 text-[13.5px] cursor-default" data-name="Đang xem">
                    @include('layouts.partials.sidebar-icon', ['icon' => $item['icon'], 'class' => 'text-[#0e4d3c]'])
                    <span class="truncate">{{ $item['name'] }}</span>
                </div>
            @else
                <a href="{{ $item['route'] }}" class="h-[38px] text-[#4b5563] hover:text-[#111827] hover:bg-[#f4f7f5] font-normal rounded-[10px] px-3 flex items-center gap-3 text-[13.5px] transition-colors">
                    @include('layouts.partials.sidebar-icon', ['icon' => $item['icon'], 'class' => 'text-[#6b7280]'])
                    <span class="truncate">{{ $item['name'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>

    <!-- Bottom Profile & Logout Card (Bo tròn theo ảnh, không cần avatar) -->
    <div class="mt-auto pt-3">
        <div class="bg-[#f8faf8] border border-[#e5e7eb] rounded-[14px] p-3 shadow-none">
            <!-- User Info Row -->
            <div class="flex items-center justify-between">
                <div class="min-w-0 pr-2">
                    <div class="text-[13px] font-semibold text-[#111827] truncate">
                        {{ Auth::user()->FullName ?? Auth::user()->UserName ?? 'Nguyễn Minh Quản Lý' }}
                    </div>
                    <div class="text-[11px] text-[#6b7280] mt-0.5 truncate">
                        {{ Auth::user()->Role ?? 'Quản lý hệ thống' }}
                    </div>
                </div>
                <svg class="w-4 h-4 text-[#9ca3af] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <div class="border-t border-[#e5e7eb] my-2"></div>

            <!-- Logout Button with icon & "Đăng xuất" -->
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-1 text-[#4b5563] hover:text-[#b91c1c] text-[12.5px] font-medium transition-colors cursor-pointer">
                        <svg class="w-4 h-4 text-[#6b7280] group-hover:text-[#b91c1c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Đăng xuất</span>
                    </button>
                </form>
            @else
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-1 text-[#4b5563] hover:text-[#b91c1c] text-[12.5px] font-medium transition-colors cursor-pointer">
                        <svg class="w-4 h-4 text-[#6b7280]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Đăng xuất</span>
                        <a href="{{ route('login') }}" class="sr-only">Đăng nhập</a>
                    </button>
                </form>
            @endauth
        </div>
    </div>
</aside>
