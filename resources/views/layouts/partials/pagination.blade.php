@props(['paginator' => null])

@php
    $hasPaginator = isset($paginator) && is_object($paginator) && method_exists($paginator, 'hasPages');
@endphp

<div class="flex items-center space-x-1 border border-[#e5e7eb] bg-white h-[38px] px-2 rounded-[8px] select-none text-[13px] text-[#374151] shadow-2xs" aria-label="Phân trang">
    @if ($hasPaginator && $paginator->hasPages())
        {{-- Nút Trước ‹ --}}
        @if ($paginator->onFirstPage())
            <span class="px-2.5 py-1 text-gray-300 cursor-not-allowed select-none">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-2.5 py-1 text-[#374151] hover:text-[#0e4d3c] hover:bg-[#f4f7f5] rounded-[6px] transition-colors" rel="prev" title="Trang trước">‹</a>
        @endif

        {{-- Danh sách các số trang --}}
        @php
            $current = $paginator->currentPage();
            $last = max(1, $paginator->lastPage());
            $start = max(1, min($current - 2, $last - 4));
            $end = min($last, max($current + 2, min(5, $last)));
        @endphp

        @if ($start > 1)
            <a href="{{ $paginator->url(1) }}" class="px-2.5 py-1 text-[#374151] hover:text-[#0e4d3c] hover:bg-[#f4f7f5] rounded-[6px] transition-colors">1</a>
            @if ($start > 2)
                <span class="px-1 text-gray-400">...</span>
            @endif
        @endif

        @for ($p = $start; $p <= $end; $p++)
            @if ($p == $current)
                <span class="px-2.5 py-1 font-semibold text-[#0e4d3c] bg-[#e4efe9] rounded-[6px]" aria-current="page">
                    {{ $p }}
                </span>
            @else
                <a href="{{ $paginator->url($p) }}" class="px-2.5 py-1 text-[#374151] hover:text-[#0e4d3c] hover:bg-[#f4f7f5] rounded-[6px] transition-colors">
                    {{ $p }}
                </a>
            @endif
        @endfor

        @if ($end < $last)
            @if ($end < $last - 1)
                <span class="px-1 text-gray-400">...</span>
            @endif
            <a href="{{ $paginator->url($last) }}" class="px-2.5 py-1 text-[#374151] hover:text-[#0e4d3c] hover:bg-[#f4f7f5] rounded-[6px] transition-colors">{{ $last }}</a>
        @endif

        {{-- Nút Sau › --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-2.5 py-1 text-[#374151] hover:text-[#0e4d3c] hover:bg-[#f4f7f5] rounded-[6px] transition-colors" rel="next" title="Trang sau">›</a>
        @else
            <span class="px-2.5 py-1 text-gray-300 cursor-not-allowed select-none">›</span>
        @endif
    @elseif ($hasPaginator && ! $paginator->hasPages())
        {{-- Single-page paginator --}}
        <span class="px-2.5 py-1 text-gray-300 cursor-not-allowed select-none">‹</span>
        <span class="px-2.5 py-1 font-semibold text-[#0e4d3c] bg-[#e4efe9] rounded-[6px]" aria-current="page">{{ $paginator->currentPage() }}</span>
        <span class="px-2.5 py-1 text-gray-300 cursor-not-allowed select-none">›</span>
    @else
        {{-- Static 1-page fallback --}}
        <span class="px-2.5 py-1 text-gray-300 cursor-not-allowed select-none">‹</span>
        <span class="px-2.5 py-1 font-semibold text-[#0e4d3c] bg-[#e4efe9] rounded-[6px]" aria-current="page">1</span>
        <span class="px-2.5 py-1 text-gray-300 cursor-not-allowed select-none">›</span>
    @endif
</div>
