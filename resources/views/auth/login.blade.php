<!DOCTYPE html>
<html lang="vi" class="h-full bg-[#f8faf8]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Đăng nhập · GGMB</title>

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
<body class="min-h-full flex flex-col justify-between bg-[#f8faf8] text-[#374151] antialiased">
    <!-- Main Content Area -->
    <main class="flex-grow flex items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
        <div class="w-full max-w-[1280px] mx-auto pt-6 lg:pt-10 pb-8">
            <!-- Header section -->
            <div class="mb-8 max-w-[980px]">
                <h1 class="text-[26px] leading-[32px] font-bold text-[#111827] tracking-tight">
                    Đăng nhập GGMB
                </h1>
                <p class="mt-2 text-[14px] leading-[20px] text-[#6B7280]">
                    Đăng nhập để truy cập chức năng theo vai trò và phạm vi được cấp.
                </p>
            </div>

            <!-- Two-column grid container -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                <!-- Left box: Giới thiệu hệ thống GGMB / Logo -->
                <div class="lg:col-span-6 w-full">
                    <div class="relative w-full h-[360px] sm:h-[450px] lg:h-[510px] bg-gradient-to-br from-[#E4EFE9] to-[#F8FAF8] border border-[#E5E7EB] rounded-[16px] overflow-hidden flex flex-col items-center justify-center p-8 shadow-none">
                        <img src="{{ asset('images/logo.png') }}" alt="GGMB Logo" class="max-w-[280px] sm:max-w-[340px] max-h-[260px] object-contain drop-shadow-sm" />
                        <div class="mt-6 text-center">
                            <span class="inline-block px-4 py-1.5 bg-white/90 backdrop-blur-xs border border-[#E5E7EB] text-[#0E4D3C] text-xs font-semibold tracking-wider uppercase rounded-full shadow-xs">
                                Giới thiệu hệ thống GGMB
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right box: Form đăng nhập -->
                <div class="lg:col-span-6 w-full flex justify-start">
                    <div class="w-full max-w-[612px] bg-white border border-[#E5E7EB] rounded-[16px] p-7 sm:p-8 min-h-[350px] flex flex-col justify-between shadow-none">
                        <div>
                            <h2 class="text-[22px] font-bold text-[#111827] mb-6">
                                Đăng nhập hệ thống
                            </h2>

                            <!-- Display session status / alert message if any -->
                            @if (session('status'))
                                <div class="mb-4 p-3 bg-[#E4EFE9] border border-[#B8D5C7] text-[#0E4D3C] text-xs rounded-[8px]">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-xs rounded-[8px]">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <form action="{{ route('login') }}" method="POST" class="space-y-4" id="loginForm">
                                @csrf

                                <!-- Tên đăng nhập · UserName -->
                                <div class="space-y-1.5">
                                    <label for="UserName" class="block text-[12px] font-semibold text-[#374151]">
                                        Tên đăng nhập
                                    </label>
                                    <input
                                        type="text"
                                        id="UserName"
                                        name="UserName"
                                        value="{{ old('UserName') }}"
                                        required
                                        autofocus
                                        autocomplete="username"
                                        placeholder="Nhập tên đăng nhập"
                                        class="w-full h-[42px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] transition-colors"
                                    >
                                </div>

                                <!-- Mật khẩu · kiểm tra PasswordHash -->
                                <div class="space-y-1.5 pt-1">
                                    <label for="password" class="block text-[12px] font-semibold text-[#374151]">
                                        Mật khẩu
                                    </label>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                        placeholder="••••••••••••"
                                        class="w-full h-[42px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] transition-colors"
                                    >
                                </div>

                                <!-- Nút đăng nhập -->
                                <div class="pt-6 flex justify-center">
                                    <button
                                        type="submit"
                                        class="px-6 h-[40px] bg-[#0E4D3C] hover:bg-[#0A3D2F] rounded-[8px] text-white text-[13.5px] font-semibold flex items-center justify-center transition-colors cursor-pointer focus:outline-none shadow-sm"
                                    >
                                        Đăng nhập →
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer: Chân trang · GGMB -->
    <footer class="w-full bg-white border-t border-[#E5E7EB] text-[#6B7280] text-[12px] font-normal py-3 px-4 sm:px-8">
        <div class="max-w-[1440px] mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-2 md:gap-8">
            <div class="space-y-0.5">
                <p class="leading-[19px] font-medium text-[#111827]">GGMB · [Tên doanh nghiệp vận hành]</p>
                <p class="leading-[19px]">Địa chỉ: [Địa chỉ văn phòng ban quản lý]</p>
            </div>
            <div class="space-y-0.5 md:text-right">
                <p class="leading-[19px]">Điện thoại: [Số liên hệ] · Email: [Email hỗ trợ]</p>
                <p class="leading-[19px]">© 2026 [Tên doanh nghiệp] · Hệ thống quản lý chung cư</p>
            </div>
        </div>
    </footer>
</body>
</html>
