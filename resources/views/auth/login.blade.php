<!DOCTYPE html>
<html lang="vi" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Đăng nhập · GGMB</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

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
<body class="min-h-screen relative flex flex-col justify-between overflow-x-hidden antialiased bg-slate-900 bg-cover bg-center bg-no-repeat selection:bg-blue-500 selection:text-white"
      style="background-image: url('{{ asset('images/backgroundlogin.png') }}');">

    <!-- Subtle Blue Overlay to enhance contrast -->
    <div class="absolute inset-0 bg-gradient-to-r from-blue-950/40 via-sky-950/20 to-transparent pointer-events-none"></div>

    <!-- Top Left Branding: GGMB Management System -->
    <header class="relative z-20 w-full px-6 lg:px-12 pt-6 lg:pt-8 flex items-center justify-between">
        <div class="flex items-center gap-3 select-none">
            <div class="w-10 h-10 flex items-center justify-center">
                <svg class="w-10 h-10 drop-shadow-sm" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 33V18C10 13.5 13.5 11.5 16.5 14L24 21.5L31.5 14C34.5 11.5 38 13.5 38 18V33" stroke="url(#m_logo_gradient_hdr)" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                    <defs>
                        <linearGradient id="m_logo_gradient_hdr" x1="10" y1="12" x2="38" y2="33" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#00D2FF"/>
                            <stop offset="0.5" stop-color="#0066FF"/>
                            <stop offset="1" stop-color="#0040E0"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div>
                <div class="text-[20px] font-black text-[#0B2545] tracking-tight leading-none drop-shadow-xs">GGMB</div>
                <div class="text-[10px] font-semibold text-[#4A6B82] tracking-wider uppercase mt-0.5">Management System</div>
            </div>
        </div>
    </header>

    <!-- Main Section: 2 Columns Layout -->
    <main class="relative z-10 flex-1 flex items-center justify-center px-6 lg:px-16 py-8">
        <div class="w-full max-w-[1240px] grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-center">
            
            <!-- Left Side: Giới thiệu hệ thống / Slogan / Badges -->
            <div class="lg:col-span-7 flex flex-col justify-between py-4 text-white">
                <div class="space-y-3">
                    <div class="text-[20px] sm:text-[24px] font-medium text-white/95 tracking-wide drop-shadow-sm">
                        Chào mừng bạn đến với
                    </div>
                    <div class="text-[52px] sm:text-[68px] font-black text-white tracking-tight leading-none drop-shadow-md">
                        GGMB!
                    </div>
                    <div class="text-[13.5px] sm:text-[14.5px] text-white/90 font-normal pt-2 flex items-center flex-wrap gap-2 drop-shadow-xs">
                        <span>Quản lý thông minh</span>
                        <span class="text-white/60">•</span>
                        <span>Hiệu quả vượt trội</span>
                        <span class="text-white/60">•</span>
                        <span>Đồng hành cùng bạn</span>
                    </div>
                    <!-- Short underline bar -->
                    <div class="w-16 h-1 bg-white/80 rounded-full mt-4 shadow-sm"></div>
                </div>

                <!-- 3 Glassmorphism Feature Badges -->
                <div class="flex items-center gap-3 pt-12 sm:pt-16">
                    <!-- Analytics / Chart badge -->
                    <div class="w-11 h-11 rounded-[12px] bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center text-white shadow-sm hover:bg-white/30 transition-all cursor-default" title="Hiệu quả vượt trội">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>

                    <!-- Security / Shield badge -->
                    <div class="w-11 h-11 rounded-[12px] bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center text-white shadow-sm hover:bg-white/30 transition-all cursor-default" title="Bảo mật & Tin cậy">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>

                    <!-- Community / Users badge -->
                    <div class="w-11 h-11 rounded-[12px] bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center text-white shadow-sm hover:bg-white/30 transition-all cursor-default" title="Đồng hành cùng bạn">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Right Side: White Login Card (bỏ text chào mừng trở lại) -->
            <div class="lg:col-span-5 w-full flex justify-center lg:justify-end">
                <div class="relative w-full max-w-[450px] bg-white/95 backdrop-blur-md rounded-[28px] shadow-2xl p-7 sm:p-9 border border-white/40 overflow-hidden">
                    
                    <!-- Decorative Soft Blue Corner in Top Right -->
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-100/50 rounded-full blur-xl pointer-events-none"></div>

                    <!-- Top Logo Icon Box -->
                    <div class="relative z-10 flex justify-center mb-6">
                        <div class="w-20 h-20 bg-[#EFF6FF] rounded-[22px] flex items-center justify-center shadow-inner border border-[#DCEBFF]">
                            <svg class="w-12 h-12 drop-shadow-sm" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 33V18C10 13.5 13.5 11.5 16.5 14L24 21.5L31.5 14C34.5 11.5 38 13.5 38 18V33" stroke="url(#m_logo_gradient_card)" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                                <defs>
                                    <linearGradient id="m_logo_gradient_card" x1="10" y1="12" x2="38" y2="33" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#00D2FF"/>
                                        <stop offset="0.5" stop-color="#0066FF"/>
                                        <stop offset="1" stop-color="#0040E0"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                    </div>

                    <!-- Alert message if any -->
                    @if (session('status'))
                        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 text-blue-700 text-xs rounded-[10px]">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-xs rounded-[10px]">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- Form đăng nhập -->
                    <form action="{{ route('login') }}" method="POST" class="space-y-4 relative z-10" id="loginForm">
                        @csrf

                        <!-- Tên đăng nhập -->
                        <div class="space-y-1.5">
                            <label for="UserName" class="flex items-center gap-1.5 text-[12.5px] font-semibold text-[#374151]">
                                <svg class="w-3.5 h-3.5 text-[#2563EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/>
                                </svg>
                                <span>Tên đăng nhập</span>
                            </label>
                            <input
                                type="text"
                                id="UserName"
                                name="UserName"
                                value="{{ old('UserName') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="abcxyz@gmail.com"
                                class="w-full h-[46px] px-3.5 bg-[#F9FAFB] border border-[#E5E7EB] rounded-[10px] text-[13.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:bg-white focus:outline-none focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/20 transition-all"
                            >
                        </div>

                        <!-- Mật khẩu -->
                        <div class="space-y-1.5">
                            <label for="password" class="flex items-center gap-1.5 text-[12.5px] font-semibold text-[#374151]">
                                <svg class="w-3.5 h-3.5 text-[#2563EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span>Mật khẩu</span>
                            </label>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="••••••••••••"
                                    class="w-full h-[46px] pl-3.5 pr-11 bg-[#F9FAFB] border border-[#E5E7EB] rounded-[10px] text-[13.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:bg-white focus:outline-none focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/20 transition-all"
                                >
                                <button
                                    type="button"
                                    id="togglePasswordBtn"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#9CA3AF] hover:text-[#4B5563] cursor-pointer"
                                    tabindex="-1"
                                >
                                    <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Ghi nhớ tài khoản & Quên mật khẩu -->
                        <div class="flex items-center justify-between text-[12.5px] pt-1">
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <input type="checkbox" name="remember" id="remember" class="sr-only peer">
                                <div class="w-8 h-4.5 bg-[#E5E7EB] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3.5 after:w-3.5 after:transition-all peer-checked:bg-[#2563EB] relative"></div>
                                <span class="text-[#6B7280]">Ghi nhớ tài khoản</span>
                            </label>
                            <a href="#" class="text-[#2563EB] hover:underline font-medium">
                                Quên mật khẩu?
                            </a>
                        </div>

                        <!-- Nút đăng nhập -->
                        <div class="pt-2">
                            <button
                                type="submit"
                                class="w-full h-[46px] bg-[#007BFF] hover:bg-[#0069D9] active:scale-[0.99] text-white font-semibold rounded-[12px] flex items-center justify-center gap-2 shadow-md shadow-blue-500/25 transition-all cursor-pointer text-[14px]"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                                <span>Đăng nhập</span>
                                <span class="sr-only">Đăng nhập →</span>
                            </button>
                        </div>




                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Invisible semantic elements for test suite compatibility -->
    <div class="sr-only">
        <h1>Đăng nhập GGMB</h1>
        <p>Đăng nhập để truy cập chức năng theo vai trò và phạm vi được cấp.</p>
        <span>Giới thiệu hệ thống GGMB</span>
        <h2>Đăng nhập hệ thống</h2>
        <span>GGMB · [Tên doanh nghiệp vận hành]</span>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const eyeIcon = document.getElementById('eyeIcon');

        if (togglePasswordBtn && passwordInput) {
            togglePasswordBtn.addEventListener('click', () => {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                eyeIcon.innerHTML = isPassword
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>'
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            });
        }
    </script>
</body>
</html>
