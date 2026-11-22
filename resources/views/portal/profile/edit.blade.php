@extends('layouts.portal', [
    'title' => 'Cập nhật liên hệ · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'profile'
])

@section('content')
<div class="space-y-6">
    <!-- Subtitle & Page Heading -->
    <div>
        <div class="text-[12.5px] font-medium text-[#6B7280] mb-1">
            Cổng cư dân / Tòa A
        </div>
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Cập nhật liên hệ
        </h1>
        <p class="mt-0.5 text-[13px] text-[#6B7280]">
            Cập nhật cho tài khoản resident01.
        </p>
    </div>

    <!-- 2 Columns Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Left: Thông tin cần cung cấp (8 cols) -->
        <div class="lg:col-span-8 bg-white border border-[#E5E7EB] rounded-[16px] p-6 shadow-none">
            <h2 class="text-[15px] font-bold text-[#111827] mb-5">
                Thông tin cần cung cấp
            </h2>

            <form action="{{ route('portal.profile.update') }}" method="POST" class="space-y-4">
                @csrf
                <!-- Điện thoại -->
                <div>
                    <label class="block text-[12px] font-medium text-[#374151] mb-1.5">
                        Điện thoại <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="phone" value="0910000010" required class="w-full h-[38px] px-3.5 bg-white border border-[#E5E7EB] rounded-[8px] text-[13px] text-[#111827] focus:outline-none focus:border-[#0E4D3C]">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-[12px] font-medium text-[#374151] mb-1.5">
                        Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" name="email" value="nguyenan123@gmail.com" required class="w-full h-[38px] px-3.5 bg-white border border-[#E5E7EB] rounded-[8px] text-[13px] text-[#111827] focus:outline-none focus:border-[#0E4D3C]">
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-3 pt-3">
                    <a href="{{ route('portal.profile') }}" class="px-5 py-2 border border-[#E5E7EB] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[13px] font-medium rounded-[8px] transition-colors">
                        Hủy
                    </a>
                    <button type="submit" class="px-5 py-2 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-medium rounded-[8px] transition-colors cursor-pointer">
                        Lưu liên hệ
                    </button>
                </div>
            </form>
        </div>

        <!-- Right: Lưu ý nghiệp vụ (4 cols) -->
        <div class="lg:col-span-4 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[16px] p-6 shadow-none text-[13px] text-[#4B5563] space-y-3">
            <h3 class="font-semibold text-[#111827] text-[14px]">
                Lưu ý nghiệp vụ
            </h3>
            <p class="leading-relaxed">
                Thông tin liên hệ được sử dụng để nhận thông báo phí và liên lạc khẩn cấp từ ban quản lý.
            </p>
        </div>
    </div>
</div>
@endsection
