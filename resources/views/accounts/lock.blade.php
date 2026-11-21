@extends('layouts.app', [
    'title' => 'Khóa tài khoản · GGMB',
    'active' => 'accounts',
    'breadcrumbs' => ['GGMB', 'Tài khoản']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    <!-- Tiêu đề & Phụ đề (Bám sát Ảnh Khóa tài khoản) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-bold text-[#b91c1c]">
            Khóa tài khoản
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#52697c]">
            {{ $account->name }} · {{ $account->username }}
        </p>
    </div>

    <!-- Khối thẻ xác nhận khóa (Bám sát Ảnh Khóa tài khoản) -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 sm:p-7 w-full max-w-[688px] space-y-6 shadow-xs">
        <form method="POST" action="{{ route('accounts.confirm-lock', $account->id) }}" onsubmit="event.preventDefault(); if(window.showToast) window.showToast('Đã khóa tài khoản thành công.', 'danger'); setTimeout(() => window.location.href='{{ route('accounts.index') }}', 600);">
            @csrf
            <!-- 2 Cột: Trạng thái hiện tại & Sau xác nhận -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <span class="block text-[12px] font-semibold text-[#52697c]">
                        Trạng thái hiện tại
                    </span>
                    <span class="block text-[14px] font-medium text-[#16734b] mt-1.5">
                        {{ $account->status_label ?? 'Đang hoạt động' }}
                    </span>
                </div>
                <div>
                    <span class="block text-[12px] font-semibold text-[#52697c]">
                        Sau xác nhận
                    </span>
                    <span class="block text-[14px] font-medium text-[#b91c1c] mt-1.5">
                        Bị khóa
                    </span>
                </div>
            </div>

            <!-- Footer Buttons: Hủy bên trái, Xác nhận khóa bên phải -->
            <div class="flex items-center gap-4 pt-6 mt-6">
                <a
                    href="{{ route('accounts.index') }}"
                    class="h-[40px] px-8 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer select-none"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-8 bg-[#b91c1c] hover:bg-[#991b1b] text-white text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer select-none shadow-sm ml-auto"
                >
                    Xác nhận khóa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
