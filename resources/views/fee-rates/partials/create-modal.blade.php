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
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[560px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header -->
            <div class="px-7 pt-6 pb-4">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeCreateFeeModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="create-fee-title">
                    Thêm loại phí mới
                </h3>
                <p class="text-[13px] text-[#52697c] mt-1">
                    Cấu hình danh mục phí và đơn giá áp dụng.
                </p>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('fee-rates.store') }}" method="POST" onsubmit="event.preventDefault(); simulateCreateFee();">
                @csrf
                <div class="px-7 pb-6 space-y-4">
                    <div>
                        <label for="fee_name" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Tên loại phí <span class="text-rose-600">*</span>
                        </label>
                        <input
                            type="text"
                            id="fee_name"
                            required
                            placeholder="Ví dụ: Phí gửi xe đạp điện"
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                        />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="fee_unit" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Đơn vị tính <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="text"
                                id="fee_unit"
                                required
                                placeholder="kWh, m³, Xe/tháng..."
                                class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>

                        <div>
                            <label for="fee_price" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Đơn giá (VND) <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="number"
                                id="fee_price"
                                required
                                placeholder="50000"
                                class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-7 py-4 border-t border-[#d9e4ec] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeCreateFeeModal()"
                        class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Lưu loại phí
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
        closeCreateFeeModal();
        alert('Đã thêm loại phí mới thành công (Demo UI)!');
    }
</script>
