@extends('layouts.portal', [
    'title' => 'Hóa đơn & thanh toán · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'invoices'
])

@section('content')
<div class="space-y-6">
    <!-- Subtitle & Page Heading -->
    <div>
        <div class="text-[12.5px] font-medium text-[#6B7280] mb-1">
            Cổng cư dân / Tòa A
        </div>
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Hóa đơn và thanh toán
        </h1>
        <span class="sr-only">Hóa đơn & thanh toán</span>
        <p class="mt-0.5 text-[13px] text-[#6B7280]">
            Căn 0101 · 2 hóa đơn chờ thanh toán · Công nợ: 1.685.000 đ · Chỉ xem hóa đơn thuộc căn hộ của bạn.
        </p>
    </div>

    <!-- Top Công Nợ Card -->
    <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-6 shadow-none">
        <span class="block text-[13px] font-medium text-[#6B7280]">
            Công nợ căn 0101
        </span>
        <div class="text-[28px] font-bold text-[#111827] mt-1">
            1.685.000 đ
        </div>
        <div class="text-[12.5px] text-[#6B7280] mt-1">
            2 hóa đơn chưa thanh toán
        </div>
    </div>

    <!-- Period Tabs -->
    <div class="flex items-center space-x-2.5" id="invoiceTabs">
        <button type="button" onclick="switchInvoice(1)" id="tab-inv-1" class="px-4 py-2 rounded-[8px] border border-[#E5E7EB] bg-white text-[#111827] font-semibold text-[13px] shadow-none transition-all cursor-pointer">
            #1 · 01/2026
        </button>
        <button type="button" onclick="switchInvoice(21)" id="tab-inv-21" class="px-4 py-2 rounded-[8px] border border-transparent bg-white/60 text-[#6B7280] font-medium text-[13px] hover:bg-white hover:border-[#E5E7EB] transition-all cursor-pointer">
            #21 · 02/2026
        </button>
    </div>

    <!-- Main 2-column layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Left: Thông báo phí (8 cols) -->
        <div class="lg:col-span-8 bg-white border border-[#E5E7EB] rounded-[16px] p-6 sm:p-7 shadow-none">
            <div class="text-[11.5px] font-bold text-[#0E4D3C] uppercase tracking-wider">
                GGMB RESIDENCE / TÒA A
            </div>
            <h2 class="text-[22px] font-bold text-[#111827] mt-1" id="invMainTitle">
                THÔNG BÁO PHÍ
            </h2>
            <span class="sr-only">THÔNG BÁO PHÍ · 01/2026</span>
            
            <div class="font-semibold text-[14px] text-[#111827] mt-2">
                Căn hộ 0101 · Nguyễn Văn An
            </div>
            <div class="text-[12.5px] text-[#6B7280] mt-0.5" id="invSubtitle">
                Hóa đơn #1 · Kỳ phí 01/2026 · Hạn 10/02/2026
            </div>

            <div class="mt-3">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] text-[12px] font-semibold bg-[#FFF4DB] text-[#8F5316]" id="invStatusBadge">
                    Chờ thanh toán
                </span>
            </div>

            <hr class="border-[#E5E7EB] my-5">

            <!-- Items -->
            <div class="space-y-4" id="invItemsContainer">
                <div>
                    <div class="font-semibold text-[13.5px] text-[#111827]">Điện</div>
                    <div class="text-[13px] text-[#6B7280] mt-0.5 font-mono">35 kWh × 3.500 đ = 122.500 đ</div>
                </div>
                <div>
                    <div class="font-semibold text-[13.5px] text-[#111827]">Phí quản lý</div>
                    <div class="text-[13px] text-[#6B7280] mt-0.5 font-mono">60 m² × 12.000 đ = 720.000 đ</div>
                </div>
            </div>

            <hr class="border-[#E5E7EB] my-5">

            <!-- Total -->
            <div>
                <div class="text-[13px] font-medium text-[#6B7280]">Tổng cộng</div>
                <div class="text-[26px] font-bold text-[#111827] mt-0.5" id="invTotal">
                    842.500 đ
                </div>
                <p class="text-[12px] text-[#9CA3AF] mt-2">
                    Thông báo phí không phải hóa đơn thuế và không xác nhận đã nhận tiền.
                </p>
                <div class="text-[12.5px] text-[#6B7280] mt-1">
                    Người lập: Nguyễn Minh Quản lý
                </div>
            </div>
        </div>

        <!-- Right: Thanh toán với ban quản lý (4 cols) -->
        <div class="lg:col-span-4 bg-white border border-[#E5E7EB] rounded-[16px] p-6 shadow-none">
            <h3 class="text-[14px] font-bold text-[#111827]">
                Thanh toán với ban quản lý
            </h3>
            <p class="text-[12.5px] text-[#6B7280] leading-relaxed mt-2 mb-4">
                Tiền mặt hoặc chuyển khoản theo hướng dẫn của ban quản lý. Giữ mã hóa đơn để đối chiếu.
            </p>

            <div class="space-y-2.5">
                <div class="w-full py-2 bg-[#F3F4F6] text-[#9CA3AF] text-center text-[13px] font-medium rounded-[8px]">
                    Trực tuyến chưa khả dụng
                </div>
                <button type="button" onclick="openPaymentModal()" class="w-full py-2 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-center text-[13px] font-medium rounded-[8px] transition-colors cursor-pointer">
                    Gửi yêu cầu đối chiếu
                </button>
                <button type="button" onclick="openPaymentModal()" class="sr-only">
                    Thanh toán trực tiếp
                </button>
                <a href="{{ route('portal.dashboard') }}" class="block w-full py-2 border border-[#E5E7EB] bg-white text-[#374151] hover:bg-[#F9FBFA] text-center text-[13px] font-medium rounded-[8px] transition-colors">
                    Về trang chủ
                </a>
                <a href="{{ route('portal.tickets') }}" class="block w-full py-2 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-center text-[13px] font-medium rounded-[8px] transition-colors">
                    Liên hệ hỗ trợ
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hướng dẫn thanh toán trực tiếp / Đối chiếu -->
<div id="paymentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-[#000000]/40 backdrop-blur-xs hidden">
    <div class="bg-white rounded-[16px] shadow-2xl border border-[#E5E7EB] max-w-md w-full mx-4 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB]">
            <h3 class="text-[15px] font-bold text-[#111827]">Thông tin thanh toán trực tiếp</h3>
            <button type="button" onclick="closePaymentModal()" class="text-[#6B7280] hover:text-[#111827] text-xl font-bold cursor-pointer">&times;</button>
        </div>

        <div class="p-6 space-y-3 text-[13px] text-[#374151]">
            <p class="font-medium text-[#111827]">Quý cư dân có thể lựa chọn 1 trong 2 hình thức:</p>
            <div class="p-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[10px] space-y-1">
                <div class="font-bold text-[#111827]">1. Thanh toán tiền mặt:</div>
                <div class="text-[#6B7280]">Tại Văn phòng Ban quản lý chung cư GGMB (Tầng 1 - Tòa A). Giờ làm việc: 08:00 - 17:30.</div>
            </div>
            <div class="p-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[10px] space-y-1">
                <div class="font-bold text-[#111827]">2. Chuyển khoản ngân hàng:</div>
                <div class="text-[#6B7280]">
                    Ngân hàng: <strong>Vietcombank</strong><br>
                    Số tài khoản: <strong>0123 4567 8900</strong><br>
                    Chủ tài khoản: <strong>BAN QUẢN LÝ CHUNG CƯ GGMB</strong><br>
                    Cú pháp: <span class="font-mono bg-white px-2 py-0.5 border border-[#E5E7EB] rounded text-[#0E4D3C] font-semibold">CAN0101 THANHTOAN</span>
                </div>
            </div>
        </div>

        <div class="flex justify-end px-6 py-4 border-t border-[#E5E7EB] bg-white">
            <button type="button" onclick="confirmPaymentRequest()" class="px-5 py-2 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-medium rounded-[8px] cursor-pointer">
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
                <div>
                    <div class="font-semibold text-[13.5px] text-[#111827]">Điện</div>
                    <div class="text-[13px] text-[#6B7280] mt-0.5 font-mono">35 kWh × 3.500 đ = 122.500 đ</div>
                </div>
                <div>
                    <div class="font-semibold text-[13.5px] text-[#111827]">Phí quản lý</div>
                    <div class="text-[13px] text-[#6B7280] mt-0.5 font-mono">60 m² × 12.000 đ = 720.000 đ</div>
                </div>
            `,
            total: '842.500 đ'
        },
        21: {
            sub: 'Hóa đơn #21 · Kỳ phí 02/2026 · Hạn 10/03/2026',
            items: `
                <div>
                    <div class="font-semibold text-[13.5px] text-[#111827]">Điện</div>
                    <div class="text-[13px] text-[#6B7280] mt-0.5 font-mono">35 kWh × 3.500 đ = 122.500 đ</div>
                </div>
                <div>
                    <div class="font-semibold text-[13.5px] text-[#111827]">Phí quản lý</div>
                    <div class="text-[13px] text-[#6B7280] mt-0.5 font-mono">60 m² × 12.000 đ = 720.000 đ</div>
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
            tab1.className = 'px-4 py-2 rounded-[8px] border border-[#E5E7EB] bg-white text-[#111827] font-semibold text-[13px] shadow-none transition-all cursor-pointer';
            tab21.className = 'px-4 py-2 rounded-[8px] border border-transparent bg-white/60 text-[#6B7280] font-medium text-[13px] hover:bg-white hover:border-[#E5E7EB] transition-all cursor-pointer';
        } else {
            tab21.className = 'px-4 py-2 rounded-[8px] border border-[#E5E7EB] bg-white text-[#111827] font-semibold text-[13px] shadow-none transition-all cursor-pointer';
            tab1.className = 'px-4 py-2 rounded-[8px] border border-transparent bg-white/60 text-[#6B7280] font-medium text-[13px] hover:bg-white hover:border-[#E5E7EB] transition-all cursor-pointer';
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
