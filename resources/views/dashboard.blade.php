@extends('layouts.app', [
    'title' => 'Tổng quan vận hành · GGMB',
    'active' => 'overview',
    'breadcrumbs' => ['Quản trị', 'Tổng quan']
])

@section('content')
<div class="max-w-[1240px] mx-auto space-y-6">
    <!-- Breadcrumb & Header Title -->
    <div>
        <nav class="text-[12px] font-normal text-[#6b7280] mb-1" aria-label="Breadcrumb">
            <span>Quản trị</span>
            <span class="mx-1 text-[#9ca3af]">/</span>
            <span class="text-[#374151]">Tổng quan</span>
        </nav>
        <h1 class="text-[26px] leading-[34px] font-bold text-[#111827] tracking-tight">
            Tổng quan vận hành
        </h1>
        <p class="mt-1 text-[13px] leading-[20px] text-[#6b7280]">
            Theo dõi căn hộ, cư dân, công nợ và yêu cầu hỗ trợ trong phạm vi quản lý.
        </p>
    </div>

    <!-- 4 KPI Cards (Bo góc 14px, nền trắng) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- KPI CĂN HỘ -->
        <div class="bg-white border border-[#e5e7eb] rounded-[14px] p-5 shadow-none flex flex-col justify-between h-[126px]">
            <span class="text-[13px] font-medium text-[#4b5563]">
                Căn hộ <span class="sr-only">CĂN HỘ</span>
            </span>
            <div class="text-[34px] font-bold text-[#111827] leading-none my-1">
                {{ $totalApartments }}
            </div>
            <div class="text-[12px] text-[#6b7280] truncate">
                {{ $occupiedApartments }} đang ở · {{ $vacantApartments }} trống · {{ $otherApartments }} ngừng
            </div>
        </div>

        <!-- KPI CƯ DÂN -->
        <div class="bg-white border border-[#e5e7eb] rounded-[14px] p-5 shadow-none flex flex-col justify-between h-[126px]">
            <span class="text-[13px] font-medium text-[#4b5563]">
                Cư dân <span class="sr-only">CƯ DÂN</span>
            </span>
            <div class="text-[34px] font-bold text-[#111827] leading-none my-1">
                {{ $totalResidents }}
            </div>
            <div class="text-[12px] text-[#6b7280] truncate">
                {{ $totalResidents }} lượt cư trú hiệu lực
            </div>
        </div>

        <!-- KPI PHƯƠNG TIỆN -->
        <div class="bg-white border border-[#e5e7eb] rounded-[14px] p-5 shadow-none flex flex-col justify-between h-[126px]">
            <span class="text-[13px] font-medium text-[#4b5563]">
                Phương tiện <span class="sr-only">PHƯƠNG TIỆN</span>
            </span>
            <div class="text-[34px] font-bold text-[#111827] leading-none my-1">
                {{ $totalVehicles }}
            </div>
            <div class="text-[12px] text-[#6b7280] truncate">
                {{ $motorbikes }} xe máy · {{ $cars }} ô tô
            </div>
        </div>

        <!-- KPI YÊU CẦU -->
        <div class="bg-white border border-[#e5e7eb] rounded-[14px] p-5 shadow-none flex flex-col justify-between h-[126px]">
            <span class="text-[13px] font-medium text-[#4b5563]">
                Yêu cầu hỗ trợ <span class="sr-only">YÊU CẦU</span>
            </span>
            <div class="text-[34px] font-bold text-[#111827] leading-none my-1">
                {{ $totalTickets }}
            </div>
            <div class="text-[12px] text-[#6b7280] truncate">
                {{ $pendingTickets }} yêu cầu chưa hoàn tất
            </div>
        </div>
    </div>

    <!-- Main Content Grid (Thu phí và công nợ + Cần ưu tiên đối soát) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Thu phí và công nợ (Bo góc 16px) -->
        <div class="lg:col-span-7 xl:col-span-8 bg-white border border-[#e5e7eb] rounded-[16px] p-6 shadow-none flex flex-col justify-between min-h-[380px]">
            <div>
                <h2 class="text-[16px] font-bold text-[#111827]">
                    Thu phí và công nợ
                </h2>
                <p class="text-[12px] text-[#6b7280] mt-1 mb-6">
                    40 hóa đơn · Tổng đã thu 6.880.000 đ <span class="sr-only">Doanh Thu</span>
                </p>

                <!-- Thanh tiến độ 1: Chưa thanh toán -->
                <div class="space-y-1.5">
                    <div class="text-[13px] font-medium text-[#8f5316]">
                        Chưa thanh toán · 28 hóa đơn
                    </div>
                    <div class="w-full h-[10px] bg-[#f3f4f6] rounded-full overflow-hidden">
                        <div class="h-full bg-[#8f5316] rounded-full" style="width: 70%;"></div>
                    </div>
                </div>

                <!-- Thanh tiến độ 2: Đã thanh toán -->
                <div class="space-y-1.5 mt-5">
                    <div class="text-[13px] font-medium text-[#115e43]">
                        Đã thanh toán · 8 hóa đơn
                    </div>
                    <div class="w-full h-[10px] bg-[#f3f4f6] rounded-full overflow-hidden">
                        <div class="h-full bg-[#115e43] rounded-full" style="width: 20%;"></div>
                    </div>
                </div>

                <!-- Thanh tiến độ 3: Đã hủy -->
                <div class="space-y-1.5 mt-5">
                    <div class="text-[13px] font-medium text-[#6b7280]">
                        Đã hủy · 4 hóa đơn
                    </div>
                    <div class="w-full h-[10px] bg-[#f3f4f6] rounded-full overflow-hidden">
                        <div class="h-full bg-[#d1d5db] rounded-full" style="width: 10%;"></div>
                    </div>
                </div>
            </div>

            <div class="pt-8">
                <a href="{{ route('invoices.index') }}" class="px-4 py-2 border border-[#e5e7eb] rounded-[8px] bg-white text-[13px] font-medium text-[#374151] hover:bg-[#f9fafb] transition-colors inline-block">
                    Quản lý hóa đơn
                </a>
            </div>
        </div>

        <!-- Cần ưu tiên đối soát (Bo góc 16px) -->
        <div class="lg:col-span-5 xl:col-span-4 bg-white border border-[#e5e7eb] rounded-[16px] p-6 shadow-none flex flex-col justify-between min-h-[380px]">
            <div>
                <h2 class="text-[16px] font-bold text-[#111827]">
                    Cần ưu tiên đối soát
                </h2>
                <div class="text-[28px] font-bold text-[#8f5316] mt-2 leading-none">
                    <span class="sr-only">Nợ phí: </span>{{ $overdueTotal }}
                </div>
                <p class="text-[12px] text-[#6b7280] mt-1 mb-5">
                    Tổng công nợ · 28 hóa đơn
                </p>

                <!-- Đường phân chia -->
                <div class="h-px bg-[#e5e7eb] my-4"></div>

                <!-- Danh sách 5 hóa đơn quá hạn -->
                <div class="text-[13px] font-medium text-[#111827] mb-3">
                    {{ $overdueCount }} hóa đơn quá hạn · 4.457.500 đ
                </div>
                <div class="space-y-2.5 text-[13px] text-[#4b5563]">
                    @foreach ($invoicesData as $inv)
                        <div class="flex items-center justify-between">
                            <span>#{{ $inv['id'] }} — {{ $inv['amount'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="pt-6">
                <a href="{{ route('invoices.index') }}" class="px-4 py-2 bg-[#0e4d3c] hover:bg-[#0a3d2f] text-white rounded-[8px] text-[13px] font-semibold transition-colors inline-block">
                    Xem công nợ
                </a>
            </div>
        </div>
    </div>

    <!-- Khung: Theo dõi tiến độ hỗ trợ (Bo góc 16px) -->
    <div class="bg-white border border-[#e5e7eb] rounded-[16px] p-6 shadow-none">
        <h2 class="text-[16px] font-bold text-[#111827] mb-4">
            Theo dõi tiến độ hỗ trợ
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-4 bg-[#f8faf8] border border-[#e5e7eb] rounded-[12px]">
                <div class="text-[12px] text-[#6b7280]">Chờ tiếp nhận</div>
                <div class="text-[22px] font-bold text-[#111827] mt-1">12</div>
                <div class="text-[11px] text-[#8f5316] mt-0.5">3 yêu cầu khẩn cấp</div>
            </div>
            <div class="p-4 bg-[#f8faf8] border border-[#e5e7eb] rounded-[12px]">
                <div class="text-[12px] text-[#6b7280]">Đang xử lý</div>
                <div class="text-[22px] font-bold text-[#111827] mt-1">24</div>
                <div class="text-[11px] text-[#115e43] mt-0.5">Kỹ thuật viên đang phụ trách</div>
            </div>
            <div class="p-4 bg-[#f8faf8] border border-[#e5e7eb] rounded-[12px]">
                <div class="text-[12px] text-[#6b7280]">Đã hoàn tất tháng này</div>
                <div class="text-[22px] font-bold text-[#111827] mt-1">64</div>
                <div class="text-[11px] text-[#6b7280] mt-0.5">Thời gian xử lý TB: 2.4h</div>
            </div>
        </div>
    </div>
</div>
@endsection
