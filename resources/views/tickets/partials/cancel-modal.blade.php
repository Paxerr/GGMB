<!-- Modal Popup: Hủy yêu cầu hỗ trợ (Bám sát Ảnh 8) -->
<div
    id="cancelTicketModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="cancel-ticket-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        id="cancelTicketBackdrop"
        onclick="closeCancelTicketModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="cancelTicketPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[620px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header (Bám sát Ảnh 8) -->
            <div class="px-7 pt-6 pb-4">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        XÁC NHẬN
                    </span>
                    <button
                        type="button"
                        onclick="closeCancelTicketModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#b91c1c] mt-1" id="cancel-ticket-title">
                    Hủy yêu cầu hỗ trợ
                </h3>
            </div>

            <!-- Modal Form -->
            <form id="cancelTicketForm" method="POST" action="" onsubmit="event.preventDefault(); simulateCancelTicket();">
                @csrf
                <div class="px-7 pb-6 space-y-4">
                    <!-- Ticket Info Summary Box (Bám sát Ảnh 8) -->
                    <div class="bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] p-3.5 space-y-1">
                        <h4 class="text-[14px] font-bold text-[#122d40]" id="cancelTicketBoxTitle">
                            Không xem được thông báo phí
                        </h4>
                        <p class="text-[12px] text-[#52697c]" id="cancelTicketBoxSub">
                            Chờ xử lý · Tài khoản · Căn 0101 · Nguyễn An
                        </p>
                        <p class="text-[11px] text-[#8a9ba8]" id="cancelTicketBoxDate">
                            Tạo 02/02/2026 08:30 · Chưa phân công
                        </p>
                    </div>

                    <!-- Flow Transition Info (Bám sát Ảnh 8) -->
                    <div class="pt-1">
                        <h4 class="text-[14px] font-bold text-[#122d40]">
                            Chờ xử lý ➔ Đã hủy
                        </h4>
                        <p class="text-[12px] text-[#52697c] mt-0.5">
                            Thông báo lý do hủy đến người gửi yêu cầu.
                        </p>
                    </div>

                    <!-- Lý do hủy * (Bám sát Ảnh 8) -->
                    <div>
                        <label for="cancel_ticket_reason" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Lý do hủy *
                        </label>
                        <textarea
                            id="cancel_ticket_reason"
                            name="reason"
                            rows="3"
                            required
                            placeholder="Nhập lý do hủy và hướng giải quyết cho người gửi..."
                            class="w-full px-3 py-2.5 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        ></textarea>
                    </div>
                </div>

                <!-- Modal Footer (Giữ phiếu bên trái, Xác nhận hủy bên phải - Bám sát Ảnh 8) -->
                <div class="px-7 py-4 border-t border-[#d9e4ec] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeCancelTicketModal()"
                        class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                    >
                        Giữ phiếu
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
    function openCancelTicketModal(idOrData) {
        const data = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.ticketsMap?.[idOrData] || {});
        const modal = document.getElementById('cancelTicketModal');
        const backdrop = document.getElementById('cancelTicketBackdrop');
        const panel = document.getElementById('cancelTicketPanel');

        if (!modal || !backdrop || !panel) return;

        const title = data.title || 'Không xem được thông báo phí';
        const category = data.category || 'Tài khoản';
        const apt = data.apartment || '0101';
        const creator = data.creator_name || 'Nguyễn An';
        const created = data.created_at || '02/02/2026 08:30';
        const statusLabel = data.status_label || 'Chờ xử lý';

        document.getElementById('cancelTicketBoxTitle').textContent = title;
        document.getElementById('cancelTicketBoxSub').textContent = `${statusLabel} · ${category} · Căn ${apt} · ${creator}`;
        document.getElementById('cancelTicketBoxDate').textContent = `Tạo ${created} · Chưa phân công`;

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeCancelTicketModal() {
        const modal = document.getElementById('cancelTicketModal');
        const backdrop = document.getElementById('cancelTicketBackdrop');
        const panel = document.getElementById('cancelTicketPanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function simulateCancelTicket() {
        closeCancelTicketModal();
        alert('Đã hủy phiếu yêu cầu hỗ trợ thành công (Demo UI)!');
    }
</script>
