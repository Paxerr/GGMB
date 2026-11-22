<!-- Modal Popup: Chỉnh sửa căn hộ (13 · SCR-APT-05 · 688px) -->
<div
    id="editApartmentModal"
    class="{{ ($errors->any() && old('_method') === 'PUT') || isset($editApartment) ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-[#000000]/40 backdrop-blur-xs p-4 overflow-y-auto"
    aria-labelledby="editModalApartmentTitle"
    role="dialog"
    aria-modal="true"
    data-name="13 · SCR-APT-05 · Chỉnh sửa căn hộ"
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
                    onclick="closeEditApartmentModal()"
                    class="text-[24px] leading-none text-[#6B7280] hover:text-[#111827] transition-colors cursor-pointer p-1"
                    aria-label="Đóng"
                >
                    &times;
                </button>
            </div>
            <h2 id="editModalApartmentTitle" class="text-[20px] font-bold text-[#111827] mt-1">
                Chỉnh sửa căn hộ {{ isset($editApartment) ? $editApartment->ApartmentNumber : '0101' }}
            </h2>
            <p id="editModalApartmentSubtitle" class="text-[13px] text-[#6B7280] mt-0.5">
                ApartmentId = {{ isset($editApartment) ? $editApartment->ApartmentId : '1' }} · FloorId = {{ isset($editApartment) ? $editApartment->FloorId : '1' }} · Status = {{ isset($editApartment) ? $editApartment->Status : 'OCCUPIED' }}
            </p>
        </div>

        <!-- Form Body -->
        <form
            action="{{ isset($editApartment) ? route('apartments.update', $editApartment->ApartmentId) : '#' }}"
            method="POST"
            id="editApartmentForm"
        >
            @csrf
            @method('PUT')

            <div class="px-6 py-5 space-y-4 max-h-[calc(85vh-150px)] overflow-y-auto" data-name="Nội dung">
                <!-- Số căn hộ · ApartmentNumber * -->
                <div>
                    <label for="editModalApartmentNumber" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                        Số căn hộ · ApartmentNumber <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="editModalApartmentNumber"
                        name="ApartmentNumber"
                        value="{{ old('ApartmentNumber', isset($editApartment) ? $editApartment->ApartmentNumber : '0101') }}"
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
                    <label for="editModalStatus" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                        Trạng thái · Status <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select
                            id="editModalStatus"
                            name="Status"
                            required
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                        >
                            <option value="OCCUPIED" {{ old('Status', isset($editApartment) ? $editApartment->Status : 'OCCUPIED') === 'OCCUPIED' ? 'selected' : '' }}>OCCUPIED · Đang ở</option>
                            <option value="VACANT" {{ old('Status', isset($editApartment) ? $editApartment->Status : 'OCCUPIED') === 'VACANT' ? 'selected' : '' }}>VACANT · Trống</option>
                            <option value="SUSPENDED" {{ old('Status', isset($editApartment) ? $editApartment->Status : 'OCCUPIED') === 'SUSPENDED' ? 'selected' : '' }}>SUSPENDED · Ngừng hoạt động</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                            ▾
                        </div>
                    </div>
                    @error('Status')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CƯ DÂN · ApartmentResident → User -->
                <div data-name="Cư dân">
                    <div class="text-[12px] font-semibold uppercase text-[#334b5d] tracking-wide mb-2">
                        CƯ DÂN · ApartmentResident → User
                    </div>
                    <div class="border border-[#d9e4ec] overflow-hidden">
                        <div class="bg-[#e4edf3] border-b border-[#d9e4ec] flex h-[38px] items-center text-[12px] font-semibold text-[#334b5d]">
                            <div class="w-[200px] min-w-[200px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                Họ tên
                            </div>
                            <div class="w-[170px] min-w-[170px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                Ngày vào
                            </div>
                            <div class="w-[140px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                Cư trú
                            </div>
                            <div class="flex-1 px-3 h-full flex items-center">
                                Thao tác
                            </div>
                        </div>

                        <div id="editModalResidentsList">
                            @if (isset($editApartment) && $editApartment->residents && $editApartment->residents->isNotEmpty())
                                @foreach ($editApartment->residents as $res)
                                    <div class="border-b last:border-b-0 border-[#d9e4ec] flex h-[44px] items-center text-[13px] text-[#334b5d]">
                                        <div class="w-[200px] min-w-[200px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium">
                                            {{ $res->user->FullName ?? '—' }}
                                        </div>
                                        <div class="w-[170px] min-w-[170px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                            {{ $res->StartDate ? \Carbon\Carbon::parse($res->StartDate)->format('d/m/Y') : '01/01/2024' }}
                                        </div>
                                        <div class="w-[140px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                            <span class="inline-block px-2 py-0.5 text-xs font-semibold {{ $res->Status === 'ACTIVE' ? 'bg-[#e6f5ec] text-[#16734b]' : 'bg-gray-100 text-[#52697c]' }}">
                                                {{ $res->Status }}
                                            </span>
                                        </div>
                                        <div class="flex-1 px-3 h-full flex items-center">
                                            <button type="button" class="text-xs text-[#c53030] hover:underline font-semibold cursor-pointer">
                                                Khai trừ
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="border-b last:border-b-0 border-[#d9e4ec] flex h-[44px] items-center text-[13px] text-[#334b5d]">
                                    <div class="w-[200px] min-w-[200px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium">
                                        Nguyễn An
                                    </div>
                                    <div class="w-[170px] min-w-[170px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                        01/01/2024
                                    </div>
                                    <div class="w-[140px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                        <span class="inline-block px-2 py-0.5 text-xs font-semibold bg-[#e6f5ec] text-[#16734b]">
                                            ACTIVE
                                        </span>
                                    </div>
                                    <div class="flex-1 px-3 h-full flex items-center">
                                        <button type="button" class="text-xs text-[#c53030] hover:underline font-semibold cursor-pointer">
                                            Khai trừ
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- XE THUỘC CĂN HỘ · Vehicle -->
                <div data-name="Xe">
                    <div class="text-[12px] font-semibold uppercase text-[#334b5d] tracking-wide mb-2">
                        XE THUỘC CĂN HỘ · Vehicle
                    </div>
                    <div class="border border-[#d9e4ec] overflow-hidden">
                        <div class="bg-[#e4edf3] border-b border-[#d9e4ec] flex h-[38px] items-center text-[12px] font-semibold text-[#334b5d]">
                            <div class="w-[200px] min-w-[200px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                Biển số xe
                            </div>
                            <div class="w-[170px] min-w-[170px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                Ngày đăng ký
                            </div>
                            <div class="w-[140px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                Loại xe
                            </div>
                            <div class="flex-1 px-3 h-full flex items-center">
                                Thao tác
                            </div>
                        </div>

                        <div id="editModalVehiclesList">
                            @if (isset($editApartment) && $editApartment->vehicles && $editApartment->vehicles->isNotEmpty())
                                @foreach ($editApartment->vehicles as $v)
                                    <div class="border-b last:border-b-0 border-[#d9e4ec] flex h-[44px] items-center text-[13px] text-[#334b5d]">
                                        <div class="w-[200px] min-w-[200px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium">
                                            {{ $v->LicensePlate }}
                                        </div>
                                        <div class="w-[170px] min-w-[170px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                            01/01/2024
                                        </div>
                                        <div class="w-[140px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                            {{ $v->VehicleType === 'CAR' ? 'Ô tô' : 'Xe máy' }}
                                        </div>
                                        <div class="flex-1 px-3 h-full flex items-center">
                                            <button type="button" class="text-xs text-[#c53030] hover:underline font-semibold cursor-pointer">
                                                Khai trừ
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="border-b last:border-b-0 border-[#d9e4ec] flex h-[44px] items-center text-[13px] text-[#334b5d]">
                                    <div class="w-[200px] min-w-[200px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium">
                                        29A-10001
                                    </div>
                                    <div class="w-[170px] min-w-[170px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                        01/01/2024
                                    </div>
                                    <div class="w-[140px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                        Xe máy
                                    </div>
                                    <div class="flex-1 px-3 h-full flex items-center">
                                        <button type="button" class="text-xs text-[#c53030] hover:underline font-semibold cursor-pointer">
                                            Khai trừ
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Mô tả · Description -->
                <div>
                    <label for="editModalDescription" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                        Mô tả · Description
                    </label>
                    <textarea
                        id="editModalDescription"
                        name="Description"
                        rows="3"
                        maxlength="500"
                        placeholder="Nhập mô tả, có thể để trống"
                        class="w-full p-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder:text-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] transition-colors resize-y"
                    >{{ old('Description', isset($editApartment) ? $editApartment->Description : 'Căn hộ tầng 1, số 01') }}</textarea>
                    @error('Description')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Modal Footer Actions -->
            <div class="h-[68px] px-6 border-t border-[#E5E7EB] flex items-center justify-between bg-white rounded-b-[16px] flex-shrink-0">
                <button
                    type="button"
                    onclick="closeEditApartmentModal()"
                    class="px-4 h-[40px] border border-[#E5E7EB] bg-white hover:bg-[#F9FBFA] text-[#374151] rounded-[8px] font-medium text-[13.5px] transition-colors cursor-pointer flex items-center justify-center select-none"
                >
                    Đóng / Hủy
                </button>
                <button
                    type="submit"
                    class="px-5 h-[40px] bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white rounded-[8px] font-semibold text-[13.5px] transition-colors cursor-pointer flex items-center justify-center select-none shadow-sm"
                >
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditApartmentModal(apartmentId) {
        const data = window.apartmentsMap ? window.apartmentsMap[apartmentId] : null;
        if (!data) return;

        // Form action URL
        const form = document.getElementById('editApartmentForm');
        if (form) {
            form.action = `/apartments/${apartmentId}`;
        }

        // Header & Subtitle
        const title = document.getElementById('editModalApartmentTitle');
        if (title) title.textContent = `Chỉnh sửa căn hộ ${data.ApartmentNumber}`;

        const subtitle = document.getElementById('editModalApartmentSubtitle');
        if (subtitle) subtitle.textContent = `ApartmentId = ${data.ApartmentId} · FloorId = ${data.FloorId} · Status = ${data.Status}`;

        // Field inputs
        const aptInput = document.getElementById('editModalApartmentNumber');
        if (aptInput) aptInput.value = data.ApartmentNumber;

        const statusSelect = document.getElementById('editModalStatus');
        if (statusSelect) statusSelect.value = data.Status;

        const descTextarea = document.getElementById('editModalDescription');
        if (descTextarea) descTextarea.value = data.Description || '';

        // Cư dân list
        const resList = document.getElementById('editModalResidentsList');
        if (resList) {
            if (data.residents && data.residents.length > 0) {
                resList.innerHTML = data.residents.map(r => `
                    <div class="border-b last:border-b-0 border-[#d9e4ec] flex h-[44px] items-center text-[13px] text-[#334b5d]">
                        <div class="w-[200px] min-w-[200px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium">
                            ${r.name || '—'}
                        </div>
                        <div class="w-[170px] min-w-[170px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                            ${r.startDate || '—'}
                        </div>
                        <div class="w-[140px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                            <span class="inline-block px-2 py-0.5 text-xs font-semibold ${r.status === 'ACTIVE' ? 'bg-[#e6f5ec] text-[#16734b]' : 'bg-gray-100 text-[#52697c]'}">
                                ${r.status || 'ACTIVE'}
                            </span>
                        </div>
                        <div class="flex-1 px-3 h-full flex items-center">
                            <button type="button" class="text-xs text-[#c53030] hover:underline font-semibold cursor-pointer">
                                Khai trừ
                            </button>
                        </div>
                    </div>
                `).join('');
            } else {
                resList.innerHTML = `
                    <div class="p-3 text-center text-[13px] text-[#52697c]">
                        Chưa có cư dân liên kết
                    </div>
                `;
            }
        }

        // Xe list
        const vehList = document.getElementById('editModalVehiclesList');
        if (vehList) {
            if (data.vehicles && data.vehicles.length > 0) {
                vehList.innerHTML = data.vehicles.map(v => {
                    const parts = v.split(' / ');
                    const plate = parts[0] || v;
                    const type = parts[1] || 'MOTORBIKE';
                    return `
                        <div class="border-b last:border-b-0 border-[#d9e4ec] flex h-[44px] items-center text-[13px] text-[#334b5d]">
                            <div class="w-[200px] min-w-[200px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium">
                                ${plate}
                            </div>
                            <div class="w-[170px] min-w-[170px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                01/01/2024
                            </div>
                            <div class="w-[140px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                ${type === 'CAR' ? 'Ô tô' : 'Xe máy'}
                            </div>
                            <div class="flex-1 px-3 h-full flex items-center">
                                <button type="button" class="text-xs text-[#c53030] hover:underline font-semibold cursor-pointer">
                                    Khai trừ
                                </button>
                            </div>
                        </div>
                    `;
                }).join('');
            } else {
                vehList.innerHTML = `
                    <div class="p-3 text-center text-[13px] text-[#52697c]">
                        Không có phương tiện đăng ký
                    </div>
                `;
            }
        }

        const modal = document.getElementById('editApartmentModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => aptInput && aptInput.focus(), 50);
        }
    }

    function closeEditApartmentModal() {
        const modal = document.getElementById('editApartmentModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // Đóng khi click ngoài hộp thoại modal
    document.getElementById('editApartmentModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditApartmentModal();
        }
    });
</script>
