@extends('layouts.app', [
    'title' => 'Xem & in hóa đơn A4 · GGMB',
    'active' => 'invoices',
    'breadcrumbs' => ['GGMB', 'Hóa đơn', 'Xem & in']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    <!-- Tiêu đề (Bám sát Ảnh 8) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
            Xem & in hóa đơn A4
        </h1>
    </div>

    <!-- Bố cục 2 cột: Khung bản in A4 bên trái + Thẻ hành động bên phải -->
    <div class="flex flex-col lg:flex-row items-start gap-8 pt-2">
        <!-- Khung bản in A4 (Tỷ lệ và bố cục chuẩn giấy in A4) -->
        <div class="w-full lg:w-[620px] bg-white border border-[#d9e4ec] rounded-[4px] p-8 shadow-sm space-y-6 text-[#122d40]" id="printArea">
            <!-- Header Hóa đơn -->
            <div class="border-b border-[#d9e4ec] pb-5">
                <span class="block text-[11px] font-bold text-slate-400 tracking-wider uppercase">
                    GGMB RESIDENCE - TÒA A
                </span>
                <h2 class="text-[24px] font-bold text-[#122d40] mt-1">
                    THÔNG BÁO PHÍ
                </h2>
                <div class="mt-2 text-[13px] text-[#52697c] space-y-0.5">
                    <p>Hóa đơn: <strong>#{{ $invoice->id ?? 1 }}</strong> · Căn hộ: <strong>{{ $invoice->apartment ?? '0101' }}</strong></p>
                    <p>Kỳ phí: <strong>{{ $invoice->period ?? '01/2026' }}</strong> · Hạn: <strong>{{ $invoice->due_date ?? '10/02/2026' }}</strong></p>
                </div>
                <div class="mt-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold bg-[#fff8e6] text-[#b37400]">
                        {{ $invoice->status_label ?? 'Chờ thanh toán' }}
                    </span>
                </div>
            </div>

            <!-- Bảng chi tiết các khoản thu -->
            <div class="border border-[#d9e4ec] rounded-[2px] overflow-hidden">
                <div class="bg-[#f8fafc] border-b border-[#d9e4ec] flex h-[36px] items-center text-[12px] font-semibold text-[#334b5d] px-3">
                    <div class="w-[180px]">Khoản thu</div>
                    <div class="w-[70px] text-center">SL</div>
                    <div class="w-[110px] text-right">Đơn giá</div>
                    <div class="flex-1 text-right">Thành tiền</div>
                </div>

                @foreach ($invoice->items as $item)
                    <div class="flex h-[42px] items-center text-[13px] border-b last:border-b-0 border-[#d9e4ec] px-3">
                        <div class="w-[180px] font-medium text-[#122d40]">{{ $item['name'] }}</div>
                        <div class="w-[70px] text-center font-mono">{{ $item['qty'] }}</div>
                        <div class="w-[110px] text-right font-mono">{{ number_format($item['price'], 0, ',', '.') }}</div>
                        <div class="flex-1 text-right font-mono font-semibold">{{ number_format($item['total'], 0, ',', '.') }}</div>
                    </div>
                @endforeach
            </div>

            <!-- Tổng cộng tiền -->
            <div class="flex items-center justify-between border-t-2 border-[#122d40] pt-4">
                <span class="text-[14px] font-bold uppercase tracking-wider text-[#122d40]">
                    TỔNG CỘNG
                </span>
                <span class="text-[22px] font-bold text-[#122d40] font-mono">
                    {{ number_format($invoice->total_amount ?? 842500, 0, ',', '.') }} đ
                </span>
            </div>

            <!-- Hướng dẫn thanh toán & Thông tin người lập -->
            <div class="pt-4 border-t border-[#d9e4ec] flex items-center gap-4">
                <div class="w-16 h-16 bg-slate-100 border border-[#d9e4ec] flex items-center justify-center text-xs text-slate-400 shrink-0">
                    QR Pay
                </div>
                <div class="text-[12px] leading-[18px] text-[#52697c]">
                    <p class="font-semibold text-[#122d40]">Thanh toán tại quầy ban quản lý</p>
                    <p>Giữ mã hóa đơn để đối chiếu khi thanh toán.</p>
                </div>
            </div>

            <div class="text-[12px] text-[#52697c] pt-2">
                Người lập: <span class="font-medium text-[#122d40]">{{ $invoice->creator ?? 'Nguyễn Minh Quản lý' }}</span>
            </div>

            <div class="text-right text-[11px] text-[#8a9ba8] pt-2">
                A4 · Bản xem trước · Trang 1/1
            </div>
        </div>

        <!-- Thẻ hành động bên phải (Bám sát Ảnh 8) -->
        <div class="w-full lg:w-[460px] bg-white border border-[#d9e4ec] rounded-[4px] p-6 space-y-4 shrink-0 shadow-sm">
            <div>
                <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase">
                    HÀNH ĐỘNG / BẢN IN
                </span>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1">
                    Thông báo phí của căn {{ $invoice->apartment ?? '0101' }}
                </h3>
                <p class="text-[13px] text-[#52697c] mt-1">
                    Xem chi tiết các khoản thu; bản in không xác nhận đã nhận tiền.
                </p>
            </div>

            <div class="pt-4 space-y-3">
                <button
                    type="button"
                    onclick="window.print()"
                    class="w-full h-[42px] bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer shadow-sm"
                >
                    In / lưu PDF
                </button>
                <a
                    href="{{ route('invoices.index') }}"
                    class="w-full h-[42px] bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer"
                >
                    Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
