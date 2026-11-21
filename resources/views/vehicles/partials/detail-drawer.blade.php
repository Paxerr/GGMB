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
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-300 opacity-0"
    ></div>

    <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
        <div
            id="vehicleDrawerPanel"
            class="w-screen max-w-[560px] bg-white border-l border-[#d9e4ec] shadow-2xl flex flex-col transform transition-transform duration-300 ease-in-out translate-x-full"
        >
            <!-- Drawer Header -->
            <div class="px-6 py-5 bg-[#e4edf3] border-b border-[#d9e4ec] flex items-center justify-between shrink-0">
                <div>
                    <h2 class="text-[18px] leading-[24px] font-semibold text-[#122d40]" id="vehicle-slide-over-title">
                        Hồ sơ phương tiện
                    </h2>
                    <p class="text-[13px] leading-[18px] text-[#334b5d] mt-0.5" id="vehicleDrawerSubtitle">
                        Thông tin đăng ký xe và thẻ phương tiện
                    </p>
                </div>
                <button
                    type="button"
                    onclick="closeVehicleDetailDrawer()"
                    class="w-8 h-8 rounded-[4px] flex items-center justify-center text-[#52697c] hover:text-[#122d40] hover:bg-white/60 transition-colors cursor-pointer"
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
                <div class="bg-[#f8fafc] border border-[#d9e4ec] p-4 rounded-[4px]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-[4px] bg-[#2864ad] text-white flex items-center justify-center text-xl shrink-0" id="vehicleDrawerIcon">
                            🚗
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-[18px] font-bold text-[#122d40] font-mono tracking-wide" id="vehicleDrawerPlate">
                                --
                            </h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[12px] text-[#52697c]">Mã xe (VehicleId):</span>
                                <span class="text-[12px] font-mono font-semibold text-[#122d40]" id="vehicleDrawerId">--</span>
                            </div>
                        </div>
                        <div id="vehicleDrawerTypeBadge">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[12px] font-medium bg-[#e8f1ff] text-[#2864ad]">
                                Xe máy
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Thông tin căn hộ & Phân bổ chỗ đỗ -->
                <div>
                    <h4 class="text-[14px] font-semibold text-[#122d40] mb-3 pb-1 border-b border-[#d9e4ec]">
                        Căn hộ & Đăng ký
                    </h4>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3 text-[14px]">
                        <div>
                            <dt class="text-[12px] text-[#52697c]">Căn hộ sở hữu</dt>
                            <dd class="font-bold text-[#2864ad] text-[16px] mt-0.5" id="vehicleDrawerApartment">--</dd>
                        </div>
                        <div>
                            <dt class="text-[12px] text-[#52697c]">Vị trí tòa / tầng</dt>
                            <dd class="font-medium text-[#122d40] mt-0.5" id="vehicleDrawerLocation">Tòa A · Tầng 1</dd>
                        </div>
                        <div>
                            <dt class="text-[12px] text-[#52697c]">Ngày đăng ký</dt>
                            <dd class="font-medium text-[#122d40] mt-0.5" id="vehicleDrawerCreatedAt">--</dd>
                        </div>
                        <div>
                            <dt class="text-[12px] text-[#52697c]">Trạng thái đăng ký</dt>
                            <dd class="font-medium text-[#16734b] mt-0.5 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-[#16734b]"></span>
                                Đang hoạt động
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Quy định & Biểu phí -->
                <div>
                    <h4 class="text-[14px] font-semibold text-[#122d40] mb-3 pb-1 border-b border-[#d9e4ec]">
                        Biểu phí & Quy định đỗ xe
                    </h4>
                    <div class="bg-white border border-[#d9e4ec] p-4 rounded-[4px] space-y-2 text-[13px] text-[#52697c]">
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
            <div class="p-4 bg-[#f8fafc] border-t border-[#d9e4ec] flex items-center justify-between shrink-0">
                <button
                    type="button"
                    onclick="closeVehicleDetailDrawer(); if (window.currentVehicleData) openCancelVehicleModal(window.currentVehicleData);"
                    class="h-[38px] px-4 bg-white border border-rose-200 hover:bg-rose-50 text-rose-600 text-[13px] font-medium rounded-[4px] transition-colors cursor-pointer"
                >
                    Hủy đăng ký xe
                </button>
                <button
                    type="button"
                    onclick="closeVehicleDetailDrawer()"
                    class="h-[38px] px-5 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-medium rounded-[4px] transition-colors cursor-pointer"
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
        document.getElementById('vehicleDrawerIcon').textContent = isCar ? '🚗' : '🛵';
        
        const badge = document.getElementById('vehicleDrawerTypeBadge');
        if (isCar) {
            badge.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded text-[12px] font-semibold bg-[#e6f5ec] text-[#16734b]">CAR · Ô tô</span>';
        } else if (data.vehicleType === 'ELECTRIC_BIKE') {
            badge.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded text-[12px] font-semibold bg-[#f0edfa] text-[#6a51ae]">ELECTRIC · Xe điện</span>';
        } else if (data.vehicleType === 'BICYCLE') {
            badge.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded text-[12px] font-semibold bg-gray-100 text-[#52697c]">BICYCLE · Xe đạp</span>';
        } else {
            badge.innerHTML = '<span class="inline-flex items-center px-2.5 py-0.5 rounded text-[12px] font-semibold bg-[#e8f1ff] text-[#2864ad]">MOTORBIKE · Xe máy</span>';
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
