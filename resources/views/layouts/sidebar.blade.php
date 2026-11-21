@props(['active' => 'overview'])

@php
    $menuItems = [
        ['id' => 'overview', 'name' => 'Tổng quan', 'route' => route('dashboard')],
        ['id' => 'buildings', 'name' => 'Tòa & tầng', 'route' => route('buildings.index')],
        ['id' => 'apartments', 'name' => 'Căn hộ', 'route' => route('apartments.index')],
        ['id' => 'residents', 'name' => 'Cư dân', 'route' => route('residents.index')],
        ['id' => 'vehicles', 'name' => 'Xe & đăng ký', 'route' => route('vehicles.index')],
        ['id' => 'utilities', 'name' => 'Điện & nước', 'route' => route('utilities.index')],
        ['id' => 'invoices', 'name' => 'Hóa đơn', 'route' => route('invoices.index')],
        ['id' => 'tickets', 'name' => 'Yêu cầu hỗ trợ', 'route' => route('tickets.index')],
        ['id' => 'notifications', 'name' => 'Thông báo', 'route' => route('notifications.index')],
        ['id' => 'fee-rates', 'name' => 'Biểu phí', 'route' => route('fee-rates.index')],
        ['id' => 'accounts', 'name' => 'Tài khoản', 'route' => route('accounts.index')],
    ];
@endphp

<aside class="w-[224px] min-w-[224px] bg-[#122d40] border-r border-[#203e52] flex flex-col shrink-0 select-none min-h-screen">
    <!-- Brand / Logo -->
    <div class="px-[23px] pt-[24px] pb-[16px]">
        <a href="{{ route('dashboard') }}" class="block">
            <h1 class="text-[22px] leading-[28px] font-semibold text-[#d4e2ec] tracking-normal">
                GGMB
            </h1>
            <p class="text-[11px] leading-[17px] font-normal text-[#a6bece] tracking-wider uppercase mt-1">
                QUẢN LÝ CHUNG CƯ
            </p>
        </a>
    </div>

    <!-- Tòa hiện hành / Logo -->
    <div class="px-[15px] mb-[24px]">
        <div class="w-[192px] h-[64px] relative rounded-[4px] overflow-hidden bg-[#183549] border border-[#203e52] flex items-center justify-center p-2">
            @if (file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" alt="GGMB Logo" class="max-w-full max-h-full block object-contain" />
            @else
                <div class="text-[#a6bece] text-xs font-medium text-center">
                    GGMB Residence
                </div>
            @endif
        </div>
    </div>

    <!-- Navigation List -->
    <nav class="flex-1 px-[15px] space-y-[7px]">
        @foreach ($menuItems as $item)
            @php
                $isActive = ($active === $item['id']);
                $prefix = $isActive ? '›  ' : '   ';
            @endphp

            @if ($isActive)
                <div class="h-[36px] bg-[#2864ad] border border-[#203e52] flex items-center px-[10px] text-[#d4e2ec] text-[14px] font-semibold leading-[20px] cursor-default" data-name="Đang xem">
                    <span class="truncate whitespace-pre">{{ $prefix }}{{ $item['name'] }}</span>
                </div>
            @else
                <a href="{{ $item['route'] }}" class="h-[36px] flex items-center px-[10px] text-[#d4e2ec] hover:text-white hover:bg-[#1a384e] transition-colors text-[14px] font-normal leading-[20px]">
                    <span class="truncate whitespace-pre">{{ $prefix }}{{ $item['name'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>
</aside>
