@extends('layouts.app', [
    'title' => 'Cấu hình biểu phí · GGMB',
    'active' => 'fee-rates',
    'breadcrumbs' => ['GGMB', 'Biểu phí']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6 pb-12">
    @if (session('success'))
        <div class="p-4 bg-[#e6f5ec] border border-[#c3e6cb] text-[#16734b] text-[14px] rounded-[4px] flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#16734b] font-bold text-lg leading-none cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Breadcrumb (Bám sát Ảnh 6) -->
    <nav class="flex items-center text-[13px] leading-[18px] text-[#52697c] space-x-2">
        <a href="{{ route('dashboard') }}" class="hover:text-[#2864ad] transition-colors">GGMB</a>
        <span>/</span>
        <span class="text-[#122d40] font-medium">Biểu phí</span>
    </nav>

    <!-- Tiêu đề & Phụ đề (Bám sát Ảnh 6) -->
    <div class="space-y-1">
        <h1 class="text-[26px] leading-[32px] font-bold text-[#122d40]">
            Cấu hình biểu phí
        </h1>
        <p class="text-[14px] leading-[20px] text-[#52697c]">
            Quản lý danh mục loại phí và đơn giá theo khoảng thời gian hiệu lực.
        </p>
    </div>

    <!-- Hàng Bộ lọc & Nút Thao tác (Bám sát Ảnh 6) -->
    <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-4 pt-2">
        <div class="flex flex-wrap items-end gap-3 sm:gap-4 flex-1">
            <!-- Trạng thái áp dụng -->
            <div class="space-y-1.5 w-full sm:w-[220px]">
                <label class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Trạng thái áp dụng
                </label>
                <div class="relative">
                    <select class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer">
                        <option value="ACTIVE" selected>Đang áp dụng ▾</option>
                        <option value="INACTIVE">Ngừng sử dụng</option>
                        <option value="ALL">Tất cả</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                </div>
            </div>

            <!-- Tìm theo Mã phí / Tên phí -->
            <div class="space-y-1.5 w-full sm:w-[280px]">
                <label class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Tìm theo Mã phí / Tên phí
                </label>
                <input
                    type="text"
                    placeholder="Nhập mã hoặc tên loại phí"
                    class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                />
            </div>

            <!-- Nút Lọc -->
            <button
                type="button"
                class="h-[42px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer"
            >
                Lọc
            </button>
        </div>

        <!-- Nút + Thêm loại phí (Mở Popup Modal) -->
        <div class="shrink-0">
            <button
                type="button"
                onclick="openCreateFeeModal()"
                class="w-full sm:w-[196px] h-[40px] px-5 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer flex items-center justify-center whitespace-nowrap shadow-sm"
            >
                ＋ Thêm loại phí
            </button>
        </div>
    </div>

    <!-- Bảng dữ liệu Cấu hình biểu phí (Bám sát Ảnh 6) -->
    <div class="bg-white border border-solid border-[#d9e4ec] overflow-hidden rounded-[4px] shadow-xs">
        <!-- Table Header -->
        <div class="bg-[#e4edf3] border-b border-[#d9e4ec] flex h-[40px] items-center text-[#334b5d] text-[12px] leading-[18px] font-semibold select-none">
            <div class="w-[120px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Mã phí / Giá</div>
            <div class="w-[120px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Mô tả</div>
            <div class="w-[160px] min-w-[120px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Tên phí</div>
            <div class="w-[120px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Hoạt động</div>
            <div class="w-[140px] min-w-[110px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Đơn giá · VND</div>
            <div class="w-[140px] min-w-[110px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Áp dụng từ</div>
            <div class="w-[140px] min-w-[110px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Áp dụng đến</div>
            <div class="flex-1 min-w-[140px] px-3 h-full flex items-center">Thao tác</div>
        </div>

        <!-- Table Rows (Bám sát Ảnh 6) -->
        @foreach ($feeRates as $rate)
            <div class="bg-white border-b last:border-b-0 border-[#d9e4ec] flex h-[48px] items-center text-[#334b5d] text-[14px] leading-[20px] hover:bg-[#f8fbfd] transition-colors">
                <div class="w-[120px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">{{ $rate->id }} / {{ $rate->rate_id }}</div>
                <div class="w-[120px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">{{ $rate->unit }}</div>
                <div class="w-[160px] min-w-[120px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium text-[#122d40]">{{ $rate->name }}</div>
                <div class="w-[120px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-[#e6f5ec] text-[#16734b]">
                        Áp dụng
                    </span>
                </div>
                <div class="w-[140px] min-w-[110px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-semibold text-[#122d40] font-mono">{{ number_format($rate->price, 0, ',', '.') }}</div>
                <div class="w-[140px] min-w-[110px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">{{ $rate->effective_from }}</div>
                <div class="w-[140px] min-w-[110px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">{{ $rate->effective_to ?? '—' }}</div>
                <div class="flex-1 min-w-[140px] px-3 h-full flex items-center text-[14px]">
                    <button
                        type="button"
                        onclick="openEditRateModal({name: '{{ $rate->name }}', price: {{ $rate->price }}, effective_from: '{{ $rate->effective_from }}', effective_to: '{{ $rate->effective_to ?? '' }}'})"
                        class="text-[#2864ad] hover:text-[#205391] hover:underline font-medium cursor-pointer"
                    >
                        Chi tiết / Đơn giá
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Khối mô tả các loại phí (Bám sát Ảnh 3) -->
    <div class="space-y-4 pt-1">
        <div class="p-4 bg-[#f8fafc] border border-dashed border-[#d9e4ec] rounded-[4px] text-[13px] text-[#52697c] space-y-1">
            <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">MÔ TẢ CÁC LOẠI PHÍ</span>
            <div>Điện · Điện năng tiêu thụ</div>
            <div>Nước · Nước sinh hoạt</div>
            <div>Phí quản lý · Phí quản lý căn hộ</div>
            <div>Gửi xe · Phí gửi xe theo tháng</div>
            <div>Internet · Dịch vụ Internet</div>
        </div>

        <!-- Thông tin hiển thị & Phân trang -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1 pb-6">
            <div class="text-[13px] text-[#52697c]">
                Hiển thị 1–5 trong 5 loại phí
            </div>

            <!-- Phân trang ‹ 1 2 › -->
            <div class="w-[120px] h-[36px] bg-white border border-[#d9e4ec] rounded-[4px] flex items-center justify-between px-3 select-none text-[13px] text-[#334b5d]">
                <span class="text-[#a6bece]">‹</span>
                <span class="font-semibold text-[#122d40] border-b-2 border-[#2864ad] pb-0.5">1</span>
                <span class="text-[#334b5d] hover:text-[#2864ad] cursor-pointer">2</span>
                <span class="text-[#334b5d] hover:text-[#2864ad] cursor-pointer">›</span>
            </div>
        </div>
    </div>
</div>

@include('fee-rates.partials.create-modal')
@include('fee-rates.partials.rate-modal')
@endsection
