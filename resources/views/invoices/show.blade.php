@extends('layouts.app', [
    'title' => 'Xem & in hóa đơn A4 · GGMB',
    'active' => 'invoices',
    'breadcrumbs' => ['Quản trị', 'Hóa đơn', 'Xem & in']
])

@section('content')
<div class="space-y-6">
    <span class="sr-only">GGMB</span>

    <!-- Breadcrumb & Tiêu đề -->
    <div>
        <nav class="flex items-center text-[12px] text-[#6B7280] space-x-1.5 mb-1.5">
            <span>Quản trị</span>
            <span>/</span>
            <a href="{{ route('invoices.index') }}" class="hover:text-[#0E4D3C]">Hóa đơn</a>
            <span>/</span>
            <span class="text-[#111827] font-medium">Xem & in</span>
        </nav>
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Xem & in hóa đơn A4
        </h1>
    </div>

    <!-- Bố cục 2 cột: Khung bản in A4 bên trái + Thẻ hành động bên phải -->
    <div class="flex flex-col lg:flex-row items-start gap-6 pt-2">
        <!-- Khung bản in A4 -->
        <div class="w-full lg:w-[620px] bg-white border border-[#E5E7EB] rounded-[14px] p-8 shadow-none space-y-6 text-[#111827]" id="printArea">
            <!-- Header Hóa đơn -->
            <div class="border-b border-[#E5E7EB] pb-5">
                <span class="block text-[11px] font-bold text-[#6B7280] tracking-wider uppercase">
                    GGMB RESIDENCE - TÒA A
                </span>
                <h2 class="text-[24px] font-bold text-[#0E4D3C] mt-1">
                    THÔNG BÁO PHÍ
                </h2>
                <div class="mt-2 text-[13px] text-[#6B7280] space-y-0.5">
                    <p>Hóa đơn: <strong>#{{ $invoice->id ?? 1 }}</strong> · Căn hộ: <strong>{{ $invoice->apartment ?? '0101' }}</strong></p>
                    <p>Kỳ phí: <strong>{{ $invoice->period ?? '01/2026' }}</strong> · Hạn: <strong>{{ $invoice->due_date ?? '10/02/2026' }}</strong></p>
                </div>
                <div class="mt-3">
                    @if (($invoice->status ?? '') === 'PAID')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] text-xs font-semibold bg-[#E4EFE9] text-[#0E4D3C]">
                            Đã thanh toán
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] text-xs font-semibold bg-[#FFF4DB] text-[#8F5316]">
                            {{ $invoice->status_label ?? 'Chờ thanh toán' }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Bảng chi tiết các khoản thu -->
            <div class="border border-[#E5E7EB] rounded-[8px] overflow-hidden">
                <div class="bg-[#F2F6F4] border-b border-[#E5E7EB] flex h-[38px] items-center text-[12px] font-semibold text-[#374151] px-4">
                    <div class="w-[180px]">Khoản thu</div>
                    <div class="w-[70px] text-center">SL</div>
                    <div class="w-[110px] text-right">Đơn giá</div>
                    <div class="flex-1 text-right">Thành tiền</div>
                </div>

                @foreach ($invoice->items as $item)
                    <div class="flex h-[42px] items-center text-[13px] border-b last:border-b-0 border-[#E5E7EB] px-4">
                        <div class="w-[180px] font-medium text-[#111827]">{{ $item['name'] }}</div>
                        <div class="w-[70px] text-center font-mono">{{ $item['qty'] }}</div>
                        <div class="w-[110px] text-right font-mono">{{ number_format($item['price'], 0, ',', '.') }}</div>
                        <div class="flex-1 text-right font-mono font-semibold">{{ number_format($item['total'], 0, ',', '.') }}</div>
                    </div>
                @endforeach
            </div>

            <!-- Tổng cộng tiền -->
            <div class="flex items-center justify-between border-t-2 border-[#0E4D3C] pt-4">
                <span class="text-[14px] font-bold uppercase tracking-wider text-[#111827]">
                    TỔNG CỘNG
                </span>
                <span class="text-[22px] font-bold text-[#0E4D3C] font-mono">
                    {{ number_format($invoice->total_amount ?? 842500, 0, ',', '.') }} đ
                </span>
            </div>

            <!-- Hướng dẫn thanh toán & Thông tin người lập -->
            <div class="pt-4 border-t border-[#E5E7EB] flex items-center gap-4">
                <div class="w-16 h-16 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] flex items-center justify-center text-xs font-semibold text-[#0E4D3C] shrink-0">
                    QR Pay
                </div>
                <div class="text-[12px] leading-[18px] text-[#6B7280]">
                    <p class="font-semibold text-[#111827]">Thanh toán tại quầy ban quản lý</p>
                    <p>Giữ mã hóa đơn để đối chiếu khi thanh toán.</p>
                </div>
            </div>

            <div class="text-[12px] text-[#6B7280] pt-2">
                Người lập: <span class="font-medium text-[#111827]">{{ $invoice->creator ?? 'Nguyễn Minh Quản lý' }}</span>
            </div>

            <div class="text-right text-[11px] text-[#9CA3AF] pt-2">
                A4 · Bản xem trước · Trang 1/1
            </div>
        </div>

        <!-- Thẻ hành động bên phải -->
        <div class="w-full lg:w-[460px] bg-white border border-[#E5E7EB] rounded-[14px] p-6 space-y-4 shrink-0 shadow-none">
            <div>
                <span class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase">
                    HÀNH ĐỘNG / BẢN IN
                </span>
                <h3 class="text-[18px] font-bold text-[#111827] mt-1">
                    Thông báo phí của căn {{ $invoice->apartment ?? '0101' }}
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-1">
                    Xem chi tiết các khoản thu; bản in không xác nhận đã nhận tiền.
                </p>
            </div>

            <div class="pt-4 space-y-3">
                <button
                    type="button"
                    onclick="window.print()"
                    class="w-full h-[40px] bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors flex items-center justify-center cursor-pointer shadow-sm"
                >
                    In / lưu PDF
                </button>
                <a
                    href="{{ route('invoices.index') }}"
                    class="w-full h-[40px] bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-semibold rounded-[8px] transition-colors flex items-center justify-center cursor-pointer"
                >
                    Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
