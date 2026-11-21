<!-- Slide-over Drawer: Lịch sử chỉ số điện nước (Bám sát Ảnh 3) -->
<div
    id="historyDrawer"
    class="fixed inset-0 z-50 overflow-hidden hidden"
    aria-labelledby="history-drawer-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        id="historyDrawerBackdrop"
        onclick="closeHistoryDrawer()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-300 opacity-0"
    ></div>

    <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
        <div
            id="historyDrawerPanel"
            class="w-screen max-w-[560px] bg-white border-l border-[#d9e4ec] shadow-2xl flex flex-col transform transition-transform duration-300 ease-in-out translate-x-full"
        >
            <!-- Drawer Header -->
            <div class="px-7 pt-6 pb-4 border-b border-[#d9e4ec] shrink-0">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        LỊCH SỬ CHỈ SỐ
                    </span>
                    <button
                        type="button"
                        onclick="closeHistoryDrawer()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="historyDrawerTitle">
                    Căn hộ 0101 · Điện
                </h3>
                <p class="text-[13px] text-[#52697c] mt-0.5" id="historyDrawerSubtitle">
                    Căn hộ 0101 · Điện · Năm 2026
                </p>
            </div>

            <!-- Drawer Body -->
            <div class="flex-1 overflow-y-auto p-7 space-y-6">
                <!-- Section 1: Biểu đồ tiêu thụ theo tháng (01–12/2026) -->
                <div>
                    <h4 class="text-[12px] font-bold text-slate-500 tracking-wider uppercase mb-3">
                        TIÊU THỤ THEO THÁNG · 01–12/2026
                    </h4>
                    <div class="bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] p-5">
                        <!-- Chart container -->
                        <div class="h-[140px] flex items-end justify-between gap-1 pb-2 border-b border-[#d9e4ec]">
                            <!-- Tháng 01 -->
                            <div class="flex-1 flex flex-col items-center justify-end h-full">
                                <span class="text-[11px] text-[#8a9ba8]">—</span>
                            </div>
                            <!-- Tháng 02 (Có số liệu 39) -->
                            <div class="flex-1 flex flex-col items-center justify-end h-full">
                                <span class="text-[12px] font-bold text-[#122d40] mb-1" id="chartValueText">39</span>
                                <div class="w-full max-w-[28px] h-[75px] bg-[#e8f1ff] border border-[#2864ad] rounded-t-[2px]"></div>
                            </div>
                            <!-- Tháng 03 - 12 -->
                            @for ($m = 3; $m <= 12; $m++)
                                <div class="flex-1 flex flex-col items-center justify-end h-full">
                                    <span class="text-[11px] text-[#8a9ba8]">—</span>
                                </div>
                            @endfor
                        </div>

                        <!-- Trục hoành các tháng 01 - 12 -->
                        <div class="flex items-center justify-between text-[11px] text-[#52697c] font-medium pt-2">
                            @for ($m = 1; $m <= 12; $m++)
                                <span class="flex-1 text-center">{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</span>
                            @endfor
                        </div>

                        <p class="text-[11px] text-[#8a9ba8] mt-3">
                            — : Chưa có dữ liệu trong tháng.
                        </p>
                    </div>
                </div>

                <!-- Section 2: Bản ghi đã lưu (Bảng số liệu kỳ) -->
                <div>
                    <h4 class="text-[12px] font-bold text-slate-500 tracking-wider uppercase mb-3" id="historyRecordPeriodTitle">
                        BẢN GHI ĐÃ LƯU · 02/2026
                    </h4>
                    <div class="bg-white border border-[#d9e4ec] rounded-[4px] overflow-hidden">
                        <div class="bg-[#e4edf3] flex h-[36px] items-center text-[12px] font-semibold text-[#334b5d] border-b border-[#d9e4ec] px-4">
                            <div class="w-1/3">Chỉ số cũ</div>
                            <div class="w-1/3">Chỉ số mới</div>
                            <div class="w-1/3 text-right">Tiêu thụ</div>
                        </div>
                        <div class="flex h-[44px] items-center text-[14px] text-[#334b5d] px-4 font-mono">
                            <div class="w-1/3" id="historyOldNum">103</div>
                            <div class="w-1/3 font-semibold text-[#122d40]" id="historyNewNum">142</div>
                            <div class="w-1/3 text-right font-bold text-[#2864ad]" id="historyUsage">39</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Drawer Footer -->
            <div class="p-5 border-t border-[#d9e4ec] flex items-center justify-between shrink-0 bg-[#f8fafc]">
                <button
                    type="button"
                    onclick="closeHistoryDrawer()"
                    class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                >
                    Đóng
                </button>
                <button
                    type="button"
                    onclick="correctFromHistory()"
                    class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
                >
                    Đính chính số
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let activeHistoryData = null;

    function openHistoryDrawer(idOrData) {
        const data = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.utilitiesMap?.[idOrData] || {});
        activeHistoryData = data;
        const drawer = document.getElementById('historyDrawer');
        const backdrop = document.getElementById('historyDrawerBackdrop');
        const panel = document.getElementById('historyDrawerPanel');

        if (!drawer || !backdrop || !panel) return;

        const apt = data.apartment || '0101';
        const type = data.type || 'Điện';
        const period = data.period || '02/2026';
        const oldNum = data.old_num || 103;
        const newNum = data.new_num || 142;
        const usage = data.usage || 39;

        document.getElementById('historyDrawerTitle').textContent = `Căn hộ ${apt} · ${type}`;
        document.getElementById('historyDrawerSubtitle').textContent = `Căn hộ ${apt} · ${type} · Năm 2026`;
        document.getElementById('chartValueText').textContent = usage;
        document.getElementById('historyRecordPeriodTitle').textContent = `BẢN GHI ĐÃ LƯU · ${period}`;
        document.getElementById('historyOldNum').textContent = oldNum;
        document.getElementById('historyNewNum').textContent = newNum;
        document.getElementById('historyUsage').textContent = usage;

        drawer.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('translate-x-full');
            panel.classList.add('translate-x-0');
        });
    }

    function closeHistoryDrawer() {
        const drawer = document.getElementById('historyDrawer');
        const backdrop = document.getElementById('historyDrawerBackdrop');
        const panel = document.getElementById('historyDrawerPanel');

        if (!drawer || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('translate-x-0');
        panel.classList.add('translate-x-full');

        setTimeout(() => {
            drawer.classList.add('hidden');
        }, 300);
    }

    function correctFromHistory() {
        const data = activeHistoryData;
        closeHistoryDrawer();
        if (data && typeof openCorrectModal === 'function') {
            setTimeout(() => {
                openCorrectModal(data);
            }, 250);
        }
    }
</script>
