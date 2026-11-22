<!-- Modal Popup: Hủy hóa đơn (Bám sát Ảnh 1) -->
<div
    id="cancelInvoiceModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="cancel-invoice-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Background backdrop -->
    <div
        id="cancelInvoiceBackdrop"
        onclick="closeCancelInvoiceModal()"
        class="fixed inset-0 bg-black/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="cancelInvoicePanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[620px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header (Bám sát Ảnh 1) -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-rose-600 tracking-wider uppercase select-none">
                        XÁC NHẬN
                    </span>
                    <button
                        type="button"
                        onclick="closeCancelInvoiceModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] font-bold text-rose-600 mt-1" id="cancel-invoice-title">
                    Hủy hóa đơn này?
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-1" id="cancelInvoiceSubtitle">
                    Hóa đơn #1 · Căn 0101 · Kỳ 01/2026 · Chờ thanh toán
                </p>
            </div>

            <!-- Modal Form -->
            <form id="cancelInvoiceForm" method="POST" action="" onsubmit="event.preventDefault(); simulateCancelInvoice();">
                @csrf
                <div class="px-6 py-5 space-y-4">
                    <!-- Hàng 1: Tổng tiền hóa đơn & Trạng thái sau xác nhận (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] p-3">
                            <span class="block text-[12px] font-semibold text-[#6B7280] mb-1">
                                Tổng tiền hóa đơn
                            </span>
                            <div id="cancelInvoiceAmount" class="text-[16px] font-bold text-[#111827] font-mono">
                                842.500 đ
                            </div>
                        </div>
                        <div class="bg-rose-50 border border-rose-200 rounded-[8px] p-3">
                            <span class="block text-[12px] font-semibold text-rose-600 mb-1">
                                Trạng thái sau xác nhận
                            </span>
                            <div class="text-[14px] font-bold text-rose-700">
                                Đã hủy
                            </div>
                        </div>
                    </div>

                    <!-- Bảng các khoản phí trên hóa đơn (Bám sát Ảnh 1) -->
                    <div>
                        <span class="block text-[11px] font-bold text-[#6B7280] uppercase tracking-wider mb-2">
                            CÁC KHOẢN PHÍ TRÊN HÓA ĐƠN
                        </span>
                        <div class="border border-[#E5E7EB] rounded-[8px] overflow-hidden">
                            <!-- Table Header -->
                            <div class="bg-[#F2F6F4] border-b border-[#E5E7EB] flex h-[38px] items-center text-[12px] font-semibold text-[#374151]">
                                <div class="flex-1 px-3 border-r border-[#E5E7EB] h-full flex items-center">Khoản phí</div>
                                <div class="w-[90px] px-3 border-r border-[#E5E7EB] h-full flex items-center">Số lượng</div>
                                <div class="w-[110px] px-3 border-r border-[#E5E7EB] h-full flex items-center">Đơn giá</div>
                                <div class="w-[120px] px-3 h-full flex items-center">Thành tiền</div>
                            </div>
                            <!-- Table Body Container -->
                            <div id="cancelInvoiceItemsContainer" class="divide-y divide-[#E5E7EB] text-[13px] text-[#374151]">
                                <div class="flex h-[40px] items-center">
                                    <div class="flex-1 px-3 border-r border-[#E5E7EB] h-full flex items-center font-medium">Điện (kWh)</div>
                                    <div class="w-[90px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-mono">35</div>
                                    <div class="w-[110px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-mono">3.500</div>
                                    <div class="w-[120px] px-3 h-full flex items-center font-semibold font-mono text-[#111827]">122.500</div>
                                </div>
                                <div class="flex h-[40px] items-center">
                                    <div class="flex-1 px-3 border-r border-[#E5E7EB] h-full flex items-center font-medium">Phí quản lý (m²)</div>
                                    <div class="w-[90px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-mono">60</div>
                                    <div class="w-[110px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-mono">12.000</div>
                                    <div class="w-[120px] px-3 h-full flex items-center font-semibold font-mono text-[#111827]">720.000</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer (2 nút: Giữ hóa đơn & Xác nhận hủy - Bám sát Ảnh 1) -->
                <div class="px-6 py-4 bg-[#F2F6F4] border-t border-[#E5E7EB] flex items-center justify-between rounded-b-[16px]">
                    <button
                        type="button"
                        onclick="closeCancelInvoiceModal()"
                        class="h-[38px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Giữ hóa đơn
                    </button>
                    <button
                        type="submit"
                        class="h-[38px] px-6 bg-rose-600 hover:bg-rose-700 text-white text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Xác nhận hủy
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCancelInvoiceModal(idOrData) {
        const data = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.invoicesMap?.[idOrData] || {});
        const modal = document.getElementById('cancelInvoiceModal');
        const backdrop = document.getElementById('cancelInvoiceBackdrop');
        const panel = document.getElementById('cancelInvoicePanel');
        const form = document.getElementById('cancelInvoiceForm');

        if (!modal || !backdrop || !panel) return;

        const id = data.id || 1;
        const apt = data.apartment || '0101';
        const period = data.period || '01/2026';
        const statusLabel = data.status_label || 'Chờ thanh toán';
        const amount = (data.amount || 842500).toLocaleString('vi-VN') + ' đ';

        document.getElementById('cancelInvoiceSubtitle').textContent = `Hóa đơn #${id} · Căn ${apt} · Kỳ ${period} · ${statusLabel}`;
        document.getElementById('cancelInvoiceAmount').textContent = amount;

        // Render line items if available
        const itemsContainer = document.getElementById('cancelInvoiceItemsContainer');
        const items = data.items || [
            { name: 'Điện (kWh)', qty: 35, price: 3500, total: 122500 },
            { name: 'Phí quản lý (m²)', qty: 60, price: 12000, total: 720000 }
        ];

        let html = '';
        items.forEach(item => {
            html += `
                <div class="flex h-[40px] items-center">
                    <div class="flex-1 px-3 border-r border-[#E5E7EB] h-full flex items-center font-medium">${item.name}</div>
                    <div class="w-[90px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-mono">${item.qty}</div>
                    <div class="w-[110px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-mono">${(item.price).toLocaleString('vi-VN')}</div>
                    <div class="w-[120px] px-3 h-full flex items-center font-semibold font-mono text-[#111827]">${(item.total).toLocaleString('vi-VN')}</div>
                </div>
            `;
        });
        itemsContainer.innerHTML = html;

        if (form) {
            form.action = `/invoices/${id}/cancel`;
        }

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeCancelInvoiceModal() {
        const modal = document.getElementById('cancelInvoiceModal');
        const backdrop = document.getElementById('cancelInvoiceBackdrop');
        const panel = document.getElementById('cancelInvoicePanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function simulateCancelInvoice() {
        closeCancelInvoiceModal();
        if (window.showToast) {
            window.showToast('Đã xác nhận hủy hóa đơn thành công!');
        }
    }
</script>
