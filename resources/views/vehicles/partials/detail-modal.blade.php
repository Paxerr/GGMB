<!-- Modal Popup: Chi tiết phương tiện (Ảnh 1 chuẩn dạng Popup Modal) -->
<div
    id="vehicleDetailModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="vehicle-detail-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Background backdrop -->
    <div
        id="vehicleDetailBackdrop"
        onclick="closeVehicleDetailModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="vehicleDetailPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[640px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header (Bám sát Ảnh 1) -->
            <div class="px-7 pt-6 pb-4">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeVehicleDetailModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="vehicle-detail-title">
                    Chi tiết phương tiện
                </h3>
                <p class="text-[13px] text-[#52697c] mt-1" id="vehicleDetailSubtitle">
                    Biển số 29-B1 100.01 · Xe máy
                </p>
            </div>

            <!-- Modal Content (Khối thông tin chuẩn Ảnh 1) -->
            <div class="px-7 pb-6 space-y-5">
                <!-- Hàng 1: Biển số & Loại xe (2 cột) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                            Biển số
                        </span>
                        <span class="block text-[14px] leading-[20px] text-[#122d40] mt-1 font-normal font-mono" id="vehicleDetailPlate">
                            29-B1 100.01
                        </span>
                    </div>
                    <div>
                        <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                            Loại xe
                        </span>
                        <span class="block text-[14px] leading-[20px] text-[#122d40] mt-1 font-normal" id="vehicleDetailType">
                            Xe máy
                        </span>
                    </div>
                </div>

                <!-- Hàng 2: Căn hộ liên kết -->
                <div>
                    <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                        Căn hộ liên kết
                    </span>
                    <span class="block text-[14px] leading-[20px] text-[#122d40] mt-1 font-normal" id="vehicleDetailApartment">
                        Tòa A · Tầng 1 · 0101
                    </span>
                </div>
            </div>

            <!-- Modal Footer (3 nút: Về danh sách, Chỉnh sửa, Hủy đăng ký - Bám sát Ảnh 1) -->
            <div class="px-7 py-4 border-t border-[#d9e4ec] flex flex-col sm:flex-row items-center gap-3">
                <button
                    type="button"
                    onclick="closeVehicleDetailModal()"
                    class="w-full sm:flex-1 h-[40px] bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center whitespace-nowrap cursor-pointer select-none"
                >
                    Về danh sách
                </button>
                <button
                    type="button"
                    onclick="editVehicleFromDetail()"
                    class="w-full sm:flex-1 h-[40px] bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center whitespace-nowrap cursor-pointer select-none shadow-sm"
                >
                    Chỉnh sửa
                </button>
                <button
                    type="button"
                    onclick="cancelVehicleFromDetail()"
                    class="w-full sm:flex-1 h-[40px] bg-white border border-[#d9e4ec] hover:bg-rose-50 text-[#b91c1c] text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center whitespace-nowrap cursor-pointer select-none"
                >
                    Hủy đăng ký
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let activeVehicleData = null;

    function openVehicleDetailModal(idOrData) {
        const data = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.vehiclesMap?.[idOrData] || {});
        activeVehicleData = data;
        const modal = document.getElementById('vehicleDetailModal');
        const backdrop = document.getElementById('vehicleDetailBackdrop');
        const panel = document.getElementById('vehicleDetailPanel');

        if (!modal || !backdrop || !panel) return;

        // Điền dữ liệu bám sát ảnh 1
        const plate = data.licensePlate || '29-B1 100.01';
        const typeName = data.typeName || 'Xe máy';
        const aptNumber = data.apartmentNumber || '0101';
        const building = data.buildingName || 'Tòa A';
        const floor = data.floorNumber || '1';
        const aptText = `${building} · Tầng ${floor} · ${aptNumber}`;

        document.getElementById('vehicleDetailSubtitle').textContent = `Biển số ${plate} · ${typeName}`;
        document.getElementById('vehicleDetailPlate').textContent = plate;
        document.getElementById('vehicleDetailType').textContent = typeName;
        document.getElementById('vehicleDetailApartment').textContent = aptText;

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeVehicleDetailModal() {
        const modal = document.getElementById('vehicleDetailModal');
        const backdrop = document.getElementById('vehicleDetailBackdrop');
        const panel = document.getElementById('vehicleDetailPanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function editVehicleFromDetail() {
        const data = activeVehicleData;
        closeVehicleDetailModal();
        if (data && typeof openEditVehicleModal === 'function') {
            setTimeout(() => {
                openEditVehicleModal(data);
            }, 250);
        }
    }

    function cancelVehicleFromDetail() {
        const data = activeVehicleData;
        closeVehicleDetailModal();
        if (data && typeof openCancelVehicleModal === 'function') {
            setTimeout(() => {
                openCancelVehicleModal(data);
            }, 250);
        }
    }
</script>
