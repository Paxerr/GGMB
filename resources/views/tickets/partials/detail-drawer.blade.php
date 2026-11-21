<!-- Slide-over Drawer: Chi tiết yêu cầu hỗ trợ (Bám sát Ảnh 3) -->
<div
    id="ticketDetailDrawer"
    class="fixed inset-0 z-50 overflow-hidden hidden"
    aria-labelledby="ticket-drawer-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        id="ticketDrawerBackdrop"
        onclick="closeTicketDetailDrawer()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-300 opacity-0"
    ></div>

    <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
        <div
            id="ticketDrawerPanel"
            class="w-screen max-w-[560px] bg-white border-l border-[#d9e4ec] shadow-2xl flex flex-col transform transition-transform duration-300 ease-in-out translate-x-full"
        >
            <!-- Drawer Header (Bám sát Ảnh 3) -->
            <div class="px-7 pt-6 pb-4 border-b border-[#d9e4ec] shrink-0">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        CHI TIẾT
                    </span>
                    <button
                        type="button"
                        onclick="closeTicketDetailDrawer()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="ticketDrawerTitle">
                    Đối chiếu tiền điện kỳ 02/2026
                </h3>
                <p class="text-[13px] text-[#52697c] mt-0.5" id="ticketDrawerSubtitle">
                    Đã xử lý · Hóa đơn · Căn hộ 0202
                </p>
            </div>

            <!-- Drawer Body (Bám sát Ảnh 3) -->
            <div class="flex-1 overflow-y-auto p-7 space-y-5">
                <!-- Section 1: Người tạo & Ngày tạo -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-4 border-b border-slate-100 text-[13px]">
                    <div>
                        <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                            NGƯỜI TẠO / CĂN HỘ
                        </span>
                        <span class="font-medium text-[#122d40]" id="ticketDrawerCreator">
                            Phan Nam / Căn 0202
                        </span>
                    </div>
                    <div>
                        <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                            TẠO / ĐÃ XỬ LÝ
                        </span>
                        <span class="text-[#52697c]" id="ticketDrawerDates">
                            11/02/2026 08:30 / 16:00
                        </span>
                    </div>
                </div>

                <!-- Phân công info -->
                <div class="text-[12px] text-[#52697c] pb-3 border-b border-slate-100" id="ticketDrawerAssigneeInfo">
                    Phân công: <span class="font-semibold text-[#122d40]" id="ticketDrawerAssigneeText">2 · Trần Thu Hỗ trợ</span> | <span id="ticketDrawerAssignedDate">11/02/2026 09:00</span>
                </div>

                <!-- Section 2: Mô tả -->
                <div>
                    <h4 class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-1.5">
                        MÔ TẢ
                    </h4>
                    <p class="text-[14px] text-[#334b5d] leading-[22px] bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] p-3.5" id="ticketDrawerDescription">
                        Cư dân đề nghị đối chiếu tiền điện kỳ 02/2026 với chỉ số công tơ của căn 0202.
                    </p>
                </div>

                <!-- Section 3: Tệp đính kèm · 1 (Bám sát Ảnh 3) -->
                <div>
                    <h4 class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-2">
                        TỆP ĐÍNH KÈM · 1
                    </h4>
                    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-3 flex items-center gap-3 hover:bg-slate-50 transition-colors cursor-pointer">
                        <div class="w-12 h-12 bg-slate-100 border border-slate-200 rounded flex items-center justify-center shrink-0">
                            <span class="text-[11px] font-bold text-slate-500 font-mono">JPG</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[13px] font-semibold text-[#122d40] truncate" id="ticketDrawerFileName">
                                minh-chung-10.jpg
                            </p>
                            <p class="text-[11px] text-[#52697c] mt-0.5" id="ticketDrawerFileMeta">
                                Tệp ảnh · 120 KB · Người gửi: Phan Nam
                            </p>
                            <p class="text-[11px] text-[#8a9ba8]">
                                Chọn tệp để xem nội dung đính kèm.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Lịch sử phản hồi · 1 (Bám sát Ảnh 3) -->
                <div>
                    <h4 class="text-[11px] font-bold text-slate-400 tracking-wider uppercase mb-2">
                        LỊCH SỬ PHẢN HỒI · 1
                    </h4>
                    <div class="space-y-3" id="ticketDrawerReplyHistory">
                        <div class="bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] p-3.5 space-y-1.5">
                            <div class="flex items-center justify-between text-[12px]">
                                <span class="font-bold text-[#122d40]">Trần Thu Hỗ trợ</span>
                                <span class="text-[#8a9ba8]">11/02/2026 15:45</span>
                            </div>
                            <p class="text-[13px] text-[#334b5d] leading-[20px]">
                                Đã đối chiếu chỉ số và đơn giá; gửi kết quả kiểm tra cho cư dân, chờ xác nhận hoàn tất.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Section 5: Thêm nội dung phản hồi (Bám sát Ảnh 3) -->
                <div class="pt-2">
                    <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                        Nội dung phản hồi
                    </label>
                    <textarea
                        rows="3"
                        id="ticketReplyTextarea"
                        placeholder="Nhập nội dung phản hồi..."
                        class="w-full px-3 py-2 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] rounded-[4px]"
                    ></textarea>
                    <p class="text-[11px] text-[#8a9ba8] mt-1">
                        Người gửi: Nguyễn Minh Quản lý
                    </p>
                </div>
            </div>

            <!-- Drawer Footer (3 nút: Đóng, Nghiệm thu, Gửi phản hồi - Bám sát Ảnh 3) -->
            <div class="px-7 py-4 border-t border-[#d9e4ec] flex items-center justify-between gap-3 bg-white shrink-0">
                <button
                    type="button"
                    onclick="closeTicketDetailDrawer()"
                    class="h-[40px] px-5 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                >
                    Đóng
                </button>
                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        onclick="verifyFromDrawer()"
                        class="h-[40px] px-5 bg-white border border-[#d9e4ec] hover:bg-emerald-50 text-emerald-700 text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                    >
                        Nghiệm thu
                    </button>
                    <button
                        type="button"
                        onclick="sendDrawerReply()"
                        class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Gửi phản hồi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let activeTicketData = null;

    function openTicketDetailDrawer(idOrData) {
        const data = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.ticketsMap?.[idOrData] || {});
        activeTicketData = data;

        const drawer = document.getElementById('ticketDetailDrawer');
        const backdrop = document.getElementById('ticketDrawerBackdrop');
        const panel = document.getElementById('ticketDrawerPanel');

        if (!drawer || !backdrop || !panel) return;

        const id = data.id || 1;
        const title = data.title || 'Đối chiếu tiền điện kỳ 02/2026';
        const category = data.category || 'Hóa đơn';
        const apt = data.apartment || '0202';
        const statusLabel = data.status_label || 'Đã xử lý';
        const creator = data.creator || 'Phan Nam / Căn 0202';
        const created = data.created_at || '11/02/2026 08:30';
        const resolved = data.resolved_at || '16:00';
        const assignee = data.assignee || '2 · Trần Thu Hỗ trợ';
        const assignedDate = data.assigned_at || '11/02/2026 09:00';
        const desc = data.description || 'Cư dân đề nghị đối chiếu tiền điện kỳ 02/2026 với chỉ số công tơ của căn 0202.';

        document.getElementById('ticketDrawerTitle').textContent = `#${id} · ${title}`;
        document.getElementById('ticketDrawerSubtitle').textContent = `${statusLabel} · ${category} · Căn hộ ${apt}`;
        document.getElementById('ticketDrawerCreator').textContent = creator;
        document.getElementById('ticketDrawerDates').textContent = `${created} / ${resolved}`;
        document.getElementById('ticketDrawerAssigneeText').textContent = assignee;
        document.getElementById('ticketDrawerAssignedDate').textContent = assignedDate;
        document.getElementById('ticketDrawerDescription').textContent = desc;

        drawer.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('translate-x-full');
            panel.classList.add('translate-x-0');
        });
    }

    function closeTicketDetailDrawer() {
        const drawer = document.getElementById('ticketDetailDrawer');
        const backdrop = document.getElementById('ticketDrawerBackdrop');
        const panel = document.getElementById('ticketDrawerPanel');

        if (!drawer || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('translate-x-0');
        panel.classList.add('translate-x-full');

        setTimeout(() => {
            drawer.classList.add('hidden');
        }, 300);
    }

    function verifyFromDrawer() {
        const data = activeTicketData;
        closeTicketDetailDrawer();
        if (data && typeof openVerifyTicketModal === 'function') {
            setTimeout(() => {
                openVerifyTicketModal(data);
            }, 250);
        }
    }

    function sendDrawerReply() {
        const text = document.getElementById('ticketReplyTextarea').value.trim();
        if (!text) {
            alert('Vui lòng nhập nội dung phản hồi');
            return;
        }
        alert('Đã gửi phản hồi thành công (Demo UI)!');
        document.getElementById('ticketReplyTextarea').value = '';
    }
</script>
