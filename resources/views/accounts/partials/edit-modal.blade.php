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
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[620px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Header -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#0E4D3C] tracking-wider uppercase select-none">
                        CHỈNH SỬA
                    </span>
                    <button
                        type="button"
                        onclick="closeAccountEditModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] sm:text-[20px] font-bold text-[#111827] tracking-tight mt-1" id="account-edit-title">
                    Chỉnh sửa tài khoản
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-0.5" id="edit_user_subtitle">
                    Tên đăng nhập được giữ nguyên.
                </p>
            </div>

            <!-- Form -->
            <form id="accountEditForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_acc_id">
                <div class="p-6 space-y-4">
                    <!-- Hàng 1: Họ tên & Điện thoại -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Họ và tên <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="edit_acc_name"
                                name="FullName"
                                required
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Điện thoại
                            </label>
                            <input
                                type="text"
                                id="edit_acc_phone"
                                name="Phone"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 2: Email & Căn cước -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Email
                            </label>
                            <input
                                type="email"
                                id="edit_acc_email"
                                name="Email"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Căn cước công dân
                            </label>
                            <input
                                type="text"
                                id="edit_acc_citizen_id"
                                name="CitizenId"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 3: Vai trò & Bộ phận -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Vai trò <span class="text-rose-500">*</span>
                            </label>
                            <select
                                id="edit_acc_role"
                                name="Role"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] cursor-pointer"
                            >
                                <option value="Quản lý">Quản lý</option>
                                <option value="Kỹ thuật">Kỹ thuật</option>
                                <option value="Hỗ trợ">Hỗ trợ</option>
                                <option value="Bảo vệ">Bảo vệ</option>
                                <option value="Cư dân">Cư dân</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Bộ phận
                            </label>
                            <input
                                type="text"
                                id="edit_acc_dept"
                                name="Department"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <!-- Mật khẩu mới -->
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Mật khẩu mới (bỏ trống nếu không thay đổi)
                        </label>
                        <input
                            type="password"
                            name="Password"
                            placeholder="••••••••"
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-slate-400 focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        />
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-6 py-4 bg-[#F8FAF8] border-t border-[#E5E7EB] rounded-b-[16px] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeAccountEditModal()"
                        class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[40px] px-5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer shadow-sm"
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
        document.getElementById('accountEditForm').action = `/accounts/${acc.id}`;
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
