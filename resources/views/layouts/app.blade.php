<!DOCTYPE html>
<html lang="vi" class="h-full bg-[#f8faf8]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'GGMB · Quản lý chung cư' }}</title>

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
<body class="min-h-screen bg-[#f8faf8] text-[#374151] antialiased flex flex-row">
    <!-- Reusable Sidebar -->
    @include('layouts.sidebar', ['active' => $active ?? 'overview'])

    <!-- Main Container -->
    <div class="flex-1 min-w-0 flex flex-col min-h-screen bg-[#f8faf8]">
        <!-- Reusable Header -->
        @include('layouts.header', ['breadcrumbs' => $breadcrumbs ?? ['GGMB', 'Tổng quan']])

        <!-- Page Dynamic Body Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            @if (isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>

        <!-- Reusable Footer -->
        @include('layouts.footer')
    </div>

    <!-- Global Toast Notification Container (Bo góc 8px) -->
    <div id="globalToastContainer" class="fixed bottom-5 right-5 z-[100] flex flex-col space-y-2 pointer-events-none"></div>

    <script>
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('globalToastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'pointer-events-auto flex items-center justify-between px-4 py-3 rounded-[8px] shadow-sm border text-[13px] font-medium transition-all duration-300 transform translate-y-4 opacity-0 max-w-sm';

            if (type === 'danger' || type === 'error') {
                toast.classList.add('bg-[#fdf2f2]', 'border-[#fecaca]', 'text-[#b91c1c]');
            } else if (type === 'info') {
                toast.classList.add('bg-[#e8f1ff]', 'border-[#b9d5ff]', 'text-[#0e4d3c]');
            } else {
                toast.classList.add('bg-[#e6f5ec]', 'border-[#c3e6cb]', 'text-[#115e43]');
            }

            toast.innerHTML = `
                <div class="flex items-center space-x-2">
                    <span>${message}</span>
                </div>
                <button type="button" class="ml-3 text-current hover:opacity-75 cursor-pointer font-bold leading-none">&times;</button>
            `;

            toast.querySelector('button').onclick = () => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 250);
            };

            container.appendChild(toast);
            requestAnimationFrame(() => {
                toast.classList.remove('opacity-0', 'translate-y-4');
                toast.classList.add('opacity-100', 'translate-y-0');
            });

            setTimeout(() => {
                if (toast.parentElement) {
                    toast.classList.add('opacity-0', 'translate-y-2');
                    setTimeout(() => toast.remove(), 250);
                }
            }, 3500);
        };
    </script>
</body>
</html>
