@props(['breadcrumbs' => ['GGMB', 'Tổng quan']])

<header class="h-[64px] min-h-[64px] bg-white border-b border-[#d9e4ec] px-8 flex items-center justify-between shrink-0 select-none">
    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-2 text-[14px] leading-[20px] text-[#334b5d]" aria-label="Breadcrumb">
        @foreach ($breadcrumbs as $index => $crumb)
            @if ($index > 0)
                <span class="text-[#52697c]">/</span>
            @endif
            <span class="{{ $loop->last ? 'text-[#334b5d] font-normal' : 'text-[#334b5d]' }}">
                {{ $crumb }}
            </span>
        @endforeach
    </nav>

    <!-- Header Actions (Right) -->
    <div class="flex items-center space-x-8 text-[13px] leading-[19px] text-[#334b5d]">
        <a href="#" class="hover:text-[#122d40] transition-colors relative flex items-center">
            Thông báo
        </a>

        @auth
            <div class="relative flex items-center space-x-4">
                <span class="text-[#334b5d]">
                    Tài khoản ({{ Auth::user()->FullName ?? Auth::user()->UserName }})
                </span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs text-[#2864ad] hover:underline cursor-pointer">
                        [Đăng xuất]
                    </button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}" class="hover:text-[#122d40] transition-colors">
                Tài khoản
            </a>
        @endauth
    </div>
</header>
