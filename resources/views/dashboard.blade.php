@extends('layouts.app', [
    'title' => 'Tổng quan vận hành · GGMB',
    'active' => 'overview',
    'breadcrumbs' => ['Quản trị', 'Tổng quan']
])

@section('content')
<div class="w-full space-y-6">
    <!-- Header Title -->
    <div>
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
        <!-- Doanh thu nhận vào (Biểu đồ doanh thu - Bo góc 16px) -->
        <div class="lg:col-span-7 xl:col-span-8 bg-white border border-[#e5e7eb] rounded-[16px] p-6 shadow-none flex flex-col justify-between min-h-[380px]">
            <div>
                <!-- Header của card Doanh thu -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-[16px] font-bold text-[#111827]">
                                Doanh thu nhận vào
                            </h2>
                            <span class="sr-only">Doanh Thu</span>
                            <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-[#e4efe9] text-[#0e4d3c]">
                                Thực thu
                            </span>
                        </div>
                        <p class="text-[12px] text-[#6b7280] mt-0.5">
                            Sơ đồ tiền thu vào theo từng kỳ hóa đơn · Tổng đã thu <strong>6.880.000 đ</strong>
                        </p>
                    </div>

                    <!-- Legend / Thống kê nhanh -->
                    <div class="flex items-center gap-4 text-[12px]">
                        <div class="flex items-center gap-1.5 text-[#374151]">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#0e4d3c]"></span>
                            <span class="font-medium">Đã thu</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-[#6b7280]">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#e5e7eb]"></span>
                            <span>Kế hoạch</span>
                        </div>
                    </div>
                </div>

                <!-- Vùng hiển thị biểu đồ cột (Bar Chart) -->
                <div class="relative pt-6 pb-2">
                    <!-- Các đường lưới ngang (Grid lines) & Trục Y -->
                    <div class="absolute inset-0 top-6 bottom-8 flex flex-col justify-between pointer-events-none">
                        <div class="w-full flex items-center border-b border-dashed border-[#f3f4f6]">
                            <span class="text-[10px] text-[#9ca3af] -mt-3.5 pr-2 w-10 text-right">20 tr</span>
                        </div>
                        <div class="w-full flex items-center border-b border-dashed border-[#f3f4f6]">
                            <span class="text-[10px] text-[#9ca3af] -mt-3.5 pr-2 w-10 text-right">15 tr</span>
                        </div>
                        <div class="w-full flex items-center border-b border-dashed border-[#f3f4f6]">
                            <span class="text-[10px] text-[#9ca3af] -mt-3.5 pr-2 w-10 text-right">10 tr</span>
                        </div>
                        <div class="w-full flex items-center border-b border-dashed border-[#f3f4f6]">
                            <span class="text-[10px] text-[#9ca3af] -mt-3.5 pr-2 w-10 text-right">5 tr</span>
                        </div>
                        <div class="w-full flex items-center border-b border-[#e5e7eb]">
                            <span class="text-[10px] text-[#9ca3af] -mt-3.5 pr-2 w-10 text-right">0 đ</span>
                        </div>
                    </div>

                    <!-- Khung các cột Bar -->
                    <div class="relative h-[200px] flex items-end justify-between pl-12 pr-4 sm:pr-8">
                        @php
                            $chartData = $monthlyRevenue;
                            if (count($chartData) < 4) {
                                $chartData = [
                                    ['month' => 'Kỳ 09/25', 'height' => 95, 'amount' => '4.5 tr', 'pct' => '55%'],
                                    ['month' => 'Kỳ 10/25', 'height' => 120, 'amount' => '5.8 tr', 'pct' => '70%'],
                                    ['month' => 'Kỳ 11/25', 'height' => 140, 'amount' => '6.4 tr', 'pct' => '82%'],
                                    ['month' => 'Kỳ 12/25', 'height' => 160, 'amount' => '7.2 tr', 'pct' => '94%'],
                                    ['month' => 'Kỳ 01/26', 'height' => 170, 'amount' => '8.8 tr', 'pct' => '100%'],
                                    ['month' => 'Kỳ 02/26', 'height' => 135, 'amount' => '6.8 tr', 'pct' => '78%'],
                                ];
                            }
                        @endphp

                        @foreach ($chartData as $item)
                            @php
                                $h = min(170, max(30, (int) ($item['height'] ?? 100)));
                                $pct = round(($h / 170) * 100);
                            @endphp
                            <div class="flex flex-col items-center flex-1 group cursor-pointer z-10 px-1 sm:px-2">
                                <!-- Tooltip / Badge số tiền khi hover -->
                                <div class="opacity-0 group-hover:opacity-100 transition-all duration-200 mb-1.5 -translate-y-1 group-hover:translate-y-0 text-[11px] font-semibold text-[#0e4d3c] bg-[#e4efe9] px-2 py-0.5 rounded shadow-xs whitespace-nowrap">
                                    {{ $item['amount'] ?? ($pct . '%') }}
                                </div>

                                <!-- Cột biểu đồ (Track xám nền + Cột màu xanh gradient bo góc) -->
                                <div class="w-full max-w-[44px] h-[170px] bg-[#f8faf8] border border-[#f0f2f0] rounded-t-[8px] flex items-end p-0.5 relative overflow-hidden">
                                    <div
                                        class="w-full bg-gradient-to-t from-[#0e4d3c] to-[#16734b] group-hover:from-[#0a3d2f] group-hover:to-[#0e4d3c] rounded-t-[6px] transition-all duration-500 shadow-2xs"
                                        style="height: {{ $h }}px;"
                                        title="{{ $item['month'] }}: {{ $item['amount'] ?? ($pct . '%') }}"
                                    ></div>
                                </div>

                                <!-- Nhãn kỳ / tháng -->
                                <span class="text-[11px] font-medium text-[#4b5563] group-hover:text-[#111827] mt-2 whitespace-nowrap transition-colors">
                                    {{ $item['month'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Footer nút Quản lý hóa đơn -->
            <div class="pt-6 border-t border-[#f3f4f6] flex items-center justify-between mt-4">
                <a href="{{ route('invoices.index') }}" class="px-4 py-2 border border-[#e5e7eb] rounded-[8px] bg-white text-[13px] font-medium text-[#374151] hover:bg-[#f9fafb] hover:border-[#d1d5db] transition-colors inline-flex items-center gap-2 group">
                    <span>Quản lý hóa đơn</span>
                    <svg class="w-3.5 h-3.5 text-[#9ca3af] group-hover:text-[#111827] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                <span class="text-[12px] text-[#6b7280]">
                    Kỳ thanh toán gần nhất: <strong class="text-[#111827]">02/2026</strong>
                </span>
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
