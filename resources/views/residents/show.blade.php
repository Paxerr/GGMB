@extends('layouts.app', [
    'title' => 'Chi tiết cư dân · ' . $resident->FullName . ' · GGMB',
    'active' => 'residents',
    'breadcrumbs' => ['GGMB', 'Cư dân', 'Chi tiết cư dân']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    @if (session('success'))
        <div class="p-4 bg-[#e6f5ec] border border-[#c3e6cb] text-[#16734b] text-[14px] rounded-[4px] flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#16734b] font-bold text-lg leading-none cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Header Title & Subtitle (17 · SCR-RES-02) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
            Chi tiết cư dân
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#334b5d]">
            {{ $resident->FullName }} · Căn hộ {{ $activeResidency?->apartment?->ApartmentNumber ?? '0101' }} · {{ ($activeResidency?->Status ?? $resident->Status) === 'ACTIVE' ? 'Đang cư trú' : 'Đã rời đi' }}
        </p>
    </div>

    <!-- Biểu mẫu và hướng dẫn (Layout 2 cột: Thông tin nghiệp vụ + Thông tin liên quan) -->
    <div class="flex flex-col lg:flex-row items-start gap-6 pt-2">
        <!-- Cột trái: Thông tin nghiệp vụ (w=688px chuẩn Figma) -->
        <div class="w-full lg:w-[688px] bg-white border border-solid border-[#d9e4ec] rounded-[4px] p-6 shrink-0">
            <div class="space-y-6">
                <!-- Hàng 1: Tên đăng nhập & Mật khẩu -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                            Tên đăng nhập
                        </span>
                        <span class="block mt-1 text-[14px] leading-[20px] font-medium text-[#122d40] font-mono">
                            {{ $resident->UserName ?? 'resident01' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                            Mật khẩu
                        </span>
                        <span class="block mt-1 text-[14px] leading-[20px] font-medium text-[#122d40] font-mono">
                            ••••••••
                        </span>
                    </div>
                </div>

                <!-- Hàng 2: Quan hệ với chủ hộ & Họ và tên -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                            Quan hệ với chủ hộ
                        </span>
                        <span class="block mt-1 text-[14px] leading-[20px] font-medium text-[#122d40]">
                            {{ $resident->relationship ?? 'Chủ hộ' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                            Họ và tên
                        </span>
                        <span class="block mt-1 text-[14px] leading-[20px] font-semibold text-[#122d40]">
                            {{ $resident->FullName }}
                        </span>
                    </div>
                </div>

                <!-- Hàng 3: Căn cước & Vai trò -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                            Căn cước
                        </span>
                        <span class="block mt-1 text-[14px] leading-[20px] font-medium text-[#122d40] font-mono">
                            {{ $resident->CitizenId ?? '—' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                            Vai trò
                        </span>
                        <span class="block mt-1 text-[14px] leading-[20px] font-medium text-[#122d40]">
                            {{ $resident->Role === 'RESIDENT' ? 'Cư dân' : ($resident->Role ?? 'Cư dân') }}
                        </span>
                    </div>
                </div>

                <!-- Hàng 4: Email & Điện thoại -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                            Email
                        </span>
                        <span class="block mt-1 text-[14px] leading-[20px] font-medium text-[#122d40]">
                            {{ $resident->Email ?? 'Chưa cập nhật' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                            Điện thoại
                        </span>
                        <span class="block mt-1 text-[14px] leading-[20px] font-medium text-[#122d40] font-mono">
                            {{ $resident->Phone ?? '—' }}
                        </span>
                    </div>
                </div>

                <!-- Hàng 5: Căn hộ hiện tại & Ngày bắt đầu cư trú -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                            Căn hộ hiện tại
                        </span>
                        <span class="block mt-1 text-[14px] leading-[20px] font-medium text-[#122d40]">
                            {{ $activeResidency?->apartment?->floor?->building?->BuildingName ?? 'Tòa A' }} · Tầng {{ $activeResidency?->apartment?->floor?->FloorNumber ?? '1' }} · Căn {{ $activeResidency?->apartment?->ApartmentNumber ?? '0101' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                            Ngày bắt đầu cư trú
                        </span>
                        <span class="block mt-1 text-[14px] leading-[20px] font-medium text-[#122d40]">
                            {{ $activeResidency?->StartDate ? \Carbon\Carbon::parse($activeResidency->StartDate)->format('d/m/Y') : '01/01/2024' }}
                        </span>
                    </div>
                </div>

                <!-- Hàng 6: Ngày kết thúc & Trạng thái -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                            Ngày kết thúc
                        </span>
                        <span class="block mt-1 text-[14px] leading-[20px] text-[#8a9ba8]">
                            {{ $activeResidency?->EndDate ? \Carbon\Carbon::parse($activeResidency->EndDate)->format('d/m/Y') : 'Chưa kết thúc' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-[12px] leading-[17px] font-semibold text-[#52697c]">
                            Trạng thái
                        </span>
                        <div class="mt-1">
                            @if (($activeResidency?->Status ?? $resident->Status) === 'ACTIVE')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[12px] font-medium bg-[#e6f5ec] text-[#16734b]">
                                    Đang hoạt động
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[12px] font-medium bg-[#f0f4f8] text-[#5c7284]">
                                    Ngừng hoạt động
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Hàng thao tác (Nút Quay lại và Nút Chỉnh sửa) -->
                <div class="pt-6 border-t border-[#d9e4ec] flex items-center justify-between gap-4">
                    <a
                        href="{{ route('residents.index') }}"
                        class="w-[204px] h-[40px] px-4 bg-white border border-solid border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-medium rounded-[4px] transition-colors flex items-center justify-center cursor-pointer"
                    >
                        ← Quay lại danh bạ
                    </a>

                    <a
                        href="{{ route('residents.edit', $resident->UserId) }}"
                        class="w-[204px] h-[40px] px-4 bg-[#2864ad] hover:bg-[#205391] border border-solid border-[#2864ad] text-white text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer"
                    >
                        Chỉnh sửa thông tin
                    </a>
                </div>
            </div>
        </div>

        <!-- Cột phải: Thông tin liên quan (w=440px) -->
        <div class="w-full lg:w-[440px] space-y-4">
            <div class="bg-white border border-solid border-[#d9e4ec] rounded-[4px] p-6 space-y-4">
                <h3 class="text-[12px] leading-[17px] font-semibold text-[#52697c] tracking-wider uppercase">
                    THÔNG TIN LIÊN QUAN
                </h3>

                <div class="p-3 bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] space-y-1">
                    <h4 class="text-[13px] font-semibold text-[#122d40]">Tài khoản cư dân</h4>
                    <p class="text-[13px] leading-[19px] text-[#52697c]">
                        Tài khoản được sử dụng để đăng nhập ứng dụng cư dân GGMB, theo dõi thông báo và nhận hóa đơn định kỳ.
                    </p>
                </div>

                <div class="p-3 bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] space-y-1">
                    <h4 class="text-[13px] font-semibold text-[#122d40]">Quyền hạn và dịch vụ</h4>
                    <p class="text-[13px] leading-[19px] text-[#52697c]">
                        Cư dân có thể đăng ký phương tiện, gửi phản ánh sự cố kỹ thuật và kiểm tra chỉ số điện nước hàng tháng.
                    </p>
                </div>

                <div class="p-3 bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] space-y-1">
                    <h4 class="text-[13px] font-semibold text-[#122d40]">Quan hệ cư trú</h4>
                    <p class="text-[13px] leading-[19px] text-[#52697c]">
                        Thông tin căn hộ gắn kết trực tiếp với lịch sử cư trú và trạng thái thanh toán của căn hộ tại tòa nhà.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
