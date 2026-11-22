@props(['breadcrumbs' => ['GGMB', 'Tổng quan']])

<header class="h-[56px] min-h-[56px] bg-white border-b border-[#eaeaea] px-8 flex items-center justify-between shrink-0 select-none">
    <!-- Left: Tòa / Vị trí theo ảnh thiết kế -->
    <div class="flex items-center space-x-2 text-[13.5px] font-semibold text-[#111827]">
        <span>GGMB Residence · Tòa A</span>
    </div>

    <!-- Right: Thông báo pill & Tên người dùng -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('notifications.index') }}" class="px-3.5 py-1.5 bg-[#f3f4f6] hover:bg-[#e5e7eb] text-[#374151] rounded-[8px] text-[12px] font-medium transition-colors flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 text-[#6b7280]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
            <span>Thông báo</span>
        </a>

        @auth
            <a href="{{ route('accounts.index') }}" class="text-[13px] font-medium text-[#111827] hover:text-[#0e4d3c] transition-colors" title="Tài khoản">
                {{ Auth::user()->FullName ?? Auth::user()->UserName ?? 'Nguyễn Minh Quản lý' }}
                <span class="sr-only">Tài khoản</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="text-[13px] font-medium text-[#111827] hover:text-[#0e4d3c] transition-colors">
                Tài khoản
            </a>
        @endauth
    </div>
</header>
