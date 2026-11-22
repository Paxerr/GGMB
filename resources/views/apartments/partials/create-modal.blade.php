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
        class="relative w-full max-w-[688px] bg-white border border-[#E5E7EB] shadow-2xl rounded-[16px] overflow-hidden transition-all my-8"
        onclick="event.stopPropagation()"
        data-name="03 · Modal"
    >
        <!-- Modal Header -->
        <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#6B7280]">
                    BIỂU MẪU / MODAL
                </span>
                <button
                    type="button"
                    onclick="closeCreateApartmentModal()"
                    class="text-[24px] leading-none text-[#6B7280] hover:text-[#111827] transition-colors cursor-pointer p-1"
                    aria-label="Đóng"
                >
                    &times;
                </button>
            </div>
            <h2 id="modalApartmentTitle" class="text-[20px] font-bold text-[#111827] mt-1">
                Thêm căn hộ
            </h2>
            <p class="text-[13px] text-[#6B7280] mt-0.5">
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
                        <label for="modalApartmentBuildingId" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Tòa · qua Floor.BuildingId
                        </label>
                        <div class="relative">
                            <select
                                id="modalApartmentBuildingId"
                                onchange="filterModalFloors(this.value)"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                            >
                                @foreach ($buildings as $b)
                                    <option value="{{ $b->BuildingId }}">
                                        {{ $b->BuildingId }} · {{ $b->BuildingName }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">
                                ▾
                            </div>
                        </div>
                    </div>

                    <!-- Tầng · FloorId * -->
                    <div>
                        <label for="modalApartmentFloorId" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Tầng · FloorId <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select
                                id="modalApartmentFloorId"
                                name="FloorId"
                                required
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
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
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">
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
                    <label for="modalApartmentNumber" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
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
                        class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] transition-colors"
                    >
                    @error('ApartmentNumber')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Trạng thái · Status * -->
                <div>
                    <label for="modalApartmentStatus" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                        Trạng thái · Status <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select
                            id="modalApartmentStatus"
                            name="Status"
                            required
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                        >
                            <option value="VACANT" {{ old('Status', 'VACANT') === 'VACANT' ? 'selected' : '' }}>VACANT · Trống</option>
                            <option value="OCCUPIED" {{ old('Status') === 'OCCUPIED' ? 'selected' : '' }}>OCCUPIED · Đang ở</option>
                            <option value="SUSPENDED" {{ old('Status') === 'SUSPENDED' ? 'selected' : '' }}>SUSPENDED · Ngừng hoạt động</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">
                            ▾
                        </div>
                    </div>
                    @error('Status')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mô tả · Description -->
                <div>
                    <label for="modalApartmentDescription" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                        Mô tả · Description
                    </label>
                    <textarea
                        id="modalApartmentDescription"
                        name="Description"
                        rows="3"
                        maxlength="500"
                        placeholder="Nhập mô tả, có thể để trống"
                        class="w-full p-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] transition-colors resize-y"
                    >{{ old('Description') }}</textarea>
                    @error('Description')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Modal Footer Actions -->
            <div class="h-[68px] px-6 border-t border-[#E5E7EB] flex items-center justify-between bg-white rounded-b-[16px] flex-shrink-0">
                <button
                    type="button"
                    onclick="closeCreateApartmentModal()"
                    class="px-4 h-[40px] border border-[#E5E7EB] bg-white hover:bg-[#F9FBFA] text-[#374151] rounded-[8px] font-medium text-[13.5px] transition-colors cursor-pointer flex items-center justify-center select-none"
                >
                    Đóng / Hủy
                </button>
                <button
                    type="submit"
                    class="px-5 h-[40px] bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white rounded-[8px] font-semibold text-[13.5px] transition-colors cursor-pointer flex items-center justify-center select-none shadow-sm"
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

    document.getElementById('createApartmentModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeCreateApartmentModal();
        }
    });
</script>
