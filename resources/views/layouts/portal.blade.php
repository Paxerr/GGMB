<!DOCTYPE html>
<html lang="vi" class="h-full bg-[#f8faf8]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'GGMB · Cổng cư dân' }}</title>

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
                            'ggmb-forest': '#0e4d3c',
                            'ggmb-sage': '#e4efe9',
                            'ggmb-canvas': '#f8faf8',
                            'ggmb-caramel': '#8f5316',
                            'ggmb-paid': '#115e43',
                            'ggmb-border': '#e5e7eb',
                            'ggmb-heading': '#111827',
                            'ggmb-body': '#374151',
                            'ggmb-muted': '#6b7280',
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
<body class="min-h-screen bg-[#F8FAF8] text-[#374151] antialiased flex flex-col justify-between selection:bg-[#E4EFE9] selection:text-[#0E4D3C]">
    <!-- Top Modern Portal Header -->
    <header class="bg-white/95 backdrop-blur-md border-b border-[#E5E7EB] sticky top-0 z-30 select-none transition-shadow duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-[64px] flex items-center justify-between">
            <!-- Left: Brand + Role Badge + Navigation Tabs -->
            <div class="flex items-center space-x-6 sm:space-x-8">
                <!-- Brand / Portal Badge -->
                @if (($portalType ?? 'resident') === 'tech')
                    <a href="{{ route('tech.tasks') }}" class="flex items-center gap-2 group shrink-0" title="GGMB Kỹ thuật">
                        <div class="w-8 h-8 rounded-[8px] bg-[#0E4D3C] text-white flex items-center justify-center font-bold text-sm shadow-xs">
                            K
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-[17px] font-bold text-[#0E4D3C] tracking-tight">GGMB</span>
                            <span class="text-[11.5px] font-semibold px-2 py-0.5 rounded-full bg-[#E4EFE9] text-[#0E4D3C]">Kỹ thuật</span>
                        </div>
                    </a>
                @else
                    <a href="{{ route('portal.dashboard') }}" class="flex items-center gap-2.5 group shrink-0" title="GGMB Cổng cư dân">
                        <div class="w-8 h-8 rounded-[8px] bg-[#0E4D3C] text-white flex items-center justify-center font-bold text-sm shadow-xs">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-[17px] font-bold text-[#0E4D3C] tracking-tight">GGMB</span>
                            <span class="text-[11.5px] font-semibold px-2 py-0.5 rounded-full bg-[#E4EFE9] text-[#0E4D3C]">Cư dân</span>
                        </div>
                    </a>
                @endif

                <!-- Desktop Navigation Tabs -->
                <nav class="hidden md:flex items-center space-x-1">
                    @if (($portalType ?? 'resident') === 'tech')
                        <a href="{{ route('tech.tasks') }}" class="px-3.5 py-1.5 rounded-[8px] text-[13.5px] transition-all {{ ($activeTab ?? 'tasks') === 'tasks' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold shadow-2xs' : 'text-[#4B5563] hover:text-[#111827] hover:bg-[#F3F4F6] font-medium' }}">
                            Bàn việc
                        </a>
                        <a href="{{ route('tech.utilities') }}" class="px-3.5 py-1.5 rounded-[8px] text-[13.5px] transition-all {{ ($activeTab ?? 'tasks') === 'utilities' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold shadow-2xs' : 'text-[#4B5563] hover:text-[#111827] hover:bg-[#F3F4F6] font-medium' }}">
                            Ghi điện nước
                        </a>
                    @else
                        <a href="{{ route('portal.dashboard') }}" class="px-3.5 py-1.5 rounded-[8px] text-[13.5px] transition-all {{ ($activeTab ?? 'dashboard') === 'dashboard' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold shadow-2xs' : 'text-[#4B5563] hover:text-[#0E4D3C] hover:bg-[#F3F4F6] font-medium' }}">
                            Trang chủ
                        </a>
                        <a href="{{ route('portal.invoices') }}" class="px-3.5 py-1.5 rounded-[8px] text-[13.5px] transition-all {{ ($activeTab ?? 'dashboard') === 'invoices' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold shadow-2xs' : 'text-[#4B5563] hover:text-[#0E4D3C] hover:bg-[#F3F4F6] font-medium' }}">
                            Hóa đơn & Phí
                        </a>
                        <a href="{{ route('portal.tickets') }}" class="px-3.5 py-1.5 rounded-[8px] text-[13.5px] transition-all {{ ($activeTab ?? 'dashboard') === 'tickets' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold shadow-2xs' : 'text-[#4B5563] hover:text-[#0E4D3C] hover:bg-[#F3F4F6] font-medium' }}">
                            Yêu cầu hỗ trợ
                        </a>
                        <a href="{{ route('portal.profile') }}" class="px-3.5 py-1.5 rounded-[8px] text-[13.5px] transition-all {{ ($activeTab ?? 'dashboard') === 'profile' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold shadow-2xs' : 'text-[#4B5563] hover:text-[#0E4D3C] hover:bg-[#F3F4F6] font-medium' }}">
                            Hồ sơ cá nhân
                        </a>
                    @endif
                </nav>
            </div>

            <!-- Right: Resident Identity & Quick Profile -->
            <div class="flex items-center space-x-3 shrink-0">
                @if (($portalType ?? 'resident') === 'tech')
                    <div class="bg-[#F8FAF8] border border-[#E5E7EB] px-3 py-1.5 rounded-[10px] text-[13px] text-[#111827] font-medium flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full bg-[#E4EFE9] text-[#0E4D3C] flex items-center justify-center font-bold text-[11px]">
                            {{ strtoupper(substr(Auth::user()->FullName ?? 'Vũ Hoàng', 0, 1)) }}
                        </div>
                        <span>{{ Auth::user()->FullName ?? 'Vũ Hoàng' }} · tech03</span>
                        <span class="sr-only">Vũ Hoàng Kỹ thuật · tech03</span>
                    </div>
                @else
                    <a href="{{ route('portal.profile') }}" class="group bg-[#F8FAF8] hover:bg-[#E4EFE9]/40 border border-[#E5E7EB] hover:border-[#B8D5C7] px-3 py-1.5 rounded-[10px] text-[13px] text-[#111827] font-medium flex items-center gap-2 transition-all">
                        <div class="w-6 h-6 rounded-full bg-[#E4EFE9] text-[#0E4D3C] flex items-center justify-center font-bold text-[11px] group-hover:bg-[#0E4D3C] group-hover:text-white transition-colors">
                            {{ strtoupper(substr(Auth::user()->FullName ?? 'Nguyễn An', 0, 1)) }}
                        </div>
                        <span class="font-semibold text-[#111827] group-hover:text-[#0E4D3C] transition-colors">
                            {{ Auth::user()->FullName ?? 'Nguyễn An' }}
                        </span>
                        <span class="text-[11px] font-semibold px-1.5 py-0.5 rounded bg-white border border-[#E5E7EB] text-[#0E4D3C]">
                            0101
                        </span>
                    </a>
                @endif

                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST" class="inline m-0">
                    @csrf
                    <button type="submit" class="p-2 text-[#6B7280] hover:text-[#B91C1C] hover:bg-rose-50 rounded-[8px] transition-colors cursor-pointer" title="Đăng xuất khỏi hệ thống">
                        <span class="sr-only">Đăng xuất</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Bar -->
    <div class="md:hidden bg-white border-b border-[#E5E7EB] px-4 py-2.5 flex items-center justify-start space-x-1.5 overflow-x-auto text-[13px] shadow-2xs">
        @if (($portalType ?? 'resident') === 'tech')
            <a href="{{ route('tech.tasks') }}" class="px-3 py-1 rounded-[6px] whitespace-nowrap {{ ($activeTab ?? 'tasks') === 'tasks' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#4B5563]' }}">Bàn việc</a>
            <a href="{{ route('tech.utilities') }}" class="px-3 py-1 rounded-[6px] whitespace-nowrap {{ ($activeTab ?? 'tasks') === 'utilities' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#4B5563]' }}">Ghi điện nước</a>
        @else
            <a href="{{ route('portal.dashboard') }}" class="px-3 py-1 rounded-[6px] whitespace-nowrap {{ ($activeTab ?? 'dashboard') === 'dashboard' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#4B5563]' }}">Trang chủ</a>
            <a href="{{ route('portal.invoices') }}" class="px-3 py-1 rounded-[6px] whitespace-nowrap {{ ($activeTab ?? 'dashboard') === 'invoices' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#4B5563]' }}">Hóa đơn</a>
            <a href="{{ route('portal.tickets') }}" class="px-3 py-1 rounded-[6px] whitespace-nowrap {{ ($activeTab ?? 'dashboard') === 'tickets' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#4B5563]' }}">Hỗ trợ</a>
            <a href="{{ route('portal.profile') }}" class="px-3 py-1 rounded-[6px] whitespace-nowrap {{ ($activeTab ?? 'dashboard') === 'profile' ? 'bg-[#E4EFE9] text-[#0E4D3C] font-semibold' : 'text-[#4B5563]' }}">Hồ sơ</a>
        @endif
    </div>

    <!-- Main Container -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (session('success'))
            <div class="mb-6 p-4 bg-[#E4EFE9] border border-[#B8D5C7] text-[#0E4D3C] text-[13.5px] rounded-[12px] flex items-center justify-between shadow-2xs">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-[#0E4D3C] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-[#0E4D3C] font-bold text-lg leading-none cursor-pointer hover:opacity-75">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 text-[13.5px] rounded-[12px] flex items-center justify-between shadow-2xs">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-700 font-bold text-lg leading-none cursor-pointer hover:opacity-75">&times;</button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Modern Building Resident Footer -->
    <footer class="bg-white border-t border-[#E5E7EB] mt-16 pt-10 pb-8 px-4 sm:px-6 lg:px-8 select-none">
        <div class="max-w-7xl mx-auto">
            <!-- 4-column Links Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 pb-8 border-b border-[#F3F4F6] text-[13px]">
                <!-- Col 1: BQL Chung cư GGMB -->
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-[16px] font-bold text-[#0E4D3C]">GGMB Residence</span>
                    </div>
                    <p class="text-[#6B7280] leading-relaxed text-[12.5px]">
                        Không gian sống văn minh, an toàn và tiện nghi dành cho mọi cư dân.
                    </p>
                    <div class="mt-3 text-[12.5px] text-[#374151] space-y-1">
                        <div>Văn phòng BQL: Tầng 1, Tòa A</div>
                        <div>Hotline 24/7: <strong class="text-[#0E4D3C]">1900 8888</strong></div>
                    </div>
                </div>

                <!-- Col 2: Dịch vụ & Tiện ích -->
                <div>
                    <h3 class="font-bold text-[#111827] mb-3 text-[13.5px]">Dịch vụ & Tiện ích</h3>
                    <ul class="space-y-2 text-[#6B7280]">
                        <li><a href="{{ route('portal.invoices') }}" class="hover:text-[#0E4D3C] transition-colors">Tra cứu hóa đơn & công nợ</a></li>
                        <li><a href="{{ route('portal.tickets') }}" class="hover:text-[#0E4D3C] transition-colors">Gửi yêu cầu kỹ thuật & hỗ trợ</a></li>
                        <li><a href="{{ route('portal.profile') }}" class="hover:text-[#0E4D3C] transition-colors">Thông tin căn hộ & xe</a></li>
                        <li><a href="{{ route('portal.dashboard') }}" class="hover:text-[#0E4D3C] transition-colors">Bảng tin thông báo chung</a></li>
                    </ul>
                </div>

                <!-- Col 3: Hướng dẫn & Quy định -->
                <div>
                    <h3 class="font-bold text-[#111827] mb-3 text-[13.5px]">Hướng dẫn & Quy định</h3>
                    <ul class="space-y-2 text-[#6B7280]">
                        <li><span class="hover:text-[#0E4D3C] transition-colors cursor-pointer">Nội quy sinh hoạt tòa nhà</span></li>
                        <li><span class="hover:text-[#0E4D3C] transition-colors cursor-pointer">Quy trình đăng ký gửi xe</span></li>
                        <li><span class="hover:text-[#0E4D3C] transition-colors cursor-pointer">Hướng dẫn đóng tiền điện nước</span></li>
                        <li><span class="hover:text-[#0E4D3C] transition-colors cursor-pointer">Số điện thoại khẩn cấp (PCCC)</span></li>
                    </ul>
                </div>

                <!-- Col 4: Thời gian làm việc -->
                <div>
                    <h3 class="font-bold text-[#111827] mb-3 text-[13.5px]">Thời gian làm việc BQL</h3>
                    <div class="space-y-2 text-[#6B7280] text-[12.5px]">
                        <div>Thứ 2 – Thứ 6: 08:00 – 17:30</div>
                        <div>Thứ 7: 08:00 – 12:00</div>
                        <div>Chủ nhật & Ngày lễ: Trực kỹ thuật</div>
                        <div class="pt-1 text-[#0E4D3C] font-medium">Bảo vệ & Kỹ thuật khẩn cấp: 24/7</div>
                    </div>
                </div>
            </div>

            <!-- Bottom Row: Copyright -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-[12px] text-[#6B7280]">
                <div>
                    © 2026 GGMB Residence · Hệ thống quản lý chung cư
                </div>
                <div class="flex items-center space-x-4">
                    <span>Phiên bản Cổng cư dân 2.0</span>
                    <span>·</span>
                    <span class="text-[#0E4D3C] font-medium">Kết nối trực tiếp Ban Quản Lý</span>
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
            toast.className = 'pointer-events-auto flex items-center justify-between px-4 py-3 rounded-[10px] shadow-lg border text-[13px] font-medium transition-all duration-300 transform translate-y-4 opacity-0 max-w-sm';

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
