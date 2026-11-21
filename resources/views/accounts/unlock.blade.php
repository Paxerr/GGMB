@extends('layouts.app', [
    'title' => 'Mở khóa tài khoản · GGMB',
    'active' => 'accounts',
    'breadcrumbs' => ['GGMB', 'Tài khoản']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    <!-- Tiêu đề & Phụ đề (Bám sát Ảnh Mở khóa tài khoản) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-bold text-[#122d40]">
            Mở khóa tài khoản
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#52697c]">
            Chỉ áp dụng cho tài khoản đang bị khóa.
        </p>
    </div>

    <!-- Khối thẻ xác nhận mở khóa (Bám sát Ảnh Mở khóa tài khoản) -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 sm:p-7 w-full max-w-[688px] space-y-6 shadow-xs">
        <form method="POST" action="{{ route('accounts.confirm-unlock', $account->id) }}" onsubmit="event.preventDefault(); if(window.showToast) window.showToast('Đã mở khóa tài khoản thành công.'); setTimeout(() => window.location.href='{{ route('accounts.index') }}', 600);">
            @csrf
            <!-- 2 Cột: Tài khoản & Sau xác nhận -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <span class="block text-[12px] font-semibold text-[#52697c]">
                        Tài khoản
                    </span>
                    <span class="block text-[14px] font-medium text-[#122d40] mt-1.5">
                        {{ $account->username }} · {{ $account->name }}
                    </span>
                </div>
                <div>
                    <span class="block text-[12px] font-semibold text-[#52697c]">
                        Sau xác nhận
                    </span>
                    <span class="block text-[14px] font-medium text-[#16734b] mt-1.5">
                        Đang hoạt động
                    </span>
                </div>
            </div>

            <!-- Footer Buttons: Hủy bên trái, Mở khóa bên phải -->
            <div class="flex items-center gap-4 pt-6 mt-6">
                <a
                    href="{{ route('accounts.index') }}"
                    class="h-[40px] px-8 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer select-none"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-8 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer select-none shadow-sm ml-auto"
                >
                    Mở khóa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
