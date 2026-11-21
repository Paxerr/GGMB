<!-- Modal Popup: Thay đổi trạng thái / Ngừng hoạt động căn hộ (14 · SCR-APT-06 · 688px) -->
<div
    id="statusApartmentModal"
    class="{{ isset($statusApartment) ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-[#000000]/40 backdrop-blur-xs p-4 overflow-y-auto"
    aria-labelledby="statusModalTitle"
    role="dialog"
    aria-modal="true"
    data-name="14 · SCR-APT-06 · Thay đổi trạng thái căn hộ"
>
    <!-- Modal Card Container (Width: 688px max, height: ~358px) -->
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
                    onclick="closeStatusApartmentModal()"
                    class="text-[26px] leading-none text-[#52697c] hover:text-[#122d40] transition-colors cursor-pointer p-1"
                    aria-label="Đóng"
                >
                    &times;
                </button>
            </div>
            <h2 id="statusModalTitle" class="text-[22px] font-bold text-[#122d40] mt-1">
                Ngừng hoạt động căn hộ
            </h2>
            <p id="statusModalSubtitle" class="text-[13px] text-[#52697c] mt-0.5">
                Căn hộ {{ isset($statusApartment) ? $statusApartment->ApartmentNumber : '0505' }} · Tầng {{ isset($statusApartment) ? ($statusApartment->floor->FloorNumber ?? $statusApartment->FloorId) : '5' }} · {{ isset($statusApartment) ? $statusApartment->Status : 'Trống' }}
            </p>
        </div>

        <!-- Form Body -->
        <form
            action="{{ isset($statusApartment) ? route('apartments.update-status', $statusApartment->ApartmentId) : '#' }}"
            method="POST"
            id="statusApartmentForm"
        >
            @csrf
            @method('PATCH')

            <div class="px-6 py-5 space-y-4" data-name="Nội dung">
                <!-- Nhóm trường: Trạng thái hiện tại & Trạng thái dự kiến (2 cols) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" data-name="Nhóm trường">
                    <!-- Trạng thái hiện tại -->
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Trạng thái hiện tại
                        </label>
                        <div id="statusModalCurrentStatus" class="h-[42px] px-3 bg-[#f8fbfd] border border-[#d9e4ec] text-[14px] font-medium text-[#122d40] flex items-center">
                            {{ isset($statusApartment) ? $statusApartment->Status : 'Trống' }}
                        </div>
                    </div>

                    <!-- Trạng thái dự kiến -->
                    <div>
                        <label for="statusModalExpectedStatus" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Trạng thái dự kiến
                        </label>
                        <div class="relative">
                            <select
                                id="statusModalExpectedStatus"
                                name="Status"
                                required
                                onchange="onStatusExpectedChange(this.value)"
                                class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] rounded-[4px] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                            >
                                <option value="SUSPENDED">Ngừng hoạt động (SUSPENDED)</option>
                                <option value="VACANT">Trống (VACANT)</option>
                                <option value="OCCUPIED">Đang ở (OCCUPIED)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                                ▾
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chú thích nghiệp vụ -->
                <div id="statusModalNoticeBox" class="p-3 bg-[#f8fbfd] border border-[#d9e4ec] text-[13px] text-[#52697c] rounded-[4px]">
                    <span class="font-semibold text-[#334b5d]">Quy tắc vận hành:</span> Kiểm tra điều kiện trước khi chuyển trạng thái căn hộ. Khi ngừng hoạt động, căn hộ không được còn cư dân đang cư trú và nợ phí quá hạn chưa tất toán.
                </div>
            </div>

            <!-- Modal Footer Actions -->
            <div class="h-[72px] px-6 border-t border-[#d9e4ec] flex items-center justify-between bg-white flex-shrink-0">
                <button
                    type="button"
                    onclick="closeStatusApartmentModal()"
                    class="w-[136px] h-[40px] border border-[#d9e4ec] bg-white hover:bg-gray-50 text-[#334b5d] rounded-[4px] font-medium text-[14px] transition-colors cursor-pointer flex items-center justify-center select-none"
                >
                    Đóng / Hủy
                </button>
                <button
                    type="submit"
                    id="statusModalConfirmBtn"
                    class="w-[204px] h-[40px] bg-[#2864ad] hover:bg-[#205391] text-white rounded-[4px] font-semibold text-[14px] transition-colors cursor-pointer flex items-center justify-center select-none"
                >
                    Xác nhận ngừng
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openStatusApartmentModal(apartmentId) {
        const data = window.apartmentsMap ? window.apartmentsMap[apartmentId] : null;
        if (!data) return;

        // Form action
        const form = document.getElementById('statusApartmentForm');
        if (form) {
            form.action = `/apartments/${apartmentId}/status`;
        }

        // Subtitle
        const subtitle = document.getElementById('statusModalSubtitle');
        if (subtitle) {
            subtitle.textContent = `Căn hộ ${data.ApartmentNumber} · Tầng ${data.FloorId} · ${data.Status}`;
        }

        // Current status display
        const currentDisplay = document.getElementById('statusModalCurrentStatus');
        if (currentDisplay) {
            currentDisplay.textContent = data.Status;
        }

        // Expected status select
        const select = document.getElementById('statusModalExpectedStatus');
        if (select) {
            if (data.Status === 'SUSPENDED' || data.Status === 'INACTIVE') {
                select.value = 'VACANT';
            } else {
                select.value = 'SUSPENDED';
            }
            onStatusExpectedChange(select.value);
        }

        const modal = document.getElementById('statusApartmentModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function onStatusExpectedChange(val) {
        const title = document.getElementById('statusModalTitle');
        const btn = document.getElementById('statusModalConfirmBtn');
        if (val === 'SUSPENDED' || val === 'INACTIVE') {
            if (title) title.textContent = 'Ngừng hoạt động căn hộ';
            if (btn) btn.textContent = 'Xác nhận ngừng';
        } else {
            if (title) title.textContent = 'Thay đổi trạng thái căn hộ';
            if (btn) btn.textContent = 'Xác nhận thay đổi';
        }
    }

    function closeStatusApartmentModal() {
        const modal = document.getElementById('statusApartmentModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // Đóng khi click ngoài backdrop
    document.getElementById('statusApartmentModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeStatusApartmentModal();
        }
    });
</script>
