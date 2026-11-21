<!DOCTYPE html>
<html lang="vi" class="h-full bg-[#f3f7fa]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'GGMB · Cổng thông tin' }}</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                        },
                        colors: {
                            'ggmb-navy': '#122D40',
                            'ggmb-body': '#334B5D',
                            'ggmb-muted': '#52697C',
                            'ggmb-border': '#D9E4EC',
                            'ggmb-bluesoft': '#E8F1FF',
                            'ggmb-primary': '#2864AD',
                            'ggmb-canvas': '#F3F7FA',
                            'ggmb-success': '#16734B',
                            'ggmb-success-soft': '#E6F5EC',
                            'ggmb-violet': '#6A51AE',
                            'ggmb-violet-soft': '#F0EDFA',
                            'ggmb-warning': '#985B06',
                            'ggmb-warning-soft': '#FFF4DB',
                            'ggmb-chrome': '#E4EDF3',
                        }
                    }
                }
            }
        </script>
    @endif

    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-[#f3f7fa] text-[#334b5d] antialiased flex flex-col justify-between">
    <!-- Top Portal Header -->
    <header class="bg-[#122D40] text-white px-6 lg:px-8 py-3.5 flex items-center justify-between shadow-sm select-none shrink-0 z-30">
        <!-- Left: Brand + Portal Badge -->
        <div class="flex items-center space-x-6">
            <a href="{{ ($portalType ?? 'resident') === 'tech' ? route('tech.tasks') : route('portal.dashboard') }}" class="text-[17px] font-bold text-white tracking-wider flex items-center">
                GGMB
            </a>
            @if (($portalType ?? 'resident') === 'tech')
                <span class="text-[12px] font-semibold text-slate-300 tracking-wider uppercase border-l border-slate-600 pl-4 py-0.5">
                    CỔNG KỸ THUẬT
                </span>
            @else
                <span class="text-[12px] font-semibold text-slate-300 tracking-wider uppercase border-l border-slate-600 pl-4 py-0.5">
                    CỔNG CƯ DÂN
                </span>
            @endif
        </div>

        <!-- Center: Navigation Tabs -->
        <nav class="hidden md:flex items-center space-x-2">
            @if (($portalType ?? 'resident') === 'tech')
                <a href="{{ route('tech.tasks') }}" class="px-5 py-1.5 rounded-[4px] text-[13px] font-medium transition-colors {{ ($activeTab ?? 'tasks') === 'tasks' ? 'bg-[#2864AD] text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    Bàn việc
                </a>
                <a href="{{ route('tech.utilities') }}" class="px-5 py-1.5 rounded-[4px] text-[13px] font-medium transition-colors {{ ($activeTab ?? 'tasks') === 'utilities' ? 'bg-[#2864AD] text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    Ghi điện nước
                </a>
            @else
                <a href="{{ route('portal.dashboard') }}" class="px-5 py-1.5 rounded-[4px] text-[13px] font-medium transition-colors {{ ($activeTab ?? 'dashboard') === 'dashboard' ? 'bg-[#2864AD] text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    Trang chủ
                </a>
                <a href="{{ route('portal.invoices') }}" class="px-5 py-1.5 rounded-[4px] text-[13px] font-medium transition-colors {{ ($activeTab ?? 'dashboard') === 'invoices' ? 'bg-[#2864AD] text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    Hóa đơn
                </a>
                <a href="{{ route('portal.tickets') }}" class="px-5 py-1.5 rounded-[4px] text-[13px] font-medium transition-colors {{ ($activeTab ?? 'dashboard') === 'tickets' ? 'bg-[#2864AD] text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-white/10' }}">
                    Hỗ trợ
                </a>
            @endif
        </nav>

        <!-- Right: User Identity & Logout -->
        <div class="flex items-center space-x-4">
            @if (($portalType ?? 'resident') === 'tech')
                <div class="text-right text-[12px] sm:text-[13px]">
                    <span class="text-slate-200 font-medium">Vũ Hoàng Kỹ thuật · tech03 · Kỹ thuật</span>
                    <span class="text-slate-500 mx-1">·</span>
                    <a href="{{ route('login') }}" class="text-slate-400 hover:text-white transition-colors">Đăng xuất</a>
                </div>
            @else
                <div class="text-right">
                    <div class="text-white font-medium text-[13px] leading-tight">
                        Nguyễn An / Căn 0101
                    </div>
                    <div class="text-slate-400 text-[12px] leading-tight mt-0.5">
                        resident01 · <a href="{{ route('login') }}" class="text-slate-400 hover:text-white transition-colors">Đăng xuất</a>
                    </div>
                </div>
            @endif
        </div>
    </header>

    <!-- Mobile Navigation Bar -->
    <div class="md:hidden bg-[#183952] px-4 py-2 flex items-center justify-around text-[13px] border-b border-slate-700">
        @if (($portalType ?? 'resident') === 'tech')
            <a href="{{ route('tech.tasks') }}" class="px-3 py-1 rounded {{ ($activeTab ?? 'tasks') === 'tasks' ? 'bg-[#2864AD] text-white font-medium' : 'text-slate-300' }}">Bàn việc</a>
            <a href="{{ route('tech.utilities') }}" class="px-3 py-1 rounded {{ ($activeTab ?? 'tasks') === 'utilities' ? 'bg-[#2864AD] text-white font-medium' : 'text-slate-300' }}">Ghi điện nước</a>
        @else
            <a href="{{ route('portal.dashboard') }}" class="px-3 py-1 rounded {{ ($activeTab ?? 'dashboard') === 'dashboard' ? 'bg-[#2864AD] text-white font-medium' : 'text-slate-300' }}">Trang chủ</a>
            <a href="{{ route('portal.invoices') }}" class="px-3 py-1 rounded {{ ($activeTab ?? 'dashboard') === 'invoices' ? 'bg-[#2864AD] text-white font-medium' : 'text-slate-300' }}">Hóa đơn</a>
            <a href="{{ route('portal.tickets') }}" class="px-3 py-1 rounded {{ ($activeTab ?? 'dashboard') === 'tickets' ? 'bg-[#2864AD] text-white font-medium' : 'text-slate-300' }}">Hỗ trợ</a>
        @endif
    </div>

    <!-- Main Container -->
    <main class="flex-1 w-full max-w-[1280px] mx-auto p-6 md:p-8">
        @if (session('success'))
            <div class="mb-6 p-4 bg-[#e6f5ec] border border-[#c3e6cb] text-[#16734b] text-[14px] rounded-[4px] flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="text-[#16734b] font-bold text-lg leading-none cursor-pointer">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-[#fdf2f2] border border-[#fecaca] text-[#b91c1c] text-[14px] rounded-[4px] flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="text-[#b91c1c] font-bold text-lg leading-none cursor-pointer">&times;</button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Global Toast Notification Container -->
    <div id="globalToastContainer" class="fixed bottom-5 right-5 z-[100] flex flex-col space-y-2 pointer-events-none"></div>

    <script>
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('globalToastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'pointer-events-auto flex items-center justify-between px-4 py-3 rounded-[4px] shadow-lg border text-[13px] font-medium transition-all duration-300 transform translate-y-4 opacity-0 max-w-sm';

            if (type === 'danger' || type === 'error') {
                toast.classList.add('bg-[#fdf2f2]', 'border-[#fecaca]', 'text-[#b91c1c]');
            } else if (type === 'info') {
                toast.classList.add('bg-[#e8f1ff]', 'border-[#b9d5ff]', 'text-[#2864ad]');
            } else {
                toast.classList.add('bg-[#e6f5ec]', 'border-[#c3e6cb]', 'text-[#16734b]');
            }

            toast.innerHTML = `
                <div class="flex items-center space-x-2">
                    <span>${message}</span>
                </div>
                <button type="button" class="ml-3 text-current hover:opacity-75 cursor-pointer font-bold leading-none">&times;</button>
            `;

            toast.querySelector('button').addEventListener('click', () => {
                toast.classList.remove('opacity-100', 'translate-y-0');
                toast.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => toast.remove(), 300);
            });

            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('opacity-0', 'translate-y-4');
                toast.classList.add('opacity-100', 'translate-y-0');
            }, 10);

            setTimeout(() => {
                if (toast.parentElement) {
                    toast.classList.remove('opacity-100', 'translate-y-0');
                    toast.classList.add('opacity-0', 'translate-y-4');
                    setTimeout(() => toast.remove(), 300);
                }
            }, 4000);
        };
    </script>
</body>
</html>
