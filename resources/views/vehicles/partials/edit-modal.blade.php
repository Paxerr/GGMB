<!-- Modal Popup: Chỉnh sửa phương tiện (SCR-VEH-04 Popup Modal) -->
<div
    id="editVehicleModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="edit-vehicle-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Background backdrop -->
    <div
        id="editVehicleBackdrop"
        onclick="closeEditVehicleModal()"
        class="fixed inset-0 bg-black/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="editVehiclePanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[600px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeEditVehicleModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] font-bold text-[#111827] mt-1" id="edit-vehicle-title">
                    Chỉnh sửa phương tiện
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-1" id="editVehicleSubtitle">
                    Cập nhật thông tin gắn với căn hộ.
                </p>
            </div>

            <!-- Modal Form -->
            <form id="editVehicleForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="px-6 py-5 space-y-4">
                    <!-- Hàng 1: Căn hộ * & Loại xe * (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_apartment_id" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Căn hộ *
                            </label>
                            <div class="relative">
                                <select
                                    id="edit_apartment_id"
                                    name="ApartmentId"
                                    required
                                    class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                                >
                                    @foreach ($apartments as $apt)
                                        <option value="{{ $apt->ApartmentId }}">
                                            {{ $apt->ApartmentNumber }} · Tầng {{ $apt->floor->FloorNumber ?? 1 }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">
                                    ▾
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="edit_vehicle_type" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Loại xe *
                            </label>
                            <div class="relative">
                                <select
                                    id="edit_vehicle_type"
                                    name="VehicleType"
                                    required
                                    class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                                >
                                    <option value="MOTORBIKE">Xe máy · MOTORBIKE</option>
                                    <option value="CAR">Ô tô · CAR</option>
                                    <option value="ELECTRIC_BIKE">Xe máy điện · ELECTRIC</option>
                                    <option value="BICYCLE">Xe đạp · BICYCLE</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">
                                    ▾
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hàng 2: Biển số * (Full width) -->
                    <div>
                        <label for="edit_license_plate" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Biển số *
                        </label>
                        <input
                            type="text"
                            id="edit_license_plate"
                            name="LicensePlate"
                            required
                            placeholder="Nhập biển số đúng định dạng"
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] uppercase"
                        />
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-[#F2F6F4] border-t border-[#E5E7EB] flex items-center justify-between rounded-b-[16px]">
                    <button
                        type="button"
                        onclick="closeEditVehicleModal()"
                        class="h-[38px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[38px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditVehicleModal(idOrData) {
        const data = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.vehiclesMap?.[idOrData] || {});
        window.activeEditVehicleId = data.vehicleId || idOrData;
        const modal = document.getElementById('editVehicleModal');
        const backdrop = document.getElementById('editVehicleBackdrop');
        const panel = document.getElementById('editVehiclePanel');
        const form = document.getElementById('editVehicleForm');

        if (!modal || !backdrop || !panel) return;

        const plate = data.licensePlate || '';
        document.getElementById('editVehicleSubtitle').textContent = `${plate} · Cập nhật thông tin gắn với căn hộ.`;
        document.getElementById('edit_license_plate').value = plate;

        if (data.vehicleType) {
            document.getElementById('edit_vehicle_type').value = data.vehicleType;
        }

        if (data.apartmentId) {
            document.getElementById('edit_apartment_id').value = data.apartmentId;
        }

        if (form && data.vehicleId) {
            form.action = `/vehicles/${data.vehicleId}`;
        }

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeEditVehicleModal() {
        const modal = document.getElementById('editVehicleModal');
        const backdrop = document.getElementById('editVehicleBackdrop');
        const panel = document.getElementById('editVehiclePanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function handleEditVehicleSubmit(event) {
        event.preventDefault();
        const plateInput = document.getElementById('edit_license_plate');
        const plate = (plateInput?.value || '').toUpperCase().trim();
        const typeSelect = document.getElementById('edit_vehicle_type');
        const typeVal = typeSelect?.value || 'MOTORBIKE';
        const typeText = typeSelect?.options[typeSelect.selectedIndex]?.text || 'Xe máy';

        closeEditVehicleModal();

        if (window.showToast) {
            window.showToast(`Đã cập nhật thông tin phương tiện ${plate} thành công.`);
        }

        if (window.activeEditVehicleId) {
            const row = document.getElementById(`vehicle_row_${window.activeEditVehicleId}`);
            if (row) {
                row.setAttribute('data-plate', plate);
                row.setAttribute('data-type', typeVal);
                const plateCell = row.children[1];
                if (plateCell) plateCell.textContent = plate;
                const typeCell = row.children[2];
                if (typeCell) {
                    typeCell.innerHTML = `<span class="inline-flex items-center px-2 py-0.5 rounded-[6px] text-xs font-semibold bg-[#E4EFE9] text-[#0E4D3C]">${typeText}</span>`;
                }
            }
        }
    }
</script>
