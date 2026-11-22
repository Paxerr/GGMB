<!-- Modal Popup: Đăng ký xe mới (27 · SCR-VEH-03 · Bám sát ảnh chụp màn hình) -->
<div
    id="createVehicleModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="create-vehicle-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Background backdrop -->
    <div
        id="createVehicleBackdrop"
        onclick="closeCreateVehicleModal()"
        class="fixed inset-0 bg-black/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="createVehiclePanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[600px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header (Bám sát ảnh 2) -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeCreateVehicleModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] font-bold text-[#111827] mt-1" id="create-vehicle-title">
                    Đăng ký xe mới
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-1">
                    Ban quản lý / nhân sự có quyền đăng ký phương tiện cho căn hộ.
                </p>
            </div>

            <!-- Modal Form -->
            <form method="POST" action="{{ route('vehicles.store') }}">
                @csrf
                <div class="px-6 py-5 space-y-4">
                    <!-- Hàng 1: Căn hộ * & Loại xe * (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="veh_apartment_id" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Căn hộ *
                            </label>
                            <div class="relative">
                                <select
                                    id="veh_apartment_id"
                                    name="ApartmentId"
                                    required
                                    class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                                >
                                    <option value="" disabled selected>Chọn căn hộ ▾</option>
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
                            <label for="veh_type" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Loại xe *
                            </label>
                            <div class="relative">
                                <select
                                    id="veh_type"
                                    name="VehicleType"
                                    required
                                    class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                                >
                                    <option value="" disabled selected>Ô tô / Xe máy ▾</option>
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
                        <label for="veh_license_plate" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Biển số *
                        </label>
                        <input
                            type="text"
                            id="veh_license_plate"
                            name="LicensePlate"
                            required
                            placeholder="Nhập biển số đúng định dạng"
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] uppercase"
                        />
                    </div>
                </div>

                <!-- Modal Footer (Hủy bên trái, Đăng ký mới bên phải - bám sát ảnh 2) -->
                <div class="px-6 py-4 bg-[#F2F6F4] border-t border-[#E5E7EB] flex items-center justify-between rounded-b-[16px]">
                    <button
                        type="button"
                        onclick="closeCreateVehicleModal()"
                        class="h-[38px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[38px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Đăng ký mới
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCreateVehicleModal() {
        const modal = document.getElementById('createVehicleModal');
        const backdrop = document.getElementById('createVehicleBackdrop');
        const panel = document.getElementById('createVehiclePanel');

        if (!modal || !backdrop || !panel) return;

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeCreateVehicleModal() {
        const modal = document.getElementById('createVehicleModal');
        const backdrop = document.getElementById('createVehicleBackdrop');
        const panel = document.getElementById('createVehiclePanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function handleCreateVehicleSubmit(event) {
        event.preventDefault();
        const plateInput = document.getElementById('veh_license_plate');
        const plate = (plateInput?.value || '29-B1 100.09').toUpperCase().trim();
        const aptSelect = document.getElementById('veh_apartment_id');
        const aptText = aptSelect?.options[aptSelect.selectedIndex]?.text || '0101 · Tầng 1';
        const typeSelect = document.getElementById('veh_type');
        const typeVal = typeSelect?.value || 'MOTORBIKE';
        const typeText = typeSelect?.options[typeSelect.selectedIndex]?.text || 'Xe máy · MOTORBIKE';

        closeCreateVehicleModal();
        if (plateInput) plateInput.value = '';

        if (window.showToast) {
            window.showToast(`Đã đăng ký phương tiện ${plate} thành công.`);
        }

        const table = document.querySelector('[data-name="Bảng dữ liệu"]');
        if (table) {
            const newRow = document.createElement('div');
            const rowId = Date.now();
            newRow.id = `vehicle_row_${rowId}`;
            newRow.setAttribute('data-plate', plate);
            newRow.setAttribute('data-type', typeVal);
            newRow.setAttribute('data-apt', aptSelect?.value || '1');
            newRow.className = 'vehicle-row bg-emerald-50/40 border-b last:border-b-0 border-[#E5E7EB] flex h-[48px] items-center text-[#374151] text-[13.5px] hover:bg-[#F9FBFA] transition-colors cursor-pointer';
            newRow.innerHTML = `
                <div class="w-[100px] min-w-[90px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-normal">Mới</div>
                <div class="w-[240px] min-w-[200px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-bold text-[#111827] font-mono tracking-wide">${plate}</div>
                <div class="w-[220px] min-w-[180px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-normal">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] text-xs font-semibold bg-[#E4EFE9] text-[#0E4D3C]">${typeText}</span>
                </div>
                <div class="w-[160px] min-w-[130px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-medium text-[#111827]">${aptText.split('·')[0].trim()}</div>
                <div class="flex-1 min-w-[220px] px-3 h-full flex items-center space-x-2 text-[13.5px]">
                    <button type="button" onclick="event.stopPropagation(); window.showToast('Phương tiện: ${plate}');" class="text-[#0E4D3C] hover:underline font-medium">Xem</button>
                    <span class="text-[#9CA3AF]">/</span>
                    <button type="button" onclick="event.stopPropagation(); window.showToast('Chỉnh sửa: ${plate}');" class="text-[#0E4D3C] hover:underline font-medium">Sửa</button>
                    <span class="text-[#9CA3AF]">/</span>
                    <button type="button" onclick="event.stopPropagation(); this.closest('.vehicle-row').remove(); window.showToast('Đã hủy đăng ký xe ${plate}', 'danger');" class="text-rose-600 hover:underline font-medium">Hủy đăng ký</button>
                </div>
            `;
            const header = table.querySelector('.bg-\\[\\#F2F6F4\\]') || table.firstElementChild;
            if (header && header.nextElementSibling) {
                table.insertBefore(newRow, header.nextElementSibling);
            } else {
                table.appendChild(newRow);
            }
        }
    }
</script>
