<!-- Modal Popup: Đính chính chỉ số (Bám sát Ảnh 4) -->
<div
    id="correctModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="correct-modal-title"
    role="dialog"
    aria-modal="true"
>
    <div
        id="correctModalBackdrop"
        onclick="closeCorrectModal()"
        class="fixed inset-0 bg-black/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="correctModalPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[600px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeCorrectModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] font-bold text-[#111827] mt-1" id="correct-modal-title">
                    Đính chính chỉ số
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-1" id="correctModalSubtitle">
                    Căn 0101 · Điện · Kỳ 02/2026
                </p>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('utilities.correct') }}" method="POST">
                @csrf
                <input type="hidden" name="MeterReadingId" id="correctMeterReadingId" value="1">
                <div class="px-6 py-5 space-y-4">
                    <!-- Hàng 1: Chỉ số kỳ trước (chỉ đọc) & Chỉ số mới * -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Chỉ số kỳ trước - chỉ đọc
                            </label>
                            <input
                                type="text"
                                id="correctOldNum"
                                name="PreviousReading"
                                readonly
                                value="103"
                                class="w-full h-[40px] px-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#6B7280] font-mono cursor-not-allowed select-none focus:outline-none"
                            />
                        </div>

                        <div>
                            <label for="correctNewNum" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Chỉ số mới <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="number"
                                id="correctNewNum"
                                name="CurrentReading"
                                required
                                value="142"
                                oninput="calcCorrectUsage()"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] font-bold text-[#111827] font-mono focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 2: Tiêu thụ (tự tính) -->
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Tiêu thụ (tự tính)
                        </label>
                        <input
                            type="text"
                            id="correctUsage"
                            readonly
                            value="39"
                            class="w-full h-[40px] px-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[13.5px] font-bold text-[#0E4D3C] font-mono cursor-not-allowed select-none focus:outline-none"
                        />
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-[#F2F6F4] border-t border-[#E5E7EB] flex items-center justify-between rounded-b-[16px]">
                    <button
                        type="button"
                        onclick="closeCorrectModal()"
                        class="h-[38px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[38px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Lưu đính chính
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCorrectModal(idOrData) {
        const data = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.utilitiesMap?.[idOrData] || {});
        const modal = document.getElementById('correctModal');
        const backdrop = document.getElementById('correctModalBackdrop');
        const panel = document.getElementById('correctModalPanel');

        if (!modal || !backdrop || !panel) return;

        const apt = data.apartment || '0101';
        const type = data.type || 'Điện';
        const period = data.period || '02/2026';
        const oldNum = data.old_num || 103;
        const newNum = data.new_num || 142;
        const usage = data.usage || (newNum - oldNum);

        document.getElementById('correctMeterReadingId').value = data.id || (typeof idOrData === 'number' ? idOrData : 1);
        document.getElementById('correctModalSubtitle').textContent = `Căn ${apt} · ${type} · Kỳ ${period}`;
        document.getElementById('correctOldNum').value = oldNum;
        document.getElementById('correctNewNum').value = newNum;
        document.getElementById('correctUsage').value = usage;

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeCorrectModal() {
        const modal = document.getElementById('correctModal');
        const backdrop = document.getElementById('correctModalBackdrop');
        const panel = document.getElementById('correctModalPanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function calcCorrectUsage() {
        const oldNum = parseInt(document.getElementById('correctOldNum').value) || 0;
        const newNum = parseInt(document.getElementById('correctNewNum').value) || 0;
        document.getElementById('correctUsage').value = Math.max(0, newNum - oldNum);
    }

    function simulateCorrect() {
        closeCorrectModal();
        if (window.showToast) {
            window.showToast('Đã cập nhật đính chính chỉ số thành công!');
        }
    }
</script>
