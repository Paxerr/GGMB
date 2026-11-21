<!-- Modal Popup: Thay đổi trạng thái cư dân (16 · SCR-RES-05 · node-id=2539-1589 · 688px) -->
<div
    id="statusResidentModal"
    class="hidden fixed inset-0 z-50 items-center justify-center bg-[#000000]/40 backdrop-blur-xs p-4 overflow-y-auto"
    aria-labelledby="statusResidentModalTitle"
    role="dialog"
    aria-modal="true"
    data-name="16 · SCR-RES-05 · Thay đổi trạng thái cư dân"
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
                    onclick="closeStatusResidentModal()"
                    class="text-[26px] leading-none text-[#52697c] hover:text-[#122d40] transition-colors cursor-pointer p-1"
                    aria-label="Đóng"
                >
                    &times;
                </button>
            </div>
            <h2 id="statusResidentModalTitle" class="text-[22px] font-bold text-[#122d40] mt-1">
                Thay đổi trạng thái cư dân
            </h2>
            <p id="statusResidentModalSubtitle" class="text-[13px] text-[#52697c] mt-0.5">
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
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Trạng thái hiện tại
                        </label>
                        <div id="statusResidentCurrentStatus" class="h-[42px] px-3 bg-[#f8fbfd] border border-[#d9e4ec] text-[14px] font-medium text-[#122d40] flex items-center">
                            Đang cư trú
                        </div>
                    </div>

                    <!-- Trạng thái dự kiến -->
                    <div>
                        <label for="statusResidentExpectedStatus" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Trạng thái dự kiến
                        </label>
                        <div class="relative">
                            <select
                                id="statusResidentExpectedStatus"
                                name="Status"
                                required
                                class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] rounded-[4px] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                            >
                                <option value="ACTIVE">Đang cư trú (ACTIVE)</option>
                                <option value="INACTIVE">Đã rời đi (INACTIVE)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                                ▾
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chú thích nghiệp vụ -->
                <div class="p-3 bg-[#f8fbfd] border border-[#d9e4ec] text-[13px] text-[#52697c] rounded-[4px]">
                    <span class="font-semibold text-[#334b5d]">Quy tắc vận hành:</span> Cập nhật quan hệ cư trú của cư dân đối với căn hộ. Khi cư dân chuyển đi (INACTIVE), hệ thống sẽ cập nhật ngày kết thúc cư trú và hủy các phân quyền quản lý liên quan đến căn hộ.
                </div>
            </div>

            <!-- Modal Footer Actions -->
            <div class="h-[72px] px-6 border-t border-[#d9e4ec] flex items-center justify-between bg-white shrink-0">
                <button
                    type="button"
                    onclick="closeStatusResidentModal()"
                    class="w-[136px] h-[40px] border border-[#d9e4ec] bg-white hover:bg-gray-50 text-[#334b5d] rounded-[4px] font-medium text-[14px] transition-colors cursor-pointer flex items-center justify-center select-none"
                >
                    Đóng / Hủy
                </button>
                <button
                    type="submit"
                    class="w-[180px] h-[40px] bg-[#2864ad] hover:bg-[#205391] text-white rounded-[4px] font-semibold text-[14px] transition-colors cursor-pointer flex items-center justify-center select-none shadow-sm"
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
