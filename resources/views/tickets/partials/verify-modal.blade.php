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
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="verifyTicketPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[620px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header (Bám sát Ảnh 7) -->
            <div class="px-7 pt-6 pb-4">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        NGHIỆM THU
                    </span>
                    <button
                        type="button"
                        onclick="closeVerifyTicketModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="verify-ticket-title">
                    Nghiệm thu & đóng phiếu
                </h3>
            </div>

            <!-- Modal Form -->
            <form id="verifyTicketForm" method="POST" action="" onsubmit="event.preventDefault(); simulateVerifyTicket();">
                @csrf
                <div class="px-7 pb-6 space-y-4">
                    <!-- Ticket Info Summary Box (Bám sát Ảnh 7) -->
                    <div class="bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] p-3.5 space-y-1">
                        <h4 class="text-[14px] font-bold text-[#122d40]" id="verifyTicketBoxTitle">
                            Đối chiếu tiền điện kỳ 02/2026
                        </h4>
                        <p class="text-[12px] text-[#52697c]" id="verifyTicketBoxSub">
                            Hóa đơn · Căn 0202 · Người tạo 19 / Phan Nam
                        </p>
                        <p class="text-[11px] text-[#8a9ba8]" id="verifyTicketBoxDate">
                            Đã xử lý lúc 11/02/2026 16:00
                        </p>
                    </div>

                    <!-- Kết quả kiểm tra / lý do trả lại * (Bám sát Ảnh 7) -->
                    <div>
                        <label for="verify_result" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Kết quả kiểm tra / lý do trả lại *
                        </label>
                        <textarea
                            id="verify_result"
                            name="result"
                            rows="3"
                            required
                            class="w-full px-3 py-2.5 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        >Đã đối chiếu chỉ số và đơn giá điện kỳ 02/2026. Gửi kết quả giải thích đến cư dân căn 0202.</textarea>
                    </div>

                    <!-- Ảnh sau xử lý (tùy chọn) · chưa tải lên (Bám sát Ảnh 7) -->
                    <div>
                        <span class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Ảnh sau xử lý (tùy chọn) · chưa tải lên
                        </span>
                        <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-3 flex items-center gap-3">
                            <div class="w-16 h-10 bg-slate-100 border border-slate-200 rounded flex items-center justify-center shrink-0">
                                <span class="text-[10px] font-bold text-slate-400 uppercase">ẢNH SAU</span>
                            </div>
                            <div class="text-[12px]">
                                <span class="text-[#2864ad] font-semibold cursor-pointer hover:underline">
                                    ＋ Chọn ảnh minh chứng
                                </span>
                                <p class="text-[11px] text-[#8a9ba8]">Chưa có ảnh minh chứng được chọn.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notice Box (Bám sát Ảnh 7) -->
                    <div class="p-3 bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] text-[12px] text-[#334b5d] space-y-1">
                        <p class="font-medium text-[#122d40]">Chỉ đóng phiếu khi đã kiểm tra kết quả và nội dung phản hồi.</p>
                        <p class="text-[11px] text-[#52697c]">Chưa đạt: chọn "Trả lại xử lý" để người phụ trách tiếp tục xử lý.</p>
                    </div>

                    <!-- Checkbox xác nhận (Bám sát Ảnh 7) -->
                    <label class="flex items-start gap-2.5 cursor-pointer select-none">
                        <input
                            type="checkbox"
                            checked
                            required
                            class="mt-0.5 rounded text-[#2864ad] focus:ring-[#2864ad]"
                        />
                        <div class="text-[12px]">
                            <span class="font-bold text-[#122d40]">Xác nhận đã kiểm tra và đồng ý đóng phiếu</span>
                            <p class="text-[11px] text-[#52697c]">Xác nhận hoàn tất và thông báo kết quả cho người gửi; giữ lịch sử xử lý.</p>
                        </div>
                    </label>
                </div>

                <!-- Modal Footer (Trả lại xử lý bên trái, Xác nhận đóng bên phải - Bám sát Ảnh 7) -->
                <div class="px-7 py-4 border-t border-[#d9e4ec] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="returnTicketToProcessing()"
                        class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                    >
                        Trả lại xử lý
                    </button>
                    <button
                        type="submit"
                        class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
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
        alert('Đã nghiệm thu và đóng phiếu yêu cầu thành công (Demo UI)!');
    }

    function returnTicketToProcessing() {
        closeVerifyTicketModal();
        alert('Đã trả lại yêu cầu về trạng thái Đang xử lý (Demo UI)!');
    }
</script>
