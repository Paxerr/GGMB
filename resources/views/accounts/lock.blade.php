@extends('layouts.app', [
    'title' => 'Khóa tài khoản · GGMB',
    'active' => 'accounts',
    'breadcrumbs' => ['Quản trị', 'Tài khoản', 'Khóa']
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
            <span class="text-[#B91C1C] font-medium">Khóa tài khoản</span>
        </nav>
        <h1 class="text-[24px] font-bold text-[#B91C1C] tracking-tight">
            Khóa tài khoản
        </h1>
        <p class="mt-0.5 text-[13.5px] text-[#6B7280]">
            {{ $account->name }} · {{ $account->username }}
        </p>
    </div>

    <!-- Khối thẻ xác nhận khóa -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-6 sm:p-7 w-full max-w-[688px] space-y-6 shadow-none">
        <form method="POST" action="{{ route('accounts.confirm-lock', $account->id) }}" onsubmit="event.preventDefault(); if(window.showToast) window.showToast('Đã khóa tài khoản thành công.', 'danger'); setTimeout(() => window.location.href='{{ route('accounts.index') }}', 600);">
            @csrf
            <!-- 2 Cột: Trạng thái hiện tại & Sau xác nhận -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <span class="block text-[12px] font-semibold text-[#6B7280]">
                        Trạng thái hiện tại
                    </span>
                    <span class="inline-block mt-1 px-2.5 py-0.5 rounded-[6px] text-xs font-semibold bg-[#E4EFE9] text-[#0E4D3C]">
                        {{ $account->status_label ?? 'Đang hoạt động' }}
                    </span>
                </div>
                <div>
                    <span class="block text-[12px] font-semibold text-[#6B7280]">
                        Sau xác nhận
                    </span>
                    <span class="inline-block mt-1 px-2.5 py-0.5 rounded-[6px] text-xs font-semibold bg-rose-50 text-rose-600">
                        Bị khóa
                    </span>
                </div>
            </div>

            <!-- Footer Buttons: Hủy bên trái, Xác nhận khóa bên phải -->
            <div class="flex items-center gap-4 pt-6 mt-6 border-t border-[#E5E7EB]">
                <a
                    href="{{ route('accounts.index') }}"
                    class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-medium rounded-[8px] transition-colors flex items-center justify-center cursor-pointer select-none"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-6 bg-[#B91C1C] hover:bg-[#991B1B] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors flex items-center justify-center cursor-pointer select-none shadow-sm ml-auto"
                >
                    Xác nhận khóa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
