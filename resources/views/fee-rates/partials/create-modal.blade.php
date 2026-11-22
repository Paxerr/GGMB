<!-- Modal: Thêm loại phí mới -->
<div
    id="createFeeModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="create-fee-title"
    role="dialog"
    aria-modal="true"
>
    <div
        id="createFeeBackdrop"
        onclick="closeCreateFeeModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="createFeePanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[560px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#0E4D3C] tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeCreateFeeModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] sm:text-[20px] font-bold text-[#111827] tracking-tight mt-1" id="create-fee-title">
                    Thêm loại phí mới
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-0.5">
                    Cấu hình danh mục phí và đơn giá áp dụng.
                </p>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('fee-rates.store') }}" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="fee_code" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Mã loại phí <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="text"
                                id="fee_code"
                                name="Code"
                                required
                                placeholder="Ví dụ: ELEC, WATER, MGMT"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] uppercase focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                        <div>
                            <label for="fee_name" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Tên loại phí <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="text"
                                id="fee_name"
                                name="Name"
                                required
                                placeholder="Ví dụ: Phí gửi xe đạp điện"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="fee_desc" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Mô tả
                            </label>
                            <input
                                type="text"
                                id="fee_desc"
                                name="Description"
                                placeholder="Mô tả loại phí..."
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>

                        <div>
                            <label for="fee_price" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Đơn giá khởi tạo (VND)
                            </label>
                            <input
                                type="number"
                                id="fee_price"
                                name="UnitPrice"
                                placeholder="50000"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-[#F8FAF8] border-t border-[#E5E7EB] rounded-b-[16px] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeCreateFeeModal()"
                        class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[40px] px-5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Tạo loại phí
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCreateFeeModal() {
        const modal = document.getElementById('createFeeModal');
        const backdrop = document.getElementById('createFeeBackdrop');
        const panel = document.getElementById('createFeePanel');

        if (!modal || !backdrop || !panel) return;

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeCreateFeeModal() {
        const modal = document.getElementById('createFeeModal');
        const backdrop = document.getElementById('createFeeBackdrop');
        const panel = document.getElementById('createFeePanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function simulateCreateFee() {
        const name = document.getElementById('fee_name').value;
        closeCreateFeeModal();
        if (window.showToast) {
            window.showToast(`Đã thêm loại phí ${name} thành công.`);
        }
    }
</script>
