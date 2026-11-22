@extends('layouts.app', [
    'title' => 'Chi tiết tài khoản · GGMB',
    'active' => 'accounts',
    'breadcrumbs' => ['Quản trị', 'Tài khoản', 'Chi tiết']
])

@section('content')
<div class="space-y-6">
    <span class="sr-only">GGMB</span>

    <!-- Tiêu đề & Phụ đề -->
    <div>
        <nav class="flex items-center text-[12px] text-[#6B7280] space-x-1.5 mb-1.5">
            <span>Quản trị</span>
            <span>/</span>
            <a href="{{ route('accounts.index') }}" class="hover:text-[#0E4D3C]">Tài khoản</a>
            <span>/</span>
            <span class="text-[#111827] font-medium">Chi tiết</span>
        </nav>
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Chi tiết tài khoản
        </h1>
        <p class="mt-0.5 text-[13.5px] text-[#6B7280]">
            {{ $account->name }} · {{ $account->username }}
        </p>
    </div>

    <!-- Khối thẻ thông tin tài khoản -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-6 sm:p-7 w-full max-w-[688px] space-y-6 shadow-none">
        <!-- Hàng 1: Họ và tên & Tên đăng nhập -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="block text-[12px] font-semibold text-[#6B7280]">Họ và tên</span>
                <span class="block text-[15px] font-bold text-[#111827] mt-1">{{ $account->name }}</span>
            </div>
            <div>
                <span class="block text-[12px] font-semibold text-[#6B7280]">Tên đăng nhập</span>
                <span class="block text-[14px] font-mono font-medium text-[#111827] mt-1">{{ $account->username }}</span>
            </div>
        </div>

        <!-- Hàng 2: Email & Điện thoại -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="block text-[12px] font-semibold text-[#6B7280]">Email</span>
                <span class="block text-[14px] text-[#374151] mt-1">{{ $account->email }}</span>
            </div>
            <div>
                <span class="block text-[12px] font-semibold text-[#6B7280]">Điện thoại</span>
                <span class="block text-[14px] font-mono text-[#374151] mt-1">{{ $account->phone }}</span>
            </div>
        </div>

        <!-- Hàng 3: Vai trò & Trạng thái -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="block text-[12px] font-semibold text-[#6B7280]">Vai trò</span>
                <span class="inline-block mt-1 px-2.5 py-0.5 rounded-[6px] text-xs font-semibold bg-[#F3F4F6] text-[#374151]">{{ $account->role }}</span>
            </div>
            <div>
                <span class="block text-[12px] font-semibold text-[#6B7280]">Trạng thái</span>
                <span class="inline-block mt-1 px-2.5 py-0.5 rounded-[6px] text-xs font-semibold bg-[#E4EFE9] text-[#0E4D3C]">{{ $account->status_label }}</span>
            </div>
        </div>

        <!-- Hàng 4: Căn cước & Bộ phận -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="block text-[12px] font-semibold text-[#6B7280]">Căn cước</span>
                <span class="block text-[14px] text-[#6B7280] mt-1">—</span>
            </div>
            <div>
                <span class="block text-[12px] font-semibold text-[#6B7280]">Bộ phận</span>
                <span class="block text-[14px] text-[#6B7280] mt-1">—</span>
            </div>
        </div>

        <!-- 2 Nút hành động -->
        <div class="flex items-center gap-4 pt-6 mt-6 border-t border-[#E5E7EB]">
            <a
                href="{{ route('accounts.index') }}"
                class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-medium rounded-[8px] transition-colors flex items-center justify-center cursor-pointer select-none"
            >
                Về danh sách
            </a>
            <a
                href="{{ route('accounts.edit', $account->id) }}"
                class="h-[40px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors flex items-center justify-center cursor-pointer select-none shadow-sm ml-auto"
            >
                Chỉnh sửa
            </a>
        </div>
    </div>
</div>
@endsection
