<!-- Modal Popup: GGMB / Popup & biểu mẫu / Chỉnh sửa tòa nhà (SCR-BLD-03) -->
<div
    id="editBuildingModal"
    class="hidden fixed inset-0 z-50 items-center justify-center bg-[#122d40]/40 backdrop-blur-xs p-4 overflow-y-auto"
    aria-labelledby="editModalTitle"
    role="dialog"
    aria-modal="true"
>
    <!-- Modal Card Container (Width: 688px max) -->
    <div
        class="relative w-full max-w-[688px] bg-white border border-solid border-[#d9e4ec] p-6 shadow-xl transition-all"
        onclick="event.stopPropagation()"
    >
        <div class="mb-5 space-y-1">
            <h2 id="editModalTitle" class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
                Chỉnh sửa tòa nhà
            </h2>
            <p id="editModalSubtitle" class="text-[14px] leading-[20px] text-[#334b5d]">
                {{ $selectedBuilding->BuildingName ?? 'GGMB Residence · Tòa A' }}
            </p>
        </div>

        <form
            id="editBuildingForm"
            action="{{ isset($selectedBuilding) ? route('buildings.update', $selectedBuilding->BuildingId) : '#' }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <!-- Form Content Box -->
            <div class="space-y-5">
                <!-- Tên tòa nhà * · Nhóm trường -->
                <div class="space-y-1.5 w-full sm:w-[312px]">
                    <label for="editModalBuildingName" class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                        Tên tòa nhà *
                    </label>
                    <input
                        type="text"
                        id="editModalBuildingName"
                        name="BuildingName"
                        value="{{ old('BuildingName', $selectedBuilding->BuildingName ?? 'GGMB Residence · Tòa A') }}"
                        required
                        placeholder="Nhập tên tòa nhà"
                        class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] rounded-[8px] text-[14px] leading-[20px] text-[#334b5d] placeholder:text-[#52697c] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] transition-colors"
                    >
                    @error('BuildingName')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Thao tác Buttons (Hủy & Lưu thay đổi) -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Nút Hủy (Kiểu=02: rounded 8px, width 204px) -->
                    <button
                        type="button"
                        onclick="closeEditBuildingModal()"
                        class="w-full sm:w-[204px] h-[40px] bg-white hover:bg-gray-50 border border-solid border-[#d9e4ec] rounded-[8px] text-[#334b5d] text-[14px] font-semibold flex items-center justify-center transition-colors cursor-pointer"
                    >
                        Hủy
                    </button>

                    <!-- Nút Lưu thay đổi (Kiểu=03 / Primary: rounded 8px, width 204px) -->
                    <button
                        type="submit"
                        class="w-full sm:w-[204px] h-[40px] bg-[#2864ad] hover:bg-[#205391] border border-solid border-[#2864ad] rounded-[8px] text-white text-[14px] font-semibold flex items-center justify-center transition-colors cursor-pointer"
                    >
                        Lưu thay đổi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditBuildingModal(id, name) {
        const modal = document.getElementById('editBuildingModal');
        const form = document.getElementById('editBuildingForm');
        const input = document.getElementById('editModalBuildingName');
        const subtitle = document.getElementById('editModalSubtitle');

        if (id && form) {
            form.action = '/buildings/' + id;
        }
        if (name && input) {
            input.value = name;
        }
        if (name && subtitle) {
            subtitle.textContent = name;
        }

        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            if (input) {
                setTimeout(() => input.focus(), 50);
            }
        }
    }

    function closeEditBuildingModal() {
        const modal = document.getElementById('editBuildingModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // Đóng khi click ngoài hộp thoại modal
    document.getElementById('editBuildingModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditBuildingModal();
        }
    });
</script>
