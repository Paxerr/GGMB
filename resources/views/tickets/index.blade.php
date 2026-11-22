@extends('layouts.app', [
    'title' => 'Quản lý yêu cầu hỗ trợ · GGMB',
    'active' => 'tickets',
    'breadcrumbs' => ['Quản trị', 'Yêu cầu hỗ trợ']
])

@section('content')
<div class="space-y-6 pb-12">
    <span class="sr-only">GGMB</span>

    <!-- Breadcrumb & Tiêu đề -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex items-center text-[12px] text-[#6B7280] space-x-1.5 mb-1.5">
                <span>Quản trị</span>
                <span>/</span>
                <span class="text-[#111827] font-medium">Yêu cầu hỗ trợ</span>
            </nav>
            <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
                Quản lý yêu cầu hỗ trợ
            </h1>
            <p class="mt-0.5 text-[13.5px] text-[#6B7280]">
                Tiếp nhận phản ánh, sự cố và yêu cầu hỗ trợ; phân công và theo dõi kết quả xử lý.
            </p>
        </div>
        <div class="shrink-0">
            <button
                type="button"
                onclick="openCreateTicketModal()"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] shadow-sm transition-colors cursor-pointer"
            >
                <span>＋</span> Tạo phiếu
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('tickets.index') }}" class="bg-white border border-[#E5E7EB] rounded-[14px] p-4 flex flex-wrap items-center gap-3 shadow-none">
        <!-- Từ khóa -->
        <div class="flex-1 min-w-[200px]">
            <label for="filterKeyword" class="sr-only">
                Tìm kiếm
            </label>
            <input
                type="text"
                id="filterKeyword"
                name="keyword"
                value="{{ request('keyword') }}"
                placeholder="Tìm tiêu đề, mô tả..."
                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
            />
        </div>

        <!-- Nhóm yêu cầu -->
        <div class="flex-1 min-w-[150px]">
            <label for="filterCategory" class="sr-only">
                Nhóm yêu cầu
            </label>
            <div class="relative">
                <select id="filterCategory" name="category" class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer">
                    <option value="">Tất cả nhóm yêu cầu</option>
                    @foreach (['Tài khoản', 'Phương tiện', 'Xe', 'Kỹ thuật', 'Hóa đơn', 'Phản ánh', 'Khác'] as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Người tạo -->
        <div class="flex-1 min-w-[150px]">
            <label for="filterCreator" class="sr-only">
                Người tạo
            </label>
            <div class="relative">
                <select id="filterCreator" name="creator_id" class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer">
                    <option value="">Tất cả người tạo</option>
                    @foreach ($creators as $c)
                        <option value="{{ $c->UserId }}" {{ request('creator_id') == $c->UserId ? 'selected' : '' }}>{{ $c->FullName }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Người phụ trách -->
        <div class="flex-1 min-w-[160px]">
            <label for="filterAssignee" class="sr-only">
                Người phụ trách
            </label>
            <div class="relative">
                <select id="filterAssignee" name="assignee_id" class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer">
                    <option value="">Tất cả người phụ trách</option>
                    @foreach ($staff as $s)
                        <option value="{{ $s->UserId }}" {{ request('assignee_id') == $s->UserId ? 'selected' : '' }}>{{ $s->UserId }} · {{ $s->FullName }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Căn hộ -->
        <div class="flex-1 min-w-[140px]">
            <label for="filterApartment" class="sr-only">
                Căn hộ
            </label>
            <div class="relative">
                <select id="filterApartment" name="apartment_id" class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer">
                    <option value="">Tất cả căn hộ</option>
                    @foreach ($apartments as $apt)
                        <option value="{{ $apt->ApartmentId }}" {{ request('apartment_id') == $apt->ApartmentId ? 'selected' : '' }}>{{ $apt->ApartmentNumber }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button
                type="submit"
                class="h-[40px] px-4 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer"
            >
                Áp dụng
            </button>
            <a
                href="{{ route('tickets.index') }}"
                class="h-[40px] px-4 bg-[#F3F4F6] hover:bg-[#E5E7EB] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer inline-flex items-center"
            >
                Đặt lại
            </a>
        </div>
    </form>

    <!-- Workflow Description & Stage Indicator -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 text-[12.5px] text-[#6B7280]">
        <div>
            <span class="font-medium text-[#111827]">Nhóm hỗ trợ:</span> Tài khoản / Phương tiện / Kỹ thuật / Hóa đơn / Phản ánh / Khác
        </div>
        <div class="text-[#0E4D3C] font-semibold flex items-center gap-1 select-none pr-1">
            NHÁNH HỦY YÊU CẦU ↘
        </div>
    </div>

    <!-- Kanban Board 6 Columns -->
    @php
        $ticketsMap = [];
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-3.5 items-start">
        @foreach ($columns as $statusKey => $col)
            @php
                $colTickets = $tickets->where('status', $statusKey);
            @endphp
            <div
                class="ticket-column-wrapper bg-[#F9FBFA] border border-[#E5E7EB] rounded-[14px] flex flex-col min-h-[460px] overflow-hidden transition-all duration-150"
                data-column-status="{{ $statusKey }}"
            >
                <!-- Column Header -->
                <div class="px-3.5 py-3 border-b border-[#E5E7EB] bg-white flex items-center justify-between">
                    <div>
                        <span class="text-[13px] font-bold text-[#111827]">
                            {{ $col['title'] }} · <span class="col-count-badge" data-col-status="{{ $statusKey }}">{{ $col['count'] }}</span>
                        </span>
                        <span class="text-[11px] text-[#6B7280] block mt-0.5">
                            {{ $col['step'] }}
                        </span>
                    </div>
                </div>

                <!-- Column Cards List (Jira Drag & Drop Zone) -->
                <div
                    class="ticket-column-body p-2.5 space-y-2.5 flex-1 min-h-[380px] transition-all rounded-b-[14px]"
                    data-column-status="{{ $statusKey }}"
                >
                    @foreach ($colTickets as $ticket)
                        @php
                            $ticketsMap[$ticket->id] = (array) $ticket;
                        @endphp
                        <div
                            class="ticket-card bg-white border border-[#E5E7EB] hover:border-[#0E4D3C] rounded-[10px] p-3 shadow-xs hover:shadow-md transition-all cursor-grab active:cursor-grabbing select-none group relative"
                            draggable="true"
                            data-ticket-id="{{ $ticket->id }}"
                            data-status="{{ $ticket->status }}"
                            onclick="handleTicketCardClick(event, {{ $ticket->id }})"
                        >
                            <!-- Card Header: Drag Handle & Tag & Dropdown options -->
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-1 min-w-0">
                                    <svg class="w-3.5 h-3.5 text-[#9CA3AF] opacity-0 group-hover:opacity-100 transition-opacity cursor-grab shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" title="Kéo thả">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                                    </svg>
                                    <span class="inline-block text-[11px] font-semibold text-[#6B7280] truncate">
                                        #{{ $ticket->id }} · {{ $ticket->category }}
                                    </span>
                                </div>
                                <div class="relative" onclick="event.stopPropagation()">
                                    <button
                                        type="button"
                                        onclick="toggleCardMenu({{ $ticket->id }})"
                                        class="w-6 h-6 flex items-center justify-center text-[#9CA3AF] hover:text-[#111827] rounded-[6px] hover:bg-slate-100 text-sm leading-none"
                                        title="Tùy chọn thao tác"
                                    >
                                        ···
                                    </button>
                                    <!-- Dropdown menu -->
                                    <div
                                        id="cardMenu_{{ $ticket->id }}"
                                        class="hidden absolute right-0 top-7 z-20 w-44 bg-white border border-[#E5E7EB] rounded-[8px] shadow-lg py-1 text-xs text-[#374151]"
                                    >
                                        <button
                                            type="button"
                                            onclick="openTicketDetailDrawer({{ $ticket->id }}); hideCardMenu({{ $ticket->id }});"
                                            class="w-full text-left px-3 py-1.5 hover:bg-[#F9FBFA] flex items-center gap-2"
                                        >
                                            <svg class="w-3.5 h-3.5 text-[#0E4D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span>Xem chi tiết</span>
                                        </button>
                                        <button
                                            type="button"
                                            onclick="openEditTicketModal({{ $ticket->id }}); hideCardMenu({{ $ticket->id }});"
                                            class="w-full text-left px-3 py-1.5 hover:bg-[#F9FBFA] flex items-center gap-2"
                                        >
                                            <svg class="w-3.5 h-3.5 text-[#374151]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            <span>Chỉnh sửa</span>
                                        </button>
                                        <button
                                            type="button"
                                            onclick="openAssignTicketModal({{ $ticket->id }}); hideCardMenu({{ $ticket->id }});"
                                            class="w-full text-left px-3 py-1.5 hover:bg-[#F9FBFA] flex items-center gap-2 text-[#0E4D3C] font-medium"
                                        >
                                            <svg class="w-3.5 h-3.5 text-[#0E4D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                            <span>Phân công xử lý</span>
                                        </button>
                                        <button
                                            type="button"
                                            onclick="openVerifyTicketModal({{ $ticket->id }}); hideCardMenu({{ $ticket->id }});"
                                            class="w-full text-left px-3 py-1.5 hover:bg-[#F9FBFA] flex items-center gap-2 text-[#0E4D3C] font-medium"
                                        >
                                            <svg class="w-3.5 h-3.5 text-[#0E4D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>Nghiệm thu & đóng</span>
                                        </button>
                                        <div class="border-t border-[#E5E7EB] my-1"></div>
                                        <button
                                            type="button"
                                            onclick="openCancelTicketModal({{ $ticket->id }}); hideCardMenu({{ $ticket->id }});"
                                            class="w-full text-left px-3 py-1.5 hover:bg-rose-50 flex items-center gap-2 text-rose-600 font-medium"
                                        >
                                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            <span>Hủy yêu cầu</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Title -->
                            <h4 class="text-[13px] font-bold text-[#111827] group-hover:text-[#0E4D3C] transition-colors leading-[18px] line-clamp-2">
                                {{ $ticket->title }}
                            </h4>

                            <!-- Card Middle: Căn hộ · Tạo bởi -->
                            <div class="mt-2 text-[11.5px] text-[#6B7280]">
                                Căn {{ $ticket->apartment }} · tạo bởi {{ explode(' · ', $ticket->creator ?? '')[0] ?: ($ticket->creator_name ?? '10') }}
                            </div>

                            <!-- Card Bottom: Ngày / Người phụ trách -->
                            <div class="mt-1.5 pt-1.5 border-t border-[#F3F4F6] flex items-center justify-between text-[11px] text-[#9CA3AF]">
                                <span>{{ \Illuminate\Support\Str::substr($ticket->created_at, 0, 5) }}</span>
                                <span class="font-medium text-[#374151]">
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

                <!-- Column Footer -->
                <div class="p-2.5 text-center border-t border-[#E5E7EB] bg-white">
                    <span class="text-[12px] font-semibold text-[#0E4D3C] hover:underline cursor-pointer">
                        Xem {{ $col['remaining'] }} phiếu còn lại
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Bottom summary -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1">
        <div class="text-[13px] text-[#6B7280]">
            Hiển thị {{ $tickets->count() }} yêu cầu · Chọn yêu cầu để xem chi tiết
        </div>

        @include('layouts.partials.pagination')
    </div>
</div>

<!-- Partials: Drawer Chi tiết & Các Modal Popup -->
@include('tickets.partials.detail-drawer')
@include('tickets.partials.create-modal')
@include('tickets.partials.edit-modal')
@include('tickets.partials.assign-modal')
@include('tickets.partials.verify-modal')
@include('tickets.partials.cancel-modal')

<style>
    .ticket-card.is-dragging {
        opacity: 0.4 !important;
        transform: scale(0.97) rotate(1.5deg) !important;
        box-shadow: 0 12px 28px -5px rgba(14, 77, 60, 0.25), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
        border-color: #0E4D3C !important;
        cursor: grabbing !important;
    }
    .ticket-column-body.drag-over {
        background-color: #E4EFE9 !important;
        outline: 2px dashed #0E4D3C;
        outline-offset: -3px;
    }
    .jira-drop-placeholder {
        border: 2px dashed #0E4D3C;
        background-color: rgba(228, 239, 233, 0.65);
        border-radius: 10px;
        min-height: 76px;
        margin: 6px 0;
        pointer-events: none;
        transition: all 0.12s ease-in-out;
    }
</style>

<script>
    window.ticketsMap = @json($ticketsMap ?? []);
    window.isDraggingCard = false;

    function handleTicketCardClick(e, ticketId) {
        if (window.isDraggingCard) return;
        if (e.target.closest('[id^="cardMenu_"]') || e.target.closest('button[onclick^="toggleCardMenu"]')) {
            return;
        }
        openTicketDetailDrawer(ticketId);
    }

    function toggleCardMenu(id) {
        const menu = document.getElementById(`cardMenu_${id}`);
        if (!menu) return;
        document.querySelectorAll('[id^="cardMenu_"]').forEach(el => {
            if (el.id !== `cardMenu_${id}`) el.classList.add('hidden');
        });
        menu.classList.toggle('hidden');
    }

    function hideCardMenu(id) {
        const menu = document.getElementById(`cardMenu_${id}`);
        if (menu) menu.classList.add('hidden');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('[id^="cardMenu_"]') && !e.target.closest('button[onclick^="toggleCardMenu"]')) {
            document.querySelectorAll('[id^="cardMenu_"]').forEach(el => el.classList.add('hidden'));
        }
    });

    // ==========================================
    // JIRA-LIKE DRAG & DROP INTERACTION LOGIC
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.ticket-card');
        const columnBodies = document.querySelectorAll('.ticket-column-body');

        let draggedCard = null;
        let dragOriginalCol = null;
        let dragOriginalStatus = null;
        let dragNextSibling = null;
        let activePlaceholder = null;

        function createPlaceholder() {
            const el = document.createElement('div');
            el.className = 'jira-drop-placeholder';
            return el;
        }

        function removePlaceholder() {
            if (activePlaceholder && activePlaceholder.parentElement) {
                activePlaceholder.parentElement.removeChild(activePlaceholder);
            }
            activePlaceholder = null;
        }

        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('.ticket-card:not(.is-dragging)')];

            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                if (offset < 0 && offset > closest.offset) {
                    return { offset: offset, element: child };
                } else {
                    return closest;
                }
            }, { offset: Number.NEGATIVE_INFINITY }).element;
        }

        function updateColumnBadge(statusKey, delta) {
            const badge = document.querySelector(`.col-count-badge[data-col-status="${statusKey}"]`);
            if (badge) {
                let current = parseInt(badge.textContent.trim(), 10) || 0;
                current = Math.max(0, current + delta);
                badge.textContent = current;
            }
        }

        cards.forEach(card => {
            card.addEventListener('dragstart', function(e) {
                window.isDraggingCard = true;
                draggedCard = card;
                dragOriginalCol = card.closest('.ticket-column-body');
                dragOriginalStatus = card.getAttribute('data-status');
                dragNextSibling = card.nextElementSibling;

                card.classList.add('is-dragging');

                e.dataTransfer.setData('text/plain', card.getAttribute('data-ticket-id'));
                e.dataTransfer.effectAllowed = 'move';
            });

            card.addEventListener('dragend', function() {
                card.classList.remove('is-dragging');
                removePlaceholder();
                columnBodies.forEach(col => col.classList.remove('drag-over'));

                setTimeout(() => {
                    window.isDraggingCard = false;
                    draggedCard = null;
                }, 100);
            });
        });

        columnBodies.forEach(col => {
            col.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';

                if (!col.classList.contains('drag-over')) {
                    col.classList.add('drag-over');
                }

                if (!activePlaceholder) {
                    activePlaceholder = createPlaceholder();
                }

                const afterElement = getDragAfterElement(col, e.clientY);
                if (afterElement == null) {
                    col.appendChild(activePlaceholder);
                } else {
                    col.insertBefore(activePlaceholder, afterElement);
                }
            });

            col.addEventListener('dragleave', function(e) {
                // Check if leaving column to outside
                if (!col.contains(e.relatedTarget)) {
                    col.classList.remove('drag-over');
                    if (activePlaceholder && activePlaceholder.parentElement === col) {
                        removePlaceholder();
                    }
                }
            });

            col.addEventListener('drop', function(e) {
                e.preventDefault();
                col.classList.remove('drag-over');

                if (!draggedCard) return;

                const ticketId = draggedCard.getAttribute('data-ticket-id');
                const targetStatus = col.getAttribute('data-column-status');
                const sourceStatus = dragOriginalStatus;

                // Place card where placeholder is
                if (activePlaceholder && activePlaceholder.parentElement === col) {
                    col.insertBefore(draggedCard, activePlaceholder);
                } else {
                    col.appendChild(draggedCard);
                }
                removePlaceholder();

                // If dropped in the same column, no status update needed
                if (targetStatus === sourceStatus) {
                    return;
                }

                // Optimistically update counts and card data
                updateColumnBadge(sourceStatus, -1);
                updateColumnBadge(targetStatus, 1);
                draggedCard.setAttribute('data-status', targetStatus);

                const currentOriginalCol = dragOriginalCol;
                const currentNextSibling = dragNextSibling;
                const currentCard = draggedCard;

                // Call Backend API
                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

                fetch(`/tickets/${ticketId}/move`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ status: targetStatus })
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Không thể thay đổi trạng thái yêu cầu');
                    }
                    if (window.ticketsMap && window.ticketsMap[ticketId]) {
                        window.ticketsMap[ticketId].status = targetStatus;
                    }
                    if (window.showToast) {
                        window.showToast(data.message, 'success');
                    }
                })
                .catch(err => {
                    // Revert position on failure
                    if (currentCard && currentOriginalCol) {
                        if (currentNextSibling && currentOriginalCol.contains(currentNextSibling)) {
                            currentOriginalCol.insertBefore(currentCard, currentNextSibling);
                        } else {
                            currentOriginalCol.appendChild(currentCard);
                        }
                        currentCard.setAttribute('data-status', sourceStatus);
                    }
                    // Revert badges
                    updateColumnBadge(targetStatus, -1);
                    updateColumnBadge(sourceStatus, 1);

                    if (window.showToast) {
                        window.showToast(err.message || 'Có lỗi xảy ra khi di chuyển yêu cầu', 'error');
                    }
                });
            });
        });
    });
</script>
@endsection
