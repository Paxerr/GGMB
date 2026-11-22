@props(['paginator' => null])

@php
    $hasPaginator = isset($paginator) && is_object($paginator) && method_exists($paginator, 'hasPages');
@endphp

<nav class="inline-flex items-center gap-1 bg-white border border-[#E5E7EB] rounded-[10px] p-1 select-none text-[13px] text-[#374151] shadow-2xs" aria-label="Phân trang">
    @if ($hasPaginator && $paginator->hasPages())
        {{-- Nút Trước ‹ --}}
        @if ($paginator->onFirstPage())
            <span class="w-8 h-8 flex items-center justify-center text-gray-300 rounded-[6px] cursor-not-allowed select-none" aria-disabled="true">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center text-[#374151] hover:text-[#0E4D3C] hover:bg-[#F4F7F5] rounded-[6px] transition-colors" rel="prev" title="Trang trước">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
        @endif

        {{-- Danh sách các số trang --}}
        @php
            $current = $paginator->currentPage();
            $last = max(1, $paginator->lastPage());
            $start = max(1, min($current - 2, $last - 4));
            $end = min($last, max($current + 2, min(5, $last)));
        @endphp

        @if ($start > 1)
            <a href="{{ $paginator->url(1) }}" class="min-w-[32px] h-8 px-2 flex items-center justify-center text-[#374151] hover:text-[#0E4D3C] hover:bg-[#F4F7F5] rounded-[6px] font-medium transition-colors">1</a>
            @if ($start > 2)
                <span class="px-1 text-gray-400 select-none">…</span>
            @endif
        @endif

        @for ($p = $start; $p <= $end; $p++)
            @if ($p == $current)
                <span class="min-w-[32px] h-8 px-2 flex items-center justify-center font-bold text-white bg-[#0E4D3C] rounded-[6px] shadow-2xs" aria-current="page">
                    {{ $p }}
                </span>
            @else
                <a href="{{ $paginator->url($p) }}" class="min-w-[32px] h-8 px-2 flex items-center justify-center text-[#374151] hover:text-[#0E4D3C] hover:bg-[#F4F7F5] rounded-[6px] font-medium transition-colors">
                    {{ $p }}
                </a>
            @endif
        @endfor

        @if ($end < $last)
            @if ($end < $last - 1)
                <span class="px-1 text-gray-400 select-none">…</span>
            @endif
            <a href="{{ $paginator->url($last) }}" class="min-w-[32px] h-8 px-2 flex items-center justify-center text-[#374151] hover:text-[#0E4D3C] hover:bg-[#F4F7F5] rounded-[6px] font-medium transition-colors">{{ $last }}</a>
        @endif

        {{-- Nút Sau › --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center text-[#374151] hover:text-[#0E4D3C] hover:bg-[#F4F7F5] rounded-[6px] transition-colors" rel="next" title="Trang sau">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        @else
            <span class="w-8 h-8 flex items-center justify-center text-gray-300 rounded-[6px] cursor-not-allowed select-none" aria-disabled="true">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </span>
        @endif
    @elseif ($hasPaginator && ! $paginator->hasPages())
        {{-- Single-page paginator --}}
        <span class="w-8 h-8 flex items-center justify-center text-gray-300 rounded-[6px] cursor-not-allowed select-none" aria-disabled="true">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </span>
        <span class="min-w-[32px] h-8 px-2 flex items-center justify-center font-bold text-white bg-[#0E4D3C] rounded-[6px] shadow-2xs" aria-current="page">{{ $paginator->currentPage() }}</span>
        <span class="w-8 h-8 flex items-center justify-center text-gray-300 rounded-[6px] cursor-not-allowed select-none" aria-disabled="true">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </span>
    @else
        {{-- Static fallback --}}
        <span class="w-8 h-8 flex items-center justify-center text-gray-300 rounded-[6px] cursor-not-allowed select-none" aria-disabled="true">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </span>
        <span class="min-w-[32px] h-8 px-2 flex items-center justify-center font-bold text-white bg-[#0E4D3C] rounded-[6px] shadow-2xs" aria-current="page">1</span>
        <span class="w-8 h-8 flex items-center justify-center text-gray-300 rounded-[6px] cursor-not-allowed select-none" aria-disabled="true">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </span>
    @endif
</nav>
