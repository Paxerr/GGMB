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
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="cancelInvoicePanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[620px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header (Bám sát Ảnh 1) -->
            <div class="px-7 pt-6 pb-4">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        XÁC NHẬN
                    </span>
                    <button
                        type="button"
                        onclick="closeCancelInvoiceModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#b91c1c] mt-1" id="cancel-invoice-title">
                    Hủy hóa đơn này?
                </h3>
                <p class="text-[13px] text-[#52697c] mt-1" id="cancelInvoiceSubtitle">
                    Hóa đơn #1 · Căn 0101 · Kỳ 01/2026 · Chờ thanh toán
                </p>
            </div>

            <!-- Modal Form -->
            <form id="cancelInvoiceForm" method="POST" action="" onsubmit="event.preventDefault(); simulateCancelInvoice();">
                @csrf
                <div class="px-7 pb-6 space-y-5">
                    <!-- Hàng 1: Tổng tiền hóa đơn & Trạng thái sau xác nhận (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c] mb-1.5">
                                Tổng tiền hóa đơn
                            </span>
                            <div id="cancelInvoiceAmount" class="h-[42px] px-3 bg-[#f8fafc] border border-[#d9e4ec] text-[14px] font-semibold text-[#122d40] font-mono flex items-center">
                                842.500 đ
                            </div>
                        </div>
                        <div>
                            <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c] mb-1.5">
                                Trạng thái sau xác nhận
                            </span>
                            <div class="h-[42px] px-3 bg-[#fdf2f2] border border-[#fecaca] text-[14px] font-semibold text-[#b91c1c] flex items-center">
                                Đã hủy
                            </div>
                        </div>
                    </div>

                    <!-- Bảng các khoản phí trên hóa đơn (Bám sát Ảnh 1) -->
                    <div>
                        <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">
                            CÁC KHOẢN PHÍ TRÊN HÓA ĐƠN
                        </span>
                        <div class="border border-[#d9e4ec] rounded-[4px] overflow-hidden">
                            <!-- Table Header -->
                            <div class="bg-[#f8fafc] border-b border-[#d9e4ec] flex h-[38px] items-center text-[12px] font-semibold text-[#52697c]">
                                <div class="flex-1 px-3 border-r border-[#d9e4ec] h-full flex items-center">Khoản phí</div>
                                <div class="w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Số lượng</div>
                                <div class="w-[110px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Đơn giá</div>
                                <div class="w-[120px] px-3 h-full flex items-center">Thành tiền</div>
                            </div>
                            <!-- Table Body Container -->
                            <div id="cancelInvoiceItemsContainer" class="divide-y divide-[#d9e4ec] text-[13px] text-[#334b5d]">
                                <div class="flex h-[40px] items-center">
                                    <div class="flex-1 px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium">Điện (kWh)</div>
                                    <div class="w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-mono">35</div>
                                    <div class="w-[110px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-mono">3.500</div>
                                    <div class="w-[120px] px-3 h-full flex items-center font-semibold font-mono text-[#122d40]">122.500</div>
                                </div>
                                <div class="flex h-[40px] items-center">
                                    <div class="flex-1 px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium">Phí quản lý (m²)</div>
                                    <div class="w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-mono">60</div>
                                    <div class="w-[110px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-mono">12.000</div>
                                    <div class="w-[120px] px-3 h-full flex items-center font-semibold font-mono text-[#122d40]">720.000</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer (2 nút: Giữ hóa đơn & Xác nhận hủy - Bám sát Ảnh 1) -->
                <div class="px-7 py-4 border-t border-[#d9e4ec] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeCancelInvoiceModal()"
                        class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                    >
                        Giữ hóa đơn
                    </button>
                    <button
                        type="submit"
                        class="h-[40px] px-6 bg-[#b91c1c] hover:bg-[#991b1b] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
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
                    <div class="flex-1 px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium">${item.name}</div>
                    <div class="w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-mono">${item.qty}</div>
                    <div class="w-[110px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-mono">${(item.price).toLocaleString('vi-VN')}</div>
                    <div class="w-[120px] px-3 h-full flex items-center font-semibold font-mono text-[#122d40]">${(item.total).toLocaleString('vi-VN')}</div>
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
        alert('Đã xác nhận hủy hóa đơn thành công (Demo UI)!');
    }
</script>
