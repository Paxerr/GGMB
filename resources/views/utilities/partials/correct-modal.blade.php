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
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="correctModalPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[600px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header -->
            <div class="px-7 pt-6 pb-4">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeCorrectModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="correct-modal-title">
                    Đính chính chỉ số
                </h3>
                <p class="text-[13px] text-[#52697c] mt-1" id="correctModalSubtitle">
                    Căn 0101 · Điện · Kỳ 02/2026
                </p>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('utilities.correct') }}" method="POST" onsubmit="event.preventDefault(); simulateCorrect();">
                @csrf
                <div class="px-7 pb-6 space-y-4">
                    <!-- Hàng 1: Chỉ số kỳ trước (chỉ đọc) & Chỉ số mới * -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Chỉ số kỳ trước - chỉ đọc
                            </label>
                            <input
                                type="text"
                                id="correctOldNum"
                                readonly
                                value="103"
                                class="w-full h-[42px] px-3 bg-slate-50 border border-[#d9e4ec] text-[14px] text-[#52697c] font-mono cursor-not-allowed select-none focus:outline-none"
                            />
                        </div>

                        <div>
                            <label for="correctNewNum" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Chỉ số mới <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="number"
                                id="correctNewNum"
                                required
                                value="142"
                                oninput="calcCorrectUsage()"
                                class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] font-semibold text-[#122d40] font-mono focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 2: Tiêu thụ (tự tính) -->
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Tiêu thụ (tự tính)
                        </label>
                        <input
                            type="text"
                            id="correctUsage"
                            readonly
                            value="39"
                            class="w-full h-[42px] px-3 bg-slate-50 border border-[#d9e4ec] text-[14px] font-bold text-[#2864ad] font-mono cursor-not-allowed select-none focus:outline-none"
                        />
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-7 py-4 border-t border-[#d9e4ec] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeCorrectModal()"
                        class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
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
        alert('Đã cập nhật đính chính chỉ số thành công (Demo UI)!');
    }
</script>
