@props(['icon', 'class' => 'text-current'])

@switch($icon)
    @case('grid')
        {{-- 4 squares icon --}}
        <svg class="w-[18px] h-[18px] shrink-0 {{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
            <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
            <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
            <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
        </svg>
        @break

    @case('building')
        {{-- Building icon --}}
        <svg class="w-[18px] h-[18px] shrink-0 {{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <rect x="4" y="3" width="16" height="18" rx="2"></rect>
            <path d="M8 7h2"></path>
            <path d="M14 7h2"></path>
            <path d="M8 11h2"></path>
            <path d="M14 11h2"></path>
            <path d="M8 15h2"></path>
            <path d="M14 15h2"></path>
            <path d="M10 21v-3h4v3"></path>
        </svg>
        @break

    @case('home')
        {{-- House icon --}}
        <svg class="w-[18px] h-[18px] shrink-0 {{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <path d="M9 21v-6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v6"></path>
        </svg>
        @break

    @case('users')
        {{-- Users icon --}}
        <svg class="w-[18px] h-[18px] shrink-0 {{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
        </svg>
        @break

    @case('car')
        {{-- Car icon --}}
        <svg class="w-[18px] h-[18px] shrink-0 {{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"></path>
            <circle cx="7" cy="17" r="2"></circle>
            <path d="M9 17h6"></path>
            <circle cx="17" cy="17" r="2"></circle>
        </svg>
        @break

    @case('bolt')
        {{-- Lightning bolt icon --}}
        <svg class="w-[18px] h-[18px] shrink-0 {{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
        </svg>
        @break

    @case('receipt')
        {{-- Document / invoice icon --}}
        <svg class="w-[18px] h-[18px] shrink-0 {{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <rect x="4" y="2" width="16" height="20" rx="2"></rect>
            <line x1="8" y1="7" x2="16" y2="7"></line>
            <line x1="8" y1="12" x2="16" y2="12"></line>
            <line x1="8" y1="17" x2="12" y2="17"></line>
        </svg>
        @break

    @case('headset')
        {{-- Customer support headset icon --}}
        <svg class="w-[18px] h-[18px] shrink-0 {{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
            <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
        </svg>
        @break

    @case('bell')
        {{-- Notification bell icon --}}
        <svg class="w-[18px] h-[18px] shrink-0 {{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
        </svg>
        @break

    @case('credit-card')
        {{-- Fee rate / card icon --}}
        <svg class="w-[18px] h-[18px] shrink-0 {{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
            <line x1="2" y1="10" x2="22" y2="10"></line>
            <line x1="6" y1="15" x2="10" y2="15"></line>
        </svg>
        @break

    @case('user')
        {{-- Single user outline icon --}}
        <svg class="w-[18px] h-[18px] shrink-0 {{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
        </svg>
        @break

    @default
        <svg class="w-[18px] h-[18px] shrink-0 {{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
        </svg>
@endswitch
