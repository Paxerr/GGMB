<!-- Modal Popup: Chỉnh sửa thông báo -->
<div
    id="editNotificationModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="edit-notif-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        id="editNotifBackdrop"
        onclick="closeEditNotificationModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="editNotifPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[620px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#0E4D3C] tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeEditNotificationModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] sm:text-[20px] font-bold text-[#111827] tracking-tight mt-1" id="edit-notif-title">
                    Chỉnh sửa thông báo
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-0.5">
                    Các trường có dấu * là bắt buộc
                </p>
            </div>

            <!-- Modal Form -->
            <form id="editNotificationForm" method="POST" action="" onsubmit="event.preventDefault(); simulateEditNotification();">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-4">
                    <!-- Tiêu đề * -->
                    <div>
                        <label for="edit_notif_title" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Tiêu đề *
                        </label>
                        <input
                            type="text"
                            id="edit_notif_title"
                            name="title"
                            required
                            value="Thông báo lịch bảo trì thang máy"
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        />
                    </div>

                    <!-- Nội dung * -->
                    <div>
                        <label for="edit_notif_body" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Nội dung *
                        </label>
                        <textarea
                            id="edit_notif_body"
                            name="body"
                            rows="4"
                            required
                            class="w-full px-3 py-2.5 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        >Thang máy tòa A bảo trì ngày 08/02/2026, 08:00–11:00. Vui lòng sử dụng thang bộ trong thời gian này.</textarea>
                    </div>

                    <!-- Phạm vi nhận * -->
                    <div>
                        <label for="edit_notif_scope" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Phạm vi nhận *
                        </label>
                        <div class="relative">
                            <select
                                id="edit_notif_scope"
                                name="scope"
                                required
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] cursor-pointer"
                            >
                                <option value="Tòa nhà" selected>Tòa nhà ▾</option>
                                <option value="Toàn bộ">Toàn bộ</option>
                                <option value="Tầng">Tầng</option>
                                <option value="Căn hộ">Căn hộ</option>
                                <option value="Cá nhân">Cá nhân</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                        </div>
                        <p class="text-[11px] text-[#6B7280] mt-1">
                            Toàn bộ / Tòa nhà / Tầng / Căn hộ / Cá nhân
                        </p>
                    </div>

                    <!-- Tòa nhận * -->
                    <div>
                        <label for="edit_notif_building" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Tòa nhận *
                        </label>
                        <input
                            type="text"
                            id="edit_notif_building"
                            value="1 · GGMB Residence · Tòa A"
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C]"
                        />
                    </div>

                    <!-- Notice Box -->
                    <div class="p-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[12px] text-[#6B7280]">
                        Kiểm tra nội dung và người nhận trước khi lưu thay đổi thông báo đã gửi.
                    </div>

                    <!-- Meta info -->
                    <div class="text-[12px] text-[#6B7280] space-y-0.5">
                        <p>Người tạo: <span class="text-[#111827] font-medium">Nguyễn Minh Quản lý</span></p>
                        <p>Ngày tạo: <span class="text-[#111827] font-medium">01/02/2026 08:00</span></p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-[#F8FAF8] border-t border-[#E5E7EB] rounded-b-[16px] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeEditNotificationModal()"
                        class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Đóng
                    </button>
                    <button
                        type="submit"
                        class="h-[40px] px-5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditNotificationModal(idOrData) {
        const data = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.notificationsMap?.[idOrData] || {});
        const modal = document.getElementById('editNotificationModal');
        const backdrop = document.getElementById('editNotifBackdrop');
        const panel = document.getElementById('editNotifPanel');

        if (!modal || !backdrop || !panel) return;

        const title = data.title || 'Thông báo lịch bảo trì thang máy';
        const body = data.body || 'Thang máy tòa A bảo trì ngày 08/02/2026, 08:00–11:00. Vui lòng sử dụng thang bộ trong thời gian này.';
        const scope = data.scope || 'Tòa nhà';

        document.getElementById('edit_notif_title').value = title;
        document.getElementById('edit_notif_body').value = body;
        if (document.getElementById('edit_notif_scope')) {
            document.getElementById('edit_notif_scope').value = scope;
        }

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeEditNotificationModal() {
        const modal = document.getElementById('editNotificationModal');
        const backdrop = document.getElementById('editNotifBackdrop');
        const panel = document.getElementById('editNotifPanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function simulateEditNotification() {
        closeEditNotificationModal();
        if (window.showToast) {
            window.showToast('Đã lưu thay đổi thông báo thành công!');
        } else {
            alert('Đã lưu thay đổi thông báo thành công!');
        }
    }
</script>
