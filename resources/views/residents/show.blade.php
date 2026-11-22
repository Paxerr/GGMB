@extends('layouts.app', [
    'title' => 'Chi tiết cư dân · ' . $resident->FullName . ' · GGMB',
    'active' => 'residents',
    'breadcrumbs' => ['Quản trị', 'Cư dân', 'Chi tiết cư dân']
])

@section('content')
<div class="space-y-6">
    <span class="sr-only">GGMB</span>
    @if (session('success'))
        <div class="p-4 bg-[#E4EFE9] border border-[#B8D5C7] text-[#0E4D3C] text-[13.5px] rounded-[8px] flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#0E4D3C] font-bold text-lg leading-none cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Header Title & Subtitle -->
    <div>
        <nav class="flex items-center text-[12px] text-[#6B7280] space-x-1.5 mb-1.5">
            <span>Quản trị</span>
            <span>/</span>
            <a href="{{ route('residents.index') }}" class="hover:text-[#0E4D3C]">Cư dân</a>
            <span>/</span>
            <span class="text-[#111827] font-medium">Chi tiết</span>
        </nav>
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Chi tiết cư dân
        </h1>
        <p class="mt-0.5 text-[13.5px] text-[#6B7280]">
            {{ $resident->FullName }} · Căn hộ {{ $activeResidency?->apartment?->ApartmentNumber ?? '0101' }} · {{ ($activeResidency?->Status ?? $resident->Status) === 'ACTIVE' ? 'Đang cư trú' : 'Đã rời đi' }}
        </p>
    </div>

    <!-- Biểu mẫu và hướng dẫn -->
    <div class="flex flex-col lg:flex-row items-start gap-6 pt-2">
        <!-- Cột trái: Thông tin nghiệp vụ -->
        <div class="w-full lg:w-[688px] bg-white border border-[#E5E7EB] rounded-[14px] p-6 shrink-0 shadow-none">
            <div class="space-y-5">
                <!-- Hàng 1: Tên đăng nhập & Mật khẩu -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[12px] font-semibold text-[#6B7280]">
                            Tên đăng nhập
                        </span>
                        <span class="block mt-1 text-[14px] font-semibold text-[#111827] font-mono">
                            {{ $resident->UserName ?? 'resident01' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-[12px] font-semibold text-[#6B7280]">
                            Mật khẩu
                        </span>
                        <span class="block mt-1 text-[14px] font-medium text-[#111827] font-mono">
                            ••••••••
                        </span>
                    </div>
                </div>

                <!-- Hàng 2: Quan hệ với chủ hộ & Họ và tên -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[12px] font-semibold text-[#6B7280]">
                            Quan hệ với chủ hộ
                        </span>
                        <span class="block mt-1 text-[14px] font-medium text-[#111827]">
                            {{ $resident->relationship ?? 'Chủ hộ' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-[12px] font-semibold text-[#6B7280]">
                            Họ và tên
                        </span>
                        <span class="block mt-1 text-[14px] font-semibold text-[#111827]">
                            {{ $resident->FullName }}
                        </span>
                    </div>
                </div>

                <!-- Hàng 3: Căn cước & Vai trò -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[12px] font-semibold text-[#6B7280]">
                            Căn cước
                        </span>
                        <span class="block mt-1 text-[14px] font-medium text-[#111827] font-mono">
                            {{ $resident->CitizenId ?? '—' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-[12px] font-semibold text-[#6B7280]">
                            Vai trò
                        </span>
                        <span class="block mt-1 text-[14px] font-medium text-[#111827]">
                            {{ $resident->Role === 'RESIDENT' ? 'Cư dân' : ($resident->Role ?? 'Cư dân') }}
                        </span>
                    </div>
                </div>

                <!-- Hàng 4: Email & Điện thoại -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[12px] font-semibold text-[#6B7280]">
                            Email
                        </span>
                        <span class="block mt-1 text-[14px] font-medium text-[#111827]">
                            {{ $resident->Email ?? 'Chưa cập nhật' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-[12px] font-semibold text-[#6B7280]">
                            Điện thoại
                        </span>
                        <span class="block mt-1 text-[14px] font-medium text-[#111827] font-mono">
                            {{ $resident->Phone ?? '—' }}
                        </span>
                    </div>
                </div>

                <!-- Hàng 5: Căn hộ hiện tại & Ngày bắt đầu cư trú -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[12px] font-semibold text-[#6B7280]">
                            Căn hộ hiện tại
                        </span>
                        <span class="block mt-1 text-[14px] font-medium text-[#111827]">
                            {{ $activeResidency?->apartment?->floor?->building?->BuildingName ?? 'Tòa A' }} · Tầng {{ $activeResidency?->apartment?->floor?->FloorNumber ?? '1' }} · Căn {{ $activeResidency?->apartment?->ApartmentNumber ?? '0101' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-[12px] font-semibold text-[#6B7280]">
                            Ngày bắt đầu cư trú
                        </span>
                        <span class="block mt-1 text-[14px] font-medium text-[#111827]">
                            {{ $activeResidency?->StartDate ? \Carbon\Carbon::parse($activeResidency->StartDate)->format('d/m/Y') : '01/01/2024' }}
                        </span>
                    </div>
                </div>

                <!-- Hàng 6: Ngày kết thúc & Trạng thái -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[12px] font-semibold text-[#6B7280]">
                            Ngày kết thúc
                        </span>
                        <span class="block mt-1 text-[14px] text-[#9CA3AF]">
                            {{ $activeResidency?->EndDate ? \Carbon\Carbon::parse($activeResidency->EndDate)->format('d/m/Y') : 'Chưa kết thúc' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-[12px] font-semibold text-[#6B7280]">
                            Trạng thái
                        </span>
                        <div class="mt-1">
                            @if (($activeResidency?->Status ?? $resident->Status) === 'ACTIVE')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] text-xs font-semibold bg-[#E4EFE9] text-[#0E4D3C]">
                                    Đang cư trú
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] text-xs font-semibold bg-[#F3F4F6] text-[#374151]">
                                    Ngừng hoạt động
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Hàng thao tác -->
                <div class="pt-4 border-t border-[#E5E7EB] flex items-center justify-between gap-4">
                    <a
                        href="{{ route('residents.index') }}"
                        class="px-5 h-[40px] bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-medium rounded-[8px] transition-colors flex items-center justify-center cursor-pointer"
                    >
                        ← Quay lại danh bạ
                    </a>

                    <a
                        href="{{ route('residents.edit', $resident->UserId) }}"
                        class="px-5 h-[40px] bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors flex items-center justify-center cursor-pointer shadow-sm"
                    >
                        Chỉnh sửa thông tin
                    </a>
                </div>
            </div>
        </div>

        <!-- Cột phải: Thông tin liên quan -->
        <div class="w-full lg:w-[440px] space-y-4">
            <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-6 space-y-4 shadow-none">
                <h3 class="text-[12px] font-bold text-[#111827] tracking-wider uppercase">
                    THÔNG TIN LIÊN QUAN
                </h3>

                <div class="p-3.5 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[10px] space-y-1">
                    <h4 class="text-[13px] font-bold text-[#111827]">Tài khoản cư dân</h4>
                    <p class="text-[12.5px] leading-[19px] text-[#6B7280]">
                        Tài khoản được sử dụng để đăng nhập ứng dụng cư dân GGMB, theo dõi thông báo và nhận hóa đơn định kỳ.
                    </p>
                </div>

                <div class="p-3.5 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[10px] space-y-1">
                    <h4 class="text-[13px] font-bold text-[#111827]">Quyền hạn và dịch vụ</h4>
                    <p class="text-[12.5px] leading-[19px] text-[#6B7280]">
                        Cư dân có thể đăng ký phương tiện, gửi phản ánh sự cố kỹ thuật và kiểm tra chỉ số điện nước hàng tháng.
                    </p>
                </div>

                <div class="p-3.5 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[10px] space-y-1">
                    <h4 class="text-[13px] font-bold text-[#111827]">Quan hệ cư trú</h4>
                    <p class="text-[12.5px] leading-[19px] text-[#6B7280]">
                        Thông tin căn hộ gắn kết trực tiếp với lịch sử cư trú và trạng thái thanh toán của căn hộ tại tòa nhà.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
