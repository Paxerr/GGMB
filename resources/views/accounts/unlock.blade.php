@extends('layouts.app', [
    'title' => 'Mở khóa tài khoản · GGMB',
    'active' => 'accounts',
    'breadcrumbs' => ['Quản trị', 'Tài khoản', 'Mở khóa']
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
            <span class="text-[#0E4D3C] font-medium">Mở khóa tài khoản</span>
        </nav>
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Mở khóa tài khoản
        </h1>
        <p class="mt-0.5 text-[13.5px] text-[#6B7280]">
            Chỉ áp dụng cho tài khoản đang bị khóa.
        </p>
    </div>

    <!-- Khối thẻ xác nhận mở khóa -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-6 sm:p-7 w-full max-w-[688px] space-y-6 shadow-none">
        <form method="POST" action="{{ route('accounts.confirm-unlock', $account->id) }}">
            @csrf
            <!-- 2 Cột: Tài khoản & Sau xác nhận -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <span class="block text-[12px] font-semibold text-[#6B7280]">
                        Tài khoản
                    </span>
                    <span class="block text-[15px] font-semibold text-[#111827] mt-1">
                        {{ $account->username }} · {{ $account->name }}
                    </span>
                </div>
                <div>
                    <span class="block text-[12px] font-semibold text-[#6B7280]">
                        Sau xác nhận
                    </span>
                    <span class="inline-block mt-1 px-2.5 py-0.5 rounded-[6px] text-xs font-semibold bg-[#E4EFE9] text-[#0E4D3C]">
                        Đang hoạt động
                    </span>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="flex items-center gap-4 pt-6 mt-6 border-t border-[#E5E7EB]">
                <a
                    href="{{ route('accounts.index') }}"
                    class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-medium rounded-[8px] transition-colors flex items-center justify-center cursor-pointer select-none"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors flex items-center justify-center cursor-pointer select-none shadow-sm ml-auto"
                >
                    Mở khóa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
