<!-- Modal Popup: Chi tiết tài khoản -->
<div
    id="accountDetailModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="account-detail-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        id="accountDetailBackdrop"
        onclick="closeAccountDetailModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="accountDetailPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[620px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Header -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#0E4D3C] tracking-wider uppercase select-none">
                        THÔNG TIN TÀI KHOẢN
                    </span>
                    <button
                        type="button"
                        onclick="closeAccountDetailModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] sm:text-[20px] font-bold text-[#111827] tracking-tight mt-1" id="account-detail-title">
                    Chi tiết tài khoản
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-0.5" id="detail_user_subtitle">
                    Hồ sơ chi tiết và phân quyền tài khoản
                </p>
            </div>

            <!-- Body Details -->
            <div class="p-6 space-y-5 text-[13px]">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <span class="block text-[11px] font-bold text-[#6B7280] uppercase tracking-wide">Họ và tên</span>
                        <span class="block text-[15px] font-semibold text-[#111827] mt-1" id="detail_name">—</span>
                    </div>
                    <div>
                        <span class="block text-[11px] font-bold text-[#6B7280] uppercase tracking-wide">Tên đăng nhập</span>
                        <span class="block text-[14px] font-mono font-medium text-[#111827] mt-1" id="detail_username">—</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <span class="block text-[11px] font-bold text-[#6B7280] uppercase tracking-wide">Email</span>
                        <span class="block text-[13.5px] text-[#374151] mt-1" id="detail_email">—</span>
                    </div>
                    <div>
                        <span class="block text-[11px] font-bold text-[#6B7280] uppercase tracking-wide">Điện thoại</span>
                        <span class="block text-[13.5px] font-mono text-[#374151] mt-1" id="detail_phone">—</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <span class="block text-[11px] font-bold text-[#6B7280] uppercase tracking-wide">Vai trò</span>
                        <span class="block text-[13.5px] font-medium text-[#111827] mt-1" id="detail_role">—</span>
                    </div>
                    <div>
                        <span class="block text-[11px] font-bold text-[#6B7280] uppercase tracking-wide">Trạng thái</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 mt-1 rounded-[6px] text-[12px] font-semibold" id="detail_status_badge">—</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <span class="block text-[11px] font-bold text-[#6B7280] uppercase tracking-wide">Căn cước</span>
                        <span class="block text-[13.5px] font-mono text-[#374151] mt-1" id="detail_citizen_id">—</span>
                    </div>
                    <div>
                        <span class="block text-[11px] font-bold text-[#6B7280] uppercase tracking-wide">Bộ phận</span>
                        <span class="block text-[13.5px] text-[#374151] mt-1" id="detail_dept">—</span>
                    </div>
                </div>

                <div class="p-3.5 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[12px] text-[#6B7280]" id="detail_note_box">
                    Ghi chú: <span id="detail_note" class="text-[#374151]">Không có ghi chú.</span>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-6 py-4 bg-[#F8FAF8] border-t border-[#E5E7EB] rounded-b-[16px] flex items-center justify-between">
                <button
                    type="button"
                    onclick="closeAccountDetailModal()"
                    class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer"
                >
                    Đóng
                </button>

                <div class="flex items-center space-x-2">
                    <button
                        type="button"
                        id="detailEditBtn"
                        onclick="switchDetailToEdit()"
                        class="h-[40px] px-5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer shadow-sm"
                    >
                        Chỉnh sửa
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentAccountData = null;

    function openAccountDetailModal(acc) {
        currentAccountData = acc;
        document.getElementById('detail_user_subtitle').innerText = `${acc.name} · ${acc.username}`;
        document.getElementById('detail_name').innerText = acc.name || '—';
        document.getElementById('detail_username').innerText = acc.username || '—';
        document.getElementById('detail_email').innerText = acc.email || '—';
        document.getElementById('detail_phone').innerText = acc.phone || '—';
        document.getElementById('detail_role').innerText = acc.role || '—';
        document.getElementById('detail_citizen_id').innerText = acc.citizen_id || '079000000001';
        document.getElementById('detail_dept').innerText = acc.dept || 'Ban quản lý chung cư GGMB';
        document.getElementById('detail_note').innerText = acc.note || 'Tài khoản nhân sự đang hoạt động bình thường.';

        const statusBadge = document.getElementById('detail_status_badge');
        if (acc.status === 'ACTIVE' || acc.status_label === 'Hoạt động') {
            statusBadge.className = 'inline-flex items-center px-2.5 py-0.5 mt-1 rounded-[6px] text-[12px] font-semibold bg-[#E4EFE9] text-[#0E4D3C]';
            statusBadge.innerText = 'Hoạt động';
        } else {
            statusBadge.className = 'inline-flex items-center px-2.5 py-0.5 mt-1 rounded-[6px] text-[12px] font-semibold bg-rose-50 text-[#B91C1C]';
            statusBadge.innerText = 'Bị khóa';
        }

        const modal = document.getElementById('accountDetailModal');
        const backdrop = document.getElementById('accountDetailBackdrop');
        const panel = document.getElementById('accountDetailPanel');

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeAccountDetailModal() {
        const modal = document.getElementById('accountDetailModal');
        const backdrop = document.getElementById('accountDetailBackdrop');
        const panel = document.getElementById('accountDetailPanel');

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 200);
    }

    function switchDetailToEdit() {
        closeAccountDetailModal();
        if (currentAccountData) {
            setTimeout(() => openAccountEditModal(currentAccountData), 220);
        }
    }
</script>
