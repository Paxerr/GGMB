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
        class="fixed inset-0 bg-black/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="collectInvoicePanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[640px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase select-none">
                        XÁC NHẬN
                    </span>
                    <button
                        type="button"
                        onclick="closeCollectModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] font-bold text-[#111827] mt-1" id="collect-invoice-title">
                    Thu tiền tại quầy
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-1" id="collectModalSubtitle">
                    Hóa đơn #1 · Căn 0101 · Kỳ 01/2026 · Chờ thanh toán
                </p>
            </div>

            <!-- Modal Form -->
            <form id="collectInvoiceForm" method="POST" action="">
                @csrf
                <div class="px-6 py-5 space-y-4">
                    <!-- Box: Số tiền cần thu -->
                    <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[10px] p-4 flex items-center justify-between">
                        <div>
                            <span class="block text-[11px] font-bold text-[#6B7280] tracking-wider uppercase">
                                SỐ TIỀN CẦN THU
                            </span>
                            <span class="block text-[26px] font-bold text-[#0E4D3C] font-mono mt-0.5" id="collectAmount">
                                842.500 đ
                            </span>
                        </div>
                        <div class="text-right text-[12.5px] text-[#6B7280]">
                            Hạn: <span id="collectDueDate" class="font-bold text-[#111827]">10/02/2026</span>
                        </div>
                    </div>

                    <!-- Hàng 1: Trạng thái sau xác nhận & Phương thức thanh toán * -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Trạng thái sau xác nhận
                            </label>
                            <div class="w-full h-[40px] px-3 bg-[#E4EFE9] border border-[#0E4D3C]/20 text-[#0E4D3C] text-[13.5px] font-semibold flex items-center rounded-[8px] select-none">
                                Đã thanh toán
                            </div>
                        </div>

                        <div>
                            <label for="collect_method" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Phương thức thanh toán <span class="text-rose-600">*</span>
                            </label>
                            <div class="relative">
                                <select id="collect_method" name="PaymentType" required class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer">
                                    <option value="CASH">Tiền mặt (CASH)</option>
                                    <option value="TRANSFER" selected>Chuyển khoản (TRANSFER)</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                            </div>
                        </div>
                    </div>

                    <!-- Hàng 2: Thời điểm thu · tự ghi lúc xác nhận -->
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Thời điểm thu · tự ghi lúc xác nhận
                        </label>
                        <input
                            type="text"
                            readonly
                            placeholder="Thời điểm thu thực tế khi lưu thành công"
                            class="w-full h-[40px] px-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#6B7280] placeholder-[#9CA3AF] cursor-not-allowed select-none focus:outline-none"
                        />
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-[#F2F6F4] border-t border-[#E5E7EB] flex items-center justify-between rounded-b-[16px]">
                    <button
                        type="button"
                        onclick="closeCollectModal()"
                        class="h-[38px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[38px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
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
        if (window.showToast) {
            window.showToast('Đã xác nhận thu tiền hóa đơn thành công!');
        }
    }
</script>
