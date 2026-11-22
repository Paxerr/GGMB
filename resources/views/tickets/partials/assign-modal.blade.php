<!-- Modal Popup: Phân công người xử lý (Bám sát Ảnh 6) -->
<div
    id="assignTicketModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="assign-ticket-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        id="assignTicketBackdrop"
        onclick="closeAssignTicketModal()"
        class="fixed inset-0 bg-black/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="assignTicketPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[620px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header (Bám sát Ảnh 6) -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase select-none">
                        PHÂN CÔNG
                    </span>
                    <button
                        type="button"
                        onclick="closeAssignTicketModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] font-bold text-[#111827] mt-1" id="assign-ticket-title">
                    Phân công người xử lý
                </h3>
            </div>

            <!-- Modal Form -->
            <form id="assignTicketForm" method="POST" action="">
                @csrf
                <div class="px-6 py-5 space-y-4">
                    <!-- Ticket Info Summary Box (Bám sát Ảnh 6) -->
                    <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] p-3.5 space-y-1">
                        <h4 class="text-[14px] font-bold text-[#111827]" id="assignTicketBoxTitle">
                            Không xem được thông báo phí
                        </h4>
                        <p class="text-[12.5px] text-[#6B7280]" id="assignTicketBoxSub">
                            Chờ xử lý · Tài khoản · Căn 0101 · Nguyễn An
                        </p>
                        <p class="text-[11.5px] text-[#9CA3AF]" id="assignTicketBoxDate">
                            02/02/2026 08:30 · Chưa phân công
                        </p>
                    </div>

                    <!-- Người phụ trách * Select -->
                    <div>
                        <label for="assign_staff_select" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                            Người phụ trách *
                        </label>
                        <div class="relative">
                            <select
                                id="assign_staff_select"
                                name="AssignedToUserId"
                                required
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                            >
                                @foreach ($staff as $s)
                                    <option value="{{ $s->UserId }}">{{ $s->UserId }} · {{ $s->FullName }} ({{ $s->Role }})</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                        </div>
                    </div>

                    <!-- Danh sách nhân sự hỗ trợ · Phù hợp yêu cầu tài khoản (Bám sát Ảnh 6) -->
                    <div>
                        <span class="block text-[11px] font-bold text-[#6B7280] uppercase tracking-wider mb-2">
                            NHÂN SỰ HỖ TRỢ / KỸ THUẬT
                        </span>
                        <div class="border border-[#E5E7EB] rounded-[8px] divide-y divide-[#E5E7EB] overflow-hidden text-[13px] max-h-52 overflow-y-auto">
                            @foreach ($staff as $index => $s)
                                <label class="flex items-center justify-between p-3 hover:bg-[#F9FBFA] cursor-pointer transition-colors">
                                    <div class="flex items-center gap-2.5">
                                        <input type="radio" name="staff_radio" value="{{ $s->UserId }}" {{ $index === 0 ? 'checked' : '' }} class="text-[#0E4D3C] focus:ring-[#0E4D3C]" />
                                        <span class="font-semibold text-[#111827]">{{ $s->UserId }} · {{ $s->FullName }}</span>
                                    </div>
                                    <span class="text-[12px] text-[#6B7280]">{{ $s->Role === 'TECHNICIAN' ? 'Kỹ thuật viên' : ($s->Role === 'SUPPORT' ? 'Chăm sóc cư dân' : 'Ban quản lý') }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Modal Footer (Hủy bên trái, Xác nhận phân công bên phải - Bám sát Ảnh 6) -->
                <div class="px-6 py-4 bg-[#F2F6F4] border-t border-[#E5E7EB] flex items-center justify-between rounded-b-[16px]">
                    <button
                        type="button"
                        onclick="closeAssignTicketModal()"
                        class="h-[38px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[38px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Xác nhận phân công
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAssignTicketModal(idOrData) {
        const data = (typeof idOrData === 'object' && idOrData !== null) ? idOrData : (window.ticketsMap?.[idOrData] || {});
        const modal = document.getElementById('assignTicketModal');
        const backdrop = document.getElementById('assignTicketBackdrop');
        const panel = document.getElementById('assignTicketPanel');

        if (!modal || !backdrop || !panel) return;

        const id = data.id || (typeof idOrData === 'number' ? idOrData : 1);
        const title = data.title || 'Không xem được thông báo phí';
        const category = data.category || 'Tài khoản';
        const apt = data.apartment || '0101';
        const creator = data.creator_name || 'Nguyễn An';
        const created = data.created_at || '02/02/2026 08:30';
        const statusLabel = data.status_label || 'Chờ xử lý';

        const form = document.getElementById('assignTicketForm');
        if (form) {
            form.action = `/tickets/${id}/assign`;
        }

        document.getElementById('assignTicketBoxTitle').textContent = title;
        document.getElementById('assignTicketBoxSub').textContent = `${statusLabel} · ${category} · Căn ${apt} · ${creator}`;
        document.getElementById('assignTicketBoxDate').textContent = `${created} · Chưa phân công`;

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeAssignTicketModal() {
        const modal = document.getElementById('assignTicketModal');
        const backdrop = document.getElementById('assignTicketBackdrop');
        const panel = document.getElementById('assignTicketPanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function simulateAssignTicket() {
        closeAssignTicketModal();
        if (window.showToast) {
            window.showToast('Phân công người xử lý thành công!');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('assign_staff_select');
        const radios = document.querySelectorAll('input[name="staff_radio"]');

        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (select) select.value = this.value;
            });
        });

        if (select) {
            select.addEventListener('change', function() {
                const r = document.querySelector(`input[name="staff_radio"][value="${this.value}"]`);
                if (r) r.checked = true;
            });
        }
    });
</script>
