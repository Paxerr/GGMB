<!-- Slide-over Drawer: Chi tiết cư dân (SCR-RES-02) -->
<div
    id="residentDetailDrawer"
    class="fixed inset-0 z-50 overflow-hidden hidden"
    aria-labelledby="slide-over-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Background backdrop -->
    <div
        id="drawerBackdrop"
        onclick="closeResidentDetailDrawer()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-300 opacity-0"
    ></div>

    <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
        <div
            id="drawerPanel"
            class="w-screen max-w-[600px] bg-white border-l border-[#d9e4ec] shadow-2xl flex flex-col transform transition-transform duration-300 ease-in-out translate-x-full"
        >
            <!-- Drawer Header -->
            <div class="px-6 py-5 bg-[#e4edf3] border-b border-[#d9e4ec] flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-[18px] leading-[24px] font-semibold text-[#122d40]" id="slide-over-title">
                        Hồ sơ cư dân
                    </h2>
                    <p class="text-[13px] leading-[18px] text-[#334b5d] mt-0.5" id="drawerSubtitle">
                        Thông tin tài khoản cư dân và quan hệ cư trú
                    </p>
                </div>
                <button
                    type="button"
                    onclick="closeResidentDetailDrawer()"
                    class="w-8 h-8 rounded-[4px] flex items-center justify-center text-[#52697c] hover:text-[#122d40] hover:bg-white/60 transition-colors cursor-pointer"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Drawer Body -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                <!-- Thông tin định danh -->
                <div class="bg-[#f8fafc] border border-[#d9e4ec] p-4 rounded-[4px]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#2864ad] text-white flex items-center justify-center text-lg font-semibold shrink-0" id="drawerAvatar">
                            --
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-[16px] font-semibold text-[#122d40] truncate" id="drawerFullName">
                                Đang tải…
                            </h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[12px] text-[#52697c]">Mã cư dân (UserId):</span>
                                <span class="text-[12px] font-mono font-semibold text-[#122d40]" id="drawerUserId">--</span>
                            </div>
                        </div>
                        <div id="drawerStatusBadge">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[12px] font-medium bg-[#e6f5ec] text-[#16734b]">
                                Đang cư trú
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Chi tiết liên hệ & giấy tờ -->
                <div>
                    <h4 class="text-[14px] font-semibold text-[#122d40] mb-3 pb-1 border-b border-[#d9e4ec]">
                        Thông tin liên hệ & Giấy tờ
                    </h4>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3 text-[14px]">
                        <div>
                            <dt class="text-[12px] text-[#52697c]">Số CCCD / CMND</dt>
                            <dd class="font-medium text-[#122d40] mt-0.5 font-mono" id="drawerCitizenId">--</dd>
                        </div>
                        <div>
                            <dt class="text-[12px] text-[#52697c]">Số điện thoại</dt>
                            <dd class="font-medium text-[#122d40] mt-0.5 font-mono" id="drawerPhone">--</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-[12px] text-[#52697c]">Địa chỉ Email</dt>
                            <dd class="font-medium text-[#122d40] mt-0.5" id="drawerEmail">--</dd>
                        </div>
                    </dl>
                </div>

                <!-- Quan hệ cư trú & Căn hộ -->
                <div>
                    <h4 class="text-[14px] font-semibold text-[#122d40] mb-3 pb-1 border-b border-[#d9e4ec]">
                        Thông tin căn hộ & Cư trú
                    </h4>
                    <div class="bg-white border border-[#d9e4ec] p-4 rounded-[4px] space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] text-[#52697c]">Căn hộ hiện tại</span>
                            <span class="text-[16px] font-bold text-[#2864ad]" id="drawerApartment">--</span>
                        </div>
                        <div class="flex items-center justify-between text-[13px]">
                            <span class="text-[#52697c]">Tòa nhà / Tầng</span>
                            <span class="font-medium text-[#122d40]" id="drawerLocation">--</span>
                        </div>
                        <div class="flex items-center justify-between text-[13px]">
                            <span class="text-[#52697c]">Ngày bắt đầu cư trú</span>
                            <span class="font-medium text-[#122d40]" id="drawerStartDate">--</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Drawer Footer -->
            <div class="p-4 bg-[#f8fafc] border-t border-[#d9e4ec] flex items-center justify-between shrink-0">
                <a
                    id="drawerFullPageLink"
                    href="#"
                    class="text-[13px] font-medium text-[#2864ad] hover:underline flex items-center gap-1"
                >
                    Xem chi tiết &rarr;
                </a>
                <div class="flex items-center space-x-2">
                    <button
                        type="button"
                        onclick="closeResidentDetailDrawer(); if (window.currentResidentData) openStatusResidentModal(window.currentResidentData);"
                        class="h-[38px] px-3.5 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[13px] font-medium rounded-[4px] transition-colors cursor-pointer"
                    >
                        Đổi trạng thái
                    </button>
                    <a
                        id="drawerEditBtn"
                        href="#"
                        class="h-[38px] px-4 bg-[#2864ad] hover:bg-[#205391] text-white text-[13px] font-medium rounded-[4px] transition-colors flex items-center justify-center cursor-pointer"
                    >
                        Chỉnh sửa
                    </a>
                    <button
                        type="button"
                        onclick="closeResidentDetailDrawer()"
                        class="h-[38px] px-3.5 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#52697c] text-[13px] font-medium rounded-[4px] transition-colors cursor-pointer"
                    >
                        Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openResidentDetailDrawer(idOrData) {
        const residentData = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.residentsMap?.[idOrData] || {});
        window.currentResidentData = residentData;
        const drawer = document.getElementById('residentDetailDrawer');
        const backdrop = document.getElementById('drawerBackdrop');
        const panel = document.getElementById('drawerPanel');

        if (!drawer || !backdrop || !panel) return;

        // Populate details
        document.getElementById('drawerFullName').textContent = residentData.fullName || '—';
        document.getElementById('drawerUserId').textContent = residentData.userId || '—';
        document.getElementById('drawerCitizenId').textContent = residentData.citizenId || '—';
        document.getElementById('drawerPhone').textContent = residentData.phone || '—';
        document.getElementById('drawerEmail').textContent = residentData.email || '—';
        document.getElementById('drawerApartment').textContent = residentData.apartmentNumber || '—';
        document.getElementById('drawerLocation').textContent = (residentData.buildingName || 'Tòa A') + ' · Tầng ' + (residentData.floorNumber || '1');
        document.getElementById('drawerStartDate').textContent = residentData.startDate || '—';
        if (document.getElementById('drawerFullPageLink')) {
            document.getElementById('drawerFullPageLink').href = '/residents/' + (residentData.userId || '');
        }
        if (document.getElementById('drawerEditBtn')) {
            document.getElementById('drawerEditBtn').href = '/residents/' + (residentData.userId || '') + '/edit';
        }

        // Avatar initials
        const nameParts = (residentData.fullName || '').trim().split(' ');
        const initials = nameParts.length > 1 
            ? (nameParts[0][0] + nameParts[nameParts.length - 1][0]).toUpperCase()
            : (residentData.fullName ? residentData.fullName.substring(0, 2).toUpperCase() : '--');
        document.getElementById('drawerAvatar').textContent = initials;

        // Status badge
        const isCurrent = residentData.residenceStatus === 'ACTIVE';
        const badgeContainer = document.getElementById('drawerStatusBadge');
        if (isCurrent) {
            badgeContainer.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded text-[12px] font-medium bg-[#e6f5ec] text-[#16734b]">Đang cư trú</span>';
        } else {
            badgeContainer.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded text-[12px] font-medium bg-[#f0f4f8] text-[#5c7284]">Đã rời đi</span>';
        }

        // Show drawer with animation
        drawer.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('translate-x-full');
            panel.classList.add('translate-x-0');
        });
    }

    function closeResidentDetailDrawer() {
        const drawer = document.getElementById('residentDetailDrawer');
        const backdrop = document.getElementById('drawerBackdrop');
        const panel = document.getElementById('drawerPanel');

        if (!drawer || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('translate-x-0');
        panel.classList.add('translate-x-full');

        setTimeout(() => {
            drawer.classList.add('hidden');
        }, 300);
    }
</script>
