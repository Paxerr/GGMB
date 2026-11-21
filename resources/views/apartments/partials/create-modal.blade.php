<!-- Modal Popup: BIỂU MẪU / MODAL · Thêm căn hộ (12 · SCR-APT-04 · 688px) -->
<div
    id="createApartmentModal"
    class="{{ ($errors->any() || request('action') === 'create-apartment') ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-[#000000]/40 backdrop-blur-xs p-4 overflow-y-auto"
    aria-labelledby="modalApartmentTitle"
    role="dialog"
    aria-modal="true"
    data-name="12 · SCR-APT-04 · Thêm căn hộ"
>
    <!-- Modal Card Container (Width: 688px max) -->
    <div
        class="relative w-full max-w-[688px] bg-white border border-solid border-[#d9e4ec] shadow-2xl rounded-[4px] overflow-hidden transition-all my-8"
        onclick="event.stopPropagation()"
        data-name="03 · Modal"
    >
        <!-- Modal Header -->
        <div class="px-6 pt-4 pb-3 border-b border-[#d9e4ec]">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#52697c]">
                    BIỂU MẪU / MODAL
                </span>
                <button
                    type="button"
                    onclick="closeCreateApartmentModal()"
                    class="text-[26px] leading-none text-[#52697c] hover:text-[#122d40] transition-colors cursor-pointer p-1"
                    aria-label="Đóng"
                >
                    &times;
                </button>
            </div>
            <h2 id="modalApartmentTitle" class="text-[22px] font-bold text-[#122d40] mt-1">
                Thêm căn hộ
            </h2>
            <p class="text-[13px] text-[#52697c] mt-0.5">
                Các trường có dấu * là bắt buộc
            </p>
        </div>

        <!-- Form Body -->
        <form action="{{ route('apartments.store') }}" method="POST" id="createApartmentForm">
            @csrf

            <div class="px-6 py-5 space-y-4" data-name="Nội dung">
                <!-- Nhóm trường: Tòa & Tầng (2 cols) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" data-name="Nhóm trường">
                    <!-- Tòa · qua Floor.BuildingId -->
                    <div>
                        <label for="modalApartmentBuildingId" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Tòa · qua Floor.BuildingId
                        </label>
                        <div class="relative">
                            <select
                                id="modalApartmentBuildingId"
                                onchange="filterModalFloors(this.value)"
                                class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] rounded-[4px] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                            >
                                @foreach ($buildings as $b)
                                    <option value="{{ $b->BuildingId }}">
                                        {{ $b->BuildingId }} · {{ $b->BuildingName }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                                ▾
                            </div>
                        </div>
                    </div>

                    <!-- Tầng · FloorId * -->
                    <div>
                        <label for="modalApartmentFloorId" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Tầng · FloorId <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select
                                id="modalApartmentFloorId"
                                name="FloorId"
                                required
                                class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] rounded-[4px] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                            >
                                <option value="">Chọn tầng ▾</option>
                                @foreach ($floors as $f)
                                    <option
                                        value="{{ $f->FloorId }}"
                                        data-building-id="{{ $f->BuildingId }}"
                                        {{ old('FloorId') == $f->FloorId ? 'selected' : '' }}
                                    >
                                        Tầng {{ $f->FloorNumber }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                                ▾
                            </div>
                        </div>
                        @error('FloorId')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Số căn hộ · ApartmentNumber * -->
                <div>
                    <label for="modalApartmentNumber" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                        Số căn hộ · ApartmentNumber <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="modalApartmentNumber"
                        name="ApartmentNumber"
                        value="{{ old('ApartmentNumber') }}"
                        required
                        maxlength="20"
                        placeholder="Nhập tối đa 20 ký tự"
                        class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] rounded-[4px] text-[14px] leading-[20px] text-[#334b5d] placeholder:text-[#52697c] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] transition-colors"
                    >
                    @error('ApartmentNumber')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Trạng thái · Status * -->
                <div>
                    <label for="modalApartmentStatus" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                        Trạng thái · Status <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select
                            id="modalApartmentStatus"
                            name="Status"
                            required
                            class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] rounded-[4px] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                        >
                            <option value="VACANT" {{ old('Status', 'VACANT') === 'VACANT' ? 'selected' : '' }}>VACANT · Trống</option>
                            <option value="OCCUPIED" {{ old('Status') === 'OCCUPIED' ? 'selected' : '' }}>OCCUPIED · Đang ở</option>
                            <option value="SUSPENDED" {{ old('Status') === 'SUSPENDED' ? 'selected' : '' }}>SUSPENDED · Ngừng hoạt động</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                            ▾
                        </div>
                    </div>
                    @error('Status')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mô tả · Description -->
                <div>
                    <label for="modalApartmentDescription" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                        Mô tả · Description
                    </label>
                    <textarea
                        id="modalApartmentDescription"
                        name="Description"
                        rows="3"
                        maxlength="500"
                        placeholder="Nhập mô tả, có thể để trống"
                        class="w-full p-3 bg-white border border-solid border-[#d9e4ec] rounded-[4px] text-[14px] leading-[20px] text-[#334b5d] placeholder:text-[#52697c] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] transition-colors resize-y"
                    >{{ old('Description') }}</textarea>
                    @error('Description')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Modal Footer Actions -->
            <div class="h-[72px] px-6 border-t border-[#d9e4ec] flex items-center justify-between bg-white flex-shrink-0">
                <button
                    type="button"
                    onclick="closeCreateApartmentModal()"
                    class="w-[136px] h-[40px] border border-[#d9e4ec] bg-white hover:bg-gray-50 text-[#334b5d] rounded-[4px] font-medium text-[14px] transition-colors cursor-pointer flex items-center justify-center select-none"
                >
                    Đóng / Hủy
                </button>
                <button
                    type="submit"
                    class="w-[204px] h-[40px] bg-[#2864ad] hover:bg-[#205391] text-white rounded-[4px] font-semibold text-[14px] transition-colors cursor-pointer flex items-center justify-center select-none"
                >
                    Tạo căn hộ
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateApartmentModal() {
        const modal = document.getElementById('createApartmentModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Trigger floor filtering with current building
            const bSelect = document.getElementById('modalApartmentBuildingId');
            if (bSelect) {
                filterModalFloors(bSelect.value);
            }
            const input = document.getElementById('modalApartmentNumber');
            if (input) {
                setTimeout(() => input.focus(), 50);
            }
        }
    }

    function closeCreateApartmentModal() {
        const modal = document.getElementById('createApartmentModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    function filterModalFloors(buildingId) {
        const floorSelect = document.getElementById('modalApartmentFloorId');
        if (!floorSelect) return;
        const options = floorSelect.querySelectorAll('option[data-building-id]');
        let hasMatch = false;
        options.forEach(opt => {
            if (!buildingId || opt.dataset.buildingId === buildingId) {
                opt.style.display = '';
                if (!hasMatch && !floorSelect.value) {
                    opt.selected = true;
                    hasMatch = true;
                }
            } else {
                opt.style.display = 'none';
                if (opt.selected) {
                    opt.selected = false;
                }
            }
        });
    }

    // Đóng khi click ra vùng backdrop ngoài modal
    document.getElementById('createApartmentModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeCreateApartmentModal();
        }
    });
</script>
