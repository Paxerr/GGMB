@extends('layouts.app', [
    'title' => 'Quản trị tài khoản · GGMB',
    'active' => 'accounts',
    'breadcrumbs' => ['Quản trị', 'Tài khoản']
])

@section('content')
<div class="space-y-6 pb-12">
    <span class="sr-only">GGMB</span>

    <!-- Tiêu đề & Nút thêm -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
                Quản trị tài khoản
            </h1>
            <p class="mt-0.5 text-[13.5px] text-[#6B7280]">
                Quản lý thông tin, vai trò và trạng thái truy cập tài khoản.
            </p>
        </div>
        <div class="shrink-0">
            <button
                type="button"
                onclick="openCreateAccountModal()"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] shadow-sm transition-colors cursor-pointer"
            >
                <span>＋</span> Thêm tài khoản
            </button>
        </div>
    </div>

    <!-- Hàng Bộ lọc -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-4 shadow-none">
        <form method="GET" action="{{ route('accounts.index') }}" class="flex flex-wrap items-center gap-3">
            <!-- Vai trò -->
            <div class="flex-1 min-w-[180px]">
                <label for="filterAccountRole" class="sr-only">
                    Vai trò
                </label>
                <div class="relative">
                    <select
                        id="filterAccountRole"
                        name="role"
                        onchange="this.form.submit()"
                        class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                    >
                        <option value="INTERNAL" {{ request('role', 'INTERNAL') === 'INTERNAL' ? 'selected' : '' }}>Nội bộ · 3 vai trò</option>
                        <option value="RESIDENT" {{ request('role') === 'RESIDENT' ? 'selected' : '' }}>Cư dân</option>
                        <option value="ALL" {{ request('role') === 'ALL' ? 'selected' : '' }}>Tất cả</option>
                    </select>
                </div>
            </div>

            <!-- Trạng thái -->
            <div class="flex-1 min-w-[160px]">
                <label for="filterAccountStatus" class="sr-only">
                    Trạng thái
                </label>
                <div class="relative">
                    <select
                        id="filterAccountStatus"
                        name="status"
                        onchange="this.form.submit()"
                        class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                    >
                        <option value="">Tất cả trạng thái</option>
                        <option value="ACTIVE" {{ request('status') === 'ACTIVE' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="LOCKED" {{ request('status') === 'LOCKED' ? 'selected' : '' }}>Bị khóa</option>
                    </select>
                </div>
            </div>

            <!-- Tìm kiếm -->
            <div class="flex-1 min-w-[240px]">
                <label for="filterAccountKeyword" class="sr-only">
                    Tìm họ tên / tên đăng nhập / email
                </label>
                <input
                    type="text"
                    id="filterAccountKeyword"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    placeholder="Tìm kiếm (họ tên, tên đăng nhập, email)..."
                    class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                />
            </div>

            <div class="flex items-center gap-2">
                <button
                    type="submit"
                    class="h-[40px] px-4 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer"
                >
                    Lọc
                </button>
                <a
                    href="{{ route('accounts.index') }}"
                    class="h-[40px] px-4 bg-[#F3F4F6] hover:bg-[#E5E7EB] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors inline-flex items-center justify-center"
                >
                    Đặt lại
                </a>
            </div>
        </form>
    </div>

    <!-- Bảng dữ liệu Tài khoản -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] overflow-x-auto shadow-none">
        <!-- Table Header -->
        <div class="bg-[#F2F6F4] border-b border-[#E5E7EB] flex h-[44px] items-center text-[#374151] text-[12px] font-semibold select-none">
            <div class="w-[60px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Mã</div>
            <div class="w-[180px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Họ tên</div>
            <div class="w-[150px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Tên đăng nhập</div>
            <div class="w-[240px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Email</div>
            <div class="w-[130px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Điện thoại</div>
            <div class="w-[110px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Vai trò</div>
            <div class="w-[110px] px-4 border-r border-[#E5E7EB] h-full flex items-center">Trạng thái</div>
            <div class="flex-1 min-w-[130px] px-4 h-full flex items-center">Thao tác</div>
        </div>

        <!-- Table Rows -->
        @foreach ($accounts as $acc)
            <div id="acc-row-{{ $acc->id }}" class="bg-white border-b border-[#E5E7EB] last:border-b-0 flex h-[52px] items-center text-[#374151] text-[13.5px] hover:bg-[#F9FBFA] transition-colors">
                <div class="w-[60px] px-4 border-r border-[#E5E7EB] h-full flex items-center text-[#6B7280]">{{ $acc->id }}</div>
                <div class="w-[180px] px-4 border-r border-[#E5E7EB] h-full flex items-center font-semibold text-[#111827] acc-name">{{ $acc->name }}</div>
                <div class="w-[150px] px-4 border-r border-[#E5E7EB] h-full flex items-center font-mono text-[#6B7280]">{{ $acc->username }}</div>
                <div class="w-[240px] px-4 border-r border-[#E5E7EB] h-full flex items-center text-[#6B7280] acc-email truncate">{{ $acc->email }}</div>
                <div class="w-[130px] px-4 border-r border-[#E5E7EB] h-full flex items-center font-mono text-[#374151] acc-phone">{{ $acc->phone }}</div>
                <div class="w-[110px] px-4 border-r border-[#E5E7EB] h-full flex items-center acc-role">
                    <span class="inline-block px-2 py-0.5 rounded-[6px] text-xs font-semibold bg-[#F3F4F6] text-[#374151]">
                        {{ $acc->role_label }}
                        <span class="sr-only">{{ $acc->role }}</span>
                    </span>
                </div>
                <div class="w-[110px] px-4 border-r border-[#E5E7EB] h-full flex items-center acc-status">
                    @if ($acc->status === 'ACTIVE' || $acc->status_label === 'Hoạt động')
                        <span class="inline-block px-2 py-0.5 rounded-[6px] text-xs font-semibold bg-[#E4EFE9] text-[#0E4D3C]">
                            {{ $acc->status_label }}
                        </span>
                    @else
                        <span class="inline-block px-2 py-0.5 rounded-[6px] text-xs font-semibold bg-rose-50 text-rose-600">
                            {{ $acc->status_label }}
                        </span>
                    @endif
                </div>
                <div class="flex-1 min-w-[130px] px-4 h-full flex items-center gap-1.5 text-[13px] acc-actions">
                    <button
                        type="button"
                        onclick="openAccountDetailModal({{ json_encode($acc) }})"
                        title="Xem chi tiết tài khoản"
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
                        onclick="openAccountEditModal({{ json_encode($acc) }})"
                        title="Chỉnh sửa tài khoản"
                        class="p-1.5 text-[#374151] hover:text-[#0E4D3C] hover:bg-[#F3F4F6] rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="sr-only">Sửa</span>
                    </button>
                    @if ($acc->is_current_user)
                        <span class="text-[#9CA3AF] text-[12px] px-1.5 font-medium">Bạn</span>
                    @else
                        @if ($acc->status === 'LOCKED' || $acc->status_label === 'Bị khóa')
                            <button
                                type="button"
                                onclick="openAccountUnlockModal({{ json_encode($acc) }})"
                                title="Mở khóa tài khoản"
                                class="p-1.5 text-[#0E4D3C] hover:bg-[#E4EFE9] rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center btn-lock-toggle"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                </svg>
                                <span class="sr-only">Mở khóa</span>
                            </button>
                        @else
                            <button
                                type="button"
                                onclick="openAccountLockModal({{ json_encode($acc) }})"
                                title="Khóa tài khoản"
                                class="p-1.5 text-[#B91C1C] hover:text-[#991B1B] hover:bg-rose-50 rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center btn-lock-toggle"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <span class="sr-only">Khóa</span>
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Dòng chú thích nghiệp vụ -->
    <div class="p-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[12px] text-[12.5px] text-[#6B7280] space-y-0.5">
        <div>4 vai trò chính: Quản lý, Nhân viên hỗ trợ, Nhân viên kỹ thuật, Cư dân.</div>
        <div>Danh sách đang lọc nhân sự nội bộ; chọn Cư dân để xem tài khoản cư dân.</div>
    </div>

    <!-- Thông tin hiển thị & Phân trang -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1 pb-6">
        <div class="text-[13px] text-[#6B7280]">
            Hiển thị {{ $accounts->firstItem() ?? 1 }}–{{ $accounts->lastItem() ?? $accounts->count() }} trong {{ $accounts->total() }} nhân sự
        </div>
        @include('layouts.partials.pagination', ['paginator' => $accounts])
    </div>
</div>

@include('accounts.partials.create-modal')
@include('accounts.partials.detail-modal')
@include('accounts.partials.edit-modal')
@include('accounts.partials.lock-modal')
@endsection
