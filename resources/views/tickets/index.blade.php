@extends('layouts.app', [
    'title' => 'Quản lý yêu cầu hỗ trợ · GGMB',
    'active' => 'tickets',
    'breadcrumbs' => ['GGMB', 'Yêu cầu hỗ trợ']
])

@section('content')
<div class="space-y-6 pb-12">
    <!-- Breadcrumb (Bám sát Ảnh 2) -->
    <nav class="flex items-center text-[13px] leading-[18px] text-[#52697c] space-x-2">
        <a href="{{ route('dashboard') }}" class="hover:text-[#2864ad] transition-colors">GGMB</a>
        <span>/</span>
        <span class="text-[#122d40] font-medium">Yêu cầu hỗ trợ</span>
    </nav>

    <!-- Page Title & Subtitle (Bám sát Ảnh 2) -->
    <div class="space-y-1">
        <h1 class="text-[28px] leading-[36px] font-bold text-[#122d40] tracking-tight">
            Quản lý yêu cầu hỗ trợ
        </h1>
        <p class="text-[14px] leading-[20px] text-[#52697c]">
            Tiếp nhận phản ánh, sự cố và yêu cầu hỗ trợ; phân công và theo dõi kết quả xử lý.
        </p>
    </div>

    <!-- Filter Bar (4 Dropdowns + Nút ＋ Tạo phiếu - Bám sát Ảnh 6) -->
    <div class="flex flex-col lg:flex-row items-stretch lg:items-end justify-between gap-4 pt-1">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 flex-1">
            <!-- Nhóm yêu cầu -->
            <div class="space-y-1.5">
                <label for="filterCategory" class="block text-[12px] font-semibold text-[#334b5d]">
                    Nhóm yêu cầu
                </label>
                <div class="relative">
                    <select id="filterCategory" class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                        <option value="">Tất cả ▾</option>
                        <option value="Tài khoản">Tài khoản</option>
                        <option value="Xe">Xe & Đăng ký</option>
                        <option value="Kỹ thuật">Kỹ thuật</option>
                        <option value="Hóa đơn">Hóa đơn</option>
                        <option value="Phản ánh">Phản ánh</option>
                        <option value="Khác">Khác</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#52697c]">▾</div>
                </div>
            </div>

            <!-- Người tạo -->
            <div class="space-y-1.5">
                <label for="filterCreator" class="block text-[12px] font-semibold text-[#334b5d]">
                    Người tạo
                </label>
                <div class="relative">
                    <select id="filterCreator" class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                        <option value="">Tất cả ▾</option>
                        <option value="Nguyễn An">Nguyễn An (Căn 0101)</option>
                        <option value="Phan Nam">Phan Nam (Căn 0202)</option>
                        <option value="Trần Bình">Trần Bình (Căn 0102)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#52697c]">▾</div>
                </div>
            </div>

            <!-- Người phụ trách -->
            <div class="space-y-1.5">
                <label for="filterAssignee" class="block text-[12px] font-semibold text-[#334b5d]">
                    Người phụ trách
                </label>
                <div class="relative">
                    <select id="filterAssignee" class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                        <option value="">Tất cả ▾</option>
                        <option value="Trần Thu Hỗ trợ">2 · Trần Thu Hỗ trợ</option>
                        <option value="Lê Anh Hỗ trợ">3 · Lê Anh Hỗ trợ</option>
                        <option value="Phạm Hà Hỗ trợ">4 · Phạm Hà Hỗ trợ</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#52697c]">▾</div>
                </div>
            </div>

            <!-- Căn hộ -->
            <div class="space-y-1.5">
                <label for="filterApartment" class="block text-[12px] font-semibold text-[#334b5d]">
                    Căn hộ
                </label>
                <div class="relative">
                    <select id="filterApartment" class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                        <option value="">Tất cả ▾</option>
                        @foreach ($apartments as $apt)
                            <option value="{{ $apt->ApartmentNumber }}">{{ $apt->ApartmentNumber }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#52697c]">▾</div>
                </div>
            </div>
        </div>

        <!-- Right: Nút ＋ Tạo phiếu -->
        <div class="shrink-0">
            <button
                type="button"
                onclick="openCreateTicketModal()"
                class="w-full sm:w-[160px] h-[40px] px-4 bg-[#2864ad] hover:bg-[#205391] border border-solid border-[#2864ad] rounded-[4px] text-[14px] font-semibold text-white transition-colors cursor-pointer flex items-center justify-center whitespace-nowrap shadow-sm"
            >
                ＋ Tạo phiếu
            </button>
        </div>
    </div>

    <!-- Workflow Description & Stage Indicator (Bám sát Ảnh 6) -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 text-[12px] text-[#52697c] pt-1">
        <div>
            <span class="font-medium text-[#334b5d]">Nhóm hỗ trợ:</span> Tài khoản / Phương tiện / Kỹ thuật / Hóa đơn / Phản ánh / Khác
        </div>
        <div class="text-[#334b5d] font-semibold flex items-center gap-1 select-none pr-1">
            NHÁNH HỦY YÊU CẦU ↘
        </div>
    </div>

    <!-- Kanban Board 6 Columns (Bám sát Ảnh 2) -->
    @php
        $ticketsMap = [];
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-3.5 items-start">
        @foreach ($columns as $statusKey => $col)
            @php
                $colTickets = $tickets->where('status', $statusKey);
            @endphp
            <div class="bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] flex flex-col min-h-[460px] overflow-hidden">
                <!-- Column Header -->
                <div class="{{ $col['bg_header'] }} px-3 py-2.5 border-b border-[#d9e4ec]">
                    <div class="flex items-center justify-between">
                        <span class="text-[13px] font-bold text-[#122d40]">
                            {{ $col['title'] }} · {{ $col['count'] }}
                        </span>
                    </div>
                    <span class="text-[11px] text-[#52697c] block mt-0.5">
                        {{ $col['step'] }}
                    </span>
                </div>

                <!-- Column Cards List -->
                <div class="p-2.5 space-y-2.5 flex-1">
                    @foreach ($colTickets as $ticket)
                        @php
                            $ticketsMap[$ticket->id] = (array) $ticket;
                        @endphp
                        <div
                            class="bg-white border border-[#d9e4ec] hover:border-[#2864ad] rounded-[4px] p-3 shadow-2xs hover:shadow-sm transition-all cursor-pointer group"
                            onclick="openTicketDetailDrawer({{ $ticket->id }})"
                        >
                            <!-- Card Header: Tag & Dropdown options -->
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="inline-block text-[11px] font-semibold text-[#52697c]">
                                    #{{ $ticket->id }} · {{ $ticket->category }}
                                </span>
                                <div class="relative" onclick="event.stopPropagation()">
                                    <button
                                        type="button"
                                        onclick="toggleCardMenu({{ $ticket->id }})"
                                        class="w-6 h-6 flex items-center justify-center text-[#8a9ba8] hover:text-[#122d40] rounded hover:bg-slate-100 text-sm leading-none"
                                        title="Tùy chọn thao tác"
                                    >
                                        ···
                                    </button>
                                    <!-- Dropdown menu -->
                                    <div
                                        id="cardMenu_{{ $ticket->id }}"
                                        class="hidden absolute right-0 top-7 z-20 w-44 bg-white border border-[#d9e4ec] rounded shadow-lg py-1 text-xs text-[#334b5d]"
                                    >
                                        <button
                                            type="button"
                                            onclick="openTicketDetailDrawer({{ $ticket->id }}); hideCardMenu({{ $ticket->id }});"
                                            class="w-full text-left px-3 py-1.5 hover:bg-slate-50 flex items-center"
                                        >
                                            Xem chi tiết
                                        </button>
                                        <button
                                            type="button"
                                            onclick="openEditTicketModal({{ $ticket->id }}); hideCardMenu({{ $ticket->id }});"
                                            class="w-full text-left px-3 py-1.5 hover:bg-slate-50 flex items-center"
                                        >
                                            Chỉnh sửa
                                        </button>
                                        <button
                                            type="button"
                                            onclick="openAssignTicketModal({{ $ticket->id }}); hideCardMenu({{ $ticket->id }});"
                                            class="w-full text-left px-3 py-1.5 hover:bg-slate-50 flex items-center text-[#2864ad]"
                                        >
                                            Phân công xử lý
                                        </button>
                                        <button
                                            type="button"
                                            onclick="openVerifyTicketModal({{ $ticket->id }}); hideCardMenu({{ $ticket->id }});"
                                            class="w-full text-left px-3 py-1.5 hover:bg-slate-50 flex items-center text-emerald-600"
                                        >
                                            Nghiệm thu & đóng
                                        </button>
                                        <div class="border-t border-[#d9e4ec] my-1"></div>
                                        <button
                                            type="button"
                                            onclick="openCancelTicketModal({{ $ticket->id }}); hideCardMenu({{ $ticket->id }});"
                                            class="w-full text-left px-3 py-1.5 hover:bg-rose-50 flex items-center text-rose-600"
                                        >
                                            Hủy yêu cầu
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Title -->
                            <h4 class="text-[13px] font-bold text-[#122d40] group-hover:text-[#2864ad] transition-colors leading-[18px] line-clamp-2">
                                {{ $ticket->title }}
                            </h4>

                            <!-- Card Middle: Căn hộ · Tạo bởi (Bám sát Ảnh 6) -->
                            <div class="mt-2 text-[11px] text-[#52697c]">
                                Căn {{ $ticket->apartment }} · tạo bởi {{ explode(' · ', $ticket->creator ?? '')[0] ?: ($ticket->creator_name ?? '10') }}
                            </div>

                            <!-- Card Bottom: Ngày / Người phụ trách (Bám sát Ảnh 6) -->
                            <div class="mt-1.5 pt-1.5 border-t border-slate-100 flex items-center justify-between text-[11px] text-[#8a9ba8]">
                                <span>{{ \Illuminate\Support\Str::substr($ticket->created_at, 0, 5) }}</span>
                                <span class="font-medium text-[#52697c]">
                                    @if ($ticket->assignee)
                                        Giao: {{ explode(' · ', $ticket->assignee)[0] }}
                                    @else
                                        Chưa phân công
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Column Footer (Bám sát Ảnh 2) -->
                <div class="p-2.5 text-center border-t border-[#d9e4ec] bg-white">
                    <span class="text-[12px] font-medium text-[#2864ad] hover:text-[#205391] cursor-pointer">
                        Xem {{ $col['remaining'] }} phiếu còn lại
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Bottom summary (Bám sát Ảnh 2) -->
    <div class="text-[13px] text-[#52697c] pt-1">
        Hiển thị 12 trong 100 yêu cầu · Chọn yêu cầu để xem chi tiết
    </div>
</div>

<!-- Partials: Drawer Chi tiết & Các Modal Popup (Bám sát Ảnh 3, 4, 5, 6, 7, 8) -->
@include('tickets.partials.detail-drawer')
@include('tickets.partials.create-modal')
@include('tickets.partials.edit-modal')
@include('tickets.partials.assign-modal')
@include('tickets.partials.verify-modal')
@include('tickets.partials.cancel-modal')

<script>
    window.ticketsMap = @json($ticketsMap ?? []);

    function toggleCardMenu(id) {
        const menu = document.getElementById(`cardMenu_${id}`);
        if (!menu) return;
        // Close other menus first
        document.querySelectorAll('[id^="cardMenu_"]').forEach(el => {
            if (el.id !== `cardMenu_${id}`) el.classList.add('hidden');
        });
        menu.classList.toggle('hidden');
    }

    function hideCardMenu(id) {
        const menu = document.getElementById(`cardMenu_${id}`);
        if (menu) menu.classList.add('hidden');
    }

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('[id^="cardMenu_"]') && !e.target.closest('button[onclick^="toggleCardMenu"]')) {
            document.querySelectorAll('[id^="cardMenu_"]').forEach(el => el.classList.add('hidden'));
        }
    });
</script>
@endsection
