<!-- Modal Popup: Thay đổi trạng thái cư dân (16 · SCR-RES-05 · node-id=2539-1589 · 688px) -->
<div
    id="statusResidentModal"
    class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-xs p-4 overflow-y-auto"
    aria-labelledby="statusResidentModalTitle"
    role="dialog"
    aria-modal="true"
    data-name="16 · SCR-RES-05 · Thay đổi trạng thái cư dân"
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
                    onclick="closeStatusResidentModal()"
                    class="text-[26px] leading-none text-[#6B7280] hover:text-[#111827] transition-colors cursor-pointer p-1"
                    aria-label="Đóng"
                >
                    &times;
                </button>
            </div>
            <h2 id="statusResidentModalTitle" class="text-[18px] font-bold text-[#111827] mt-1">
                Thay đổi trạng thái cư dân
            </h2>
            <p id="statusResidentModalSubtitle" class="text-[13px] text-[#6B7280] mt-0.5">
                Cư dân · Đang tải…
            </p>
        </div>

        <!-- Form Body -->
        <form
            action="#"
            method="POST"
            id="statusResidentForm"
        >
            @csrf
            @method('PATCH')

            <div class="px-6 py-5 space-y-4" data-name="Nội dung">
                <!-- Nhóm trường: Trạng thái hiện tại & Trạng thái dự kiến (2 cols) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" data-name="Nhóm trường">
                    <!-- Trạng thái hiện tại -->
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Trạng thái hiện tại
                        </label>
                        <div id="statusResidentCurrentStatus" class="h-[40px] px-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[13.5px] font-medium text-[#111827] flex items-center">
                            Đang cư trú
                        </div>
                    </div>

                    <!-- Trạng thái dự kiến -->
                    <div>
                        <label for="statusResidentExpectedStatus" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Trạng thái dự kiến
                        </label>
                        <div class="relative">
                            <select
                                id="statusResidentExpectedStatus"
                                name="Status"
                                required
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] leading-[20px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                            >
                                <option value="ACTIVE">Đang cư trú (ACTIVE)</option>
                                <option value="INACTIVE">Đã rời đi (INACTIVE)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">
                                ▾
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chú thích nghiệp vụ -->
                <div class="p-3.5 bg-[#F8FAF8] border border-[#E5E7EB] text-[13px] text-[#6B7280] rounded-[8px]">
                    <span class="font-semibold text-[#374151]">Quy tắc vận hành:</span> Cập nhật quan hệ cư trú của cư dân đối với căn hộ. Khi cư dân chuyển đi (INACTIVE), hệ thống sẽ cập nhật ngày kết thúc cư trú và hủy các phân quyền quản lý liên quan đến căn hộ.
                </div>
            </div>

            <!-- Modal Footer Actions -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-t border-[#E5E7EB] flex items-center justify-between rounded-b-[16px]">
                <button
                    type="button"
                    onclick="closeStatusResidentModal()"
                    class="h-[38px] px-5 border border-[#E5E7EB] bg-white hover:bg-[#F9FBFA] text-[#374151] rounded-[8px] font-semibold text-[13px] transition-colors cursor-pointer flex items-center justify-center select-none"
                >
                    Đóng / Hủy
                </button>
                <button
                    type="submit"
                    class="h-[38px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white rounded-[8px] font-semibold text-[13px] transition-colors cursor-pointer flex items-center justify-center select-none shadow-sm"
                >
                    Xác nhận
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openStatusResidentModal(idOrData) {
        const residentData = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.residentsMap?.[idOrData] || {});
        const modal = document.getElementById('statusResidentModal');
        const form = document.getElementById('statusResidentForm');
        const subtitle = document.getElementById('statusResidentModalSubtitle');
        const currentStatusBox = document.getElementById('statusResidentCurrentStatus');
        const expectedSelect = document.getElementById('statusResidentExpectedStatus');

        if (!modal || !form) return;

        form.action = '/residents/' + residentData.userId + '/status';
        
        const isCurrentlyActive = residentData.residenceStatus === 'ACTIVE';
        subtitle.textContent = (residentData.fullName || 'Cư dân') + ' · Căn hộ ' + (residentData.apartmentNumber || '—') + ' · ' + (isCurrentlyActive ? 'Đang cư trú' : 'Đã rời đi');
        currentStatusBox.textContent = isCurrentlyActive ? 'Đang cư trú' : 'Đã rời đi';
        
        // Default expected status to the opposite or matching
        expectedSelect.value = isCurrentlyActive ? 'INACTIVE' : 'ACTIVE';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeStatusResidentModal() {
        const modal = document.getElementById('statusResidentModal');
        if (!modal) return;
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeStatusResidentModal();
        }
    });
</script>
