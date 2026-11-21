@extends('layouts.app', [
    'title' => 'Bảng tin tòa nhà · GGMB',
    'active' => 'notifications',
    'breadcrumbs' => ['GGMB', 'Thông báo']
])

@section('content')
<div class="space-y-6 pb-12">
    <!-- Breadcrumb (Bám sát Ảnh 9) -->
    <nav class="flex items-center text-[13px] leading-[18px] text-[#52697c] space-x-2">
        <a href="{{ route('dashboard') }}" class="hover:text-[#2864ad] transition-colors">GGMB</a>
        <span>/</span>
        <span class="text-[#122d40] font-medium">Thông báo</span>
    </nav>

    <!-- Page Title & Subtitle (Bám sát Ảnh 9) -->
    <div class="space-y-1">
        <h1 class="text-[28px] leading-[36px] font-bold text-[#122d40] tracking-tight">
            Bảng tin tòa nhà
        </h1>
        <p class="text-[14px] leading-[20px] text-[#52697c]">
            Gửi thông báo theo đúng phạm vi; theo dõi đã đọc / chưa đọc cho từng người nhận.
        </p>
    </div>

    <!-- Filter Bar (Bám sát Ảnh 9) -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-4 flex flex-col lg:flex-row items-stretch lg:items-end justify-between gap-4 shadow-xs">
        <form method="GET" action="{{ route('notifications.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3 flex-1">
            <!-- Phạm vi -->
            <div class="space-y-1.5 w-full sm:w-[220px]">
                <label for="filterScope" class="block text-[12px] font-semibold text-[#334b5d]">
                    Phạm vi
                </label>
                <div class="relative">
                    <select
                        id="filterScope"
                        name="scope"
                        class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer"
                    >
                        <option value="">Tất cả phạm vi ▾</option>
                        <option value="Tòa nhà">Tòa nhà</option>
                        <option value="Tất cả">Tất cả</option>
                        <option value="Tầng">Tầng</option>
                        <option value="Căn hộ">Căn hộ</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#52697c]">▾</div>
                </div>
            </div>

            <!-- Tìm tiêu đề thông báo -->
            <div class="space-y-1.5 flex-1">
                <label for="filterSearch" class="block text-[12px] font-semibold text-[#334b5d]">
                    Tìm tiêu đề thông báo
                </label>
                <input
                    type="text"
                    id="filterSearch"
                    name="q"
                    placeholder="Nhập tiêu đề thông báo"
                    class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad]"
                />
            </div>

            <!-- Nút Lọc -->
            <button
                type="submit"
                class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
            >
                Lọc
            </button>
        </form>

        <!-- Right: Nút ＋ Soạn thông báo (Mở Modal Popup) -->
        <div class="shrink-0">
            <button
                type="button"
                onclick="openCreateNotificationModal()"
                class="w-full sm:w-[170px] h-[40px] px-4 bg-[#2864ad] hover:bg-[#205391] border border-solid border-[#2864ad] rounded-[4px] text-[14px] font-semibold text-white transition-colors cursor-pointer flex items-center justify-center whitespace-nowrap shadow-sm"
            >
                ＋ Soạn thông báo
            </button>
        </div>
    </div>

    <!-- Data Table (Bám sát Ảnh 9) -->
    @php
        $notificationsMap = [];
    @endphp
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] overflow-hidden shadow-xs">
        <!-- Table Header -->
        <div class="bg-[#f0f4f8] border-b border-[#d9e4ec] flex h-[44px] items-center text-[12px] leading-[18px] font-semibold text-[#52697c] select-none">
            <div class="w-[60px] min-w-[50px] px-3 border-r border-[#d9e4ec] h-full flex items-center">ID</div>
            <div class="flex-1 min-w-[200px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Tiêu đề</div>
            <div class="w-[120px] min-w-[100px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Phạm vi</div>
            <div class="w-[200px] min-w-[180px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Người tạo · Mã</div>
            <div class="w-[160px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Ngày tạo</div>
            <div class="w-[150px] min-w-[130px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Đọc / Chưa / Tổng</div>
            <div class="w-[140px] min-w-[120px] px-3 h-full flex items-center">Thao tác</div>
        </div>

        <!-- Table Rows -->
        @foreach ($notifications as $notif)
            @php
                $notificationsMap[$notif->id] = (array) $notif;
            @endphp
            <div
                class="bg-white border-b last:border-b-0 border-[#d9e4ec] flex h-[48px] items-center text-[#334b5d] text-[14px] leading-[20px] hover:bg-[#f8fbfd] transition-colors cursor-pointer"
                onclick="if(!event.target.closest('button')) openNotificationDetailDrawer({{ $notif->id }})"
            >
                <div class="w-[60px] min-w-[50px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">{{ $notif->id }}</div>
                <div class="flex-1 min-w-[200px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium text-[#122d40] truncate">
                    {{ $notif->title }}
                </div>
                <div class="w-[120px] min-w-[100px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal text-[13px]">
                    <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-[#334b5d]">
                        {{ $notif->scope }}
                    </span>
                </div>
                <div class="w-[200px] min-w-[180px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal text-[13px] text-[#52697c] truncate">
                    {{ $notif->creator }}
                </div>
                <div class="w-[160px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal text-[13px] text-[#52697c]">
                    {{ $notif->created_at }}
                </div>
                <div class="w-[150px] min-w-[130px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium font-mono text-[13px] text-[#122d40]">
                    {{ $notif->read_count }} / {{ $notif->unread_count }} / {{ $notif->total_count }}
                </div>
                <div class="w-[140px] min-w-[120px] px-3 h-full flex items-center space-x-2 text-[14px]">
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openNotificationDetailDrawer({{ $notif->id }});"
                        class="text-[#2864ad] hover:text-[#205391] hover:underline font-medium cursor-pointer"
                    >
                        Xem
                    </button>
                    <span class="text-[#52697c]">/</span>
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openEditNotificationModal({{ $notif->id }});"
                        class="text-[#2864ad] hover:text-[#205391] hover:underline font-medium cursor-pointer"
                    >
                        Sửa
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Informational Scope Box (Bám sát Ảnh 10) -->
    <div class="bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] p-4 space-y-2 text-[13px] text-[#52697c]">
        <h4 class="text-[12px] font-bold text-[#122d40] uppercase tracking-wider">
            PHẠM VI GỬI THÔNG BÁO
        </h4>
        <div class="space-y-1 text-[#334b5d] font-mono text-xs">
            <p>#1 · Toàn tòa A: Lịch bảo trì thang máy</p>
            <p>#2 · Tất cả cư dân: Nhắc thanh toán phí tháng 02/2026</p>
            <p>#3 · Tầng 2, Tòa A: Cập nhật xử lý yêu cầu kỹ thuật</p>
            <p>#4 · Căn hộ 0101: Thông báo riêng</p>
        </div>
        <p class="text-[12px] text-[#8a9ba8] pt-1">
            Chọn Xem để theo dõi người nhận đã đọc hoặc chưa đọc thông báo.
        </p>
    </div>

    <!-- Pagination & Row Info (Bám sát Ảnh 9) -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1 pb-6">
        <div class="text-[13px] text-[#52697c]">
            Hiển thị 1–4 trong 4 thông báo
        </div>

        <!-- Phân trang ‹ 1 2 ... 7 › -->
        <div class="w-[204px] h-[40px] bg-white border border-[#d9e4ec] rounded-[4px] flex items-center justify-between px-3 select-none text-[14px] text-[#334b5d]">
            <span class="text-[#a6bece]">‹</span>
            <span class="font-semibold text-[#122d40] border-b-2 border-[#2864ad] pb-0.5">1</span>
            <span class="text-[#334b5d]">2</span>
            <span class="text-[#8a9ba8]">...</span>
            <span class="text-[#334b5d]">7</span>
            <span class="text-[#334b5d] hover:text-[#2864ad] cursor-pointer">›</span>
        </div>
    </div>
</div>

<!-- Partials: Drawer Chi tiết & Modal Soạn / Sửa (Bám sát Ảnh 10) -->
@include('notifications.partials.detail-drawer')
@include('notifications.partials.create-modal')
@include('notifications.partials.edit-modal')

<script>
    window.notificationsMap = @json($notificationsMap ?? []);
</script>
@endsection
