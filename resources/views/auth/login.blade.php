<!DOCTYPE html>
<html lang="vi" class="h-full bg-[#f3f7fa]">
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
                            'ggmb-navy': '#122D40',
                            'ggmb-body': '#334B5D',
                            'ggmb-muted': '#52697C',
                            'ggmb-border': '#D9E4EC',
                            'ggmb-bluesoft': '#E8F1FF',
                            'ggmb-primary': '#2864AD',
                            'ggmb-canvas': '#F3F7FA',
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
<body class="min-h-full flex flex-col justify-between bg-[#f3f7fa] text-[#334b5d] antialiased">
    <!-- Main Content Area -->
    <main class="flex-grow flex items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
        <div class="w-full max-w-[1280px] mx-auto pt-6 lg:pt-10 pb-8">
            <!-- Header section -->
            <div class="mb-8 max-w-[980px]">
                <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40] tracking-tight">
                    Đăng nhập GGMB
                </h1>
                <p class="mt-2 text-[14px] leading-[20px] text-[#334b5d]">
                    Đăng nhập để truy cập chức năng theo vai trò và phạm vi được cấp.
                </p>
            </div>

            <!-- Two-column grid container -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                <!-- Left box: Giới thiệu hệ thống GGMB / Logo -->
                <div class="lg:col-span-6 w-full">
                    <div class="relative w-full h-[360px] sm:h-[450px] lg:h-[510px] bg-gradient-to-br from-[#e8f1ff] to-[#f4f8fb] border border-[#d9e4ec] rounded-[4px] overflow-hidden flex flex-col items-center justify-center p-8 shadow-xs">
                        <img src="{{ asset('images/logo.png') }}" alt="GGMB Logo" class="max-w-[280px] sm:max-w-[340px] max-h-[260px] object-contain drop-shadow-sm" />
                        <div class="mt-6 text-center">
                            <span class="inline-block px-4 py-1.5 bg-white/80 backdrop-blur-xs border border-[#d9e4ec] text-[#2864ad] text-xs font-semibold tracking-wider uppercase rounded-full shadow-2xs">
                                Giới thiệu hệ thống GGMB
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right box: Form đăng nhập -->
                <div class="lg:col-span-6 w-full flex justify-start">
                    <div class="w-full max-w-[612px] bg-white border border-solid border-[#d9e4ec] p-7 sm:p-8 min-h-[350px] flex flex-col justify-between">
                        <div>
                            <h2 class="text-[24px] leading-[30px] font-semibold text-[#122d40] mb-6">
                                Đăng nhập hệ thống
                            </h2>

                            <!-- Display session status / alert message if any -->
                            @if (session('status'))
                                <div class="mb-4 p-3 bg-blue-50 border border-blue-200 text-[#2864ad] text-xs">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-xs">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <form action="{{ route('login') }}" method="POST" class="space-y-4" id="loginForm">
                                @csrf

                                <!-- Tên đăng nhập · UserName -->
                                <div class="space-y-1.5">
                                    <label for="UserName" class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
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
                                        class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] placeholder:text-[#52697c] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] transition-colors"
                                    >
                                </div>

                                <!-- Mật khẩu · kiểm tra PasswordHash -->
                                <div class="space-y-1.5 pt-1">
                                    <label for="password" class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                                        Mật khẩu
                                    </label>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                        placeholder="••••••••••••"
                                        class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] placeholder:text-[#52697c] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] transition-colors"
                                    >
                                </div>

                                <!-- Nút đăng nhập · GgmbNut -->
                                <div class="pt-6 flex justify-center">
                                    <button
                                        type="submit"
                                        class="w-[114px] h-[40px] bg-[#2864ad] hover:bg-[#205391] border border-solid border-[#2864ad] hover:border-[#205391] rounded-[4px] text-white text-[14px] font-semibold flex items-center justify-center transition-colors cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#2864ad] focus:ring-offset-2"
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
    <footer class="w-full bg-white border-t border-solid border-[#d9e4ec] text-[#52697c] text-[12px] font-semibold py-3 px-4 sm:px-8">
        <div class="max-w-[1440px] mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-2 md:gap-8">
            <div class="space-y-0.5">
                <p class="leading-[19px]">GGMB · [Tên doanh nghiệp vận hành]</p>
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
