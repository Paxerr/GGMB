<!-- Modal Popup: Hủy đăng ký phương tiện (Ảnh 3 chuẩn dạng Popup Modal) -->
<div
    id="cancelVehicleModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="cancel-vehicle-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Background backdrop -->
    <div
        id="cancelVehicleBackdrop"
        onclick="closeCancelVehicleModal()"
        class="fixed inset-0 bg-black/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="cancelVehiclePanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[640px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header (Bám sát Ảnh 3) -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-rose-600 tracking-wider uppercase select-none">
                        XÁC NHẬN
                    </span>
                    <button
                        type="button"
                        onclick="closeCancelVehicleModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] font-bold text-rose-600 mt-1" id="cancel-vehicle-title">
                    Hủy đăng ký phương tiện
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-1" id="cancelModalSubtitle">
                    Xác nhận hủy đăng ký xe 29-B1 100.01 khỏi căn hộ 0101.
                </p>
            </div>

            <!-- Modal Form -->
            <form id="cancelVehicleForm" method="POST" action="">
                @csrf
                <div class="px-6 py-5 space-y-4">
                    <!-- Hàng 1: Biển số & Loại xe (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] p-3">
                            <span class="block text-[12px] font-semibold text-[#6B7280]">
                                Biển số
                            </span>
                            <span class="block text-[14px] font-bold text-[#111827] mt-0.5 font-mono" id="cancelModalPlate">
                                29-B1 100.01
                            </span>
                        </div>
                        <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] p-3">
                            <span class="block text-[12px] font-semibold text-[#6B7280]">
                                Loại xe
                            </span>
                            <span class="block text-[14px] font-medium text-[#111827] mt-0.5" id="cancelModalType">
                                Xe máy
                            </span>
                        </div>
                    </div>

                    <!-- Hàng 2: Căn hộ liên kết -->
                    <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] p-3">
                        <span class="block text-[12px] font-semibold text-[#6B7280]">
                            Căn hộ liên kết
                        </span>
                        <span class="block text-[14px] font-medium text-[#111827] mt-0.5" id="cancelModalApartment">
                            Tòa A · Tầng 1 · 0101
                        </span>
                    </div>
                </div>

                <!-- Modal Footer (2 nút: Giữ đăng ký & Xác nhận hủy - Bám sát Ảnh 3) -->
                <div class="px-6 py-4 bg-[#F2F6F4] border-t border-[#E5E7EB] flex items-center justify-between rounded-b-[16px]">
                    <button
                        type="button"
                        onclick="closeCancelVehicleModal()"
                        class="h-[38px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Giữ đăng ký
                    </button>
                    <button
                        type="submit"
                        class="h-[38px] px-6 bg-rose-600 hover:bg-rose-700 text-white text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Xác nhận hủy
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCancelVehicleModal(idOrData) {
        const data = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.vehiclesMap?.[idOrData] || {});
        window.activeCancelVehicleId = data.vehicleId || idOrData;
        const modal = document.getElementById('cancelVehicleModal');
        const backdrop = document.getElementById('cancelVehicleBackdrop');
        const panel = document.getElementById('cancelVehiclePanel');
        const form = document.getElementById('cancelVehicleForm');

        if (!modal || !backdrop || !panel) return;

        const plate = data.licensePlate || '29-B1 100.01';
        const typeName = data.typeName || 'Xe máy';
        const aptNumber = data.apartmentNumber || '0101';
        const building = data.buildingName || 'Tòa A';
        const floor = data.floorNumber || '1';
        const aptText = `${building} · Tầng ${floor} · ${aptNumber}`;

        document.getElementById('cancelModalSubtitle').textContent = `Xác nhận hủy đăng ký xe ${plate} khỏi căn hộ ${aptNumber}.`;
        document.getElementById('cancelModalPlate').textContent = plate;
        document.getElementById('cancelModalType').textContent = typeName;
        document.getElementById('cancelModalApartment').textContent = aptText;

        if (form && data.vehicleId) {
            form.action = `/vehicles/${data.vehicleId}/cancel`;
        }

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeCancelVehicleModal() {
        const modal = document.getElementById('cancelVehicleModal');
        const backdrop = document.getElementById('cancelVehicleBackdrop');
        const panel = document.getElementById('cancelVehiclePanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function handleCancelVehicleSubmit(event) {
        event.preventDefault();
        const plate = document.getElementById('cancelModalPlate')?.textContent || 'phương tiện';
        closeCancelVehicleModal();

        if (window.showToast) {
            window.showToast(`Đã hủy đăng ký xe ${plate} thành công.`, 'danger');
        }

        if (window.activeCancelVehicleId) {
            const row = document.getElementById(`vehicle_row_${window.activeCancelVehicleId}`);
            if (row) {
                row.style.transition = 'all 0.3s ease';
                row.style.opacity = '0';
                row.style.backgroundColor = '#fdf2f2';
                setTimeout(() => row.remove(), 300);
            }
        }
    }
</script>
