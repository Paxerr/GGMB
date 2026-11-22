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
    <!-- Brand / Header -->
    <div class="px-2 pt-1 pb-2">
        <a href="{{ route('dashboard') }}" class="block">
            <h1 class="text-[22px] leading-tight font-bold text-[#0e4d3c] tracking-tight">
                GGMB
            </h1>
            <p class="text-[11px] leading-normal font-semibold text-[#6b7280] tracking-wider uppercase mt-0.5">
                QUẢN LÝ CHUNG CƯ
            </p>
        </a>
    </div>

    <!-- Tòa hiện hành Card (Bo góc 12px) -->
    <div class="bg-[#f2f6f4] border border-[#e3ebe5] rounded-[12px] p-3 my-3">
        <div class="text-[13px] font-semibold text-[#111827]">
            GGMB Residence
        </div>
        <div class="text-[11px] text-[#6b7280] mt-0.5">
            Tòa A · 5 tầng · 40 căn hộ
        </div>
    </div>

    <!-- VẬN HÀNH Section Label -->
    <div class="text-[11px] font-semibold text-[#9ca3af] tracking-wider uppercase px-2 mb-2 mt-1">
        VẬN HÀNH
    </div>

    <!-- Navigation List (Bo góc 10px, icons theo mẫu) -->
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

    <!-- Bottom Profile & Logout -->
    <div class="border-t border-[#eaeaea] pt-4 mt-auto px-1">
        <div class="text-[13px] font-semibold text-[#111827] truncate">
            {{ Auth::user()->FullName ?? Auth::user()->UserName ?? 'Nguyễn Minh Quản lý' }}
        </div>
        <div class="text-[11px] text-[#6b7280] mt-0.5">
            {{ Auth::user()->Role ?? 'Quản lý hệ thống' }}
        </div>

        @auth
            <form action="{{ route('logout') }}" method="POST" class="mt-2.5">
                @csrf
                <button type="submit" class="px-3.5 py-1.5 bg-[#f3f4f6] hover:bg-[#e5e7eb] text-[#374151] rounded-[6px] text-[12px] font-medium transition-colors cursor-pointer inline-flex items-center">
                    Đăng xuất
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="mt-2.5 inline-block px-3.5 py-1.5 bg-[#f3f4f6] hover:bg-[#e5e7eb] text-[#374151] rounded-[6px] text-[12px] font-medium transition-colors">
                Đăng nhập
            </a>
        @endauth
    </div>
</aside>
