<!-- Modal Popup: Chỉnh sửa tài khoản -->
<div
    id="accountEditModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="account-edit-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        id="accountEditBackdrop"
        onclick="closeAccountEditModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="accountEditPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[620px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <!-- Header -->
            <div class="px-7 pt-6 pb-4 border-b border-[#d9e4ec]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        CHỈNH SỬA
                    </span>
                    <button
                        type="button"
                        onclick="closeAccountEditModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="account-edit-title">
                    Chỉnh sửa tài khoản
                </h3>
                <p class="text-[13px] text-[#52697c] mt-0.5" id="edit_user_subtitle">
                    Tên đăng nhập được giữ nguyên.
                </p>
            </div>

            <!-- Form -->
            <form id="accountEditForm" onsubmit="event.preventDefault(); submitAccountEdit();">
                <input type="hidden" id="edit_acc_id">
                <div class="px-7 py-5 space-y-4">
                    <!-- Hàng 1: Họ tên & Điện thoại -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Họ và tên <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="edit_acc_name"
                                required
                                class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] focus:outline-none focus:border-[#2864ad]"
                            />
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Điện thoại
                            </label>
                            <input
                                type="text"
                                id="edit_acc_phone"
                                class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] focus:outline-none focus:border-[#2864ad]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 2: Email & Căn cước -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Email
                            </label>
                            <input
                                type="email"
                                id="edit_acc_email"
                                class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] focus:outline-none focus:border-[#2864ad]"
                            />
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Căn cước công dân
                            </label>
                            <input
                                type="text"
                                id="edit_acc_citizen_id"
                                class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] focus:outline-none focus:border-[#2864ad]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 3: Vai trò & Bộ phận -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Vai trò <span class="text-rose-500">*</span>
                            </label>
                            <select
                                id="edit_acc_role"
                                class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] focus:outline-none focus:border-[#2864ad]"
                            >
                                <option value="Quản lý">Quản lý</option>
                                <option value="Kỹ thuật">Kỹ thuật</option>
                                <option value="Hỗ trợ">Hỗ trợ</option>
                                <option value="Bảo vệ">Bảo vệ</option>
                                <option value="Cư dân">Cư dân</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Bộ phận
                            </label>
                            <input
                                type="text"
                                id="edit_acc_dept"
                                class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] focus:outline-none focus:border-[#2864ad]"
                            />
                        </div>
                    </div>

                    <!-- Mật khẩu mới -->
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Mật khẩu mới (bỏ trống nếu không thay đổi)
                        </label>
                        <input
                            type="password"
                            placeholder="••••••••"
                            class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] placeholder-slate-400 focus:outline-none focus:border-[#2864ad]"
                        />
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-7 py-4 bg-[#f8fafc] border-t border-[#d9e4ec] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeAccountEditModal()"
                        class="h-[38px] px-5 bg-white border border-[#d9e4ec] hover:bg-slate-50 text-[#334b5d] text-[13px] font-medium rounded-[4px] transition-colors cursor-pointer"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[38px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer shadow-sm"
                    >
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAccountEditModal(acc) {
        document.getElementById('edit_acc_id').value = acc.id;
        document.getElementById('edit_user_subtitle').innerText = `${acc.name} · Tên đăng nhập ${acc.username} được giữ nguyên.`;
        document.getElementById('edit_acc_name').value = acc.name || '';
        document.getElementById('edit_acc_phone').value = acc.phone || '';
        document.getElementById('edit_acc_email').value = acc.email || '';
        document.getElementById('edit_acc_citizen_id').value = acc.citizen_id || '079000000001';
        document.getElementById('edit_acc_role').value = acc.role || 'Quản lý';
        document.getElementById('edit_acc_dept').value = acc.dept || 'Ban quản lý chung cư GGMB';

        const modal = document.getElementById('accountEditModal');
        const backdrop = document.getElementById('accountEditBackdrop');
        const panel = document.getElementById('accountEditPanel');

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeAccountEditModal() {
        const modal = document.getElementById('accountEditModal');
        const backdrop = document.getElementById('accountEditBackdrop');
        const panel = document.getElementById('accountEditPanel');

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 200);
    }

    function submitAccountEdit() {
        const id = document.getElementById('edit_acc_id').value;
        const newName = document.getElementById('edit_acc_name').value;
        const newPhone = document.getElementById('edit_acc_phone').value;
        const newEmail = document.getElementById('edit_acc_email').value;
        const newRole = document.getElementById('edit_acc_role').value;

        // Cập nhật DOM của dòng tương ứng
        const row = document.getElementById(`acc-row-${id}`);
        if (row) {
            const nameEl = row.querySelector('.acc-name');
            if (nameEl) nameEl.innerText = newName;
            const phoneEl = row.querySelector('.acc-phone');
            if (phoneEl) phoneEl.innerText = newPhone;
            const emailEl = row.querySelector('.acc-email');
            if (emailEl) emailEl.innerText = newEmail;
            const roleEl = row.querySelector('.acc-role');
            if (roleEl) roleEl.innerText = newRole;
        }

        closeAccountEditModal();
        if (window.showToast) {
            window.showToast(`Đã lưu thay đổi cho tài khoản ${newName} thành công!`);
        }
    }
</script>
