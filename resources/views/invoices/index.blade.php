@extends('layouts.app', [
    'title' => 'Quản lý hóa đơn · GGMB',
    'active' => 'invoices',
    'breadcrumbs' => ['Quản trị', 'Hóa đơn']
])

@section('content')
<div class="space-y-6">
    <span class="sr-only">GGMB</span>
    @if (session('success'))
        <div class="p-4 bg-[#E4EFE9] border border-[#B8D5C7] text-[#0E4D3C] text-[13.5px] rounded-[8px] flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#0E4D3C] font-bold text-lg leading-none cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Tiêu đề & Bộ lọc -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
                Quản lý hóa đơn
            </h1>
            <p class="mt-0.5 text-[13.5px] text-[#6B7280]">
                Lập hóa đơn theo căn hộ, dịch vụ và kỳ; theo dõi công nợ, hạn thanh toán và kết quả thu.
            </p>
        </div>
        <div class="shrink-0">
            <button
                type="button"
                onclick="openCreateInvoiceModal()"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] shadow-sm transition-colors cursor-pointer"
            >
                <span>＋</span> Tạo hóa đơn
            </button>
        </div>
    </div>

    <!-- 3 Thẻ thống kê KPI -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- KPI 1: Công nợ -->
        <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-5 shadow-none">
            <span class="block text-[11px] font-bold text-[#8F5316] tracking-wider uppercase">
                CÔNG NỢ · {{ $debtCount ?? 0 }} HÓA ĐƠN
            </span>
            <span class="block text-[26px] font-bold text-[#8F5316] font-mono mt-1">
                {{ $debtTotal ?? '0 đ' }}
            </span>
        </div>

        <!-- KPI 2: Đã thanh toán -->
        <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-5 shadow-none">
            <span class="block text-[11px] font-bold text-[#0E4D3C] tracking-wider uppercase">
                ĐÃ THANH TOÁN · {{ $paidCount ?? 0 }} HÓA ĐƠN
            </span>
            <span class="block text-[26px] font-bold text-[#0E4D3C] font-mono mt-1">
                {{ $paidTotal ?? '0 đ' }}
            </span>
        </div>

        <!-- KPI 3: Quá hạn -->
        <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-5 shadow-none">
            <span class="block text-[11px] font-bold text-rose-600 tracking-wider uppercase">
                QUÁ HẠN · {{ $overdueCount ?? 0 }} HÓA ĐƠN
            </span>
            <span class="block text-[26px] font-bold text-rose-600 font-mono mt-1">
                {{ $overdueTotal ?? '0 đ' }}
            </span>
        </div>
    </div>

    <!-- Hàng Bộ lọc -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-4 shadow-none">
        <form method="GET" action="{{ route('invoices.index') }}" class="flex flex-wrap items-center gap-3">
            <!-- Kỳ thanh toán -->
            <div class="flex-1 min-w-[180px]">
                <label for="filterInvoicePeriod" class="sr-only">
                    Kỳ thanh toán
                </label>
                <div class="relative">
                    <select
                        id="filterInvoicePeriod"
                        name="period"
                        onchange="this.form.submit()"
                        class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                    >
                        <option value="">Tất cả kỳ thanh toán</option>
                        <option value="01/2026" {{ request('period') === '01/2026' ? 'selected' : '' }}>01/2026</option>
                        <option value="02/2026" {{ request('period') === '02/2026' ? 'selected' : '' }}>02/2026</option>
                        <option value="12/2025" {{ request('period') === '12/2025' ? 'selected' : '' }}>12/2025</option>
                    </select>
                </div>
            </div>

            <!-- Trạng thái -->
            <div class="flex-1 min-w-[180px]">
                <label for="filterInvoiceStatus" class="sr-only">
                    Trạng thái
                </label>
                <div class="relative">
                    <select
                        id="filterInvoiceStatus"
                        name="status"
                        onchange="this.form.submit()"
                        class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                    >
                        <option value="">Tất cả trạng thái</option>
                        <option value="PENDING" {{ request('status') === 'PENDING' ? 'selected' : '' }}>Chờ thanh toán</option>
                        <option value="PAID" {{ request('status') === 'PAID' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="OVERDUE" {{ request('status') === 'OVERDUE' ? 'selected' : '' }}>Quá hạn</option>
                    </select>
                </div>
            </div>

            <!-- Căn hộ -->
            <div class="flex-1 min-w-[180px]">
                <label for="filterInvoiceApartment" class="sr-only">
                    Căn hộ
                </label>
                <div class="relative">
                    <select
                        id="filterInvoiceApartment"
                        name="apartment_id"
                        onchange="this.form.submit()"
                        class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                    >
                        <option value="">Tất cả căn hộ</option>
                        @foreach ($apartments as $apt)
                            <option value="{{ $apt->ApartmentId }}" {{ request('apartment_id') == $apt->ApartmentId ? 'selected' : '' }}>
                                {{ $apt->ApartmentNumber }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button
                    type="submit"
                    class="h-[40px] px-4 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer"
                >
                    Áp dụng
                </button>
                <a
                    href="{{ route('invoices.index') }}"
                    class="h-[40px] px-4 bg-[#F3F4F6] hover:bg-[#E5E7EB] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors inline-flex items-center justify-center"
                >
                    Đặt lại
                </a>
            </div>
        </form>
    </div>

    <!-- Bảng Hóa đơn -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] overflow-hidden shadow-none">
        <!-- Table Header -->
        <div class="bg-[#F2F6F4] border-b border-[#E5E7EB] flex h-[44px] items-center text-[#374151] text-[12px] font-semibold select-none">
            <div class="w-[60px] min-w-[50px] px-4 border-r border-[#E5E7EB] h-full flex items-center">ID</div>
            <div class="w-[110px] min-w-[90px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Căn hộ</div>
            <div class="w-[110px] min-w-[90px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Kỳ</div>
            <div class="w-[150px] min-w-[120px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Tổng tiền (đ)</div>
            <div class="w-[150px] min-w-[120px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Hạn thanh toán</div>
            <div class="w-[150px] min-w-[120px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Trạng thái</div>
            <div class="flex-1 min-w-[200px] px-4 h-full flex items-center">Thao tác</div>
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
                class="bg-white border-b border-[#E5E7EB] last:border-b-0 flex h-[52px] items-center text-[#374151] text-[13.5px] hover:bg-[#F9FBFA] transition-colors cursor-pointer"
                onclick="if(!event.target.closest('a') && !event.target.closest('button')) window.location.href='{{ route('invoices.show', $inv->id) }}'"
            >
                <div class="w-[60px] min-w-[50px] px-4 border-r border-[#E5E7EB] h-full flex items-center text-[#6B7280]">{{ $inv->id }}</div>
                <div class="w-[110px] min-w-[90px] px-4 border-r border-[#E5E7EB] h-full flex items-center font-semibold text-[#111827]">{{ $inv->apartment }}</div>
                <div class="w-[110px] min-w-[90px] px-4 border-r border-[#E5E7EB] h-full flex items-center text-[#374151]">{{ $inv->period }}</div>
                <div class="w-[150px] min-w-[120px] px-4 border-r border-[#E5E7EB] h-full flex items-center font-semibold text-[#111827] font-mono">{{ number_format($inv->amount, 0, ',', '.') }}</div>
                <div class="w-[150px] min-w-[120px] px-4 border-r border-[#E5E7EB] h-full flex items-center text-[#6B7280]">{{ $inv->due_date }}</div>
                <div class="w-[150px] min-w-[120px] px-4 border-r border-[#E5E7EB] h-full flex items-center">
                    @if ($inv->status === 'PAID')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] text-xs font-semibold bg-[#E4EFE9] text-[#0E4D3C]">Đã thanh toán</span>
                    @elseif ($inv->status === 'OVERDUE')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] text-xs font-semibold bg-[#FFF4DB] text-[#8F5316]">Quá hạn</span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] text-xs font-semibold bg-[#FFF4DB] text-[#8F5316]">Chờ thanh toán</span>
                    @endif
                </div>
                <div class="flex-1 min-w-[200px] px-4 h-full flex items-center gap-1.5 text-[13px]">
                    <a
                        href="{{ route('invoices.show', $inv->id) }}"
                        onclick="event.stopPropagation();"
                        title="Xem / In hóa đơn"
                        class="p-1.5 text-[#0E4D3C] hover:bg-[#E4EFE9] rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span class="sr-only">Xem / In</span>
                    </a>
                    @if ($inv->status !== 'PAID')
                        <button
                            type="button"
                            onclick="event.stopPropagation(); openCollectModal({{ $inv->id }});"
                            title="Thu phí hóa đơn"
                            class="p-1.5 text-[#8F5316] hover:bg-amber-50 rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="sr-only">Thu</span>
                        </button>
                        <button
                            type="button"
                            onclick="event.stopPropagation(); openCancelInvoiceModal({{ $inv->id }});"
                            title="Hủy hóa đơn"
                            class="p-1.5 text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span class="sr-only">Hủy</span>
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Chú thích & Phân trang -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1">
        <div class="text-[13px] text-[#6B7280]">
            Hiển thị {{ $invoices->firstItem() ?? 1 }}–{{ $invoices->lastItem() ?? $invoices->count() }} trong {{ $invoices->total() }} hóa đơn · Thống kê toàn bộ công nợ theo kỳ thanh toán.
        </div>

        @include('layouts.partials.pagination', ['paginator' => $invoices])
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
