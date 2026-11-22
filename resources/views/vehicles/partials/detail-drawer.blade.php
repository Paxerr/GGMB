<!-- Slide-over Drawer: Chi tiết phương tiện (26 · SCR-VEH-02) -->
<div
    id="vehicleDetailDrawer"
    class="fixed inset-0 z-50 overflow-hidden hidden"
    aria-labelledby="vehicle-slide-over-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Background backdrop -->
    <div
        id="vehicleDrawerBackdrop"
        onclick="closeVehicleDetailDrawer()"
        class="fixed inset-0 bg-black/40 backdrop-blur-[1px] transition-opacity duration-300 opacity-0"
    ></div>

    <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
        <div
            id="vehicleDrawerPanel"
            class="w-screen max-w-[560px] bg-white border-l border-[#E5E7EB] shadow-2xl flex flex-col transform transition-transform duration-300 ease-in-out translate-x-full"
        >
            <!-- Drawer Header -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-[18px] leading-[24px] font-bold text-[#111827]" id="vehicle-slide-over-title">
                        Hồ sơ phương tiện
                    </h2>
                    <p class="text-[13px] leading-[18px] text-[#6B7280] mt-0.5" id="vehicleDrawerSubtitle">
                        Thông tin đăng ký xe và thẻ phương tiện
                    </p>
                </div>
                <button
                    type="button"
                    onclick="closeVehicleDetailDrawer()"
                    class="w-8 h-8 rounded-[8px] flex items-center justify-center text-[#6B7280] hover:text-[#111827] hover:bg-white/60 transition-colors cursor-pointer"
                    aria-label="Đóng"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Drawer Body -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                <!-- Khối định danh xe -->
                <div class="bg-[#F8FAF8] border border-[#E5E7EB] p-4 rounded-[10px]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-[8px] bg-[#0E4D3C] text-white flex items-center justify-center shrink-0" id="vehicleDrawerIcon">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h2"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-[18px] font-bold text-[#111827] font-mono tracking-wide" id="vehicleDrawerPlate">
                                --
                            </h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[12px] text-[#6B7280]">Mã xe (VehicleId):</span>
                                <span class="text-[12px] font-mono font-semibold text-[#111827]" id="vehicleDrawerId">--</span>
                            </div>
                        </div>
                        <div id="vehicleDrawerTypeBadge">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] text-[12px] font-semibold bg-[#E4EFE9] text-[#0E4D3C]">
                                Xe máy
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Thông tin căn hộ & Phân bổ chỗ đỗ -->
                <div>
                    <h4 class="text-[13px] font-bold text-[#111827] uppercase tracking-wide mb-3 pb-1 border-b border-[#E5E7EB]">
                        Căn hộ & Đăng ký
                    </h4>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3 text-[13.5px]">
                        <div>
                            <dt class="text-[12px] font-medium text-[#6B7280]">Căn hộ sở hữu</dt>
                            <dd class="font-bold text-[#0E4D3C] text-[16px] mt-0.5" id="vehicleDrawerApartment">--</dd>
                        </div>
                        <div>
                            <dt class="text-[12px] font-medium text-[#6B7280]">Vị trí tòa / tầng</dt>
                            <dd class="font-medium text-[#111827] mt-0.5" id="vehicleDrawerLocation">Tòa A · Tầng 1</dd>
                        </div>
                        <div>
                            <dt class="text-[12px] font-medium text-[#6B7280]">Ngày đăng ký</dt>
                            <dd class="font-medium text-[#111827] mt-0.5" id="vehicleDrawerCreatedAt">--</dd>
                        </div>
                        <div>
                            <dt class="text-[12px] font-medium text-[#6B7280]">Trạng thái đăng ký</dt>
                            <dd class="font-semibold text-[#0E4D3C] mt-0.5 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-[#0E4D3C]"></span>
                                Đang hoạt động
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Quy định & Biểu phí -->
                <div>
                    <h4 class="text-[13px] font-bold text-[#111827] uppercase tracking-wide mb-3 pb-1 border-b border-[#E5E7EB]">
                        Biểu phí & Quy định đỗ xe
                    </h4>
                    <div class="bg-white border border-[#E5E7EB] p-4 rounded-[10px] space-y-2 text-[13px] text-[#6B7280]">
                        <p class="leading-[19px]">
                            • Phí trông giữ xe được tính gộp vào kỳ hóa đơn sinh hoạt hàng tháng của căn hộ.
                        </p>
                        <p class="leading-[19px]">
                            • Cư dân cần quẹt thẻ xe đúng biển số đăng ký tại cổng kiểm soát tầng hầm.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Drawer Footer -->
            <div class="p-4 bg-[#F2F6F4] border-t border-[#E5E7EB] flex items-center justify-between shrink-0">
                <button
                    type="button"
                    onclick="closeVehicleDetailDrawer(); if (window.currentVehicleData) openCancelVehicleModal(window.currentVehicleData);"
                    class="h-[38px] px-4 bg-white border border-rose-200 hover:bg-rose-50 text-rose-600 text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer"
                >
                    Hủy đăng ký xe
                </button>
                <button
                    type="button"
                    onclick="closeVehicleDetailDrawer()"
                    class="h-[38px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer"
                >
                    Đóng
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openVehicleDetailDrawer(data) {
        window.currentVehicleData = data;
        const drawer = document.getElementById('vehicleDetailDrawer');
        const backdrop = document.getElementById('vehicleDrawerBackdrop');
        const panel = document.getElementById('vehicleDrawerPanel');

        if (!drawer || !backdrop || !panel) return;

        // Điền dữ liệu
        document.getElementById('vehicleDrawerPlate').textContent = data.licensePlate || '—';
        document.getElementById('vehicleDrawerId').textContent = data.vehicleId || '—';
        document.getElementById('vehicleDrawerApartment').textContent = 'Căn hộ ' + (data.apartmentNumber || '—');
        document.getElementById('vehicleDrawerLocation').textContent = (data.buildingName || 'Tòa A') + ' · Tầng ' + (data.floorNumber || '1');
        document.getElementById('vehicleDrawerCreatedAt').textContent = data.createdAt || '01/01/2026';
        document.getElementById('vehicleDrawerSubtitle').textContent = `Biển số ${data.licensePlate || ''} · ${data.typeName || 'Xe máy'}`;

        // Loại xe & Icon
        const isCar = (data.vehicleType === 'CAR');
        document.getElementById('vehicleDrawerIcon').innerHTML = isCar
            ? '<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h2"/></svg>'
            : '<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="5.5" cy="17.5" r="3.5" stroke-width="2"/><circle cx="18.5" cy="17.5" r="3.5" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 6h-3l-2.5 5.5H18M9 17.5l2-6M12 17.5l3-6"/></svg>';
        
        const badge = document.getElementById('vehicleDrawerTypeBadge');
        if (isCar) {
            badge.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] text-[12px] font-semibold bg-[#E4EFE9] text-[#0E4D3C]">CAR · Ô tô</span>';
        } else if (data.vehicleType === 'ELECTRIC_BIKE') {
            badge.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] text-[12px] font-semibold bg-emerald-50 text-[#0E4D3C]">ELECTRIC · Xe điện</span>';
        } else if (data.vehicleType === 'BICYCLE') {
            badge.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] text-[12px] font-semibold bg-gray-100 text-[#6B7280]">BICYCLE · Xe đạp</span>';
        } else {
            badge.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] text-[12px] font-semibold bg-[#E4EFE9] text-[#0E4D3C]">MOTORBIKE · Xe máy</span>';
        }

        drawer.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('translate-x-full');
            panel.classList.add('translate-x-0');
        });
    }

    function closeVehicleDetailDrawer() {
        const drawer = document.getElementById('vehicleDetailDrawer');
        const backdrop = document.getElementById('vehicleDrawerBackdrop');
        const panel = document.getElementById('vehicleDrawerPanel');

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
