@extends('layouts.portal', [
    'title' => 'Hóa đơn & thanh toán · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'invoices'
])

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-[26px] font-semibold text-[#122d40] leading-tight">
            Hóa đơn & thanh toán
        </h1>
        <p class="mt-1 text-[14px] text-[#52697c]">
            Căn 0101 · 2 hóa đơn chờ thanh toán · Công nợ: 1.685.000 đ · Chỉ xem hóa đơn thuộc căn hộ của bạn.
        </p>
    </div>

    <!-- Main 2-column layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Pane (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Selector Box -->
            <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-5 shadow-sm">
                <span class="block text-[12px] font-semibold text-[#52697c] tracking-wider uppercase mb-3">
                    CHỌN HÓA ĐƠN CỦA CĂN 0101
                </span>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="invoiceTabs">
                    <button type="button" onclick="switchInvoice(1)" id="tab-inv-1" class="text-left px-4 py-2.5 rounded-[4px] border-2 border-[#2864AD] bg-white text-[#122d40] font-medium text-[13px] shadow-sm transition-all">
                        #1 · 01/2026 · Chờ thanh toán
                    </button>
                    <button type="button" onclick="switchInvoice(21)" id="tab-inv-21" class="text-left px-4 py-2.5 rounded-[4px] border border-[#d9e4ec] bg-[#f8fafc] text-[#52697c] font-medium text-[13px] hover:bg-white transition-all">
                        #21 · 02/2026 · Chờ thanh toán
                    </button>
                </div>
            </div>

            <!-- Invoice Details Card -->
            <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 shadow-sm space-y-6">
                <!-- Invoice Header -->
                <div>
                    <h2 class="text-[18px] font-bold text-[#122d40] tracking-wide" id="invTitle">
                        THÔNG BÁO PHÍ · 01/2026
                    </h2>
                    <div class="text-[13px] text-[#52697c] mt-1" id="invSubtitle">
                        GGMB Residence · Tòa A<br>
                        Căn 0101 · Hóa đơn #1 · Người xem: Nguyễn An
                    </div>
                </div>

                <!-- Due date & Status row -->
                <div class="flex items-center justify-between border-t border-b border-[#d9e4ec] py-3 text-[13px]">
                    <div>
                        <span class="text-[#52697c]">Hạn thanh toán:</span>
                        <span class="font-medium text-[#122d40] ml-1" id="invDueDate">10/02/2026</span>
                    </div>
                    <div class="font-semibold text-amber-600" id="invStatus">
                        Chờ thanh toán
                    </div>
                </div>

                <!-- Table Breakdown -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-[13px] border-collapse">
                        <thead>
                            <tr class="bg-[#f0f4f8] text-[#334b5d] font-semibold border-b border-[#d9e4ec]">
                                <th class="py-2.5 px-4">Khoản phí</th>
                                <th class="py-2.5 px-4 text-center">Số lượng</th>
                                <th class="py-2.5 px-4 text-right">Đơn giá (đ)</th>
                                <th class="py-2.5 px-4 text-right">Thành tiền (đ)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#d9e4ec] text-[#334b5d]" id="invItems">
                            <tr>
                                <td class="py-3 px-4 font-medium text-[#122d40]">Điện (kWh)</td>
                                <td class="py-3 px-4 text-center">35</td>
                                <td class="py-3 px-4 text-right">3.500</td>
                                <td class="py-3 px-4 text-right">122.500</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-medium text-[#122d40]">Phí quản lý (m²)</td>
                                <td class="py-3 px-4 text-center">60</td>
                                <td class="py-3 px-4 text-right">12.000</td>
                                <td class="py-3 px-4 text-right">720.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Total Amount Area -->
                <div class="flex flex-col items-end pt-4 border-t border-[#d9e4ec] space-y-1">
                    <div class="flex items-baseline space-x-4">
                        <span class="text-[13px] font-bold text-[#122d40] uppercase tracking-wider">TỔNG CỘNG</span>
                        <span class="text-[26px] font-bold text-[#122d40]" id="invTotal">842.500 đ</span>
                    </div>
                    <div class="text-[12px] text-[#52697c]">
                        Chưa ghi nhận thanh toán
                    </div>
                </div>
            </div>

            <!-- Tip Notice Box -->
            <div class="p-4 border border-dashed border-[#d9e4ec] bg-[#f8fafc] rounded-[4px] text-[13px] text-[#52697c]">
                Đối chiếu sản lượng, số lượng và đơn giá; gửi yêu cầu hỗ trợ nếu có sai lệch.
            </div>
        </div>

        <!-- Right Pane: Payment (1/3) -->
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 shadow-sm space-y-6">
                <div>
                    <h2 class="text-[15px] font-semibold text-[#122d40] uppercase tracking-wide">
                        THANH TOÁN
                    </h2>
                </div>

                <!-- Placeholder Payment Methods Box -->
                <div class="w-full aspect-[4/3] bg-[#f0f4f8] border border-[#d9e4ec] rounded-[4px] flex items-center justify-center p-6 text-center">
                    <span class="text-[15px] font-semibold text-[#52697c] tracking-wider uppercase">
                        TIỀN MẶT /<br>CHUYỂN KHOẢN
                    </span>
                </div>

                <div class="text-[13px] text-[#52697c] text-center">
                    Thanh toán với ban quản lý
                </div>

                <div>
                    <button type="button" onclick="openPaymentModal()" class="w-full py-3 px-4 bg-[#0d766e] hover:bg-[#0f605a] text-white font-medium text-[14px] rounded-[4px] shadow-sm transition-colors cursor-pointer text-center">
                        Thanh toán trực tiếp
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hướng dẫn thanh toán trực tiếp -->
<div id="paymentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
    <div class="bg-white rounded-[4px] shadow-xl border border-[#d9e4ec] max-w-md w-full mx-4 p-6 space-y-5 animate-in fade-in duration-200">
        <div class="flex items-center justify-between border-b border-[#d9e4ec] pb-3">
            <h3 class="text-[16px] font-bold text-[#122d40]">Thông tin thanh toán trực tiếp</h3>
            <button type="button" onclick="closePaymentModal()" class="text-slate-400 hover:text-slate-700 text-xl font-bold">&times;</button>
        </div>

        <div class="space-y-3 text-[13px] text-[#334b5d]">
            <p class="font-medium text-[#122d40]">Quý cư dân có thể lựa chọn 1 trong 2 hình thức:</p>
            <div class="p-3 bg-[#f8fafc] border border-[#d9e4ec] rounded space-y-1.5">
                <div class="font-semibold text-[#122d40]">1. Thanh toán tiền mặt:</div>
                <div class="text-[#52697c]">Tại Văn phòng Ban quản lý chung cư GGMB (Tầng 1 - Tòa A). Giờ làm việc: 08:00 - 17:30 các ngày trong tuần.</div>
            </div>
            <div class="p-3 bg-[#f8fafc] border border-[#d9e4ec] rounded space-y-1.5">
                <div class="font-semibold text-[#122d40]">2. Chuyển khoản ngân hàng:</div>
                <div class="text-[#52697c]">
                    Ngân hàng: <strong>Vietcombank</strong><br>
                    Số tài khoản: <strong>0123 4567 8900</strong><br>
                    Chủ tài khoản: <strong>BAN QUẢN LÝ CHUNG CƯ GGMB</strong><br>
                    Cú pháp: <span class="font-mono bg-white px-2 py-0.5 border rounded text-[#2864ad]">CAN0101 THANHTOAN</span>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-2">
            <button type="button" onclick="confirmPaymentRequest()" class="px-5 py-2.5 bg-[#0d766e] hover:bg-[#0f605a] text-white text-[13px] font-medium rounded-[4px] cursor-pointer">
                Đã gửi thanh toán / Xác nhận
            </button>
        </div>
    </div>
</div>

<script>
    const invoicesData = {
        1: {
            title: 'THÔNG BÁO PHÍ · 01/2026',
            sub: 'GGMB Residence · Tòa A<br>Căn 0101 · Hóa đơn #1 · Người xem: Nguyễn An',
            due: '10/02/2026',
            total: '842.500 đ',
            items: `
                <tr>
                    <td class="py-3 px-4 font-medium text-[#122d40]">Điện (kWh)</td>
                    <td class="py-3 px-4 text-center">35</td>
                    <td class="py-3 px-4 text-right">3.500</td>
                    <td class="py-3 px-4 text-right">122.500</td>
                </tr>
                <tr>
                    <td class="py-3 px-4 font-medium text-[#122d40]">Phí quản lý (m²)</td>
                    <td class="py-3 px-4 text-center">60</td>
                    <td class="py-3 px-4 text-right">12.000</td>
                    <td class="py-3 px-4 text-right">720.000</td>
                </tr>
            `
        },
        21: {
            title: 'THÔNG BÁO PHÍ · 02/2026',
            sub: 'GGMB Residence · Tòa A<br>Căn 0101 · Hóa đơn #21 · Người xem: Nguyễn An',
            due: '10/03/2026',
            total: '842.500 đ',
            items: `
                <tr>
                    <td class="py-3 px-4 font-medium text-[#122d40]">Điện (kWh)</td>
                    <td class="py-3 px-4 text-center">35</td>
                    <td class="py-3 px-4 text-right">3.500</td>
                    <td class="py-3 px-4 text-right">122.500</td>
                </tr>
                <tr>
                    <td class="py-3 px-4 font-medium text-[#122d40]">Phí quản lý (m²)</td>
                    <td class="py-3 px-4 text-center">60</td>
                    <td class="py-3 px-4 text-right">12.000</td>
                    <td class="py-3 px-4 text-right">720.000</td>
                </tr>
            `
        }
    };

    function switchInvoice(id) {
        const inv = invoicesData[id];
        if (!inv) return;

        document.getElementById('invTitle').innerHTML = inv.title;
        document.getElementById('invSubtitle').innerHTML = inv.sub;
        document.getElementById('invDueDate').innerText = inv.due;
        document.getElementById('invTotal').innerText = inv.total;
        document.getElementById('invItems').innerHTML = inv.items;

        const tab1 = document.getElementById('tab-inv-1');
        const tab21 = document.getElementById('tab-inv-21');

        if (id === 1) {
            tab1.className = 'text-left px-4 py-2.5 rounded-[4px] border-2 border-[#2864AD] bg-white text-[#122d40] font-medium text-[13px] shadow-sm transition-all';
            tab21.className = 'text-left px-4 py-2.5 rounded-[4px] border border-[#d9e4ec] bg-[#f8fafc] text-[#52697c] font-medium text-[13px] hover:bg-white transition-all';
        } else {
            tab21.className = 'text-left px-4 py-2.5 rounded-[4px] border-2 border-[#2864AD] bg-white text-[#122d40] font-medium text-[13px] shadow-sm transition-all';
            tab1.className = 'text-left px-4 py-2.5 rounded-[4px] border border-[#d9e4ec] bg-[#f8fafc] text-[#52697c] font-medium text-[13px] hover:bg-white transition-all';
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
