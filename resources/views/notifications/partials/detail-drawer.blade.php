<!-- Slide-over Drawer: Chi tiết thông báo (Bám sát Ảnh 10) -->
<div
    id="notificationDetailDrawer"
    class="fixed inset-0 z-50 overflow-hidden hidden"
    aria-labelledby="notif-drawer-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        id="notifDrawerBackdrop"
        onclick="closeNotificationDetailDrawer()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-300 opacity-0"
    ></div>

    <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
        <div
            id="notifDrawerPanel"
            class="w-screen max-w-[580px] bg-white border-l border-[#d9e4ec] shadow-2xl flex flex-col transform transition-transform duration-300 ease-in-out translate-x-full"
        >
            <!-- Drawer Header (Bám sát Ảnh 10) -->
            <div class="px-7 pt-6 pb-4 border-b border-[#d9e4ec] shrink-0">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        CHI TIẾT
                    </span>
                    <button
                        type="button"
                        onclick="closeNotificationDetailDrawer()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="notifDrawerHeaderId">
                    Chi tiết thông báo #1
                </h3>
            </div>

            <!-- Drawer Body (Bám sát Ảnh 10) -->
            <div class="flex-1 overflow-y-auto p-7 space-y-5">
                <!-- Tiêu đề thông báo -->
                <div>
                    <h4 class="text-[16px] font-bold text-[#122d40] leading-snug" id="notifDrawerTitle">
                        Thông báo lịch bảo trì thang máy
                    </h4>
                    <p class="text-[13px] text-[#334b5d] mt-2 leading-[22px]" id="notifDrawerBody">
                        Thang máy tòa A bảo trì ngày 08/02/2026, 08:00–11:00. Vui lòng sử dụng thang bộ trong thời gian này.
                    </p>
                </div>

                <!-- Meta info (Bám sát Ảnh 10) -->
                <div class="space-y-1 text-[12px] text-[#52697c] pb-4 border-b border-slate-100">
                    <p><span class="font-medium text-[#334b5d]">Người tạo:</span> <span id="notifDrawerCreator">Nguyễn Minh Quản lý</span></p>
                    <p><span class="font-medium text-[#334b5d]">Ngày tạo:</span> <span id="notifDrawerDate">01/02/2026 08:00</span></p>
                    <p><span class="font-medium text-[#334b5d]">Phạm vi nhận:</span> <span id="notifDrawerScope">Toàn tòa A · GGMB Residence</span></p>
                </div>

                <!-- Segmented Tabs Filter: Tất cả / Đã đọc / Chưa đọc (Bám sát Ảnh 10) -->
                <div>
                    <div class="flex items-center gap-2 select-none">
                        <button
                            type="button"
                            id="tabAll"
                            onclick="filterRecipients('all')"
                            class="flex-1 h-[36px] bg-[#2864ad] text-white text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer"
                        >
                            Tất cả (<span id="countAll">30</span>)
                        </button>
                        <button
                            type="button"
                            id="tabRead"
                            onclick="filterRecipients('read')"
                            class="flex-1 h-[36px] bg-white border border-[#d9e4ec] text-[#334b5d] hover:bg-slate-50 text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer"
                        >
                            Đã đọc (<span id="countRead">10</span>)
                        </button>
                        <button
                            type="button"
                            id="tabUnread"
                            onclick="filterRecipients('unread')"
                            class="flex-1 h-[36px] bg-white border border-[#d9e4ec] text-[#334b5d] hover:bg-slate-50 text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer"
                        >
                            Chưa đọc (<span id="countUnread">20</span>)
                        </button>
                    </div>
                </div>

                <!-- Bảng danh sách người nhận (Bám sát Ảnh 10) -->
                <div class="border border-[#d9e4ec] rounded-[4px] overflow-hidden">
                    <!-- Table Header -->
                    <div class="bg-[#f0f4f8] border-b border-[#d9e4ec] flex h-[38px] items-center text-[12px] font-semibold text-[#52697c]">
                        <div class="w-[50px] px-3 border-r border-[#d9e4ec] h-full flex items-center">STT</div>
                        <div class="flex-1 px-3 border-r border-[#d9e4ec] h-full flex items-center">Họ tên</div>
                        <div class="w-[110px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Đã đọc</div>
                        <div class="w-[110px] px-3 h-full flex items-center">Thao tác</div>
                    </div>
                    <!-- Table Body -->
                    <div id="recipientsTableBody" class="divide-y divide-[#d9e4ec] text-[13px] text-[#334b5d]">
                        <!-- Rendered dynamically -->
                    </div>
                </div>
            </div>

            <!-- Drawer Footer (Đóng bên trái, Sửa thông báo bên phải - Bám sát Ảnh 10) -->
            <div class="px-7 py-4 border-t border-[#d9e4ec] flex items-center justify-between bg-white shrink-0">
                <button
                    type="button"
                    onclick="closeNotificationDetailDrawer()"
                    class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                >
                    Đóng
                </button>
                <button
                    type="button"
                    onclick="editFromNotificationDrawer()"
                    class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
                >
                    Sửa thông báo
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let activeNotificationData = null;
    let currentRecipientsFilter = 'all';

    function openNotificationDetailDrawer(idOrData) {
        const data = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.notificationsMap?.[idOrData] || {});
        activeNotificationData = data;

        const drawer = document.getElementById('notificationDetailDrawer');
        const backdrop = document.getElementById('notifDrawerBackdrop');
        const panel = document.getElementById('notifDrawerPanel');

        if (!drawer || !backdrop || !panel) return;

        const id = data.id || 1;
        const title = data.title || 'Thông báo lịch bảo trì thang máy';
        const body = data.body || 'Thang máy tòa A bảo trì ngày 08/02/2026, 08:00–11:00. Vui lòng sử dụng thang bộ trong thời gian này.';
        const creator = data.creator || '1 · Nguyễn Minh Quản lý';
        const date = data.created_at || '01/02/2026 08:00';
        const scope = data.scope_detail || (data.scope ? `Toàn ${data.scope} · GGMB Residence` : 'Toàn tòa A · GGMB Residence');
        const total = data.total_count || 30;
        const read = data.read_count || 10;
        const unread = data.unread_count || 20;

        document.getElementById('notifDrawerHeaderId').textContent = `Chi tiết thông báo #${id}`;
        document.getElementById('notifDrawerTitle').textContent = title;
        document.getElementById('notifDrawerBody').textContent = body;
        document.getElementById('notifDrawerCreator').textContent = creator;
        document.getElementById('notifDrawerDate').textContent = date;
        document.getElementById('notifDrawerScope').textContent = scope;

        document.getElementById('countAll').textContent = total;
        document.getElementById('countRead').textContent = read;
        document.getElementById('countUnread').textContent = unread;

        filterRecipients('all');

        drawer.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('translate-x-full');
            panel.classList.add('translate-x-0');
        });
    }

    function closeNotificationDetailDrawer() {
        const drawer = document.getElementById('notificationDetailDrawer');
        const backdrop = document.getElementById('notifDrawerBackdrop');
        const panel = document.getElementById('notifDrawerPanel');

        if (!drawer || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('translate-x-0');
        panel.classList.add('translate-x-full');

        setTimeout(() => {
            drawer.classList.add('hidden');
        }, 300);
    }

    function filterRecipients(type) {
        currentRecipientsFilter = type;
        const tabAll = document.getElementById('tabAll');
        const tabRead = document.getElementById('tabRead');
        const tabUnread = document.getElementById('tabUnread');

        // Reset styling
        [tabAll, tabRead, tabUnread].forEach(tab => {
            tab.className = "flex-1 h-[36px] bg-white border border-[#d9e4ec] text-[#334b5d] hover:bg-slate-50 text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer";
        });

        if (type === 'read') {
            tabRead.className = "flex-1 h-[36px] bg-[#2864ad] text-white text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer";
        } else if (type === 'unread') {
            tabUnread.className = "flex-1 h-[36px] bg-[#2864ad] text-white text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer";
        } else {
            tabAll.className = "flex-1 h-[36px] bg-[#2864ad] text-white text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer";
        }

        renderRecipientsList();
    }

    function renderRecipientsList() {
        const body = document.getElementById('recipientsTableBody');
        if (!body) return;

        const recipients = activeNotificationData?.recipients || [
            { stt: 1, name: 'Nguyễn An', read: false, read_label: 'Chưa đọc' },
            { stt: 2, name: 'Trần Bình', read: false, read_label: 'Chưa đọc' },
            { stt: 3, name: 'Lê Chi', read: true, read_label: 'Đã đọc' },
            { stt: 4, name: 'Phạm Dũng', read: false, read_label: 'Chưa đọc' },
            { stt: 5, name: 'Hoàng Giang', read: false, read_label: 'Chưa đọc' },
            { stt: 6, name: 'Vũ Hà', read: true, read_label: 'Đã đọc' },
        ];

        let filtered = recipients;
        if (currentRecipientsFilter === 'read') {
            filtered = recipients.filter(r => r.read === true);
        } else if (currentRecipientsFilter === 'unread') {
            filtered = recipients.filter(r => r.read === false);
        }

        if (filtered.length === 0) {
            body.innerHTML = `
                <div class="p-6 text-center text-[#8a9ba8] text-[13px]">
                    Không có người nhận nào trong mục này.
                </div>
            `;
            return;
        }

        let html = '';
        filtered.forEach((r, idx) => {
            const isRead = r.read;
            const badge = isRead 
                ? '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-[#e6f5ec] text-[#16734b]">Đã đọc</span>'
                : '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-slate-100 text-[#52697c]">Chưa đọc</span>';

            html += `
                <div class="flex h-[42px] items-center hover:bg-[#f8fbfd] transition-colors">
                    <div class="w-[50px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">${r.stt ?? (idx + 1)}</div>
                    <div class="flex-1 px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium text-[#122d40] truncate">${r.name}</div>
                    <div class="w-[110px] px-3 border-r border-[#d9e4ec] h-full flex items-center">${badge}</div>
                    <div class="w-[110px] px-3 h-full flex items-center">
                        <button type="button" onclick="alert('Xem chi tiết người nhận: ${r.name}');" class="text-[#2864ad] hover:text-[#205391] hover:underline font-medium text-[13px] cursor-pointer">
                            Xem chi tiết
                        </button>
                    </div>
                </div>
            `;
        });

        body.innerHTML = html;
    }

    function editFromNotificationDrawer() {
        const data = activeNotificationData;
        closeNotificationDetailDrawer();
        if (data && typeof openEditNotificationModal === 'function') {
            setTimeout(() => {
                openEditNotificationModal(data);
            }, 250);
        }
    }
</script>
