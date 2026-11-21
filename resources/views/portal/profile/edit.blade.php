@extends('layouts.portal', [
    'title' => 'Cập nhật liên hệ · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'dashboard'
])

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-[26px] font-semibold text-[#122d40] leading-tight">
            Cập nhật liên hệ
        </h1>
        <p class="mt-1 text-[14px] text-[#52697c]">
            Cập nhật cho tài khoản resident01.
        </p>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 sm:p-8 max-w-xl shadow-sm">
        <form action="{{ route('portal.profile.update') }}" method="POST" class="space-y-5">
            @csrf
            <!-- Điện thoại -->
            <div>
                <label class="block text-[13px] font-medium text-[#334b5d] mb-1.5">
                    Điện thoại <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="phone" value="0910000010" required class="w-full h-[40px] px-3.5 bg-white border border-[#d9e4ec] rounded-[4px] text-[14px] text-[#122d40] focus:outline-none focus:border-[#2864ad]">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-[13px] font-medium text-[#334b5d] mb-1.5">
                    Email <span class="text-rose-500">*</span>
                </label>
                <input type="email" name="email" value="nguyenan123@gmail.com" required class="w-full h-[40px] px-3.5 bg-white border border-[#d9e4ec] rounded-[4px] text-[14px] text-[#122d40] focus:outline-none focus:border-[#2864ad]">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-3 pt-3">
                <a href="{{ route('portal.profile') }}" class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-slate-50 text-[#334b5d] font-medium text-[14px] rounded-[4px] flex items-center transition-colors">
                    Hủy
                </a>
                <button type="submit" class="h-[40px] px-6 bg-[#2864AD] hover:bg-[#1e4d87] text-white font-medium text-[14px] rounded-[4px] transition-colors cursor-pointer shadow-sm">
                    Lưu liên hệ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
