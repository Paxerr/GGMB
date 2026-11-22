<!-- Modal Popup: Chỉnh sửa yêu cầu chưa phân công (Bám sát Ảnh 5) -->
<div
    id="editTicketModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="edit-ticket-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        id="editTicketBackdrop"
        onclick="closeEditTicketModal()"
        class="fixed inset-0 bg-black/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="editTicketPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[620px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header (Bám sát Ảnh 5) -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeEditTicketModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] font-bold text-[#111827] mt-1" id="edit-ticket-title">
                    Chỉnh sửa yêu cầu chưa phân công
                </h3>
            </div>

            <!-- Modal Form -->
            <form id="editTicketForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="px-6 py-5 space-y-4">
                    <!-- Tiêu đề * -->
                    <div>
                        <label for="edit_ticket_title" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Tiêu đề *
                        </label>
                        <input
                            type="text"
                            id="edit_ticket_title"
                            name="Subject"
                            required
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        />
                    </div>

                    <!-- Mô tả * -->
                    <div>
                        <label for="edit_ticket_desc" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Mô tả *
                        </label>
                        <textarea
                            id="edit_ticket_desc"
                            name="Description"
                            rows="3"
                            required
                            class="w-full px-3 py-2.5 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                        ></textarea>
                    </div>

                    <!-- 2 cột: Nhóm yêu cầu * & Căn hộ liên quan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_ticket_cat" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Nhóm yêu cầu *
                            </label>
                            <div class="relative">
                                <select
                                    id="edit_ticket_cat"
                                    name="Category"
                                    required
                                    class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] cursor-pointer"
                                >
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
                            <label for="edit_ticket_apt" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Căn hộ liên quan
                            </label>
                            <div class="relative">
                                <select
                                    id="edit_ticket_apt"
                                    name="ApartmentId"
                                    class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] cursor-pointer"
                                >
                                    @foreach ($apartments as $apt)
                                        <option value="{{ $apt->ApartmentId }}">{{ $apt->ApartmentNumber }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer (Hủy bên trái, Lưu thay đổi bên phải - Bám sát Ảnh 5) -->
                <div class="px-6 py-4 bg-[#F2F6F4] border-t border-[#E5E7EB] flex items-center justify-between rounded-b-[16px]">
                    <button
                        type="button"
                        onclick="closeEditTicketModal()"
                        class="h-[38px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[38px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditTicketModal(idOrData) {
        const data = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.ticketsMap?.[idOrData] || {});
        const modal = document.getElementById('editTicketModal');
        const backdrop = document.getElementById('editTicketBackdrop');
        const panel = document.getElementById('editTicketPanel');

        if (!modal || !backdrop || !panel) return;

        const id = data.id || (typeof idOrData === 'number' ? idOrData : 1);
        const title = data.title || '';
        const desc = data.description || '';
        const category = data.category || 'Tài khoản';
        const aptId = data.apartment_id || '';

        const form = document.getElementById('editTicketForm');
        if (form) {
            form.action = `/tickets/${id}`;
        }

        document.getElementById('edit_ticket_title').value = title;
        document.getElementById('edit_ticket_desc').value = desc;
        document.getElementById('edit_ticket_cat').value = category;
        if (document.getElementById('edit_ticket_apt') && aptId) {
            document.getElementById('edit_ticket_apt').value = aptId;
        }

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeEditTicketModal() {
        const modal = document.getElementById('editTicketModal');
        const backdrop = document.getElementById('editTicketBackdrop');
        const panel = document.getElementById('editTicketPanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function simulateEditTicket() {
        closeEditTicketModal();
        if (window.showToast) {
            window.showToast('Đã cập nhật yêu cầu hỗ trợ thành công!');
        }
    }
</script>
