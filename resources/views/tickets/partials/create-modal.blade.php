<!-- Modal Popup: Tạo phiếu sự cố (Bám sát Ảnh 4) -->
<div
    id="createTicketModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="create-ticket-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        id="createTicketBackdrop"
        onclick="closeCreateTicketModal()"
        class="fixed inset-0 bg-black/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="createTicketPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[620px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header (Bám sát Ảnh 4) -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeCreateTicketModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] font-bold text-[#111827] mt-1" id="create-ticket-title">
                    Tạo phiếu sự cố
                </h3>
            </div>

            <!-- Modal Form -->
            <form method="POST" action="{{ route('tickets.store') }}">
                @csrf
                <div class="px-6 py-5 space-y-4">
                    <!-- Tiêu đề * -->
                    <div>
                        <label for="create_ticket_title" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Tiêu đề *
                        </label>
                        <input
                            type="text"
                            id="create_ticket_title"
                            name="Subject"
                            required
                            placeholder="Nhập tóm tắt vấn đề cần hỗ trợ"
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        />
                    </div>

                    <!-- Mô tả * -->
                    <div>
                        <label for="create_ticket_desc" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Mô tả *
                        </label>
                        <textarea
                            id="create_ticket_desc"
                            name="Description"
                            rows="3"
                            required
                            placeholder="Nhập hiện tượng, vị trí và thời điểm phát hiện để bộ phận tiếp nhận kiểm tra..."
                            class="w-full px-3 py-2.5 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        ></textarea>
                    </div>

                    <!-- 2 cột: Nhóm yêu cầu * & Căn hộ liên quan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="create_ticket_cat" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Nhóm yêu cầu *
                            </label>
                            <div class="relative">
                                <select
                                    id="create_ticket_cat"
                                    name="Category"
                                    required
                                    class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] cursor-pointer"
                                >
                                    <option value="" disabled selected>Chọn loại yêu cầu ▾</option>
                                    <option value="Tài khoản">Tài khoản</option>
                                    <option value="Phương tiện">Phương tiện</option>
                                    <option value="Kỹ thuật">Kỹ thuật</option>
                                    <option value="Hóa đơn">Hóa đơn</option>
                                    <option value="Phản ánh">Phản ánh</option>
                                    <option value="Khác">Khác</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                            </div>
                        </div>

                        <div>
                            <label for="create_ticket_apt" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Căn hộ liên quan
                            </label>
                            <div class="relative">
                                <select
                                    id="create_ticket_apt"
                                    name="ApartmentId"
                                    class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] cursor-pointer"
                                >
                                    <option value="" disabled selected>Chọn căn hộ ▾</option>
                                    @foreach ($apartments as $apt)
                                        <option value="{{ $apt->ApartmentId }}">{{ $apt->ApartmentNumber }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                            </div>
                        </div>
                    </div>

                    <!-- Phân loại helper text -->
                    <p class="text-[12px] text-[#6B7280]">
                        Phân loại nội dung hỗ trợ: Tài khoản / Phương tiện / Kỹ thuật / Hóa đơn / Phản ánh / Khác
                    </p>

                    <!-- Người tạo notice box -->
                    <div class="p-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[12.5px] text-[#374151]">
                        <span class="font-bold text-[#111827]">Người tạo:</span> Nguyễn Minh Quản lý
                        <p class="text-[11.5px] text-[#6B7280] mt-0.5">
                            Tạo thành công ở trạng thái Chờ xử lý; thông báo đến bộ phận tiếp nhận.
                        </p>
                    </div>

                    <!-- Ảnh / video đính kèm (Bám sát Ảnh 4) -->
                    <div>
                        <span class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Ảnh / video đính kèm (không bắt buộc)
                        </span>
                        <div class="bg-white border border-[#E5E7EB] rounded-[8px] p-3 flex items-center gap-3">
                            <div class="w-12 h-10 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[6px] flex items-center justify-center shrink-0">
                                <span class="text-[10px] font-bold text-[#6B7280] uppercase">ẢNH</span>
                            </div>
                            <div class="text-[12px]">
                                <span class="text-[#0E4D3C] font-semibold cursor-pointer hover:underline">
                                    ＋ Chọn ảnh / video minh chứng
                                </span>
                                <p class="text-[11px] text-[#9CA3AF]">Chưa có tệp được chọn.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer (Hủy bên trái, Tạo phiếu bên phải - Bám sát Ảnh 4) -->
                <div class="px-6 py-4 bg-[#F2F6F4] border-t border-[#E5E7EB] flex items-center justify-between rounded-b-[16px]">
                    <button
                        type="button"
                        onclick="closeCreateTicketModal()"
                        class="h-[38px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[38px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Tạo phiếu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCreateTicketModal() {
        const modal = document.getElementById('createTicketModal');
        const backdrop = document.getElementById('createTicketBackdrop');
        const panel = document.getElementById('createTicketPanel');

        if (!modal || !backdrop || !panel) return;

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeCreateTicketModal() {
        const modal = document.getElementById('createTicketModal');
        const backdrop = document.getElementById('createTicketBackdrop');
        const panel = document.getElementById('createTicketPanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function simulateCreateTicket() {
        closeCreateTicketModal();
        if (window.showToast) {
            window.showToast('Tạo phiếu sự cố mới thành công!');
        }
    }
</script>
