<!-- ========================================== -->
<!-- 1. Modal: Thêm tầng mới (Create Floor)     -->
<!-- ========================================== -->
<div
    id="createFloorModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="create-floor-title"
    role="dialog"
    aria-modal="true"
>
    <div
        id="createFloorBackdrop"
        onclick="closeCreateFloorModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="createFloorPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[540px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <div class="px-7 pt-6 pb-4 border-b border-[#d9e4ec]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        CẤU TRÚC
                    </span>
                    <button
                        type="button"
                        onclick="closeCreateFloorModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                    >&times;</button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="create-floor-title">
                    Thêm tầng mới
                </h3>
                <p class="text-[13px] text-[#52697c] mt-0.5">
                    Thêm tầng vào tòa nhà {{ $selectedBuilding->BuildingName ?? 'GGMB Residence · Tòa A' }}.
                </p>
            </div>

            <form id="createFloorForm" onsubmit="event.preventDefault(); submitCreateFloor();">
                <div class="px-7 py-5 space-y-4">
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Tòa nhà
                        </label>
                        <input
                            type="text"
                            value="{{ $selectedBuilding->BuildingName ?? 'GGMB Residence · Tòa A' }}"
                            readonly
                            class="w-full h-[40px] px-3 bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#52697c] select-none cursor-not-allowed"
                        />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Số tầng <span class="text-rose-500">*</span>
                            </label>
                            <input
                                type="number"
                                id="create_floor_number"
                                required
                                min="1"
                                max="99"
                                value="6"
                                placeholder="Ví dụ: 6"
                                class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] focus:outline-none focus:border-[#2864ad]"
                            />
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Số căn dự kiến
                            </label>
                            <input
                                type="number"
                                id="create_floor_units"
                                min="1"
                                max="30"
                                value="8"
                                class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] focus:outline-none focus:border-[#2864ad]"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Ghi chú
                        </label>
                        <input
                            type="text"
                            id="create_floor_note"
                            placeholder="Khu căn hộ tiêu chuẩn"
                            class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] focus:outline-none focus:border-[#2864ad]"
                        />
                    </div>
                </div>

                <div class="px-7 py-4 bg-[#f8fafc] border-t border-[#d9e4ec] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeCreateFloorModal()"
                        class="h-[38px] px-5 bg-white border border-[#d9e4ec] hover:bg-slate-50 text-[#334b5d] text-[13px] font-medium rounded-[4px] transition-colors cursor-pointer"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[38px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer shadow-sm"
                    >
                        Tạo tầng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- 2. Modal: Chỉnh sửa tầng (Edit Floor)      -->
<!-- ========================================== -->
<div
    id="editFloorModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="edit-floor-title"
    role="dialog"
    aria-modal="true"
>
    <div
        id="editFloorBackdrop"
        onclick="closeEditFloorModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="editFloorPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[540px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <div class="px-7 pt-6 pb-4 border-b border-[#d9e4ec]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        CHỈNH SỬA
                    </span>
                    <button
                        type="button"
                        onclick="closeEditFloorModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                    >&times;</button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="edit-floor-title">
                    Chỉnh sửa tầng
                </h3>
                <p class="text-[13px] text-[#52697c] mt-0.5" id="editFloorSubtitle">
                    Cập nhật thông tin số tầng.
                </p>
            </div>

            <form id="editFloorForm" onsubmit="event.preventDefault(); submitEditFloor();">
                <input type="hidden" id="edit_floor_id">
                <div class="px-7 py-5 space-y-4">
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Mã tầng
                        </label>
                        <input
                            type="text"
                            id="edit_floor_code_display"
                            readonly
                            class="w-full h-[40px] px-3 bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#52697c] select-none cursor-not-allowed"
                        />
                    </div>

                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Số tầng <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="number"
                            id="edit_floor_number"
                            required
                            min="1"
                            max="99"
                            class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] focus:outline-none focus:border-[#2864ad]"
                        />
                    </div>
                </div>

                <div class="px-7 py-4 bg-[#f8fafc] border-t border-[#d9e4ec] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeEditFloorModal()"
                        class="h-[38px] px-5 bg-white border border-[#d9e4ec] hover:bg-slate-50 text-[#334b5d] text-[13px] font-medium rounded-[4px] transition-colors cursor-pointer"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[38px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer shadow-sm"
                    >
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- 3. Modal: Xóa tầng (Delete Floor)         -->
<!-- ========================================== -->
<div
    id="deleteFloorModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="del-floor-title"
    role="dialog"
    aria-modal="true"
>
    <div
        id="deleteFloorBackdrop"
        onclick="closeDeleteFloorModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="deleteFloorPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[480px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <div class="px-7 pt-6 pb-4">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-rose-500 tracking-wider uppercase select-none">
                        XÁC NHẬN
                    </span>
                    <button
                        type="button"
                        onclick="closeDeleteFloorModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                    >&times;</button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="del-floor-title">
                    Xóa tầng này?
                </h3>
                <p class="text-[13px] text-[#52697c] mt-1" id="deleteFloorMessage">
                    Bạn có chắc chắn muốn xóa tầng này khỏi tòa nhà?
                </p>
            </div>

            <div class="px-7 pb-5">
                <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-[4px] text-[13px] text-rose-700">
                    Lưu ý: Chỉ được xóa tầng khi không còn căn hộ nào thuộc tầng đó. Nếu đã có căn hộ, vui lòng chuyển căn hộ sang tầng khác trước.
                </div>
            </div>

            <div class="px-7 py-4 bg-[#f8fafc] border-t border-[#d9e4ec] flex items-center justify-between">
                <button
                    type="button"
                    onclick="closeDeleteFloorModal()"
                    class="h-[38px] px-5 bg-white border border-[#d9e4ec] hover:bg-slate-50 text-[#334b5d] text-[13px] font-medium rounded-[4px] transition-colors cursor-pointer"
                >
                    Hủy bỏ
                </button>
                <button
                    type="button"
                    onclick="confirmDeleteFloor()"
                    class="h-[38px] px-6 bg-rose-600 hover:bg-rose-700 text-white text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer shadow-sm"
                >
                    Xác nhận xóa
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- 4. Modal: Chi tiết tầng (Detail Floor)    -->
<!-- ========================================== -->
<div
    id="detailFloorModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="detail-floor-title"
    role="dialog"
    aria-modal="true"
>
    <div
        id="detailFloorBackdrop"
        onclick="closeDetailFloorModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="detailFloorPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[540px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <div class="px-7 pt-6 pb-4 border-b border-[#d9e4ec]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        THÔNG TIN TẦNG
                    </span>
                    <button
                        type="button"
                        onclick="closeDetailFloorModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                    >&times;</button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="detail_floor_title">
                    Chi tiết tầng
                </h3>
            </div>

            <div class="px-7 py-5 space-y-4 text-[13px]">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[11px] font-bold text-[#52697c] uppercase">Mã tầng</span>
                        <span class="block text-[14px] font-medium text-[#122d40] mt-1" id="detail_floor_id">—</span>
                    </div>
                    <div>
                        <span class="block text-[11px] font-bold text-[#52697c] uppercase">Tên số tầng</span>
                        <span class="block text-[14px] font-medium text-[#122d40] mt-1" id="detail_floor_num">—</span>
                    </div>
                </div>

                <div>
                    <span class="block text-[11px] font-bold text-[#52697c] uppercase">Tòa nhà</span>
                    <span class="block text-[14px] text-[#122d40] mt-1" id="detail_floor_building">—</span>
                </div>

                <div class="p-3 bg-[#f8fafc] border border-dashed border-[#d9e4ec] rounded-[4px] space-y-1">
                    <span class="block text-[11px] font-bold text-slate-500 uppercase">Căn hộ thuộc tầng</span>
                    <div class="text-[12px] text-[#334b5d]" id="detail_floor_apartments">
                        Gồm 8 căn hộ: 01, 02, 03, 04, 05, 06, 07, 08.
                    </div>
                </div>
            </div>

            <div class="px-7 py-4 bg-[#f8fafc] border-t border-[#d9e4ec] flex items-center justify-end">
                <button
                    type="button"
                    onclick="closeDetailFloorModal()"
                    class="h-[38px] px-6 bg-white border border-[#d9e4ec] hover:bg-slate-50 text-[#334b5d] text-[13px] font-medium rounded-[4px] transition-colors cursor-pointer"
                >
                    Đóng
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- 5. Modal: Xóa tòa nhà (Delete Building)   -->
<!-- ========================================== -->
<div
    id="deleteBuildingModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="del-bld-title"
    role="dialog"
    aria-modal="true"
>
    <div
        id="deleteBuildingBackdrop"
        onclick="closeDeleteBuildingModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="deleteBuildingPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[480px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <div class="px-7 pt-6 pb-4">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-rose-500 tracking-wider uppercase select-none">
                        XÁC NHẬN
                    </span>
                    <button
                        type="button"
                        onclick="closeDeleteBuildingModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                    >&times;</button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="del-bld-title">
                    Xóa tòa nhà này?
                </h3>
                <p class="text-[13px] text-[#52697c] mt-1">
                    Bạn có chắc chắn muốn xóa tòa nhà <strong>{{ $selectedBuilding->BuildingName ?? 'GGMB Residence · Tòa A' }}</strong>?
                </p>
            </div>

            <div class="px-7 pb-5">
                <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-[4px] text-[13px] text-rose-700">
                    Hệ thống chỉ cho phép xóa tòa nhà khi không còn căn hộ hoặc cư dân cư trú.
                </div>
            </div>

            <div class="px-7 py-4 bg-[#f8fafc] border-t border-[#d9e4ec] flex items-center justify-between">
                <button
                    type="button"
                    onclick="closeDeleteBuildingModal()"
                    class="h-[38px] px-5 bg-white border border-[#d9e4ec] hover:bg-slate-50 text-[#334b5d] text-[13px] font-medium rounded-[4px] transition-colors cursor-pointer"
                >
                    Hủy bỏ
                </button>
                <button
                    type="button"
                    onclick="confirmDeleteBuilding()"
                    class="h-[38px] px-6 bg-rose-600 hover:bg-rose-700 text-white text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer shadow-sm"
                >
                    Xác nhận xóa tòa
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let activeFloorIdToDelete = null;

    // --- CREATE FLOOR MODAL ---
    function openCreateFloorModal() {
        const modal = document.getElementById('createFloorModal');
        const backdrop = document.getElementById('createFloorBackdrop');
        const panel = document.getElementById('createFloorPanel');

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeCreateFloorModal() {
        const modal = document.getElementById('createFloorModal');
        const backdrop = document.getElementById('createFloorBackdrop');
        const panel = document.getElementById('createFloorPanel');

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 200);
    }

    function submitCreateFloor() {
        const num = document.getElementById('create_floor_number').value;
        const newId = Date.now().toString().slice(-4);
        const bldName = "{{ $selectedBuilding->BuildingName ?? 'GGMB Residence · Tòa A' }}";

        const tableContainer = document.querySelector('[data-name="Bảng dữ liệu"]');
        if (tableContainer) {
            const emptyEl = tableContainer.querySelector('.p-6.text-center');
            if (emptyEl) emptyEl.remove();

            const row = document.createElement('div');
            row.id = `floor-row-${newId}`;
            row.className = 'bg-white border-b last:border-b-0 border-[#d9e4ec] flex h-[48px] items-center text-[#334b5d] text-[14px] hover:bg-[#f8fbfd] transition-all animate-in fade-in duration-300';
            row.innerHTML = `
                <div class="w-[90px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">${newId}</div>
                <div class="flex-1 px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal truncate">${bldName}</div>
                <div class="w-[173px] min-w-[173px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal floor-num">${num}</div>
                <div class="w-[274px] min-w-[274px] px-3 h-full flex items-center space-x-2">
                    <button type="button" onclick="openDetailFloorModal('${newId}', '${num}', '${bldName}')" class="text-[#2864ad] hover:underline cursor-pointer">Xem</button>
                    <span class="text-[#52697c]">/</span>
                    <button type="button" onclick="openEditFloorModal('${newId}', '${num}')" class="text-[#2864ad] hover:underline cursor-pointer">Sửa</button>
                    <span class="text-[#52697c]">/</span>
                    <button type="button" onclick="openDeleteFloorModal('${newId}', '${num}')" class="text-rose-600 hover:underline cursor-pointer">Xóa</button>
                </div>
            `;
            tableContainer.appendChild(row);
        }

        closeCreateFloorModal();
        if (window.showToast) {
            window.showToast(`Đã thêm thành công Tầng ${num}!`);
        }
    }

    // --- EDIT FLOOR MODAL ---
    function openEditFloorModal(id, floorNum) {
        document.getElementById('edit_floor_id').value = id;
        document.getElementById('edit_floor_code_display').value = id;
        document.getElementById('edit_floor_number').value = floorNum;
        document.getElementById('editFloorSubtitle').innerText = `Cập nhật thông tin cho tầng ${floorNum} (Mã #${id}).`;

        const modal = document.getElementById('editFloorModal');
        const backdrop = document.getElementById('editFloorBackdrop');
        const panel = document.getElementById('editFloorPanel');

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeEditFloorModal() {
        const modal = document.getElementById('editFloorModal');
        const backdrop = document.getElementById('editFloorBackdrop');
        const panel = document.getElementById('editFloorPanel');

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 200);
    }

    function submitEditFloor() {
        const id = document.getElementById('edit_floor_id').value;
        const newNum = document.getElementById('edit_floor_number').value;

        const row = document.getElementById(`floor-row-${id}`);
        if (row) {
            const numEl = row.querySelector('.floor-num');
            if (numEl) numEl.innerText = newNum;
        }

        closeEditFloorModal();
        if (window.showToast) {
            window.showToast(`Đã lưu thay đổi cho Tầng ${newNum} thành công!`);
        }
    }

    // --- DELETE FLOOR MODAL ---
    function openDeleteFloorModal(id, floorNum) {
        activeFloorIdToDelete = id;
        document.getElementById('deleteFloorMessage').innerHTML = `Bạn có chắc chắn muốn xóa <strong>Tầng ${floorNum}</strong> (Mã #${id})?`;

        const modal = document.getElementById('deleteFloorModal');
        const backdrop = document.getElementById('deleteFloorBackdrop');
        const panel = document.getElementById('deleteFloorPanel');

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeDeleteFloorModal() {
        const modal = document.getElementById('deleteFloorModal');
        const backdrop = document.getElementById('deleteFloorBackdrop');
        const panel = document.getElementById('deleteFloorPanel');

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 200);
    }

    function confirmDeleteFloor() {
        if (activeFloorIdToDelete) {
            const row = document.getElementById(`floor-row-${activeFloorIdToDelete}`);
            if (row) {
                row.classList.add('opacity-0', 'scale-95');
                setTimeout(() => row.remove(), 250);
            }
        }
        closeDeleteFloorModal();
        if (window.showToast) {
            window.showToast('Đã xóa tầng thành công!');
        }
    }

    // --- DETAIL FLOOR MODAL ---
    function openDetailFloorModal(id, floorNum, bldName) {
        document.getElementById('detail_floor_title').innerText = `Chi tiết Tầng ${floorNum}`;
        document.getElementById('detail_floor_id').innerText = id;
        document.getElementById('detail_floor_num').innerText = `Tầng ${floorNum}`;
        document.getElementById('detail_floor_building').innerText = bldName;
        document.getElementById('detail_floor_apartments').innerText = `Gồm 8 căn hộ: ${floorNum.padStart(2, '0')}01, ${floorNum.padStart(2, '0')}02, ${floorNum.padStart(2, '0')}03, ${floorNum.padStart(2, '0')}04, ${floorNum.padStart(2, '0')}05, ${floorNum.padStart(2, '0')}06, ${floorNum.padStart(2, '0')}07, ${floorNum.padStart(2, '0')}08.`;

        const modal = document.getElementById('detailFloorModal');
        const backdrop = document.getElementById('detailFloorBackdrop');
        const panel = document.getElementById('detailFloorPanel');

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeDetailFloorModal() {
        const modal = document.getElementById('detailFloorModal');
        const backdrop = document.getElementById('detailFloorBackdrop');
        const panel = document.getElementById('detailFloorPanel');

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 200);
    }

    // --- DELETE BUILDING MODAL ---
    function openDeleteBuildingModal() {
        const modal = document.getElementById('deleteBuildingModal');
        const backdrop = document.getElementById('deleteBuildingBackdrop');
        const panel = document.getElementById('deleteBuildingPanel');

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeDeleteBuildingModal() {
        const modal = document.getElementById('deleteBuildingModal');
        const backdrop = document.getElementById('deleteBuildingBackdrop');
        const panel = document.getElementById('deleteBuildingPanel');

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 200);
    }

    function confirmDeleteBuilding() {
        closeDeleteBuildingModal();
        if (window.showToast) {
            window.showToast('Không thể xóa tòa nhà: Vẫn còn căn hộ và cư dân đang sinh sống!', 'error');
        }
    }
</script>
