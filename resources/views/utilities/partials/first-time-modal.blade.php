<!-- Modal Popup: Nhập chỉ số lần đầu (Bám sát Ảnh 5) -->
<div
    id="firstTimeModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="first-time-title"
    role="dialog"
    aria-modal="true"
>
    <div
        id="firstTimeBackdrop"
        onclick="closeFirstTimeModal()"
        class="fixed inset-0 bg-black/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="firstTimePanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[640px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeFirstTimeModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] font-bold text-[#111827] mt-1" id="first-time-title">
                    Nhập chỉ số lần đầu
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-1">
                    Dùng khi chưa có chỉ số kỳ trước cho căn hộ và loại phí.
                </p>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('utilities.first-time') }}" method="POST" onsubmit="event.preventDefault(); simulateFirstTime();">
                @csrf
                <div class="px-6 py-5 space-y-4">
                    <!-- Hàng 1: Căn hộ * & Loại phí * -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="ft_apartment" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Căn hộ <span class="text-rose-600">*</span>
                            </label>
                            <div class="relative">
                                <select id="ft_apartment" required class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer">
                                    <option value="" disabled selected>Chọn căn hộ ▾</option>
                                    @foreach ($apartments as $apt)
                                        <option value="{{ $apt->ApartmentId }}">{{ $apt->ApartmentNumber }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                            </div>
                        </div>

                        <div>
                            <label for="ft_type" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Loại phí <span class="text-rose-600">*</span>
                            </label>
                            <div class="relative">
                                <select id="ft_type" required class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer">
                                    <option value="Điện">Điện ▾</option>
                                    <option value="Nước">Nước ▾</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                            </div>
                        </div>
                    </div>

                    <!-- Hàng 2: Kỳ ghi * & Chỉ số đầu kỳ * -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="ft_period" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Kỳ ghi <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="text"
                                id="ft_period"
                                required
                                placeholder="MM/YYYY"
                                value="02/2026"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>

                        <div>
                            <label for="ft_start_num" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Chỉ số đầu kỳ <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="number"
                                id="ft_start_num"
                                required
                                placeholder="Nhập theo biên bản bàn giao"
                                oninput="calcFtUsage()"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 3: Chỉ số cuối kỳ * & Tiêu thụ -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="ft_end_num" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Chỉ số cuối kỳ <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="number"
                                id="ft_end_num"
                                required
                                placeholder="Nhập số ghi thực tế"
                                oninput="calcFtUsage()"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>

                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Tiêu thụ
                            </label>
                            <input
                                type="text"
                                id="ft_usage"
                                readonly
                                placeholder="Tự tính = cuối kỳ – đầu kỳ"
                                class="w-full h-[40px] px-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[13.5px] font-bold text-[#0E4D3C] placeholder-[#9CA3AF] cursor-not-allowed select-none focus:outline-none"
                            />
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-[#F2F6F4] border-t border-[#E5E7EB] flex items-center justify-between rounded-b-[16px]">
                    <button
                        type="button"
                        onclick="closeFirstTimeModal()"
                        class="h-[38px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[38px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Lưu chỉ số
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openFirstTimeModal() {
        const modal = document.getElementById('firstTimeModal');
        const backdrop = document.getElementById('firstTimeBackdrop');
        const panel = document.getElementById('firstTimePanel');

        if (!modal || !backdrop || !panel) return;

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeFirstTimeModal() {
        const modal = document.getElementById('firstTimeModal');
        const backdrop = document.getElementById('firstTimeBackdrop');
        const panel = document.getElementById('firstTimePanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function calcFtUsage() {
        const start = parseInt(document.getElementById('ft_start_num').value) || 0;
        const end = parseInt(document.getElementById('ft_end_num').value) || 0;
        const diff = end - start;
        document.getElementById('ft_usage').value = diff >= 0 ? diff : '0 (Không hợp lệ)';
    }

    function simulateFirstTime() {
        closeFirstTimeModal();
        if (window.showToast) {
            window.showToast('Đã lưu chỉ số lần đầu thành công!');
        }
    }
</script>
