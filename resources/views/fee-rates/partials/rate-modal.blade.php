<!-- Modal Popup: Chỉnh sửa đơn giá -->
<div
    id="editRateModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="edit-rate-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Background backdrop -->
    <div
        id="editRateBackdrop"
        onclick="closeEditRateModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="editRatePanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[600px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#0E4D3C] tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeEditRateModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] sm:text-[20px] font-bold text-[#111827] tracking-tight mt-1" id="edit-rate-title">
                    Chỉnh sửa đơn giá
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-0.5" id="editRateSubtitle">
                    Điện · Chỉ người có quyền cấu hình được sửa.
                </p>
            </div>

            <!-- Two Tabs: Thêm mới / › Sửa hiện hành -->
            <div class="px-6 pt-4 pb-1">
                <div class="flex border border-[#E5E7EB] rounded-[8px] overflow-hidden p-1 bg-[#F8FAF8]">
                    <button
                        type="button"
                        onclick="switchRateTab('create')"
                        id="rateTabCreate"
                        class="flex-1 h-[36px] flex items-center justify-center text-[13px] font-medium text-[#6B7280] hover:text-[#111827] rounded-[6px] transition-colors cursor-pointer"
                    >
                        Thêm mới
                    </button>
                    <button
                        type="button"
                        onclick="switchRateTab('edit')"
                        id="rateTabEdit"
                        class="flex-1 h-[36px] flex items-center justify-center text-[13px] font-semibold bg-[#0E4D3C] text-white rounded-[6px] transition-colors cursor-pointer"
                    >
                        › Sửa hiện hành
                    </button>
                </div>
            </div>

            <!-- Modal Form -->
            <form id="editRateForm" method="POST" action="" onsubmit="handleEditRateSubmit(event)">
                @csrf
                <div class="p-6 space-y-4">
                    <!-- Loại phí * (không đổi khi sửa) -->
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Loại phí * (không đổi khi sửa)
                        </label>
                        <input
                            type="text"
                            id="edit_rate_fee_name"
                            readonly
                            value="Điện"
                            class="w-full h-[40px] px-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#6B7280] focus:outline-none cursor-not-allowed"
                        />
                        <p class="text-[11px] text-[#6B7280] mt-1">
                            Đơn giá dùng khi lập chi tiết hóa đơn theo thời gian hiệu lực. Không tự thay đổi hóa đơn đã lập.
                        </p>
                    </div>

                    <!-- Đơn giá * · VND -->
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Đơn giá * · VND
                        </label>
                        <input
                            type="text"
                            id="edit_rate_price"
                            value="3.500"
                            required
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        />
                    </div>

                    <!-- Hàng 2 Cột: Áp dụng từ * & Áp dụng đến -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Áp dụng từ *
                            </label>
                            <input
                                type="text"
                                id="edit_rate_from"
                                value="01/01/2025"
                                required
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Áp dụng đến
                            </label>
                            <input
                                type="text"
                                id="edit_rate_to"
                                value="Không giới hạn"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <p class="text-[11px] text-[#6B7280]">
                        Đơn giá không âm; kiểm tra định dạng và thời gian áp dụng trước khi lưu.
                    </p>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-[#F8FAF8] border-t border-[#E5E7EB] rounded-b-[16px] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeEditRateModal()"
                        class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[40px] px-5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Lưu đơn giá
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditRateModal(data = {}) {
        const modal = document.getElementById('editRateModal');
        const backdrop = document.getElementById('editRateBackdrop');
        const panel = document.getElementById('editRatePanel');

        if (!modal || !backdrop || !panel) return;

        const feeName = data.name || 'Điện';
        const price = (data.price || 3500).toLocaleString('vi-VN');
        const from = data.effective_from || '01/01/2025';
        const to = data.effective_to || 'Không giới hạn';

        document.getElementById('editRateSubtitle').textContent = `${feeName} · Chỉ người có quyền cấu hình được sửa.`;
        document.getElementById('edit_rate_fee_name').value = feeName;
        document.getElementById('edit_rate_price').value = price;
        document.getElementById('edit_rate_from').value = from;
        document.getElementById('edit_rate_to').value = to;

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeEditRateModal() {
        const modal = document.getElementById('editRateModal');
        const backdrop = document.getElementById('editRateBackdrop');
        const panel = document.getElementById('editRatePanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function switchRateTab(tab) {
        const tabCreate = document.getElementById('rateTabCreate');
        const tabEdit = document.getElementById('rateTabEdit');

        if (tab === 'create') {
            tabCreate.className = 'flex-1 h-[36px] flex items-center justify-center text-[13px] font-semibold bg-[#0E4D3C] text-white rounded-[6px] transition-colors cursor-pointer';
            tabEdit.className = 'flex-1 h-[36px] flex items-center justify-center text-[13px] font-medium text-[#6B7280] hover:text-[#111827] rounded-[6px] transition-colors cursor-pointer';
            document.getElementById('edit_rate_price').value = '';
            document.getElementById('edit_rate_from').value = 'dd/mm/yyyy';
            document.getElementById('edit_rate_to').value = 'Để trống nếu không giới hạn';
        } else {
            tabEdit.className = 'flex-1 h-[36px] flex items-center justify-center text-[13px] font-semibold bg-[#0E4D3C] text-white rounded-[6px] transition-colors cursor-pointer';
            tabCreate.className = 'flex-1 h-[36px] flex items-center justify-center text-[13px] font-medium text-[#6B7280] hover:text-[#111827] rounded-[6px] transition-colors cursor-pointer';
            document.getElementById('edit_rate_price').value = '3.500';
            document.getElementById('edit_rate_from').value = '01/01/2025';
            document.getElementById('edit_rate_to').value = 'Không giới hạn';
        }
    }

    function handleEditRateSubmit(event) {
        event.preventDefault();
        const price = document.getElementById('edit_rate_price')?.value || '3.500';
        closeEditRateModal();

        if (window.showToast) {
            window.showToast(`Đã lưu đơn giá ${price} đ thành công.`);
        }
    }
</script>
