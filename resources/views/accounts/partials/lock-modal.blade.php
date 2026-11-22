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
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[560px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Header -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#B91C1C] tracking-wider uppercase select-none">
                        BẢO MẬT & TRUY CẬP
                    </span>
                    <button
                        type="button"
                        onclick="closeAccountLockModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] sm:text-[20px] font-bold text-[#B91C1C] tracking-tight mt-1" id="lock-modal-title">
                    Khóa tài khoản
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-0.5" id="lock_account_subtitle">
                    Tài khoản sẽ bị vô hiệu hóa quyền đăng nhập.
                </p>
            </div>

            <!-- Body Content -->
            <div class="p-6 space-y-4">
                <input type="hidden" id="lock_account_id">

                <!-- 2 Cột: Trạng thái hiện tại & Sau xác nhận -->
                <div class="grid grid-cols-2 gap-4 p-4 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px]">
                    <div>
                        <span class="block text-[11px] font-semibold text-[#6B7280] uppercase tracking-wide">
                            Trạng thái hiện tại
                        </span>
                        <span class="block text-[14px] font-semibold text-[#0E4D3C] mt-1">
                            Đang hoạt động
                        </span>
                    </div>
                    <div>
                        <span class="block text-[11px] font-semibold text-[#6B7280] uppercase tracking-wide">
                            Sau xác nhận
                        </span>
                        <span class="block text-[14px] font-semibold text-[#B91C1C] mt-1">
                            Bị khóa
                        </span>
                    </div>
                </div>

                <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-[8px] text-[13px] text-rose-700 leading-relaxed">
                    Lưu ý: Sau khi bị khóa, người dùng này sẽ không thể đăng nhập vào ứng dụng cư dân hoặc cổng quản trị cho đến khi được mở khóa.
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-6 py-4 bg-[#F8FAF8] border-t border-[#E5E7EB] rounded-b-[16px] flex items-center justify-between">
                <button
                    type="button"
                    onclick="closeAccountLockModal()"
                    class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                >
                    Hủy
                </button>
                <button
                    type="button"
                    onclick="confirmAccountLock()"
                    class="h-[40px] px-5 bg-[#B91C1C] hover:bg-[#991B1B] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
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
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[560px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Header -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#0E4D3C] tracking-wider uppercase select-none">
                        BẢO MẬT & TRUY CẬP
                    </span>
                    <button
                        type="button"
                        onclick="closeAccountUnlockModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] sm:text-[20px] font-bold text-[#111827] tracking-tight mt-1" id="unlock-modal-title">
                    Mở khóa tài khoản
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-0.5" id="unlock_account_subtitle">
                    Khôi phục quyền truy cập hệ thống cho tài khoản.
                </p>
            </div>

            <!-- Body Content -->
            <div class="p-6 space-y-4">
                <input type="hidden" id="unlock_account_id">

                <!-- 2 Cột: Trạng thái hiện tại & Sau xác nhận -->
                <div class="grid grid-cols-2 gap-4 p-4 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px]">
                    <div>
                        <span class="block text-[11px] font-semibold text-[#6B7280] uppercase tracking-wide">
                            Trạng thái hiện tại
                        </span>
                        <span class="block text-[14px] font-semibold text-[#B91C1C] mt-1">
                            Bị khóa
                        </span>
                    </div>
                    <div>
                        <span class="block text-[11px] font-semibold text-[#6B7280] uppercase tracking-wide">
                            Sau xác nhận
                        </span>
                        <span class="block text-[14px] font-semibold text-[#0E4D3C] mt-1">
                            Đang hoạt động
                        </span>
                    </div>
                </div>

                <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-[8px] text-[13px] text-[#0E4D3C] leading-relaxed">
                    Sau khi mở khóa, người dùng có thể sử dụng lại tên đăng nhập và mật khẩu hiện có để đăng nhập bình thường.
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-6 py-4 bg-[#F8FAF8] border-t border-[#E5E7EB] rounded-b-[16px] flex items-center justify-between">
                <button
                    type="button"
                    onclick="closeAccountUnlockModal()"
                    class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                >
                    Hủy
                </button>
                <button
                    type="button"
                    onclick="confirmAccountUnlock()"
                    class="h-[40px] px-5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
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
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/accounts/${id}/lock`;
        form.innerHTML = `@csrf`;
        document.body.appendChild(form);
        form.submit();
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
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/accounts/${id}/unlock`;
        form.innerHTML = `@csrf`;
        document.body.appendChild(form);
        form.submit();
    }
</script>
