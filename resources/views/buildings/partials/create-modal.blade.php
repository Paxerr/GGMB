<!-- Modal Popup: GGMB / Popup & biểu mẫu / Thêm tòa nhà (SCR-BLD-02) -->
<div
    id="createBuildingModal"
    class="{{ ($errors->has('BuildingName') || request('action') === 'create-building') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-[#111827]/40 backdrop-blur-xs p-4 overflow-y-auto"
    aria-labelledby="modalTitle"
    role="dialog"
    aria-modal="true"
>
    <!-- Modal Card Container (Width: 688px max) -->
    <div
        class="relative w-full max-w-[688px] bg-white border border-[#e5e7eb] rounded-[16px] p-6 shadow-xl transition-all"
        onclick="event.stopPropagation()"
    >
        <div class="mb-5">
            <h2 id="modalTitle" class="text-[26px] leading-[32px] font-bold text-[#111827]">
                Thêm tòa nhà
            </h2>
        </div>

        <form action="{{ route('buildings.store') }}" method="POST" id="createBuildingForm">
            @csrf

            <!-- Form Content Box -->
            <div class="space-y-5">
                <!-- Tên tòa nhà * · Nhóm trường -->
                <div class="space-y-1.5 w-full sm:w-[312px]">
                    <label for="modalBuildingName" class="block text-[12px] leading-[18px] font-semibold text-[#374151]">
                        Tên tòa nhà *
                    </label>
                    <input
                        type="text"
                        id="modalBuildingName"
                        name="BuildingName"
                        value="{{ old('BuildingName') }}"
                        required
                        placeholder="Nhập tên tòa nhà"
                        class="w-full h-[42px] px-3 bg-white border border-[#e5e7eb] rounded-[8px] text-[14px] leading-[20px] text-[#111827] placeholder:text-[#9ca3af] focus:outline-none focus:border-[#0e4d3c] focus:ring-1 focus:ring-[#0e4d3c] transition-colors"
                    >
                    @error('BuildingName')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Thao tác Buttons (Hủy & Tạo tòa nhà) -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Nút Hủy (rounded 8px) -->
                    <button
                        type="button"
                        onclick="closeBuildingModal()"
                        class="w-full sm:w-[204px] h-[40px] bg-white hover:bg-gray-50 border border-[#e5e7eb] rounded-[8px] text-[#374151] text-[14px] font-medium flex items-center justify-center transition-colors cursor-pointer"
                    >
                        Hủy
                    </button>

                    <!-- Nút Tạo tòa nhà (Primary: rounded 8px) -->
                    <button
                        type="submit"
                        class="w-full sm:w-[204px] h-[40px] bg-[#0e4d3c] hover:bg-[#0a3d2f] border border-[#0e4d3c] rounded-[8px] text-white text-[14px] font-semibold flex items-center justify-center transition-colors cursor-pointer shadow-sm"
                    >
                        Tạo tòa nhà
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openBuildingModal() {
        const modal = document.getElementById('createBuildingModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            const input = document.getElementById('modalBuildingName');
            if (input) {
                setTimeout(() => input.focus(), 50);
            }
        }
    }

    function closeBuildingModal() {
        const modal = document.getElementById('createBuildingModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // Đóng khi click ngoài hộp thoại modal
    document.getElementById('createBuildingModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeBuildingModal();
        }
    });

    // Đóng khi bấm phím Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeBuildingModal();
        }
    });
</script>
