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

        /* Collapsible Sidebar Styles */
        #mainSidebar {
            transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1), min-width 0.25s cubic-bezier(0.4, 0, 0.2, 1), padding 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        html.has-collapsed-sidebar #mainSidebar,
        #mainSidebar.is-collapsed {
            width: 68px !important;
            min-width: 68px !important;
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        
        html.has-collapsed-sidebar #mainSidebar .sidebar-full-only,
        #mainSidebar.is-collapsed .sidebar-full-only {
            display: none !important;
        }
        
        html.has-collapsed-sidebar #mainSidebar .sidebar-nav-item,
        #mainSidebar.is-collapsed .sidebar-nav-item {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            gap: 0 !important;
        }
        
        html.has-collapsed-sidebar #mainSidebar .sidebar-brand-link,
        #mainSidebar.is-collapsed .sidebar-brand-link {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            gap: 0 !important;
        }

        html.has-collapsed-sidebar #mainSidebar .sidebar-toggle-btn,
        #mainSidebar.is-collapsed .sidebar-toggle-btn {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .sidebar-collapsed-only {
            display: none !important;
        }

        html.has-collapsed-sidebar #mainSidebar .sidebar-collapsed-only,
        #mainSidebar.is-collapsed .sidebar-collapsed-only {
            display: flex !important;
        }

        html.has-collapsed-sidebar #mainSidebar .sidebar-icon-flip,
        #mainSidebar.is-collapsed .sidebar-icon-flip {
            transform: rotate(180deg);
        }

        /* Custom Modern Select Scrollbar */
        .custom-select-menu::-webkit-scrollbar {
            width: 5px;
        }
        .custom-select-menu::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-select-menu::-webkit-scrollbar-thumb {
            background-color: #e5e7eb;
            border-radius: 9999px;
        }
        .custom-select-menu::-webkit-scrollbar-thumb:hover {
            background-color: #cbd5e1;
        }

        /* Sleek Scrollbars for Main Scroll Container and Sidebar Nav */
        main::-webkit-scrollbar,
        #mainSidebar nav::-webkit-scrollbar,
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        main::-webkit-scrollbar-track,
        #mainSidebar nav::-webkit-scrollbar-track,
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        main::-webkit-scrollbar-thumb,
        #mainSidebar nav::-webkit-scrollbar-thumb,
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 9999px;
        }
        main::-webkit-scrollbar-thumb:hover,
        #mainSidebar nav::-webkit-scrollbar-thumb:hover,
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: #9ca3af;
        }
    </style>

    <script>
        if (localStorage.getItem('ggmb_sidebar_collapsed') === 'true') {
            document.documentElement.classList.add('has-collapsed-sidebar');
        }
    </script>
</head>
<body class="h-screen overflow-hidden bg-[#f8faf8] text-[#374151] antialiased flex flex-row">
    <!-- Reusable Sidebar (Cố định theo chiều dọc) -->
    @include('layouts.sidebar', ['active' => $active ?? 'overview'])

    <!-- Main Container (Khung chính cố định chiều cao màn hình) -->
    <div class="flex-1 min-w-0 flex flex-col h-screen overflow-hidden bg-[#f8faf8]">
        <!-- Reusable Header (Cố định ở trên cùng) -->
        @include('layouts.header', ['breadcrumbs' => $breadcrumbs ?? ['GGMB', 'Tổng quan']])

        <!-- Page Dynamic Body Content (Vùng duy nhất cuộn khi lăn chuột) -->
        <main class="flex-1 overflow-y-auto flex flex-col">
            <div class="flex-1 p-6 sm:p-8">
                @if (isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </div>

            <!-- Reusable Footer (Nằm ở cuối trang cuộn) -->
            @include('layouts.footer')
        </main>
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

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (window.showToast) {
                    window.showToast(@json(session('success')), 'success');
                }
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (window.showToast) {
                    window.showToast(@json(session('error')), 'error');
                }
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (window.showToast) {
                    @foreach ($errors->all() as $err)
                        window.showToast(@json($err), 'error');
                    @endforeach
                }
            });
        </script>
    @endif

    <!-- Sidebar Toggle Script -->
    <script>
        (function() {
            window.toggleSidebar = function() {
                const sidebar = document.getElementById('mainSidebar');
                if (!sidebar) return;

                const isCurrentlyCollapsed = sidebar.classList.contains('is-collapsed') || document.documentElement.classList.contains('has-collapsed-sidebar');
                
                if (isCurrentlyCollapsed) {
                    sidebar.classList.remove('is-collapsed');
                    document.documentElement.classList.remove('has-collapsed-sidebar');
                    localStorage.setItem('ggmb_sidebar_collapsed', 'false');
                } else {
                    sidebar.classList.add('is-collapsed');
                    document.documentElement.classList.add('has-collapsed-sidebar');
                    localStorage.setItem('ggmb_sidebar_collapsed', 'true');
                }

                window.dispatchEvent(new Event('resize'));
            };

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.js-sidebar-toggle').forEach(function(btn) {
                    btn.addEventListener('click', window.toggleSidebar);
                });
            });
        })();
    </script>

    <!-- Modern Custom Dropdown Enhancer -->
    <script>
        (function() {
            function initCustomDropdowns() {
                document.querySelectorAll('select:not([data-customized]):not([multiple])').forEach(function(select) {
                    // Skip if parent already customized
                    if (select.closest('.custom-select-wrapper')) return;

                    select.setAttribute('data-customized', 'true');

                    const parent = select.parentElement;
                    if (!parent) return;

                    // Remove old hardcoded ▾ characters in sibling helper
                    const oldArrow = parent.querySelector('.pointer-events-none');
                    if (oldArrow && oldArrow.textContent.includes('▾')) {
                        oldArrow.style.display = 'none';
                    }

                    // Create wrapper
                    const wrapper = document.createElement('div');
                    wrapper.className = 'custom-select-wrapper relative w-full select-none';

                    // Get initial selected option text
                    const getSelectedText = () => {
                        const opt = select.options[select.selectedIndex] || select.options[0];
                        return opt ? opt.textContent.replace(/▾/g, '').trim() : '';
                    };

                    // Trigger button
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'w-full h-[40px] pl-3.5 pr-3 bg-white hover:bg-[#fafafa] border border-[#e5e7eb] hover:border-[#cbd5e1] rounded-[10px] text-[13.5px] text-[#111827] font-medium flex items-center justify-between gap-2 transition-all cursor-pointer shadow-2xs focus:outline-hidden focus:border-[#0e4d3c] focus:ring-2 focus:ring-[#0e4d3c]/15 text-left';
                    btn.setAttribute('aria-haspopup', 'listbox');
                    btn.setAttribute('aria-expanded', 'false');

                    const labelSpan = document.createElement('span');
                    labelSpan.className = 'truncate flex-1';
                    labelSpan.textContent = getSelectedText();

                    const chevron = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                    chevron.setAttribute('class', 'w-4 h-4 text-[#9ca3af] shrink-0 transition-transform duration-200 pointer-events-none');
                    chevron.setAttribute('fill', 'none');
                    chevron.setAttribute('stroke', 'currentColor');
                    chevron.setAttribute('viewBox', '0 0 24 24');
                    chevron.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />';

                    btn.appendChild(labelSpan);
                    btn.appendChild(chevron);

                    // Floating menu
                    const menu = document.createElement('div');
                    menu.className = 'hidden absolute left-0 right-0 top-full mt-1.5 bg-white border border-[#e5e7eb] rounded-[12px] shadow-[0_12px_30px_-5px_rgba(0,0,0,0.1),0_4px_10px_-2px_rgba(0,0,0,0.04)] p-1.5 z-50 max-h-[260px] overflow-y-auto custom-select-menu transition-all duration-150 origin-top transform scale-95 opacity-0';
                    menu.setAttribute('role', 'listbox');

                    function renderOptions() {
                        menu.innerHTML = '';
                        Array.from(select.options).forEach(function(opt) {
                            if (opt.disabled) return;
                            const optText = opt.textContent.replace(/▾/g, '').trim();
                            const isSelected = opt.selected;

                            const item = document.createElement('div');
                            item.className = 'px-3 py-2 rounded-[8px] text-[13.5px] cursor-pointer transition-colors flex items-center justify-between ' +
                                (isSelected ? 'bg-[#e4efe9] text-[#0e4d3c] font-semibold' : 'text-[#374151] hover:text-[#0e4d3c] hover:bg-[#f4f7f5] font-medium');

                            const textSpan = document.createElement('span');
                            textSpan.className = 'truncate';
                            textSpan.textContent = optText;
                            item.appendChild(textSpan);

                            if (isSelected) {
                                const check = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                                check.setAttribute('class', 'w-4 h-4 text-[#0e4d3c] shrink-0 ml-2');
                                check.setAttribute('fill', 'none');
                                check.setAttribute('stroke', 'currentColor');
                                check.setAttribute('viewBox', '0 0 24 24');
                                check.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />';
                                item.appendChild(check);
                            }

                            item.addEventListener('click', function(e) {
                                e.stopPropagation();
                                select.value = opt.value;
                                labelSpan.textContent = optText;
                                closeMenu();
                                renderOptions();
                                select.dispatchEvent(new Event('change', { bubbles: true }));
                            });

                            menu.appendChild(item);
                        });
                    }

                    renderOptions();

                    function openMenu() {
                        // Close any other open menu
                        document.querySelectorAll('.custom-select-menu').forEach(function(m) {
                            if (m !== menu) {
                                m.classList.add('hidden', 'scale-95', 'opacity-0');
                                m.classList.remove('scale-100', 'opacity-100');
                                const p = m.parentElement;
                                if (p) {
                                    const c = p.querySelector('svg');
                                    if (c) c.classList.remove('rotate-180');
                                }
                            }
                        });

                        menu.classList.remove('hidden');
                        requestAnimationFrame(() => {
                            menu.classList.remove('scale-95', 'opacity-0');
                            menu.classList.add('scale-100', 'opacity-100');
                        });
                        chevron.classList.add('rotate-180');
                        btn.setAttribute('aria-expanded', 'true');

                        // Position check: if overflows viewport bottom, position above
                        const rect = btn.getBoundingClientRect();
                        const spaceBelow = window.innerHeight - rect.bottom;
                        if (spaceBelow < 260 && rect.top > 260) {
                            menu.classList.remove('top-full', 'mt-1.5', 'origin-top');
                            menu.classList.add('bottom-full', 'mb-1.5', 'origin-bottom');
                        } else {
                            menu.classList.remove('bottom-full', 'mb-1.5', 'origin-bottom');
                            menu.classList.add('top-full', 'mt-1.5', 'origin-top');
                        }
                    }

                    function closeMenu() {
                        menu.classList.remove('scale-100', 'opacity-100');
                        menu.classList.add('scale-95', 'opacity-0');
                        chevron.classList.remove('rotate-180');
                        btn.setAttribute('aria-expanded', 'false');
                        setTimeout(() => {
                            if (btn.getAttribute('aria-expanded') === 'false') {
                                menu.classList.add('hidden');
                            }
                        }, 150);
                    }

                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        if (menu.classList.contains('hidden')) {
                            openMenu();
                        } else {
                            closeMenu();
                        }
                    });

                    // Update label when underlying select changes
                    select.addEventListener('change', function() {
                        labelSpan.textContent = getSelectedText();
                        renderOptions();
                    });

                    // Hook property descriptor on select.value
                    try {
                        const originalValueDescriptor = Object.getOwnPropertyDescriptor(HTMLSelectElement.prototype, 'value');
                        Object.defineProperty(select, 'value', {
                            get: function() {
                                return originalValueDescriptor.get.call(this);
                            },
                            set: function(val) {
                                originalValueDescriptor.set.call(this, val);
                                labelSpan.textContent = getSelectedText();
                                renderOptions();
                            }
                        });
                    } catch (e) {}

                    // Form reset listener
                    if (select.form) {
                        select.form.addEventListener('reset', function() {
                            setTimeout(function() {
                                labelSpan.textContent = getSelectedText();
                                renderOptions();
                            }, 20);
                        });
                    }

                    // MutationObserver for options
                    try {
                        const observer = new MutationObserver(function() {
                            labelSpan.textContent = getSelectedText();
                            renderOptions();
                        });
                        observer.observe(select, { childList: true, subtree: true, attributes: true });
                    } catch (e) {}

                    // Hide native select visually while keeping in DOM
                    select.style.position = 'absolute';
                    select.style.opacity = '0';
                    select.style.pointerEvents = 'none';
                    select.style.width = '1px';
                    select.style.height = '1px';
                    select.style.clip = 'rect(0, 0, 0, 0)';

                    // Insert custom dropdown into parent
                    parent.insertBefore(wrapper, select);
                    wrapper.appendChild(select);
                    wrapper.appendChild(btn);
                    wrapper.appendChild(menu);
                });
            }

            // Global click listener to close open menus
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.custom-select-wrapper')) {
                    document.querySelectorAll('.custom-select-menu').forEach(function(m) {
                        m.classList.add('hidden');
                        const p = m.parentElement;
                        if (p) {
                            const c = p.querySelector('svg');
                            if (c) c.classList.remove('rotate-180');
                        }
                    });
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.custom-select-menu').forEach(function(m) {
                        m.classList.add('hidden');
                        const p = m.parentElement;
                        if (p) {
                            const c = p.querySelector('svg');
                            if (c) c.classList.remove('rotate-180');
                        }
                    });
                }
            });

            document.addEventListener('DOMContentLoaded', initCustomDropdowns);
            window.initCustomDropdowns = initCustomDropdowns;
        })();
    </script>
</body>
</html>
