<!-- Modal Popup: Nghiệm thu & đóng phiếu (Bám sát Ảnh 7) -->
<div
    id="verifyTicketModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="verify-ticket-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        id="verifyTicketBackdrop"
        onclick="closeVerifyTicketModal()"
        class="fixed inset-0 bg-black/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="verifyTicketPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[620px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header (Bám sát Ảnh 7) -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase select-none">
                        NGHIỆM THU
                    </span>
                    <button
                        type="button"
                        onclick="closeVerifyTicketModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] font-bold text-[#111827] mt-1" id="verify-ticket-title">
                    Nghiệm thu & đóng phiếu
                </h3>
            </div>

            <!-- Modal Form -->
            <form id="verifyTicketForm" method="POST" action="" onsubmit="event.preventDefault(); simulateVerifyTicket();">
                @csrf
                <div class="px-6 py-5 space-y-4">
                    <!-- Ticket Info Summary Box (Bám sát Ảnh 7) -->
                    <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] p-3.5 space-y-1">
                        <h4 class="text-[14px] font-bold text-[#111827]" id="verifyTicketBoxTitle">
                            Đối chiếu tiền điện kỳ 02/2026
                        </h4>
                        <p class="text-[12.5px] text-[#6B7280]" id="verifyTicketBoxSub">
                            Hóa đơn · Căn 0202 · Người tạo 19 / Phan Nam
                        </p>
                        <p class="text-[11.5px] text-[#9CA3AF]" id="verifyTicketBoxDate">
                            Đã xử lý lúc 11/02/2026 16:00
                        </p>
                    </div>

                    <!-- Kết quả kiểm tra / lý do trả lại * (Bám sát Ảnh 7) -->
                    <div>
                        <label for="verify_result" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Kết quả kiểm tra / lý do trả lại *
                        </label>
                        <textarea
                            id="verify_result"
                            name="result"
                            rows="3"
                            required
                            class="w-full px-3 py-2.5 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        >Đã đối chiếu chỉ số và đơn giá điện kỳ 02/2026. Gửi kết quả giải thích đến cư dân căn 0202.</textarea>
                    </div>

                    <!-- Ảnh sau xử lý (tùy chọn) · chưa tải lên (Bám sát Ảnh 7) -->
                    <div>
                        <span class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Ảnh sau xử lý (tùy chọn) · chưa tải lên
                        </span>
                        <div class="bg-white border border-[#E5E7EB] rounded-[8px] p-3 flex items-center gap-3">
                            <div class="w-16 h-10 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[6px] flex items-center justify-center shrink-0">
                                <span class="text-[10px] font-bold text-[#6B7280] uppercase">ẢNH SAU</span>
                            </div>
                            <div class="text-[12px]">
                                <span class="text-[#0E4D3C] font-semibold cursor-pointer hover:underline">
                                    ＋ Chọn ảnh minh chứng
                                </span>
                                <p class="text-[11px] text-[#9CA3AF]">Chưa có ảnh minh chứng được chọn.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notice Box (Bám sát Ảnh 7) -->
                    <div class="p-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[12px] text-[#374151] space-y-1">
                        <p class="font-semibold text-[#111827]">Chỉ đóng phiếu khi đã kiểm tra kết quả và nội dung phản hồi.</p>
                        <p class="text-[11.5px] text-[#6B7280]">Chưa đạt: chọn "Trả lại xử lý" để người phụ trách tiếp tục xử lý.</p>
                    </div>

                    <!-- Checkbox xác nhận (Bám sát Ảnh 7) -->
                    <label class="flex items-start gap-2.5 cursor-pointer select-none">
                        <input
                            type="checkbox"
                            checked
                            required
                            class="mt-0.5 rounded-[4px] border-[#E5E7EB] text-[#0E4D3C] focus:ring-[#0E4D3C]"
                        />
                        <div class="text-[12.5px]">
                            <span class="font-bold text-[#111827]">Xác nhận đã kiểm tra và đồng ý đóng phiếu</span>
                            <p class="text-[11.5px] text-[#6B7280]">Xác nhận hoàn tất và thông báo kết quả cho người gửi; giữ lịch sử xử lý.</p>
                        </div>
                    </label>
                </div>

                <!-- Modal Footer (Trả lại xử lý bên trái, Xác nhận đóng bên phải - Bám sát Ảnh 7) -->
                <div class="px-6 py-4 bg-[#F2F6F4] border-t border-[#E5E7EB] flex items-center justify-between rounded-b-[16px]">
                    <button
                        type="button"
                        onclick="returnTicketToProcessing()"
                        class="h-[38px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Trả lại xử lý
                    </button>
                    <button
                        type="submit"
                        class="h-[38px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Xác nhận đóng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openVerifyTicketModal(idOrData) {
        const data = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.ticketsMap?.[idOrData] || {});
        const modal = document.getElementById('verifyTicketModal');
        const backdrop = document.getElementById('verifyTicketBackdrop');
        const panel = document.getElementById('verifyTicketPanel');

        if (!modal || !backdrop || !panel) return;

        const title = data.title || 'Đối chiếu tiền điện kỳ 02/2026';
        const category = data.category || 'Hóa đơn';
        const apt = data.apartment || '0202';
        const creator = data.creator || '19 / Phan Nam';
        const resolved = data.resolved_at || '11/02/2026 16:00';

        document.getElementById('verifyTicketBoxTitle').textContent = title;
        document.getElementById('verifyTicketBoxSub').textContent = `${category} · Căn ${apt} · Người tạo ${creator}`;
        document.getElementById('verifyTicketBoxDate').textContent = `Đã xử lý lúc ${resolved}`;

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeVerifyTicketModal() {
        const modal = document.getElementById('verifyTicketModal');
        const backdrop = document.getElementById('verifyTicketBackdrop');
        const panel = document.getElementById('verifyTicketPanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function simulateVerifyTicket() {
        closeVerifyTicketModal();
        if (window.showToast) {
            window.showToast('Đã nghiệm thu và đóng phiếu yêu cầu thành công!');
        }
    }

    function returnTicketToProcessing() {
        closeVerifyTicketModal();
        if (window.showToast) {
            window.showToast('Đã trả lại yêu cầu về trạng thái Đang xử lý!');
        }
    }
</script>
