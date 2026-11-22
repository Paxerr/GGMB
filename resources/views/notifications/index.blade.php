@extends('layouts.app', [
    'title' => 'Bảng tin tòa nhà · GGMB',
    'active' => 'notifications',
    'breadcrumbs' => ['Quản trị', 'Thông báo']
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
                <span class="text-[#111827] font-medium">Thông báo</span>
            </nav>
            <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
                Bảng tin tòa nhà
            </h1>
            <p class="mt-0.5 text-[13.5px] text-[#6B7280]">
                Gửi thông báo theo đúng phạm vi; theo dõi đã đọc / chưa đọc cho từng người nhận.
            </p>
        </div>
        <div class="shrink-0">
            <button
                type="button"
                onclick="openCreateNotificationModal()"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] shadow-sm transition-colors cursor-pointer"
            >
                <span>＋</span> Soạn thông báo
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-4 flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 shadow-none">
        <form method="GET" action="{{ route('notifications.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1">
            <!-- Phạm vi -->
            <div class="w-full sm:w-[220px]">
                <label for="filterScope" class="sr-only">
                    Phạm vi
                </label>
                <div class="relative">
                    <select
                        id="filterScope"
                        name="scope"
                        class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                    >
                        <option value="">Tất cả phạm vi</option>
                        <option value="Tòa nhà">Tòa nhà</option>
                        <option value="Tất cả">Tất cả</option>
                        <option value="Tầng">Tầng</option>
                        <option value="Căn hộ">Căn hộ</option>
                    </select>
                </div>
            </div>

            <!-- Tìm tiêu đề thông báo -->
            <div class="flex-1">
                <label for="filterSearch" class="sr-only">
                    Tìm tiêu đề thông báo
                </label>
                <input
                    type="text"
                    id="filterSearch"
                    name="q"
                    placeholder="Tìm kiếm tiêu đề thông báo..."
                    class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                />
            </div>

            <!-- Nút Lọc -->
            <button
                type="submit"
                class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
            >
                Lọc
            </button>
        </form>
    </div>

    <!-- Data Table -->
    @php
        $notificationsMap = [];
    @endphp
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] overflow-x-auto shadow-none">
        <!-- Table Header -->
        <div class="bg-[#F2F6F4] border-b border-[#E5E7EB] flex h-[44px] items-center text-[12px] font-semibold text-[#374151] select-none">
            <div class="w-[60px] min-w-[50px] px-4 border-r border-[#E5E7EB] h-full flex items-center">ID</div>
            <div class="flex-1 min-w-[200px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Tiêu đề</div>
            <div class="w-[130px] min-w-[100px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Phạm vi</div>
            <div class="w-[200px] min-w-[180px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Người tạo · Mã</div>
            <div class="w-[160px] min-w-[140px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Ngày tạo</div>
            <div class="w-[160px] min-w-[130px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Đọc / Chưa / Tổng</div>
            <div class="w-[140px] min-w-[120px] px-4 h-full flex items-center">Thao tác</div>
        </div>

        <!-- Table Rows -->
        @foreach ($notifications as $notif)
            @php
                $notificationsMap[$notif->id] = (array) $notif;
            @endphp
            <div
                class="bg-white border-b border-[#E5E7EB] last:border-b-0 flex h-[52px] items-center text-[#374151] text-[13.5px] hover:bg-[#F9FBFA] transition-colors cursor-pointer"
                onclick="if(!event.target.closest('button')) openNotificationDetailDrawer({{ $notif->id }})"
            >
                <div class="w-[60px] min-w-[50px] px-4 border-r border-[#E5E7EB] h-full flex items-center text-[#6B7280]">{{ $notif->id }}</div>
                <div class="flex-1 min-w-[200px] px-4 border-r border-[#E5E7EB] h-full flex items-center font-semibold text-[#111827] truncate">
                    {{ $notif->title }}
                </div>
                <div class="w-[130px] min-w-[100px] px-4 border-r border-[#E5E7EB] h-full flex items-center">
                    <span class="inline-block px-2.5 py-0.5 rounded-[6px] text-xs font-semibold bg-[#E4EFE9] text-[#0E4D3C]">
                        {{ $notif->scope }}
                    </span>
                </div>
                <div class="w-[200px] min-w-[180px] px-4 border-r border-[#E5E7EB] h-full flex items-center text-[13px] text-[#6B7280] truncate">
                    {{ $notif->creator }}
                </div>
                <div class="w-[160px] min-w-[140px] px-4 border-r border-[#E5E7EB] h-full flex items-center text-[13px] text-[#6B7280]">
                    {{ $notif->created_at }}
                </div>
                <div class="w-[160px] min-w-[130px] px-4 border-r border-[#E5E7EB] h-full flex items-center font-medium font-mono text-[13px] text-[#111827]">
                    {{ $notif->read_count }} / {{ $notif->unread_count }} / {{ $notif->total_count }}
                </div>
                <div class="w-[140px] min-w-[120px] px-4 h-full flex items-center gap-1.5 text-[13px]">
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openNotificationDetailDrawer({{ $notif->id }});"
                        title="Xem chi tiết thông báo"
                        class="p-1.5 text-[#0E4D3C] hover:bg-[#E4EFE9] rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span class="sr-only">Xem</span>
                    </button>
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openEditNotificationModal({{ $notif->id }});"
                        title="Chỉnh sửa thông báo"
                        class="p-1.5 text-[#374151] hover:text-[#0E4D3C] hover:bg-[#F3F4F6] rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="sr-only">Sửa</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination & Row Info -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1 pb-6">
        <div class="text-[13px] text-[#6B7280]">
            Hiển thị 1–4 trong 4 thông báo
        </div>

        @include('layouts.partials.pagination')
    </div>
</div>

<!-- Partials: Drawer Chi tiết & Modal Soạn / Sửa -->
@include('notifications.partials.detail-drawer')
@include('notifications.partials.create-modal')
@include('notifications.partials.edit-modal')

<script>
    window.notificationsMap = @json($notificationsMap ?? []);
</script>
@endsection
