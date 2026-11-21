@extends('layouts.app', [
    'title' => 'Quản trị tài khoản · GGMB',
    'active' => 'accounts',
    'breadcrumbs' => ['GGMB', 'Tài khoản']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    <!-- Tiêu đề & Phụ đề (Bám sát Ảnh Quản trị tài khoản) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-bold text-[#122d40]">
            Quản trị tài khoản
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#52697c]">
            Quản lý thông tin, vai trò và trạng thái truy cập tài khoản.
        </p>
    </div>

    <!-- Hàng Bộ lọc & Nút Thao tác (Bám sát Ảnh) -->
    <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-4 pt-1">
        <div class="flex flex-wrap items-end gap-3 sm:gap-4 flex-1">
            <!-- Vai trò -->
            <div class="space-y-1.5 w-full sm:w-[220px]">
                <label class="block text-[12px] font-semibold text-[#334b5d]">
                    Vai trò
                </label>
                <div class="relative">
                    <select class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                        <option value="INTERNAL">Nội bộ · 4 vai trò ▾</option>
                        <option value="RESIDENT">Cư dân</option>
                        <option value="ALL">Tất cả</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#52697c]">▾</div>
                </div>
            </div>

            <!-- Trạng thái -->
            <div class="space-y-1.5 w-full sm:w-[160px]">
                <label class="block text-[12px] font-semibold text-[#334b5d]">
                    Trạng thái
                </label>
                <div class="relative">
                    <select class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                        <option value="">Tất cả ▾</option>
                        <option value="ACTIVE">Hoạt động</option>
                        <option value="LOCKED">Bị khóa</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#52697c]">▾</div>
                </div>
            </div>

            <!-- Tìm kiếm -->
            <div class="space-y-1.5 w-full sm:w-[280px]">
                <label class="block text-[12px] font-semibold text-[#334b5d]">
                    Tìm họ tên / tên đăng nhập / email
                </label>
                <input
                    type="text"
                    placeholder="Nhập từ khóa"
                    class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad]"
                />
            </div>

            <!-- Nút Lọc -->
            <button
                type="button"
                class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[13px] font-semibold rounded-[4px] transition-colors cursor-pointer"
            >
                Lọc
            </button>
        </div>

        <!-- Nút ＋ Thêm tài khoản -->
        <div class="shrink-0">
            <button
                type="button"
                onclick="openCreateAccountModal()"
                class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer flex items-center justify-center whitespace-nowrap shadow-sm"
            >
                ＋ Thêm tài khoản
            </button>
        </div>
    </div>

    <!-- Bảng dữ liệu Tài khoản (Bám sát Ảnh) -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] overflow-hidden shadow-2xs">
        <!-- Table Header -->
        <div class="bg-[#e4edf3] border-b border-[#d9e4ec] flex h-[40px] items-center text-[#334b5d] text-[12px] font-semibold select-none">
            <div class="w-[60px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Mã</div>
            <div class="w-[180px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Họ tên</div>
            <div class="w-[150px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Tên đăng nhập</div>
            <div class="w-[240px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Email</div>
            <div class="w-[130px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Điện thoại</div>
            <div class="w-[110px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Vai trò</div>
            <div class="w-[110px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Trạng thái</div>
            <div class="flex-1 min-w-[130px] px-3 h-full flex items-center">Thao tác</div>
        </div>

        <!-- Table Rows -->
        @foreach ($accounts as $acc)
            <div id="acc-row-{{ $acc->id }}" class="bg-white border-b last:border-b-0 border-[#d9e4ec] flex h-[48px] items-center text-[#334b5d] text-[13px] hover:bg-[#f8fbfd] transition-colors">
                <div class="w-[60px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">{{ $acc->id }}</div>
                <div class="w-[180px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium text-[#122d40] acc-name">{{ $acc->name }}</div>
                <div class="w-[150px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-mono text-[#52697c]">{{ $acc->username }}</div>
                <div class="w-[240px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal text-[#52697c] acc-email truncate">{{ $acc->email }}</div>
                <div class="w-[130px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-mono acc-phone">{{ $acc->phone }}</div>
                <div class="w-[110px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal acc-role">{{ $acc->role }}</div>
                <div class="w-[110px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal acc-status">{{ $acc->status_label }}</div>
                <div class="flex-1 min-w-[130px] px-3 h-full flex items-center space-x-1.5 text-[13px] acc-actions">
                    <button type="button" onclick="openAccountDetailModal({{ json_encode($acc) }})" class="text-[#2864ad] hover:underline font-medium cursor-pointer">Xem</button>
                    <span class="text-[#52697c]">/</span>
                    <button type="button" onclick="openAccountEditModal({{ json_encode($acc) }})" class="text-[#2864ad] hover:underline font-medium cursor-pointer">Sửa</button>
                    @if ($acc->is_current_user)
                        <span class="text-[#52697c] text-[12px]">· Bạn</span>
                    @else
                        <span class="text-[#52697c]">/</span>
                        @if ($acc->status === 'LOCKED' || $acc->status_label === 'Bị khóa')
                            <button type="button" onclick="openAccountUnlockModal({{ json_encode($acc) }})" class="text-[#2864ad] hover:underline font-medium cursor-pointer btn-lock-toggle">Mở khóa</button>
                        @else
                            <button type="button" onclick="openAccountLockModal({{ json_encode($acc) }})" class="text-[#b91c1c] hover:underline font-medium cursor-pointer btn-lock-toggle">Khóa</button>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Dòng chú thích nghiệp vụ (Bám sát Ảnh) -->
    <div class="p-3 bg-[#f8fafc] border border-dashed border-[#d9e4ec] rounded-[4px] text-[12px] text-[#52697c] space-y-0.5">
        <div>5 vai trò: Quản lý, Hỗ trợ, Kỹ thuật, Bảo vệ, Cư dân.</div>
        <div>Danh sách đang lọc nhân sự nội bộ; chọn Cư dân để xem tài khoản cư dân.</div>
    </div>

    <!-- Thông tin hiển thị & Phân trang (Bám sát Ảnh 4) -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1 pb-6">
        <div class="text-[13px] text-[#52697c]">
            Hiển thị 1–6 trong 9 nhân sự
        </div>
        <div class="w-[120px] h-[36px] bg-white border border-[#d9e4ec] rounded-[4px] flex items-center justify-between px-3 select-none text-[13px] text-[#334b5d]">
            <span class="text-[#a6bece]">‹</span>
            <span class="font-semibold text-[#122d40] border-b-2 border-[#2864ad] pb-0.5">1</span>
            <span class="text-[#334b5d]">2</span>
            <span class="text-[#334b5d]">›</span>
        </div>
    </div>
</div>

@include('accounts.partials.create-modal')
@include('accounts.partials.detail-modal')
@include('accounts.partials.edit-modal')
@include('accounts.partials.lock-modal')
@endsection
