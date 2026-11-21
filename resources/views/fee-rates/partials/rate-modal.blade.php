<!-- Modal Popup: Chỉnh sửa đơn giá (Bám sát Ảnh Chỉnh sửa đơn giá) -->
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
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[600px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header (Bám sát Ảnh Chỉnh sửa đơn giá) -->
            <div class="px-7 pt-6 pb-3">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeEditRateModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="edit-rate-title">
                    Chỉnh sửa đơn giá
                </h3>
                <p class="text-[13px] text-[#52697c] mt-0.5" id="editRateSubtitle">
                    Điện · Chỉ người có quyền cấu hình được sửa.
                </p>
            </div>

            <!-- Two Tabs: Thêm mới / › Sửa hiện hành -->
            <div class="px-7 pt-1 pb-3">
                <div class="flex border border-[#d9e4ec] rounded-[4px] overflow-hidden p-0.5 bg-[#f8fafc]">
                    <button
                        type="button"
                        onclick="switchRateTab('create')"
                        id="rateTabCreate"
                        class="flex-1 h-[36px] flex items-center justify-center text-[13px] font-medium text-[#52697c] hover:text-[#122d40] rounded transition-colors"
                    >
                        Thêm mới
                    </button>
                    <button
                        type="button"
                        onclick="switchRateTab('edit')"
                        id="rateTabEdit"
                        class="flex-1 h-[36px] flex items-center justify-center text-[13px] font-semibold bg-[#2864ad] text-white rounded transition-colors"
                    >
                        › Sửa hiện hành
                    </button>
                </div>
            </div>

            <!-- Modal Form -->
            <form id="editRateForm" method="POST" action="" onsubmit="handleEditRateSubmit(event)">
                @csrf
                <div class="px-7 pb-6 space-y-4">
                    <!-- Loại phí * (không đổi khi sửa) -->
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Loại phí * (không đổi khi sửa)
                        </label>
                        <input
                            type="text"
                            id="edit_rate_fee_name"
                            readonly
                            value="Điện"
                            class="w-full h-[42px] px-3 bg-[#f8fafc] border border-[#d9e4ec] text-[14px] text-[#52697c] focus:outline-none cursor-not-allowed"
                        />
                        <p class="text-[11px] text-[#8a9ba8] mt-1">
                            Đơn giá dùng khi lập chi tiết hóa đơn theo thời gian hiệu lực. Không tự thay đổi hóa đơn đã lập.
                        </p>
                    </div>

                    <!-- Đơn giá * · VND -->
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Đơn giá * · VND
                        </label>
                        <input
                            type="text"
                            id="edit_rate_price"
                            value="3.500"
                            required
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        />
                    </div>

                    <!-- Hàng 2 Cột: Áp dụng từ * & Áp dụng đến -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Áp dụng từ *
                            </label>
                            <input
                                type="text"
                                id="edit_rate_from"
                                value="01/01/2025"
                                required
                                class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Áp dụng đến
                            </label>
                            <input
                                type="text"
                                id="edit_rate_to"
                                value="Không giới hạn"
                                class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                    </div>

                    <p class="text-[11px] text-[#8a9ba8]">
                        Đơn giá không âm; kiểm tra định dạng và thời gian áp dụng trước khi lưu.
                    </p>
                </div>

                <!-- Modal Footer (Hủy bên trái, Lưu đơn giá bên phải - Bám sát Ảnh) -->
                <div class="px-7 py-4 border-t border-[#d9e4ec] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeEditRateModal()"
                        class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
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
            tabCreate.className = 'flex-1 h-[36px] flex items-center justify-center text-[13px] font-semibold bg-[#2864ad] text-white rounded transition-colors';
            tabEdit.className = 'flex-1 h-[36px] flex items-center justify-center text-[13px] font-medium text-[#52697c] hover:text-[#122d40] rounded transition-colors';
            document.getElementById('edit_rate_price').value = '';
            document.getElementById('edit_rate_from').value = 'dd/mm/yyyy';
            document.getElementById('edit_rate_to').value = 'Để trống nếu không giới hạn';
        } else {
            tabEdit.className = 'flex-1 h-[36px] flex items-center justify-center text-[13px] font-semibold bg-[#2864ad] text-white rounded transition-colors';
            tabCreate.className = 'flex-1 h-[36px] flex items-center justify-center text-[13px] font-medium text-[#52697c] hover:text-[#122d40] rounded transition-colors';
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
