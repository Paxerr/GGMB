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
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="editVehiclePanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[600px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header -->
            <div class="px-7 pt-6 pb-4">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeEditVehicleModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="edit-vehicle-title">
                    Chỉnh sửa phương tiện
                </h3>
                <p class="text-[13px] text-[#52697c] mt-1" id="editVehicleSubtitle">
                    Cập nhật thông tin gắn với căn hộ.
                </p>
            </div>

            <!-- Modal Form -->
            <form id="editVehicleForm" method="POST" action="" onsubmit="handleEditVehicleSubmit(event)">
                @csrf
                @method('PUT')
                <div class="px-7 pb-6 space-y-4">
                    <!-- Hàng 1: Căn hộ * & Loại xe * (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_apartment_id" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Căn hộ *
                            </label>
                            <div class="relative">
                                <select
                                    id="edit_apartment_id"
                                    name="ApartmentId"
                                    required
                                    class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                                >
                                    @foreach ($apartments as $apt)
                                        <option value="{{ $apt->ApartmentId }}">
                                            {{ $apt->ApartmentNumber }} · Tầng {{ $apt->floor->FloorNumber ?? 1 }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                                    ▾
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="edit_vehicle_type" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Loại xe *
                            </label>
                            <div class="relative">
                                <select
                                    id="edit_vehicle_type"
                                    name="VehicleType"
                                    required
                                    class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                                >
                                    <option value="MOTORBIKE">Xe máy · MOTORBIKE</option>
                                    <option value="CAR">Ô tô · CAR</option>
                                    <option value="ELECTRIC_BIKE">Xe máy điện · ELECTRIC</option>
                                    <option value="BICYCLE">Xe đạp · BICYCLE</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                                    ▾
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hàng 2: Biển số * (Full width) -->
                    <div>
                        <label for="edit_license_plate" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Biển số *
                        </label>
                        <input
                            type="text"
                            id="edit_license_plate"
                            name="LicensePlate"
                            required
                            placeholder="Nhập biển số đúng định dạng"
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] uppercase"
                        />
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-7 py-4 border-t border-[#d9e4ec] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeEditVehicleModal()"
                        class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
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
                    typeCell.innerHTML = `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-[#e8f1ff] text-[#2864ad]">${typeText}</span>`;
                }
            }
        }
    }
</script>
