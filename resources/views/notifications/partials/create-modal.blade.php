<!-- Modal Popup: Soạn thông báo mới -->
<div
    id="createNotificationModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="create-notif-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        id="createNotifBackdrop"
        onclick="closeCreateNotificationModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="createNotifPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[620px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header -->
            <div class="px-7 pt-6 pb-4">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeCreateNotificationModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="create-notif-title">
                    Soạn thông báo mới
                </h3>
                <p class="text-[13px] text-[#52697c] mt-0.5">
                    Gửi thông báo đến cư dân theo từng phạm vi lựa chọn.
                </p>
            </div>

            <!-- Modal Form -->
            <form method="POST" action="{{ route('notifications.store') }}" onsubmit="event.preventDefault(); simulateCreateNotification();">
                @csrf
                <div class="px-7 pb-6 space-y-4">
                    <!-- Tiêu đề * -->
                    <div>
                        <label for="create_notif_title" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Tiêu đề thông báo *
                        </label>
                        <input
                            type="text"
                            id="create_notif_title"
                            name="title"
                            required
                            placeholder="Nhập tiêu đề thông báo ngắn gọn, rõ ràng"
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        />
                    </div>

                    <!-- Phạm vi nhận * -->
                    <div>
                        <label for="create_notif_scope" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Phạm vi nhận *
                        </label>
                        <div class="relative">
                            <select
                                id="create_notif_scope"
                                name="scope"
                                required
                                class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer"
                            >
                                <option value="Tòa nhà" selected>Toàn tòa A · GGMB Residence ▾</option>
                                <option value="Tất cả">Tất cả cư dân toàn khu</option>
                                <option value="Tầng">Theo tầng cụ thể</option>
                                <option value="Căn hộ">Theo căn hộ riêng lẻ</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                        </div>
                    </div>

                    <!-- Nội dung thông báo * -->
                    <div>
                        <label for="create_notif_body" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Nội dung thông báo *
                        </label>
                        <textarea
                            id="create_notif_body"
                            name="body"
                            rows="4"
                            required
                            placeholder="Nhập nội dung chi tiết thông báo gửi đến cư dân..."
                            class="w-full px-3 py-2.5 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        ></textarea>
                    </div>

                    <div class="p-3 bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] text-[12px] text-[#52697c]">
                        Người tạo: <span class="font-bold text-[#122d40]">1 · Nguyễn Minh Quản lý</span>. Hệ thống sẽ tự động gửi thông báo đến các cư dân thuộc phạm vi trên.
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-7 py-4 border-t border-[#d9e4ec] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeCreateNotificationModal()"
                        class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Gửi thông báo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCreateNotificationModal() {
        const modal = document.getElementById('createNotificationModal');
        const backdrop = document.getElementById('createNotifBackdrop');
        const panel = document.getElementById('createNotifPanel');

        if (!modal || !backdrop || !panel) return;

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeCreateNotificationModal() {
        const modal = document.getElementById('createNotificationModal');
        const backdrop = document.getElementById('createNotifBackdrop');
        const panel = document.getElementById('createNotifPanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function simulateCreateNotification() {
        closeCreateNotificationModal();
        alert('Gửi thông báo mới thành công (Demo UI)!');
    }
</script>
