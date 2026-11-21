<!-- Modal Popup: Khóa tài khoản (Lock Account) -->
<div
    id="accountLockModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="lock-modal-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        id="accountLockBackdrop"
        onclick="closeAccountLockModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="accountLockPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[560px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <!-- Header -->
            <div class="px-7 pt-6 pb-4 border-b border-[#d9e4ec]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-rose-500 tracking-wider uppercase select-none">
                        BẢO MẬT & TRUY CẬP
                    </span>
                    <button
                        type="button"
                        onclick="closeAccountLockModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#b91c1c] mt-1" id="lock-modal-title">
                    Khóa tài khoản
                </h3>
                <p class="text-[13px] text-[#52697c] mt-0.5" id="lock_account_subtitle">
                    Tài khoản sẽ bị vô hiệu hóa quyền đăng nhập.
                </p>
            </div>

            <!-- Body Content -->
            <div class="px-7 py-6 space-y-5">
                <input type="hidden" id="lock_account_id">

                <!-- 2 Cột: Trạng thái hiện tại & Sau xác nhận -->
                <div class="grid grid-cols-2 gap-6 p-4 bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px]">
                    <div>
                        <span class="block text-[11px] font-semibold text-[#52697c] uppercase tracking-wide">
                            Trạng thái hiện tại
                        </span>
                        <span class="block text-[14px] font-medium text-[#16734b] mt-1">
                            Đang hoạt động
                        </span>
                    </div>
                    <div>
                        <span class="block text-[11px] font-semibold text-[#52697c] uppercase tracking-wide">
                            Sau xác nhận
                        </span>
                        <span class="block text-[14px] font-medium text-[#b91c1c] mt-1">
                            Bị khóa
                        </span>
                    </div>
                </div>

                <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-[4px] text-[13px] text-rose-700 leading-relaxed">
                    Lưu ý: Sau khi bị khóa, người dùng này sẽ không thể đăng nhập vào ứng dụng cư dân hoặc cổng quản trị cho đến khi được mở khóa.
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-7 py-4 bg-[#f8fafc] border-t border-[#d9e4ec] flex items-center justify-between">
                <button
                    type="button"
                    onclick="closeAccountLockModal()"
                    class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-slate-50 text-[#334b5d] text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                >
                    Hủy
                </button>
                <button
                    type="button"
                    onclick="confirmAccountLock()"
                    class="h-[40px] px-6 bg-[#b91c1c] hover:bg-[#991b1b] text-white text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
                >
                    Xác nhận khóa
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Popup: Mở khóa tài khoản (Unlock Account) -->
<div
    id="accountUnlockModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="unlock-modal-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        id="accountUnlockBackdrop"
        onclick="closeAccountUnlockModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="accountUnlockPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[560px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <!-- Header -->
            <div class="px-7 pt-6 pb-4 border-b border-[#d9e4ec]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#16734b] tracking-wider uppercase select-none">
                        BẢO MẬT & TRUY CẬP
                    </span>
                    <button
                        type="button"
                        onclick="closeAccountUnlockModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="unlock-modal-title">
                    Mở khóa tài khoản
                </h3>
                <p class="text-[13px] text-[#52697c] mt-0.5" id="unlock_account_subtitle">
                    Khôi phục quyền truy cập hệ thống cho tài khoản.
                </p>
            </div>

            <!-- Body Content -->
            <div class="px-7 py-6 space-y-5">
                <input type="hidden" id="unlock_account_id">

                <!-- 2 Cột: Trạng thái hiện tại & Sau xác nhận -->
                <div class="grid grid-cols-2 gap-6 p-4 bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px]">
                    <div>
                        <span class="block text-[11px] font-semibold text-[#52697c] uppercase tracking-wide">
                            Trạng thái hiện tại
                        </span>
                        <span class="block text-[14px] font-medium text-[#b91c1c] mt-1">
                            Bị khóa
                        </span>
                    </div>
                    <div>
                        <span class="block text-[11px] font-semibold text-[#52697c] uppercase tracking-wide">
                            Sau xác nhận
                        </span>
                        <span class="block text-[14px] font-medium text-[#16734b] mt-1">
                            Đang hoạt động
                        </span>
                    </div>
                </div>

                <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-[4px] text-[13px] text-[#16734b] leading-relaxed">
                    Sau khi mở khóa, người dùng có thể sử dụng lại tên đăng nhập và mật khẩu hiện có để đăng nhập bình thường.
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-7 py-4 bg-[#f8fafc] border-t border-[#d9e4ec] flex items-center justify-between">
                <button
                    type="button"
                    onclick="closeAccountUnlockModal()"
                    class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-slate-50 text-[#334b5d] text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                >
                    Hủy
                </button>
                <button
                    type="button"
                    onclick="confirmAccountUnlock()"
                    class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
                >
                    Xác nhận mở khóa
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentLockAccount = null;

    // --- LOCK MODAL ---
    function openAccountLockModal(acc) {
        currentLockAccount = acc;
        document.getElementById('lock_account_id').value = acc.id;
        document.getElementById('lock_account_subtitle').innerText = `${acc.name} · ${acc.username}`;

        const modal = document.getElementById('accountLockModal');
        const backdrop = document.getElementById('accountLockBackdrop');
        const panel = document.getElementById('accountLockPanel');

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeAccountLockModal() {
        const modal = document.getElementById('accountLockModal');
        const backdrop = document.getElementById('accountLockBackdrop');
        const panel = document.getElementById('accountLockPanel');

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 200);
    }

    function confirmAccountLock() {
        if (!currentLockAccount) return;
        const id = currentLockAccount.id;
        const row = document.getElementById(`acc-row-${id}`);

        if (row) {
            // Cập nhật trạng thái
            const statusEl = row.querySelector('.acc-status');
            if (statusEl) {
                statusEl.innerText = 'Bị khóa';
                statusEl.classList.add('text-rose-600', 'font-medium');
            }

            // Cập nhật nút khóa/mở khóa
            const actionsEl = row.querySelector('.acc-actions');
            if (actionsEl) {
                currentLockAccount.status = 'LOCKED';
                currentLockAccount.status_label = 'Bị khóa';
                const lockBtn = actionsEl.querySelector('.btn-lock-toggle');
                if (lockBtn) {
                    lockBtn.innerText = 'Mở khóa';
                    lockBtn.className = 'text-[#2864ad] hover:underline font-medium cursor-pointer btn-lock-toggle';
                    lockBtn.onclick = () => openAccountUnlockModal(currentLockAccount);
                }
            }
        }

        const name = currentLockAccount.name;
        closeAccountLockModal();
        if (window.showToast) {
            window.showToast(`Đã khóa tài khoản ${name} thành công!`, 'danger');
        }
    }

    // --- UNLOCK MODAL ---
    function openAccountUnlockModal(acc) {
        currentLockAccount = acc;
        document.getElementById('unlock_account_id').value = acc.id;
        document.getElementById('unlock_account_subtitle').innerText = `${acc.name} · ${acc.username}`;

        const modal = document.getElementById('accountUnlockModal');
        const backdrop = document.getElementById('accountUnlockBackdrop');
        const panel = document.getElementById('accountUnlockPanel');

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeAccountUnlockModal() {
        const modal = document.getElementById('accountUnlockModal');
        const backdrop = document.getElementById('accountUnlockBackdrop');
        const panel = document.getElementById('accountUnlockPanel');

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 200);
    }

    function confirmAccountUnlock() {
        if (!currentLockAccount) return;
        const id = currentLockAccount.id;
        const row = document.getElementById(`acc-row-${id}`);

        if (row) {
            // Cập nhật trạng thái
            const statusEl = row.querySelector('.acc-status');
            if (statusEl) {
                statusEl.innerText = 'Hoạt động';
                statusEl.classList.remove('text-rose-600', 'font-medium');
            }

            // Cập nhật nút khóa/mở khóa
            const actionsEl = row.querySelector('.acc-actions');
            if (actionsEl) {
                currentLockAccount.status = 'ACTIVE';
                currentLockAccount.status_label = 'Hoạt động';
                const lockBtn = actionsEl.querySelector('.btn-lock-toggle');
                if (lockBtn) {
                    lockBtn.innerText = 'Khóa';
                    lockBtn.className = 'text-[#b91c1c] hover:underline font-medium cursor-pointer btn-lock-toggle';
                    lockBtn.onclick = () => openAccountLockModal(currentLockAccount);
                }
            }
        }

        const name = currentLockAccount.name;
        closeAccountUnlockModal();
        if (window.showToast) {
            window.showToast(`Đã mở khóa tài khoản ${name} thành công!`);
        }
    }
</script>
