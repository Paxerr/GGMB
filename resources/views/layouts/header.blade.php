@props(['breadcrumbs' => ['GGMB', 'Tổng quan']])

<header class="h-[56px] min-h-[56px] bg-white border-b border-[#eaeaea] px-6 sm:px-8 flex items-center justify-between shrink-0 select-none sticky top-0 z-20">
    <!-- Left: Breadcrumb theo trang hiện tại -->
    <div class="flex items-center text-[13.5px] font-medium text-[#111827]">
        <!-- Breadcrumb Navigation on Header -->
        <nav class="flex items-center space-x-1.5 text-[13px] overflow-hidden" aria-label="Breadcrumb">
            @foreach ($breadcrumbs as $index => $crumb)
                @if ($index > 0)
                    <span class="text-[#9ca3af] text-[11px]">/</span>
                @endif
                @if ($loop->last)
                    <span class="font-semibold text-[#111827] truncate">{{ $crumb }}</span>
                @else
                    <span class="text-[#6b7280] truncate">{{ $crumb }}</span>
                @endif
            @endforeach
        </nav>
    </div>

    <!-- Right: Thông tin người đăng nhập & Nút Đăng xuất -->
    <div class="flex items-center space-x-3 sm:space-x-4">
        @auth
            <!-- Tên & Vai trò người đăng nhập -->
            <a href="{{ route('accounts.index') }}" class="flex items-center gap-2.5 py-1 px-2 rounded-[8px] hover:bg-[#f8faf8] transition-colors group" title="Tài khoản">
                <div class="w-7 h-7 rounded-full bg-[#e4efe9] text-[#0e4d3c] flex items-center justify-center font-semibold text-[11px] shrink-0 border border-[#cde0d5]">
                    <svg class="w-3.5 h-3.5 text-[#0e4d3c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="flex flex-col text-left leading-none">
                    <span class="text-[13px] font-semibold text-[#111827] group-hover:text-[#0e4d3c] transition-colors truncate max-w-[160px]">
                        {{ Auth::user()->FullName ?? Auth::user()->UserName ?? 'Nguyễn Văn Quản Lý' }}
                    </span>
                    <span class="text-[10px] font-medium text-[#6b7280] tracking-wider uppercase mt-1 truncate max-w-[160px]">
                        {{ Auth::user()->Role ?? 'Quản lý' }}
                    </span>
                </div>
                <span class="sr-only">Tài khoản</span>
            </a>

            <!-- Nút Đăng xuất bên trên header -->
            <form action="{{ route('logout') }}" method="POST" class="inline-flex items-center m-0">
                @csrf
                <button type="submit" class="h-8 px-2.5 sm:px-3 bg-white hover:bg-[#fef2f2] border border-[#e5e7eb] hover:border-[#fecaca] text-[#4b5563] hover:text-[#b91c1c] rounded-[8px] text-[12px] font-medium transition-all flex items-center gap-1.5 cursor-pointer group shadow-2xs" title="Đăng xuất khỏi hệ thống">
                    <svg class="w-3.5 h-3.5 text-[#6b7280] group-hover:text-[#b91c1c] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Đăng xuất</span>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="px-3.5 py-1.5 bg-[#0e4d3c] text-white hover:bg-[#0b3d30] rounded-[8px] text-[12px] font-medium transition-colors">
                Đăng nhập
                <span class="sr-only">Tài khoản</span>
            </a>
        @endauth
    </div>
</header>
