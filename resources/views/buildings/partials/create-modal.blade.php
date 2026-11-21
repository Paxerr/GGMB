<!-- Modal Popup: GGMB / Popup & biểu mẫu / Thêm tòa nhà (SCR-BLD-02) -->
<div
    id="createBuildingModal"
    class="{{ ($errors->has('BuildingName') || request('action') === 'create-building') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-[#122d40]/40 backdrop-blur-xs p-4 overflow-y-auto"
    aria-labelledby="modalTitle"
    role="dialog"
    aria-modal="true"
>
    <!-- Modal Card Container (Width: 688px max) -->
    <div
        class="relative w-full max-w-[688px] bg-white border border-solid border-[#d9e4ec] p-6 shadow-xl transition-all"
        onclick="event.stopPropagation()"
    >
        <div class="mb-5">
            <h2 id="modalTitle" class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
                Thêm tòa nhà
            </h2>
        </div>

        <form action="{{ route('buildings.store') }}" method="POST" id="createBuildingForm">
            @csrf

            <!-- Form Content Box -->
            <div class="space-y-5">
                <!-- Tên tòa nhà * · Nhóm trường -->
                <div class="space-y-1.5 w-full sm:w-[312px]">
                    <label for="modalBuildingName" class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                        Tên tòa nhà *
                    </label>
                    <input
                        type="text"
                        id="modalBuildingName"
                        name="BuildingName"
                        value="{{ old('BuildingName') }}"
                        required
                        placeholder="Nhập tên tòa nhà"
                        class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] rounded-[8px] text-[14px] leading-[20px] text-[#334b5d] placeholder:text-[#52697c] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] transition-colors"
                    >
                    @error('BuildingName')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Thao tác Buttons (Hủy & Tạo tòa nhà) -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Nút Hủy (Kiểu=02: rounded 8px, width 204px) -->
                    <button
                        type="button"
                        onclick="closeBuildingModal()"
                        class="w-full sm:w-[204px] h-[40px] bg-white hover:bg-gray-50 border border-solid border-[#d9e4ec] rounded-[8px] text-[#334b5d] text-[14px] font-semibold flex items-center justify-center transition-colors cursor-pointer"
                    >
                        Hủy
                    </button>

                    <!-- Nút Tạo tòa nhà (Kiểu=03 / Primary: rounded 8px, width 204px) -->
                    <button
                        type="submit"
                        class="w-full sm:w-[204px] h-[40px] bg-[#2864ad] hover:bg-[#205391] border border-solid border-[#2864ad] rounded-[8px] text-white text-[14px] font-semibold flex items-center justify-center transition-colors cursor-pointer"
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
