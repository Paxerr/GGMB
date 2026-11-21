@extends('layouts.app', [
    'title' => 'Quản lý hóa đơn · GGMB',
    'active' => 'invoices',
    'breadcrumbs' => ['GGMB', 'Hóa đơn']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    @if (session('success'))
        <div class="p-4 bg-[#e6f5ec] border border-[#c3e6cb] text-[#16734b] text-[14px] rounded-[4px] flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#16734b] font-bold text-lg leading-none cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Tiêu đề & Phụ đề (33 · SCR-INV-01 · Bám sát Ảnh 7) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
            Quản lý hóa đơn
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#334b5d]">
            Lập hóa đơn theo căn hộ, dịch vụ và kỳ; theo dõi công nợ, hạn thanh toán và kết quả thu.
        </p>
    </div>

    <!-- 3 Thẻ thống kê KPI (Bám sát Ảnh 7) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- KPI 1: Công nợ -->
        <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-5 shadow-sm">
            <span class="block text-[11px] font-bold text-slate-500 tracking-wider uppercase">
                CÔNG NỢ · 28 HÓA ĐƠN
            </span>
            <span class="block text-[24px] font-bold text-[#122d40] font-mono mt-1.5">
                {{ $debtTotal ?? '24.920.000 đ' }}
            </span>
        </div>

        <!-- KPI 2: Đã thanh toán -->
        <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-5 shadow-sm">
            <span class="block text-[11px] font-bold text-slate-500 tracking-wider uppercase">
                ĐÃ THANH TOÁN · 8 HÓA ĐƠN
            </span>
            <span class="block text-[24px] font-bold text-[#16734b] font-mono mt-1.5">
                {{ $paidTotal ?? '6.880.000 đ' }}
            </span>
        </div>

        <!-- KPI 3: Quá hạn -->
        <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-5 shadow-sm">
            <span class="block text-[11px] font-bold text-rose-500 tracking-wider uppercase">
                QUÁ HẠN · 5 HÓA ĐƠN
            </span>
            <span class="block text-[24px] font-bold text-[#b91c1c] font-mono mt-1.5">
                {{ $overdueTotal ?? '4.457.500 đ' }}
            </span>
        </div>
    </div>

    <!-- Hàng Bộ lọc & Nút + Tạo hóa đơn -->
    <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-4 pt-1">
        <div class="flex flex-wrap items-end gap-3 sm:gap-4 flex-1">
            <!-- Kỳ thanh toán -->
            <div class="space-y-1.5 w-full sm:w-[220px]">
                <label class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Kỳ thanh toán
                </label>
                <div class="relative">
                    <select class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer">
                        <option value="">Tất cả ▾</option>
                        <option value="01/2026">01/2026</option>
                        <option value="02/2026">02/2026</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                </div>
            </div>

            <!-- Trạng thái -->
            <div class="space-y-1.5 w-full sm:w-[220px]">
                <label class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Trạng thái
                </label>
                <div class="relative">
                    <select class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer">
                        <option value="">Tất cả ▾</option>
                        <option value="PENDING">Chờ thanh toán</option>
                        <option value="PAID">Đã thanh toán</option>
                        <option value="OVERDUE">Quá hạn</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                </div>
            </div>

            <!-- Căn hộ -->
            <div class="space-y-1.5 w-full sm:w-[220px]">
                <label class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Căn hộ
                </label>
                <div class="relative">
                    <select class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer">
                        <option value="">Tất cả ▾</option>
                        @foreach ($apartments as $apt)
                            <option value="{{ $apt->ApartmentId }}">{{ $apt->ApartmentNumber }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                </div>
            </div>
        </div>

        <!-- Nút + Tạo hóa đơn -->
        <div class="shrink-0">
            <button
                type="button"
                onclick="openCreateInvoiceModal()"
                class="w-full sm:w-[196px] h-[40px] px-5 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer flex items-center justify-center whitespace-nowrap shadow-sm"
            >
                ＋ Tạo hóa đơn
            </button>
        </div>
    </div>

    <!-- Bảng Hóa đơn (100% full width) -->
    <div class="bg-white border border-solid border-[#d9e4ec] overflow-hidden rounded-[4px]">
        <!-- Table Header -->
        <div class="bg-[#e4edf3] border-b border-[#d9e4ec] flex h-[40px] items-center text-[#334b5d] text-[12px] leading-[18px] font-semibold select-none">
            <div class="w-[60px] min-w-[50px] px-3 border-r border-[#d9e4ec] h-full flex items-center">ID</div>
            <div class="w-[110px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Căn hộ</div>
            <div class="w-[110px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Kỳ</div>
            <div class="w-[150px] min-w-[120px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Tổng tiền (đ)</div>
            <div class="w-[150px] min-w-[120px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Hạn thanh toán</div>
            <div class="w-[150px] min-w-[120px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Trạng thái</div>
            <div class="flex-1 min-w-[200px] px-3 h-full flex items-center">Thao tác</div>
        </div>

        <!-- Table Rows -->
        @php
            $invoicesMap = [];
        @endphp
        @foreach ($invoices as $inv)
            @php
                $invData = [
                    'id' => $inv->id,
                    'apartment' => $inv->apartment,
                    'period' => $inv->period,
                    'amount' => $inv->amount,
                    'due_date' => $inv->due_date,
                    'status' => $inv->status,
                    'status_label' => $inv->status_label,
                    'items' => $inv->items ?? [],
                ];
                $invoicesMap[$inv->id] = $invData;
            @endphp
            <div
                class="bg-white border-b last:border-b-0 border-[#d9e4ec] flex h-[48px] items-center text-[#334b5d] text-[14px] leading-[20px] hover:bg-[#f8fbfd] transition-colors cursor-pointer"
                onclick="if(!event.target.closest('a') && !event.target.closest('button')) window.location.href='{{ route('invoices.show', $inv->id) }}'"
            >
                <div class="w-[60px] min-w-[50px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">{{ $inv->id }}</div>
                <div class="w-[110px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium text-[#122d40]">{{ $inv->apartment }}</div>
                <div class="w-[110px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">{{ $inv->period }}</div>
                <div class="w-[150px] min-w-[120px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-semibold text-[#122d40] font-mono">{{ number_format($inv->amount, 0, ',', '.') }}</div>
                <div class="w-[150px] min-w-[120px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">{{ $inv->due_date }}</div>
                <div class="w-[150px] min-w-[120px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                    @if ($inv->status === 'PAID')
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-[#e6f5ec] text-[#16734b]">Đã thanh toán</span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-[#fff8e6] text-[#b37400]">Chờ thanh toán</span>
                    @endif
                </div>
                <div class="flex-1 min-w-[200px] px-3 h-full flex items-center space-x-2 text-[14px]">
                    <a
                        href="{{ route('invoices.show', $inv->id) }}"
                        onclick="event.stopPropagation();"
                        class="text-[#2864ad] hover:text-[#205391] hover:underline font-medium cursor-pointer"
                    >
                        Xem / In
                    </a>
                    @if ($inv->status !== 'PAID')
                        <span class="text-[#52697c]">/</span>
                        <button
                            type="button"
                            onclick="event.stopPropagation(); openCollectModal({{ $inv->id }});"
                            class="text-[#2864ad] hover:text-[#205391] hover:underline font-medium cursor-pointer"
                        >
                            Thu
                        </button>
                        <span class="text-[#52697c]">/</span>
                        <button
                            type="button"
                            onclick="event.stopPropagation(); openCancelInvoiceModal({{ $inv->id }});"
                            class="text-rose-600 hover:text-rose-700 hover:underline font-medium cursor-pointer"
                        >
                            Hủy
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Chú thích & Phân trang -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1 pb-6">
        <div class="text-[13px] text-[#52697c]">
            Hiển thị 1–6 trong 40 hóa đơn · Thống kê toàn bộ công nợ theo kỳ thanh toán.
        </div>

        <!-- Phân trang ‹ 1 2 ... 7 › -->
        <div class="w-[204px] h-[40px] bg-white border border-[#d9e4ec] rounded-[4px] flex items-center justify-between px-3 select-none text-[14px] text-[#334b5d]">
            <span class="text-[#a6bece]">‹</span>
            <span class="font-semibold text-[#122d40] border-b-2 border-[#2864ad] pb-0.5">1</span>
            <span class="text-[#334b5d]">2</span>
            <span class="text-[#8a9ba8]">...</span>
            <span class="text-[#334b5d]">7</span>
            <span class="text-[#334b5d] hover:text-[#2864ad] cursor-pointer">›</span>
        </div>
    </div>
</div>

<!-- Modals: Lập hóa đơn mới, Thu tiền tại quầy & Hủy hóa đơn -->
@include('invoices.partials.create-modal')
@include('invoices.partials.collect-modal')
@include('invoices.partials.cancel-modal')

<script>
    window.invoicesMap = @json($invoicesMap ?? []);
</script>
@endsection
