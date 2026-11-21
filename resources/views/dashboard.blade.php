@extends('layouts.app', [
    'title' => 'Tổng quan vận hành · GGMB',
    'active' => 'overview',
    'breadcrumbs' => ['GGMB', 'Tổng quan']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    <!-- Page Header Title & Subtitle -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
            Tổng quan vận hành
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#52697c]">
            Theo dõi căn hộ, cư dân, công nợ và yêu cầu hỗ trợ trong phạm vi quản lý.
        </p>
    </div>

    <!-- 4 KPI Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <!-- KPI CĂN HỘ -->
        <div class="bg-[#e8f1ff] border border-solid border-[#d9e4ec] h-[120px] p-[15px] flex flex-col justify-between" data-name="KPI CĂN HỘ">
            <span class="text-[11px] leading-[17px] font-semibold text-[#334b5d] uppercase">
                CĂN HỘ
            </span>
            <span class="text-[30px] leading-[36px] font-semibold text-[#2864ad]">
                {{ $totalApartments }}
            </span>
            <span class="text-[11px] leading-[17px] font-normal text-[#334b5d]">
                {{ $occupiedApartments }} đang ở · {{ $vacantApartments }} trống · {{ $otherApartments }} ngừng
            </span>
        </div>

        <!-- KPI CƯ DÂN -->
        <div class="bg-[#e6f5ec] border border-solid border-[#d9e4ec] h-[120px] p-[15px] flex flex-col justify-between" data-name="KPI CƯ DÂN">
            <span class="text-[11px] leading-[17px] font-semibold text-[#334b5d] uppercase">
                CƯ DÂN
            </span>
            <span class="text-[30px] leading-[36px] font-semibold text-[#16734b]">
                {{ $totalResidents }}
            </span>
            <span class="text-[11px] leading-[17px] font-normal text-[#334b5d]">
                {{ $totalResidents }} lượt cư trú đang hiệu lực
            </span>
        </div>

        <!-- KPI PHƯƠNG TIỆN -->
        <div class="bg-[#f0edfa] border border-solid border-[#d9e4ec] h-[120px] p-[15px] flex flex-col justify-between" data-name="KPI PHƯƠNG TIỆN">
            <span class="text-[11px] leading-[17px] font-semibold text-[#334b5d] uppercase">
                PHƯƠNG TIỆN
            </span>
            <span class="text-[30px] leading-[36px] font-semibold text-[#6a51ae]">
                {{ $totalVehicles }}
            </span>
            <span class="text-[11px] leading-[17px] font-normal text-[#334b5d]">
                {{ $motorbikes }} xe máy · {{ $cars }} ô tô
            </span>
        </div>

        <!-- KPI YÊU CẦU -->
        <div class="bg-[#fff4db] border border-solid border-[#d9e4ec] h-[120px] p-[15px] flex flex-col justify-between" data-name="KPI PHIẾU SỰ CỐ">
            <span class="text-[11px] leading-[17px] font-semibold text-[#334b5d] uppercase">
                YÊU CẦU
            </span>
            <span class="text-[30px] leading-[36px] font-semibold text-[#985b06]">
                {{ $totalTickets }}
            </span>
            <span class="text-[11px] leading-[17px] font-normal text-[#334b5d]">
                {{ $pendingTickets }} phiếu chưa hoàn tất
            </span>
        </div>
    </div>

    <!-- Main Chart & Overdue Debt Table Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Khung biểu đồ dữ liệu: Doanh Thu -->
        <div class="lg:col-span-7 bg-white border border-solid border-[#d9e4ec] p-[19px] min-h-[394px] flex flex-col justify-between" data-name="Khung biểu đồ dữ liệu">
            <div>
                <h2 class="text-[18px] leading-[24px] font-semibold text-[#334b5d]">
                    Doanh Thu
                </h2>
                <p class="text-[12px] leading-[18px] font-normal text-[#334b5d] mt-1">
                    Sơ đồ tiền thu vào theo từng tháng
                </p>
            </div>

            <!-- Biểu đồ cột -->
            <div class="pt-8 pb-4">
                <div class="relative w-full max-w-[624px] mx-auto h-[220px] flex items-end justify-between px-2 sm:px-6">
                    <!-- Đường baseline phân vùng -->
                    <div class="absolute bottom-[36px] left-0 right-0 h-px bg-[#d9e4ec]" data-name="Đường phân vùng"></div>

                    @foreach ($monthlyRevenue as $item)
                        <div class="flex flex-col items-center z-10">
                            <!-- Cột bar -->
                            <div
                                class="bg-[#2864ad] border border-[#d9e4ec] w-[36px] sm:w-[54px] transition-all hover:opacity-90"
                                style="height: {{ $item['height'] }}px;"
                                title="{{ $item['month'] }}"
                            ></div>
                            <!-- Label tháng -->
                            <span class="text-[10px] leading-[16px] text-[#334b5d] mt-2 whitespace-nowrap">
                                {{ $item['month'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Khung dữ liệu: Công nợ -->
        <div class="lg:col-span-5 bg-white border border-solid border-[#d9e4ec] p-[19px] min-h-[394px]" data-name="Công nợ">
            <h2 class="text-[22px] leading-[28px] font-semibold text-[#334b5d]">
                Nợ phí: {{ $overdueTotal }}
            </h2>
            <p class="text-[14px] leading-[20px] font-normal text-[#334b5d] mt-1 mb-6">
                {{ $overdueCount }} hóa đơn chờ thanh toán đã quá hạn
            </p>

            <!-- Bảng dữ liệu công nợ -->
            <div class="border border-solid border-[#d9e4ec] overflow-hidden" data-name="Bảng dữ liệu">
                <!-- Tiêu đề cột -->
                <div class="bg-[#e4edf3] border-b border-[#d9e4ec] flex h-[40px] items-center text-[#334b5d] text-[12px] font-semibold">
                    <div class="w-[35%] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                        Hóa đơn
                    </div>
                    <div class="w-[65%] px-3 h-full flex items-center">
                        Số tiền
                    </div>
                </div>

                <!-- Danh sách bản ghi -->
                @forelse ($invoicesData as $invoice)
                    <div class="bg-white border-b last:border-b-0 border-[#d9e4ec] flex h-[48px] items-center text-[#334b5d] text-[14px]">
                        <div class="w-[35%] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                            {{ $invoice['id'] }}
                        </div>
                        <div class="w-[65%] px-3 h-full flex items-center">
                            {{ $invoice['amount'] }}
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-sm text-[#52697c]">
                        Không có hóa đơn quá hạn
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
