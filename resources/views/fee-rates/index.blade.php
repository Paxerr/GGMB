@extends('layouts.app', [
    'title' => 'Cấu hình biểu phí · GGMB',
    'active' => 'fee-rates',
    'breadcrumbs' => ['Quản trị', 'Biểu phí']
])

@section('content')
<div class="w-full space-y-6">
    <span class="sr-only">GGMB</span>
    @if (session('success'))
        <div class="p-4 bg-[#E4EFE9] border border-[#B8D5C7] text-[#0E4D3C] text-[13.5px] rounded-[8px] flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#0E4D3C] font-bold text-lg leading-none cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Header Title & Subtitle -->
    <div>
        <h1 class="text-[26px] leading-[34px] font-bold text-[#111827] tracking-tight">
            Cấu hình biểu phí
        </h1>
        <p class="mt-1 text-[13px] leading-[20px] text-[#6b7280]">
            Quản lý danh mục loại phí và đơn giá theo khoảng thời gian hiệu lực
        </p>
    </div>

    <!-- Filters & Action Button Row -->
    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 pt-1">
        <!-- Hàng Bộ lọc -->
        <form method="GET" action="{{ route('fee-rates.index') }}" class="flex flex-wrap items-center gap-3 sm:gap-4 flex-1">
            <!-- Trạng thái áp dụng -->
            <div class="w-full sm:w-[220px]">
                <label for="filterStatus" class="sr-only">
                    Trạng thái áp dụng
                </label>
                <div class="relative">
                    <select id="filterStatus" name="status" onchange="this.form.submit()" class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer">
                        <option value="ACTIVE" {{ request('status', 'ACTIVE') === 'ACTIVE' ? 'selected' : '' }}>Đang áp dụng</option>
                        <option value="INACTIVE" {{ request('status') === 'INACTIVE' ? 'selected' : '' }}>Ngừng sử dụng</option>
                        <option value="ALL" {{ request('status') === 'ALL' ? 'selected' : '' }}>Tất cả</option>
                    </select>
                </div>
            </div>

            <!-- Tìm theo Mã phí / Tên phí -->
            <div class="flex-1 min-w-[240px]">
                <label for="filterKeyword" class="sr-only">
                    Tìm theo Mã phí / Tên phí
                </label>
                <input
                    id="filterKeyword"
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    placeholder="Tìm theo mã hoặc tên loại phí..."
                    class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                />
            </div>

            <div class="flex items-center gap-2">
                <button
                    type="submit"
                    class="h-[40px] px-4 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer"
                >
                    Áp dụng
                </button>
                <a
                    href="{{ route('fee-rates.index') }}"
                    class="h-[40px] px-4 bg-[#F3F4F6] hover:bg-[#E5E7EB] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer inline-flex items-center"
                >
                    Đặt lại
                </a>
            </div>
        </form>

        <!-- Thêm loại phí button -->
        <div class="flex items-center gap-2 shrink-0">
            <button
                type="button"
                onclick="openCreateFeeModal()"
                class="h-[40px] px-4 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] shadow-sm transition-colors cursor-pointer inline-flex items-center gap-1.5"
            >
                <span>＋</span> Thêm loại phí
            </button>
        </div>
    </div>

    <!-- Bảng dữ liệu Cấu hình biểu phí -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] overflow-x-auto shadow-none">
        <!-- Table Header -->
        <div class="bg-[#F2F6F4] border-b border-[#E5E7EB] flex h-[44px] items-center text-[#374151] text-[12px] font-semibold select-none">
            <div class="w-[120px] min-w-[90px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Mã phí / Giá</div>
            <div class="flex-1 min-w-[180px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Tên loại phí</div>
            <div class="w-[130px] min-w-[90px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Đơn vị tính</div>
            <div class="w-[120px] min-w-[90px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Trạng thái</div>
            <div class="w-[150px] min-w-[120px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Đơn giá · VND</div>
            <div class="w-[140px] min-w-[110px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Áp dụng từ</div>
            <div class="w-[140px] min-w-[110px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Áp dụng đến</div>
            <div class="w-[110px] min-w-[90px] px-4 h-full flex items-center justify-center text-[#0E4D3C]">Thao tác</div>
        </div>

        <!-- Table Rows -->
        @forelse ($feeRates as $rate)
            <div class="bg-white border-b border-[#E5E7EB] last:border-b-0 flex h-[52px] items-center text-[#374151] text-[13.5px] hover:bg-[#F9FBFA] transition-colors">
                <div class="w-[120px] min-w-[90px] px-4 border-r border-[#E5E7EB] h-full flex items-center text-[#6B7280] font-mono">{{ $rate->id }} / {{ $rate->rate_id }}</div>
                <div class="flex-1 min-w-[180px] px-4 border-r border-[#E5E7EB] h-full flex items-center font-semibold text-[#111827]">{{ $rate->name }}</div>
                <div class="w-[130px] min-w-[90px] px-4 border-r border-[#E5E7EB] h-full flex items-center text-[#374151]">{{ $rate->unit }}</div>
                <div class="w-[120px] min-w-[90px] px-4 border-r border-[#E5E7EB] h-full flex items-center">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] text-xs font-semibold bg-[#E4EFE9] text-[#0E4D3C]">
                        Áp dụng
                    </span>
                </div>
                <div class="w-[150px] min-w-[120px] px-4 border-r border-[#E5E7EB] h-full flex items-center font-semibold text-[#111827] font-mono">{{ number_format($rate->price, 0, ',', '.') }}</div>
                <div class="w-[140px] min-w-[110px] px-4 border-r border-[#E5E7EB] h-full flex items-center text-[#6B7280]">{{ $rate->effective_from }}</div>
                <div class="w-[140px] min-w-[110px] px-4 border-r border-[#E5E7EB] h-full flex items-center text-[#6B7280]">{{ $rate->effective_to ?? '—' }}</div>
                <div class="w-[110px] min-w-[90px] px-4 h-full flex items-center justify-center gap-1.5 text-[13px]">
                    <button
                        type="button"
                        onclick="openEditRateModal({id: {{ $rate->id }}, name: '{{ $rate->name }}', price: {{ $rate->price }}, effective_from: '{{ $rate->effective_from }}', effective_to: '{{ $rate->effective_to ?? '' }}'})"
                        title="Chỉnh sửa đơn giá"
                        class="p-1.5 text-[#0E4D3C] hover:bg-[#E4EFE9] rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="sr-only">Chi tiết / Đơn giá</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-[#6B7280] text-[13.5px]">
                Không tìm thấy loại phí nào phù hợp điều kiện lọc.
            </div>
        @endforelse
    </div>

    <!-- Thông tin hiển thị & Phân trang -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1">
        <div class="text-[13px] text-[#6B7280]">
            Hiển thị 1–{{ count($feeRates) }} trong {{ count($feeRates) }} loại phí
        </div>

        @include('layouts.partials.pagination')
    </div>
</div>

@include('fee-rates.partials.create-modal')
@include('fee-rates.partials.rate-modal')
@endsection
