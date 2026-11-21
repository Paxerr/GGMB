<!-- Modal Popup: Thu tiền tại quầy (Bám sát Ảnh 10) -->
<div
    id="collectInvoiceModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="collect-invoice-title"
    role="dialog"
    aria-modal="true"
>
    <div
        id="collectInvoiceBackdrop"
        onclick="closeCollectModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="collectInvoicePanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[640px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header -->
            <div class="px-7 pt-6 pb-4">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        XÁC NHẬN
                    </span>
                    <button
                        type="button"
                        onclick="closeCollectModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="collect-invoice-title">
                    Thu tiền tại quầy
                </h3>
                <p class="text-[13px] text-[#52697c] mt-1" id="collectModalSubtitle">
                    Hóa đơn #1 · Căn 0101 · Kỳ 01/2026 · Chờ thanh toán
                </p>
            </div>

            <!-- Modal Form -->
            <form id="collectInvoiceForm" method="POST" action="" onsubmit="event.preventDefault(); simulateCollectInvoice();">
                @csrf
                <div class="px-7 pb-6 space-y-5">
                    <!-- Box: Số tiền cần thu -->
                    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-5 flex items-center justify-between">
                        <div>
                            <span class="block text-[11px] font-bold text-slate-500 tracking-wider uppercase">
                                SỐ TIỀN CẦN THU
                            </span>
                            <span class="block text-[28px] font-bold text-[#122d40] font-mono mt-1" id="collectAmount">
                                842.500 đ
                            </span>
                        </div>
                        <div class="text-right text-[12px] text-[#52697c]">
                            Hạn: <span id="collectDueDate" class="font-medium">10/02/2026</span>
                        </div>
                    </div>

                    <!-- Hàng 1: Trạng thái sau xác nhận & Phương thức thanh toán * -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Trạng thái sau xác nhận
                            </label>
                            <div class="w-full h-[42px] px-3 bg-[#e6f5ec] border border-[#c3e6cb] text-[#16734b] text-[14px] font-semibold flex items-center rounded-[2px] select-none">
                                Đã thanh toán
                            </div>
                        </div>

                        <div>
                            <label for="collect_method" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Phương thức thanh toán <span class="text-rose-600">*</span>
                            </label>
                            <div class="relative">
                                <select id="collect_method" required class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer">
                                    <option value="CASH">Tiền mặt / Chuyển khoản ▾</option>
                                    <option value="BANK_TRANSFER">Chuyển khoản ngân hàng</option>
                                    <option value="QR">Quét mã VietQR</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                            </div>
                        </div>
                    </div>

                    <!-- Hàng 2: Thời điểm thu · tự ghi lúc xác nhận -->
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Thời điểm thu · tự ghi lúc xác nhận
                        </label>
                        <input
                            type="text"
                            readonly
                            placeholder="Thời điểm thu thực tế khi lưu thành công"
                            class="w-full h-[42px] px-3 bg-slate-50 border border-[#d9e4ec] text-[14px] text-[#52697c] placeholder-[#8a9ba8] cursor-not-allowed select-none focus:outline-none"
                        />
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-7 py-4 border-t border-[#d9e4ec] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeCollectModal()"
                        class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Xác nhận đã thu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCollectModal(idOrData) {
        const data = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.invoicesMap?.[idOrData] || {});
        const modal = document.getElementById('collectInvoiceModal');
        const backdrop = document.getElementById('collectInvoiceBackdrop');
        const panel = document.getElementById('collectInvoicePanel');
        const form = document.getElementById('collectInvoiceForm');

        if (!modal || !backdrop || !panel) return;

        const id = data.id || 1;
        const apt = data.apartment || '0101';
        const period = data.period || '01/2026';
        const amount = (data.amount || 842500).toLocaleString('vi-VN') + ' đ';
        const dueDate = data.due_date || '10/02/2026';

        document.getElementById('collectModalSubtitle').textContent = `Hóa đơn #${id} · Căn ${apt} · Kỳ ${period} · Chờ thanh toán`;
        document.getElementById('collectAmount').textContent = amount;
        document.getElementById('collectDueDate').textContent = dueDate;

        if (form) {
            form.action = `/invoices/${id}/collect`;
        }

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeCollectModal() {
        const modal = document.getElementById('collectInvoiceModal');
        const backdrop = document.getElementById('collectInvoiceBackdrop');
        const panel = document.getElementById('collectInvoicePanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function simulateCollectInvoice() {
        closeCollectModal();
        alert('Đã xác nhận thu tiền hóa đơn thành công (Demo UI)!');
    }
</script>
