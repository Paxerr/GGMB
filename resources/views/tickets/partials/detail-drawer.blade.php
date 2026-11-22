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
        class="fixed inset-0 bg-black/40 backdrop-blur-[1px] transition-opacity duration-300 opacity-0"
    ></div>

    <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
        <div
            id="ticketDrawerPanel"
            class="w-screen max-w-[560px] bg-white border-l border-[#E5E7EB] shadow-2xl flex flex-col transform transition-transform duration-300 ease-in-out translate-x-full"
        >
            <!-- Drawer Header (Bám sát Ảnh 3) -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] shrink-0">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase select-none">
                        CHI TIẾT
                    </span>
                    <button
                        type="button"
                        onclick="closeTicketDetailDrawer()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] font-bold text-[#111827] mt-1" id="ticketDrawerTitle">
                    Đối chiếu tiền điện kỳ 02/2026
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-0.5" id="ticketDrawerSubtitle">
                    Đã xử lý · Hóa đơn · Căn hộ 0202
                </p>
            </div>

            <!-- Drawer Body (Bám sát Ảnh 3) -->
            <div class="flex-1 overflow-y-auto p-6 space-y-5">
                <!-- Section 1: Người tạo & Ngày tạo -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-4 border-b border-[#E5E7EB] text-[13px]">
                    <div>
                        <span class="block text-[11px] font-bold text-[#6B7280] uppercase tracking-wider mb-1">
                            NGƯỜI TẠO / CĂN HỘ
                        </span>
                        <span class="font-semibold text-[#111827]" id="ticketDrawerCreator">
                            Phan Nam / Căn 0202
                        </span>
                    </div>
                    <div>
                        <span class="block text-[11px] font-bold text-[#6B7280] uppercase tracking-wider mb-1">
                            TẠO / ĐÃ XỬ LÝ
                        </span>
                        <span class="text-[#6B7280]" id="ticketDrawerDates">
                            11/02/2026 08:30 / 16:00
                        </span>
                    </div>
                </div>

                <!-- Phân công info -->
                <div class="text-[12.5px] text-[#6B7280] pb-3 border-b border-[#E5E7EB]" id="ticketDrawerAssigneeInfo">
                    Phân công: <span class="font-semibold text-[#111827]" id="ticketDrawerAssigneeText">2 · Trần Thu Hỗ trợ</span> | <span id="ticketDrawerAssignedDate">11/02/2026 09:00</span>
                </div>

                <!-- Section 2: Mô tả -->
                <div>
                    <h4 class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase mb-1.5">
                        MÔ TẢ
                    </h4>
                    <p class="text-[13.5px] text-[#374151] leading-[22px] bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] p-3.5" id="ticketDrawerDescription">
                        Cư dân đề nghị đối chiếu tiền điện kỳ 02/2026 với chỉ số công tơ của căn 0202.
                    </p>
                </div>

                <!-- Section 3: Tệp đính kèm · 1 (Bám sát Ảnh 3) -->
                <div>
                    <h4 class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase mb-2">
                        TỆP ĐÍNH KÈM · 1
                    </h4>
                    <div class="bg-white border border-[#E5E7EB] rounded-[8px] p-3 flex items-center gap-3 hover:bg-[#F9FBFA] transition-colors cursor-pointer">
                        <div class="w-12 h-12 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[6px] flex items-center justify-center shrink-0">
                            <span class="text-[11px] font-bold text-[#6B7280] font-mono">JPG</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[13px] font-semibold text-[#111827] truncate" id="ticketDrawerFileName">
                                minh-chung-10.jpg
                            </p>
                            <p class="text-[11.5px] text-[#6B7280] mt-0.5" id="ticketDrawerFileMeta">
                                Tệp ảnh · 120 KB · Người gửi: Phan Nam
                            </p>
                            <p class="text-[11px] text-[#9CA3AF]">
                                Chọn tệp để xem nội dung đính kèm.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Lịch sử phản hồi · 1 (Bám sát Ảnh 3) -->
                <div>
                    <h4 class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase mb-2">
                        LỊCH SỬ PHẢN HỒI · 1
                    </h4>
                    <div class="space-y-3" id="ticketDrawerReplyHistory">
                        <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] p-3.5 space-y-1.5">
                            <div class="flex items-center justify-between text-[12px]">
                                <span class="font-bold text-[#111827]">Trần Thu Hỗ trợ</span>
                                <span class="text-[#9CA3AF]">11/02/2026 15:45</span>
                            </div>
                            <p class="text-[13px] text-[#374151] leading-[20px]">
                                Đã đối chiếu chỉ số và đơn giá; gửi kết quả kiểm tra cho cư dân, chờ xác nhận hoàn tất.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Section 5: Thêm nội dung phản hồi (Bám sát Ảnh 3) -->
                <div class="pt-2">
                    <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                        Nội dung phản hồi
                    </label>
                    <textarea
                        rows="3"
                        id="ticketReplyTextarea"
                        placeholder="Nhập nội dung phản hồi..."
                        class="w-full px-3 py-2 bg-white border border-[#E5E7EB] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] rounded-[8px]"
                    ></textarea>
                    <p class="text-[11.5px] text-[#9CA3AF] mt-1">
                        Người gửi: Nguyễn Minh Quản lý
                    </p>
                </div>
            </div>

            <!-- Drawer Footer (3 nút: Đóng, Nghiệm thu, Gửi phản hồi - Bám sát Ảnh 3) -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-t border-[#E5E7EB] flex items-center justify-between gap-3 shrink-0">
                <button
                    type="button"
                    onclick="closeTicketDetailDrawer()"
                    class="h-[38px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                >
                    Đóng
                </button>
                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        onclick="verifyFromDrawer()"
                        class="h-[38px] px-5 bg-white border border-[#0E4D3C] hover:bg-[#E4EFE9] text-[#0E4D3C] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Nghiệm thu
                    </button>
                    <button
                        type="button"
                        onclick="sendDrawerReply()"
                        class="h-[38px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
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
        if (window.showToast) {
            window.showToast('Đã gửi phản hồi thành công!');
        }
        document.getElementById('ticketReplyTextarea').value = '';
    }
</script>
