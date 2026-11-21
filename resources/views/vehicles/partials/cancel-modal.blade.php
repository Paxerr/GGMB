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
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="cancelVehiclePanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[640px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header (Bám sát Ảnh 3) -->
            <div class="px-7 pt-6 pb-4">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-rose-400 tracking-wider uppercase select-none">
                        XÁC NHẬN
                    </span>
                    <button
                        type="button"
                        onclick="closeCancelVehicleModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#b91c1c] mt-1" id="cancel-vehicle-title">
                    Hủy đăng ký phương tiện
                </h3>
                <p class="text-[13px] text-[#e05252] mt-1" id="cancelModalSubtitle">
                    Xác nhận hủy đăng ký xe 29-B1 100.01 khỏi căn hộ 0101.
                </p>
            </div>

            <!-- Modal Form -->
            <form id="cancelVehicleForm" method="POST" action="" onsubmit="handleCancelVehicleSubmit(event)">
                @csrf
                <div class="px-7 pb-6 space-y-5">
                    <!-- Hàng 1: Biển số & Loại xe (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                                Biển số
                            </span>
                            <span class="block text-[14px] leading-[20px] text-[#122d40] mt-1 font-normal font-mono" id="cancelModalPlate">
                                29-B1 100.01
                            </span>
                        </div>
                        <div>
                            <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                                Loại xe
                            </span>
                            <span class="block text-[14px] leading-[20px] text-[#122d40] mt-1 font-normal" id="cancelModalType">
                                Xe máy
                            </span>
                        </div>
                    </div>

                    <!-- Hàng 2: Căn hộ liên kết -->
                    <div>
                        <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                            Căn hộ liên kết
                        </span>
                        <span class="block text-[14px] leading-[20px] text-[#122d40] mt-1 font-normal" id="cancelModalApartment">
                            Tòa A · Tầng 1 · 0101
                        </span>
                    </div>
                </div>

                <!-- Modal Footer (2 nút: Giữ đăng ký & Xác nhận hủy - Bám sát Ảnh 3) -->
                <div class="px-7 py-4 border-t border-[#d9e4ec] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeCancelVehicleModal()"
                        class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                    >
                        Giữ đăng ký
                    </button>
                    <button
                        type="submit"
                        class="h-[40px] px-6 bg-[#b91c1c] hover:bg-[#991b1b] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
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
