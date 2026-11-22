<!DOCTYPE html>
<html lang="vi" class="h-full bg-[#f8faf8]">
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
                            'ggmb-navy': '#111827',
                            'ggmb-body': '#374151',
                            'ggmb-muted': '#6B7280',
                            'ggmb-border': '#E5E7EB',
                            'ggmb-bluesoft': '#E4EFE9',
                            'ggmb-primary': '#0E4D3C',
                            'ggmb-canvas': '#F8FAF8',
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
<body class="min-h-screen bg-[#F8FAF8] text-[#374151] antialiased flex flex-col justify-between">
    <!-- Top White Portal Header -->
    <header class="bg-white border-b border-[#E5E7EB] sticky top-0 z-30 select-none">
        <div class="max-w-[1240px] mx-auto px-6 h-[64px] flex items-center justify-between">
            <!-- Left: Brand + Navigation Tabs grouped on the left -->
            <div class="flex items-center space-x-8 sm:space-x-10">
                <!-- Brand / Portal Badge -->
                @if (($portalType ?? 'resident') === 'tech')
                    <a href="{{ route('tech.tasks') }}" class="flex items-center gap-1.5 group shrink-0">
                        <span class="text-[17px] font-bold text-[#0E4D3C] tracking-tight">GGMB</span>
                        <span class="text-[14.5px] font-medium text-[#0E4D3C]">/ Kỹ thuật</span>
                    </a>
                @else
                    <a href="{{ route('portal.dashboard') }}" class="flex items-center gap-1.5 group shrink-0">
                        <span class="text-[17px] font-bold text-[#0E4D3C] tracking-tight">GGMB</span>
                        <span class="text-[14.5px] font-medium text-[#0E4D3C]">/ Cư dân</span>
                    </a>
                @endif

                <!-- Navigation Tabs (shifted to the left next to brand) -->
                <nav class="hidden md:flex items-center space-x-1.5">
                    @if (($portalType ?? 'resident') === 'tech')
                        <a href="{{ route('tech.tasks') }}" class="px-4 py-1.5 rounded-[8px] text-[13.5px] transition-colors {{ ($activeTab ?? 'tasks') === 'tasks' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#374151] hover:text-[#111827] font-medium' }}">
                            Bàn việc
                        </a>
                        <a href="{{ route('tech.utilities') }}" class="px-4 py-1.5 rounded-[8px] text-[13.5px] transition-colors {{ ($activeTab ?? 'tasks') === 'utilities' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#374151] hover:text-[#111827] font-medium' }}">
                            Ghi điện nước
                        </a>
                    @else
                        <a href="{{ route('portal.dashboard') }}" class="px-4 py-1.5 rounded-[8px] text-[13.5px] transition-colors {{ ($activeTab ?? 'dashboard') === 'dashboard' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#374151] hover:text-[#111827] font-medium' }}">
                            Trang chủ
                        </a>
                        <a href="{{ route('portal.invoices') }}" class="px-4 py-1.5 rounded-[8px] text-[13.5px] transition-colors {{ ($activeTab ?? 'dashboard') === 'invoices' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#374151] hover:text-[#111827] font-medium' }}">
                            Hóa đơn
                        </a>
                        <a href="{{ route('portal.tickets') }}" class="px-4 py-1.5 rounded-[8px] text-[13.5px] transition-colors {{ ($activeTab ?? 'dashboard') === 'tickets' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#374151] hover:text-[#111827] font-medium' }}">
                            Hỗ trợ
                        </a>
                        <a href="{{ route('portal.profile') }}" class="px-4 py-1.5 rounded-[8px] text-[13.5px] transition-colors {{ ($activeTab ?? 'dashboard') === 'profile' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#374151] hover:text-[#111827] font-medium' }}">
                            Cá nhân
                        </a>
                    @endif
                </nav>
            </div>

            <!-- Right: User Identity Pill -->
            <div class="flex items-center space-x-3 shrink-0">
                @if (($portalType ?? 'resident') === 'tech')
                    <div class="bg-[#F3F4F6] px-3.5 py-1.5 rounded-[8px] text-[13px] text-[#111827] font-medium flex items-center">
                        <span>Vũ Hoàng · tech03</span>
                        <span class="sr-only">Vũ Hoàng Kỹ thuật · tech03</span>
                    </div>
                @else
                    <div class="bg-[#F3F4F6] px-3.5 py-1.5 rounded-[8px] text-[13px] text-[#111827] font-medium flex items-center">
                        <span>Nguyễn An · 0101</span>
                    </div>
                @endif
                <a href="{{ route('login') }}" class="text-[12px] text-[#9CA3AF] hover:text-[#0E4D3C] transition-colors" title="Đăng xuất">
                    <span class="sr-only">Đăng xuất</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Sub-bar -->
    <div class="md:hidden bg-white border-b border-[#E5E7EB] px-4 py-2 flex items-center justify-start space-x-2 overflow-x-auto text-[13px]">
        @if (($portalType ?? 'resident') === 'tech')
            <a href="{{ route('tech.tasks') }}" class="px-3 py-1 rounded-[6px] {{ ($activeTab ?? 'tasks') === 'tasks' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#4B5563]' }}">Bàn việc</a>
            <a href="{{ route('tech.utilities') }}" class="px-3 py-1 rounded-[6px] {{ ($activeTab ?? 'tasks') === 'utilities' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#4B5563]' }}">Ghi điện nước</a>
        @else
            <a href="{{ route('portal.dashboard') }}" class="px-3 py-1 rounded-[6px] {{ ($activeTab ?? 'dashboard') === 'dashboard' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#4B5563]' }}">Trang chủ</a>
            <a href="{{ route('portal.invoices') }}" class="px-3 py-1 rounded-[6px] {{ ($activeTab ?? 'dashboard') === 'invoices' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#4B5563]' }}">Hóa đơn</a>
            <a href="{{ route('portal.tickets') }}" class="px-3 py-1 rounded-[6px] {{ ($activeTab ?? 'dashboard') === 'tickets' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#4B5563]' }}">Hỗ trợ</a>
            <a href="{{ route('portal.profile') }}" class="px-3 py-1 rounded-[6px] {{ ($activeTab ?? 'dashboard') === 'profile' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#4B5563]' }}">Cá nhân</a>
        @endif
    </div>

    <!-- Main Container -->
    <main class="flex-1 w-full max-w-[1240px] mx-auto px-6 py-8">
        @if (session('success'))
            <div class="mb-6 p-4 bg-[#E4EFE9] border border-[#B8D5C7] text-[#0E4D3C] text-[13.5px] rounded-[10px] flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="text-[#0E4D3C] font-bold text-lg leading-none cursor-pointer">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 text-[13.5px] rounded-[10px] flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-700 font-bold text-lg leading-none cursor-pointer">&times;</button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- 4-Column Design Footer Matching Screenshots -->
    <footer class="bg-white border-t border-[#E5E7EB] mt-16 pt-12 pb-10 px-6 lg:px-12 select-none">
        <div class="max-w-[1240px] mx-auto">
            <!-- 4-column Links Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 pb-12 border-b border-[#F3F4F6] text-[13px]">
                <!-- Col 1: Product -->
                <div>
                    <h3 class="font-bold text-[#111827] mb-3.5">Product</h3>
                    <ul class="space-y-2.5 text-[#6B7280]">
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Landing Page</a></li>
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Popup Builder</a></li>
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Web-design</a></li>
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Content</a></li>
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Integrations</a></li>
                    </ul>
                </div>

                <!-- Col 2: Use Cases -->
                <div>
                    <h3 class="font-bold text-[#111827] mb-3.5">Use Cases</h3>
                    <ul class="space-y-2.5 text-[#6B7280]">
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Web-designers</a></li>
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Marketers</a></li>
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Small Business</a></li>
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Website Builder</a></li>
                    </ul>
                </div>

                <!-- Col 3: Resources -->
                <div>
                    <h3 class="font-bold text-[#111827] mb-3.5">Resources</h3>
                    <ul class="space-y-2.5 text-[#6B7280]">
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Academy</a></li>
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Themes</a></li>
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Hosting</a></li>
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Developers</a></li>
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Support</a></li>
                    </ul>
                </div>

                <!-- Col 4: Company -->
                <div>
                    <h3 class="font-bold text-[#111827] mb-3.5">Company</h3>
                    <ul class="space-y-2.5 text-[#6B7280]">
                        <li><a href="#" class="hover:text-[#111827] transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-[#111827] transition-colors">FAQs</a></li>
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Teams</a></li>
                        <li><a href="#" class="hover:text-[#111827] transition-colors">Contact Us</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Row: Social Icons & Legal Links -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-[12px] text-[#6B7280]">
                <!-- Social Icons -->
                <div class="flex items-center space-x-4 text-[#374151]">
                    <!-- Facebook -->
                    <a href="#" class="hover:text-[#0E4D3C] transition-colors" aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <!-- Instagram -->
                    <a href="#" class="hover:text-[#0E4D3C] transition-colors" aria-label="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <!-- YouTube -->
                    <a href="#" class="hover:text-[#0E4D3C] transition-colors" aria-label="YouTube">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    <!-- LinkedIn -->
                    <a href="#" class="hover:text-[#0E4D3C] transition-colors" aria-label="LinkedIn">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                </div>

                <!-- Legal Links -->
                <div class="flex flex-wrap items-center gap-x-5 gap-y-2">
                    <a href="#" class="hover:text-[#111827] transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-[#111827] transition-colors">Terms of Use</a>
                    <a href="#" class="hover:text-[#111827] transition-colors">Sales and Refunds</a>
                    <a href="#" class="hover:text-[#111827] transition-colors">Legal</a>
                    <a href="#" class="hover:text-[#111827] transition-colors">Site Map</a>
                </div>
            </div>

            <div class="sr-only">
                © 2026 GGMB · Hệ thống quản lý chung cư
            </div>
        </div>
    </footer>

    <!-- Global Toast Notification Container -->
    <div id="globalToastContainer" class="fixed bottom-5 right-5 z-[100] flex flex-col space-y-2 pointer-events-none"></div>

    <script>
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('globalToastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'pointer-events-auto flex items-center justify-between px-4 py-3 rounded-[8px] shadow-lg border text-[13px] font-medium transition-all duration-300 transform translate-y-4 opacity-0 max-w-sm';

            if (type === 'danger' || type === 'error') {
                toast.classList.add('bg-rose-50', 'border-rose-200', 'text-rose-700');
            } else if (type === 'info') {
                toast.classList.add('bg-[#E4EFE9]', 'border-[#B8D5C7]', 'text-[#0E4D3C]');
            } else {
                toast.classList.add('bg-[#E4EFE9]', 'border-[#B8D5C7]', 'text-[#0E4D3C]');
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
