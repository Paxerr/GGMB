@extends('layouts.app', [
    'title' => 'Chi tiết tài khoản · GGMB',
    'active' => 'accounts',
    'breadcrumbs' => ['GGMB', 'Tài khoản']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    <!-- Tiêu đề & Phụ đề (Bám sát Ảnh Chi tiết tài khoản) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-bold text-[#122d40]">
            Chi tiết tài khoản
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#52697c]">
            {{ $account->name }} · {{ $account->username }}
        </p>
    </div>

    <!-- Khối thẻ thông tin tài khoản (Bám sát Ảnh Chi tiết tài khoản) -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 sm:p-7 w-full max-w-[688px] space-y-6 shadow-xs">
        <!-- Hàng 1: Họ và tên & Tên đăng nhập -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c]">Họ và tên</span>
                <span class="block text-[14px] font-medium text-[#122d40] mt-1">{{ $account->name }}</span>
            </div>
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c]">Tên đăng nhập</span>
                <span class="block text-[14px] font-mono text-[#122d40] mt-1">{{ $account->username }}</span>
            </div>
        </div>

        <!-- Hàng 2: Email & Điện thoại -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c]">Email</span>
                <span class="block text-[14px] text-[#122d40] mt-1">{{ $account->email }}</span>
            </div>
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c]">Điện thoại</span>
                <span class="block text-[14px] font-mono text-[#122d40] mt-1">{{ $account->phone }}</span>
            </div>
        </div>

        <!-- Hàng 3: Vai trò & Trạng thái -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c]">Vai trò</span>
                <span class="block text-[14px] text-[#122d40] mt-1">{{ $account->role }}</span>
            </div>
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c]">Trạng thái</span>
                <span class="block text-[14px] font-medium text-[#16734b] mt-1">{{ $account->status_label }}</span>
            </div>
        </div>

        <!-- Hàng 4: Căn cước & Bộ phận -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c]">Căn cước</span>
                <span class="block text-[14px] text-[#52697c] mt-1">—</span>
            </div>
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c]">Bộ phận</span>
                <span class="block text-[14px] text-[#52697c] mt-1">—</span>
            </div>
        </div>

        <!-- 2 Nút hành động: Về danh sách & Chỉnh sửa -->
        <div class="flex items-center gap-4 pt-6 mt-6 border-t border-[#d9e4ec]">
            <a
                href="{{ route('accounts.index') }}"
                class="h-[40px] px-8 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer select-none"
            >
                Về danh sách
            </a>
            <a
                href="{{ route('accounts.edit', $account->id) }}"
                class="h-[40px] px-8 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer select-none shadow-sm ml-auto"
            >
                Chỉnh sửa
            </a>
        </div>
    </div>
</div>
@endsection
