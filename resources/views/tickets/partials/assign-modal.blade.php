<!-- Modal Popup: Phân công người xử lý (Bám sát Ảnh 6) -->
<div
    id="assignTicketModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="assign-ticket-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        id="assignTicketBackdrop"
        onclick="closeAssignTicketModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="assignTicketPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[620px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header (Bám sát Ảnh 6) -->
            <div class="px-7 pt-6 pb-4">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        PHÂN CÔNG
                    </span>
                    <button
                        type="button"
                        onclick="closeAssignTicketModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="assign-ticket-title">
                    Phân công người xử lý
                </h3>
            </div>

            <!-- Modal Form -->
            <form id="assignTicketForm" method="POST" action="" onsubmit="event.preventDefault(); simulateAssignTicket();">
                @csrf
                <div class="px-7 pb-6 space-y-4">
                    <!-- Ticket Info Summary Box (Bám sát Ảnh 6) -->
                    <div class="bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] p-3.5 space-y-1">
                        <h4 class="text-[14px] font-bold text-[#122d40]" id="assignTicketBoxTitle">
                            Không xem được thông báo phí
                        </h4>
                        <p class="text-[12px] text-[#52697c]" id="assignTicketBoxSub">
                            Chờ xử lý · Tài khoản · Căn 0101 · Nguyễn An
                        </p>
                        <p class="text-[11px] text-[#8a9ba8]" id="assignTicketBoxDate">
                            02/02/2026 08:30 · Chưa phân công
                        </p>
                    </div>

                    <!-- Người phụ trách * Select -->
                    <div>
                        <label for="assign_staff_select" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Người phụ trách *
                        </label>
                        <div class="relative">
                            <select
                                id="assign_staff_select"
                                name="assignee_id"
                                required
                                class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer"
                            >
                                <option value="2">2 · Trần Thu Hỗ trợ ▾</option>
                                <option value="3">3 · Lê Anh Hỗ trợ</option>
                                <option value="4">4 · Phạm Hà Hỗ trợ</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                        </div>
                    </div>

                    <!-- Danh sách nhân sự hỗ trợ · Phù hợp yêu cầu tài khoản (Bám sát Ảnh 6) -->
                    <div>
                        <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">
                            NHÂN SỰ HỖ TRỢ · PHÙ HỢP YÊU CẦU TÀI KHOẢN
                        </span>
                        <div class="border border-[#d9e4ec] rounded-[4px] divide-y divide-[#d9e4ec] overflow-hidden text-[13px]">
                            <label class="flex items-center justify-between p-3 hover:bg-slate-50 cursor-pointer transition-colors">
                                <div class="flex items-center gap-2.5">
                                    <input type="radio" name="staff_radio" value="2" checked class="text-[#2864ad] focus:ring-[#2864ad]" />
                                    <span class="font-medium text-[#122d40]">2 · Trần Thu Hỗ trợ</span>
                                </div>
                                <span class="text-[12px] text-[#52697c]">Chăm sóc cư dân</span>
                            </label>
                            <label class="flex items-center justify-between p-3 hover:bg-slate-50 cursor-pointer transition-colors">
                                <div class="flex items-center gap-2.5">
                                    <input type="radio" name="staff_radio" value="3" class="text-[#2864ad] focus:ring-[#2864ad]" />
                                    <span class="font-medium text-[#122d40]">3 · Lê Anh Hỗ trợ</span>
                                </div>
                                <span class="text-[12px] text-[#52697c]">Chăm sóc cư dân</span>
                            </label>
                            <label class="flex items-center justify-between p-3 hover:bg-slate-50 cursor-pointer transition-colors">
                                <div class="flex items-center gap-2.5">
                                    <input type="radio" name="staff_radio" value="4" class="text-[#2864ad] focus:ring-[#2864ad]" />
                                    <span class="font-medium text-[#122d40]">4 · Phạm Hà Hỗ trợ</span>
                                </div>
                                <span class="text-[12px] text-[#52697c]">Chăm sóc cư dân</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer (Hủy bên trái, Xác nhận phân công bên phải - Bám sát Ảnh 6) -->
                <div class="px-7 py-4 border-t border-[#d9e4ec] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeAssignTicketModal()"
                        class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Xác nhận phân công
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAssignTicketModal(idOrData) {
        const data = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.ticketsMap?.[idOrData] || {});
        const modal = document.getElementById('assignTicketModal');
        const backdrop = document.getElementById('assignTicketBackdrop');
        const panel = document.getElementById('assignTicketPanel');

        if (!modal || !backdrop || !panel) return;

        const title = data.title || 'Không xem được thông báo phí';
        const category = data.category || 'Tài khoản';
        const apt = data.apartment || '0101';
        const creator = data.creator_name || 'Nguyễn An';
        const created = data.created_at || '02/02/2026 08:30';
        const statusLabel = data.status_label || 'Chờ xử lý';

        document.getElementById('assignTicketBoxTitle').textContent = title;
        document.getElementById('assignTicketBoxSub').textContent = `${statusLabel} · ${category} · Căn ${apt} · ${creator}`;
        document.getElementById('assignTicketBoxDate').textContent = `${created} · Chưa phân công`;

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeAssignTicketModal() {
        const modal = document.getElementById('assignTicketModal');
        const backdrop = document.getElementById('assignTicketBackdrop');
        const panel = document.getElementById('assignTicketPanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function simulateAssignTicket() {
        closeAssignTicketModal();
        alert('Phân công người xử lý thành công (Demo UI)!');
    }
</script>
