@extends('layouts.portal', [
    'title' => 'Hóa đơn & thanh toán · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'invoices'
])

@section('content')
<div class="space-y-8 sm:space-y-10">
    <!-- Header Title & Subtitle -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="text-[12.5px] font-semibold text-[#6B7280] mb-1.5 flex items-center gap-1.5">
                <span>Cổng cư dân</span>
                <span>/</span>
                <span class="text-[#111827]">Tòa A</span>
            </div>
            <h1 class="text-[26px] font-bold text-[#111827] tracking-tight">
                Hóa đơn và thanh toán
            </h1>
            <span class="sr-only">Hóa đơn & thanh toán</span>
            <p class="mt-1.5 text-[13.5px] text-[#6B7280]">
                Căn 0101 · 2 hóa đơn chờ thanh toán · Công nợ: 1.685.000 đ · Chỉ xem hóa đơn thuộc căn hộ của bạn.
            </p>
        </div>

        <button type="button" onclick="openPaymentModal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[10px] shadow-xs transition-colors cursor-pointer shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <span>Hướng dẫn thanh toán</span>
        </button>
    </div>

    <!-- Outstanding Balance Card -->
    <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-7 sm:p-8 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11.5px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    Chờ thanh toán
                </span>
                <span class="text-[13px] font-medium text-[#6B7280]">Công nợ căn 0101</span>
            </div>
            <div class="text-[30px] sm:text-[34px] font-black text-[#111827] mt-2 tracking-tight font-mono">
                1.685.000 đ
            </div>
            <div class="text-[13px] text-[#6B7280] mt-1">
                Bao gồm 2 hóa đơn chưa thanh toán (Kỳ 01/2026 và 02/2026)
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" onclick="openPaymentModal()" class="px-5 py-2.5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white font-semibold text-[13px] rounded-[10px] shadow-xs transition-colors cursor-pointer">
                Thanh toán ngay
            </button>
        </div>
    </div>

    <!-- Period Tabs -->
    <div class="flex items-center space-x-2 border-b border-[#E5E7EB] pb-4 pt-1" id="invoiceTabs">
        <span class="text-[12.5px] font-semibold text-[#6B7280] mr-2">Chọn kỳ phí:</span>
        <button type="button" onclick="switchInvoice(1)" id="tab-inv-1" class="px-4 py-2 rounded-[10px] border border-[#0E4D3C] bg-[#E4EFE9] text-[#0E4D3C] font-bold text-[13px] shadow-2xs transition-all cursor-pointer flex items-center gap-2">
            <span>#1 · 01/2026</span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#0E4D3C]"></span>
        </button>
        <button type="button" onclick="switchInvoice(21)" id="tab-inv-21" class="px-4 py-2 rounded-[10px] border border-transparent bg-white text-[#6B7280] hover:text-[#111827] hover:border-[#E5E7EB] font-medium text-[13px] transition-all cursor-pointer flex items-center gap-2">
            <span>#21 · 02/2026</span>
        </button>
    </div>

    <!-- Main 2-column layout -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
        <!-- Left: Thông báo phí (8 cols on xl) -->
        <div class="xl:col-span-8 bg-white border border-[#E5E7EB] rounded-[18px] p-6 sm:p-8 shadow-xs">
            <!-- Invoice Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 sm:pb-7 border-b border-[#F3F4F6] gap-4">
                <div>
                    <div class="text-[12px] font-bold text-[#0E4D3C] uppercase tracking-wider">
                        GGMB RESIDENCE / TÒA A
                    </div>
                    <h2 class="text-[24px] font-bold text-[#111827] mt-1.5 tracking-tight" id="invMainTitle">
                        THÔNG BÁO PHÍ
                    </h2>
                    <span class="sr-only">THÔNG BÁO PHÍ · 01/2026</span>
                    <div class="text-[13px] text-[#6B7280] mt-1.5" id="invSubtitle">
                        Hóa đơn #1 · Kỳ phí 01/2026 · Hạn 10/02/2026
                    </div>
                </div>

                <div class="sm:text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/60" id="invStatusBadge">
                        Chờ thanh toán
                    </span>
                    <div class="font-semibold text-[13.5px] text-[#111827] mt-2">
                        Căn hộ 0101 · Nguyễn Văn An
                    </div>
                </div>
            </div>

            <!-- Items Table Breakdown -->
            <div class="py-6 sm:py-7 border-b border-[#F3F4F6] space-y-4" id="invItemsContainer">
                <div class="flex items-center justify-between p-5 rounded-[12px] bg-[#F8FAF8] border border-[#E5E7EB]/60">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-[14px] text-[#111827]">Điện sinh hoạt</span>
                            <span class="text-[11px] font-semibold text-emerald-800 bg-[#E4EFE9] px-2 py-0.5 rounded">Điện năng</span>
                        </div>
                        <div class="text-[12.5px] text-[#6B7280] mt-1 font-mono">35 kWh × 3.500 đ = 122.500 đ</div>
                    </div>
                    <div class="font-bold text-[15px] text-[#111827] font-mono">
                        122.500 đ
                    </div>
                </div>

                <div class="flex items-center justify-between p-5 rounded-[12px] bg-[#F8FAF8] border border-[#E5E7EB]/60">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-[14px] text-[#111827]">Phí quản lý căn hộ</span>
                            <span class="text-[11px] font-semibold text-sky-800 bg-sky-50 px-2 py-0.5 rounded">Dịch vụ tòa nhà</span>
                        </div>
                        <div class="text-[12.5px] text-[#6B7280] mt-1 font-mono">60 m² × 12.000 đ = 720.000 đ</div>
                    </div>
                    <div class="font-bold text-[15px] text-[#111827] font-mono">
                        720.000 đ
                    </div>
                </div>
            </div>

            <!-- Total Amount Section -->
            <div class="pt-6 sm:pt-7 flex flex-col sm:flex-row sm:items-end justify-between gap-5">
                <div>
                    <div class="text-[12.5px] font-semibold text-[#6B7280] uppercase tracking-wider">Tổng cộng kỳ thanh toán</div>
                    <div class="text-[32px] font-black text-[#0E4D3C] mt-1.5 font-mono tracking-tight" id="invTotal">
                        842.500 đ
                    </div>
                    <p class="text-[12px] text-[#9CA3AF] mt-2 italic">
                        * Thông báo phí không phải hóa đơn thuế và không xác nhận đã nhận tiền.
                    </p>
                </div>

                <div class="text-[12.5px] text-[#6B7280] bg-[#F8FAF8] px-4 py-2.5 rounded-[10px] border border-[#E5E7EB] shrink-0">
                    Người lập biểu: <strong class="text-[#111827]">Nguyễn Minh Quản lý</strong>
                </div>
            </div>
        </div>

        <!-- Right: Thanh toán với ban quản lý (4 cols on xl) -->
        <div class="xl:col-span-4 space-y-6">
            <!-- Box hướng dẫn chuyển khoản -->
            <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-6 sm:p-7 shadow-xs space-y-5">
                <div class="flex items-center gap-2.5 pb-4 border-b border-[#F3F4F6]">
                    <div class="w-8 h-8 rounded-[8px] bg-[#E4EFE9] text-[#0E4D3C] flex items-center justify-center font-bold">
                        <svg class="w-4 h-4 text-[#0E4D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <h3 class="text-[15px] font-bold text-[#111827]">
                        Thanh toán với ban quản lý
                    </h3>
                </div>

                <p class="text-[12.5px] text-[#6B7280] leading-relaxed">
                    Quý cư dân chuyển khoản theo thông tin bên dưới hoặc đóng tiền mặt tại văn phòng BQL.
                </p>

                <!-- Bank Info Box -->
                <div class="p-4.5 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[12px] space-y-3 text-[12.5px]">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-[#6B7280]">
                        <span class="text-[12px]">Ngân hàng:</span>
                        <strong class="text-[#111827] sm:text-right">Vietcombank (VCB)</strong>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-[#6B7280]">
                        <span class="text-[12px]">Số tài khoản:</span>
                        <strong class="text-[#0E4D3C] font-mono text-[14px]">0123 4567 8900</strong>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-[#6B7280]">
                        <span class="text-[12px]">Chủ tài khoản:</span>
                        <strong class="text-[#111827] sm:text-right break-words">BAN QUẢN LÝ CHUNG CƯ GGMB</strong>
                    </div>
                    <div class="pt-2.5 border-t border-[#E5E7EB] flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-[#6B7280]">
                        <span class="text-[12px]">Nội dung CK:</span>
                        <span class="font-mono bg-white px-2 py-0.5 border border-[#B8D5C7] rounded text-[#0E4D3C] font-bold self-start sm:self-auto">
                            CAN0101 HD1
                        </span>
                    </div>
                </div>

                <div class="space-y-3 pt-2">
                    <button type="button" onclick="openPaymentModal()" class="w-full py-2.5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-center text-[13px] font-semibold rounded-[10px] transition-colors cursor-pointer shadow-xs">
                        Gửi yêu cầu đối chiếu
                    </button>
                    <button type="button" onclick="openPaymentModal()" class="w-full py-2.5 bg-white hover:bg-[#F8FAF8] border border-[#E5E7EB] text-[#374151] text-center text-[13px] font-semibold rounded-[10px] transition-colors cursor-pointer">
                        Thanh toán trực tiếp
                    </button>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-5.5 shadow-xs space-y-2.5">
                <a href="{{ route('portal.tickets') }}" class="flex items-center justify-between p-2.5 rounded-[10px] hover:bg-[#F8FAF8] text-[13px] font-medium text-[#374151] hover:text-[#0E4D3C] transition-colors">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#0E4D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Thắc mắc về chỉ số điện nước?
                    </span>
                    <span>→</span>
                </a>
                <a href="{{ route('portal.dashboard') }}" class="flex items-center justify-between p-2.5 rounded-[10px] hover:bg-[#F8FAF8] text-[13px] font-medium text-[#374151] hover:text-[#0E4D3C] transition-colors">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#0E4D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Quay về Trang chủ Cư dân
                    </span>
                    <span>→</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hướng dẫn thanh toán trực tiếp / Đối chiếu -->
<div id="paymentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-[#000000]/40 backdrop-blur-xs hidden">
    <div class="bg-white rounded-[20px] shadow-2xl border border-[#E5E7EB] max-w-md w-full mx-4 overflow-hidden transform transition-all animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB]">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-[#E4EFE9] text-[#0E4D3C] flex items-center justify-center font-bold text-xs">
                    <svg class="w-4 h-4 text-[#0E4D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3 class="text-[15px] font-bold text-[#111827]">Thông tin thanh toán trực tiếp</h3>
            </div>
            <button type="button" onclick="closePaymentModal()" class="text-[#6B7280] hover:text-[#111827] text-2xl font-bold cursor-pointer leading-none">&times;</button>
        </div>

        <div class="p-6 space-y-3.5 text-[13px] text-[#374151]">
            <p class="font-medium text-[#111827]">Quý cư dân có thể lựa chọn 1 trong 2 hình thức:</p>
            <div class="p-4 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[12px] space-y-1">
                <div class="font-bold text-[#111827]">
                    1. Thanh toán tiền mặt:
                </div>
                <div class="text-[#6B7280] text-[12.5px] leading-relaxed">
                    Tại Văn phòng Ban quản lý chung cư GGMB (Tầng 1 - Tòa A). Giờ làm việc: 08:00 - 17:30 các ngày từ thứ 2 đến thứ 7.
                </div>
            </div>

            <div class="p-4 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[12px] space-y-1.5">
                <div class="font-bold text-[#111827]">
                    2. Chuyển khoản ngân hàng:
                </div>
                <div class="text-[#6B7280] text-[12.5px] space-y-1">
                    <div>Ngân hàng: <strong class="text-[#111827]">Vietcombank (VCB)</strong></div>
                    <div>Số tài khoản: <strong class="text-[#0E4D3C] font-mono text-[13px]">0123 4567 8900</strong></div>
                    <div>Chủ tài khoản: <strong class="text-[#111827]">BAN QUẢN LÝ CHUNG CƯ GGMB</strong></div>
                    <div>Cú pháp: <span class="font-mono bg-white px-2 py-0.5 border border-[#B8D5C7] rounded text-[#0E4D3C] font-bold">CAN0101 THANHTOAN</span></div>
                </div>
            </div>
        </div>

        <div class="flex justify-end px-6 py-4 border-t border-[#E5E7EB] bg-white gap-2.5">
            <button type="button" onclick="closePaymentModal()" class="px-4 py-2 border border-[#E5E7EB] bg-white hover:bg-[#F8FAF8] text-[#374151] text-[13px] font-semibold rounded-[8px] cursor-pointer">
                Đóng
            </button>
            <button type="button" onclick="confirmPaymentRequest()" class="px-5 py-2 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[8px] cursor-pointer shadow-xs">
                Đã gửi thanh toán / Xác nhận
            </button>
        </div>
    </div>
</div>

<script>
    const invoicesData = {
        1: {
            sub: 'Hóa đơn #1 · Kỳ phí 01/2026 · Hạn 10/02/2026',
            items: `
                <div class="flex items-center justify-between p-5 rounded-[12px] bg-[#F8FAF8] border border-[#E5E7EB]/60">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-[14px] text-[#111827]">Điện sinh hoạt</span>
                            <span class="text-[11px] font-semibold text-emerald-800 bg-[#E4EFE9] px-2 py-0.5 rounded">Điện năng</span>
                        </div>
                        <div class="text-[12.5px] text-[#6B7280] mt-1 font-mono">35 kWh × 3.500 đ = 122.500 đ</div>
                    </div>
                    <div class="font-bold text-[15px] text-[#111827] font-mono">122.500 đ</div>
                </div>
                <div class="flex items-center justify-between p-5 rounded-[12px] bg-[#F8FAF8] border border-[#E5E7EB]/60">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-[14px] text-[#111827]">Phí quản lý căn hộ</span>
                            <span class="text-[11px] font-semibold text-sky-800 bg-sky-50 px-2 py-0.5 rounded">Dịch vụ tòa nhà</span>
                        </div>
                        <div class="text-[12.5px] text-[#6B7280] mt-1 font-mono">60 m² × 12.000 đ = 720.000 đ</div>
                    </div>
                    <div class="font-bold text-[15px] text-[#111827] font-mono">720.000 đ</div>
                </div>
            `,
            total: '842.500 đ'
        },
        21: {
            sub: 'Hóa đơn #21 · Kỳ phí 02/2026 · Hạn 10/03/2026',
            items: `
                <div class="flex items-center justify-between p-5 rounded-[12px] bg-[#F8FAF8] border border-[#E5E7EB]/60">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-[14px] text-[#111827]">Điện sinh hoạt</span>
                            <span class="text-[11px] font-semibold text-emerald-800 bg-[#E4EFE9] px-2 py-0.5 rounded">Điện năng</span>
                        </div>
                        <div class="text-[12.5px] text-[#6B7280] mt-1 font-mono">35 kWh × 3.500 đ = 122.500 đ</div>
                    </div>
                    <div class="font-bold text-[15px] text-[#111827] font-mono">122.500 đ</div>
                </div>
                <div class="flex items-center justify-between p-5 rounded-[12px] bg-[#F8FAF8] border border-[#E5E7EB]/60">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-[14px] text-[#111827]">Phí quản lý căn hộ</span>
                            <span class="text-[11px] font-semibold text-sky-800 bg-sky-50 px-2 py-0.5 rounded">Dịch vụ tòa nhà</span>
                        </div>
                        <div class="text-[12.5px] text-[#6B7280] mt-1 font-mono">60 m² × 12.000 đ = 720.000 đ</div>
                    </div>
                    <div class="font-bold text-[15px] text-[#111827] font-mono">720.000 đ</div>
                </div>
            `,
            total: '842.500 đ'
        }
    };

    function switchInvoice(id) {
        const inv = invoicesData[id];
        if (!inv) return;

        document.getElementById('invSubtitle').innerText = inv.sub;
        document.getElementById('invItemsContainer').innerHTML = inv.items;
        document.getElementById('invTotal').innerText = inv.total;

        const tab1 = document.getElementById('tab-inv-1');
        const tab21 = document.getElementById('tab-inv-21');

        if (id === 1) {
            tab1.className = 'px-4 py-2 rounded-[10px] border border-[#0E4D3C] bg-[#E4EFE9] text-[#0E4D3C] font-bold text-[13px] shadow-2xs transition-all cursor-pointer flex items-center gap-2';
            tab21.className = 'px-4 py-2 rounded-[10px] border border-transparent bg-white text-[#6B7280] hover:text-[#111827] hover:border-[#E5E7EB] font-medium text-[13px] transition-all cursor-pointer flex items-center gap-2';
        } else {
            tab21.className = 'px-4 py-2 rounded-[10px] border border-[#0E4D3C] bg-[#E4EFE9] text-[#0E4D3C] font-bold text-[13px] shadow-2xs transition-all cursor-pointer flex items-center gap-2';
            tab1.className = 'px-4 py-2 rounded-[10px] border border-transparent bg-white text-[#6B7280] hover:text-[#111827] hover:border-[#E5E7EB] font-medium text-[13px] transition-all cursor-pointer flex items-center gap-2';
        }
    }

    function openPaymentModal() {
        document.getElementById('paymentModal').classList.remove('hidden');
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
    }

    function confirmPaymentRequest() {
        closePaymentModal();
        if (window.showToast) {
            window.showToast('Đã gửi thông tin thanh toán! Ban quản lý sẽ đối soát và cập nhật trạng thái trong 24h.');
        }
    }
</script>
@endsection
