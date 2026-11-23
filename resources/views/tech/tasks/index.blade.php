@extends('layouts.portal', [
    'title' => 'Bàn việc hiện trường · GGMB',
    'portalType' => 'tech',
    'activeTab' => 'tasks'
])

@section('content')
<div class="space-y-8 sm:space-y-10">
    <!-- Subtitle & Page Heading -->
    <div>
        <div class="text-[12.5px] font-semibold text-[#6B7280] mb-1.5 flex items-center gap-1.5">
            <span>Cổng kỹ thuật</span>
            <span>/</span>
            <span class="text-[#111827]">Tòa A</span>
        </div>
        <h1 class="text-[26px] font-bold text-[#111827] tracking-tight">
            Bàn việc hiện trường
        </h1>
        <p class="mt-1.5 text-[13.5px] text-[#6B7280]">
            Công việc kỹ thuật được giao cho bạn; không hiển thị yêu cầu ngoài phạm vi phụ trách.
        </p>
    </div>

    <!-- 3 Stat KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Stat Card 1 -->
        <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-6 sm:p-7 shadow-none hover:border-[#CBD5E1] transition-all">
            <span class="block text-[12.5px] font-semibold text-[#6B7280] uppercase tracking-wider">
                Đang xử lý
            </span>
            <span class="sr-only">ĐANG XỬ LÝ</span>
            <div class="text-[28px] sm:text-[30px] font-bold text-[#111827] mt-2.5 font-mono tracking-tight">
                17
            </div>
            <div class="mt-2 text-[12.5px] text-[#6B7280]">
                Phiếu cần thực hiện
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-6 sm:p-7 shadow-none hover:border-[#CBD5E1] transition-all">
            <span class="block text-[12.5px] font-semibold text-[#6B7280] uppercase tracking-wider">
                Đã giao
            </span>
            <div class="text-[28px] sm:text-[30px] font-bold text-[#111827] mt-2.5 font-mono tracking-tight">
                0
            </div>
            <div class="mt-2 text-[12.5px] text-[#6B7280]">
                Chưa tiếp nhận
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-6 sm:p-7 shadow-none hover:border-[#CBD5E1] transition-all">
            <span class="block text-[12.5px] font-semibold text-[#6B7280] uppercase tracking-wider">
                Chờ nghiệm thu
            </span>
            <div class="text-[28px] sm:text-[30px] font-bold text-[#111827] mt-2.5 font-mono tracking-tight">
                0
            </div>
            <div class="mt-2 text-[12.5px] text-[#6B7280]">
                Đã gửi kết quả
            </div>
        </div>
    </div>

    <!-- Main Card: 17 yêu cầu được phân công -->
    <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-7 sm:p-8 shadow-none">
        <h2 class="text-[16px] font-bold text-[#111827] pb-4 mb-6 border-b border-[#F3F4F6]">
            17 yêu cầu được phân công
        </h2>

        <!-- Responsive Grid of Task Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-5 sm:gap-6">
            <!-- Task 1 -->
            <div class="bg-[#F8FAF8] border border-[#E5E7EB] hover:border-[#B8D5C7] rounded-[14px] p-6 flex flex-col justify-between transition-all">
                <div>
                    <div class="flex items-center justify-between mb-2.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] text-[11.5px] font-semibold bg-[#FFF4DB] text-[#8F5316]">
                            Đang xử lý
                        </span>
                    </div>
                    <div class="font-bold text-[#111827] text-[14px]">
                        #3 · Đèn hành lang tầng 1 không sáng
                    </div>
                    <div class="text-[12.5px] text-[#6B7280] mt-1.5">
                        Căn 0103 · 04/02/2026 09:00
                    </div>
                </div>
                <div class="mt-4 pt-3.5 border-t border-[#E5E7EB]/60">
                    <a href="{{ route('tech.tasks.show', 3) }}" class="inline-flex items-center px-4 py-2 border border-[#E5E7EB] bg-white rounded-[8px] text-[12.5px] font-medium text-[#374151] hover:bg-[#F9FBFA] hover:text-[#0E4D3C] transition-colors shadow-2xs">
                        Mở công việc →
                    </a>
                </div>
            </div>

            <!-- Task 2 -->
            <div class="bg-[#F8FAF8] border border-[#E5E7EB] hover:border-[#B8D5C7] rounded-[14px] p-6 flex flex-col justify-between transition-all">
                <div>
                    <div class="flex items-center justify-between mb-2.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] text-[11.5px] font-semibold bg-[#FFF4DB] text-[#8F5316]">
                            Đang xử lý
                        </span>
                    </div>
                    <div class="font-bold text-[#111827] text-[14px]">
                        #9 · Rò nước hành lang tầng 2
                    </div>
                    <div class="text-[12.5px] text-[#6B7280] mt-1.5">
                        Căn 0204 · 04/02/2026 09:30
                    </div>
                </div>
                <div class="mt-4 pt-3.5 border-t border-[#E5E7EB]/60">
                    <a href="{{ route('tech.tasks.show', 9) }}" class="inline-flex items-center px-4 py-2 border border-[#E5E7EB] bg-white rounded-[8px] text-[12.5px] font-medium text-[#374151] hover:bg-[#F9FBFA] hover:text-[#0E4D3C] transition-colors shadow-2xs">
                        Mở công việc →
                    </a>
                </div>
            </div>

            <!-- Task 3 -->
            <div class="bg-[#F8FAF8] border border-[#E5E7EB] hover:border-[#B8D5C7] rounded-[14px] p-6 flex flex-col justify-between transition-all">
                <div>
                    <div class="flex items-center justify-between mb-2.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] text-[11.5px] font-semibold bg-[#FFF4DB] text-[#8F5316]">
                            Đang xử lý
                        </span>
                    </div>
                    <div class="font-bold text-[#111827] text-[14px]">
                        #15 · Ổ cắm sảnh tầng 2 mất điện
                    </div>
                    <div class="text-[12.5px] text-[#6B7280] mt-1.5">
                        Sảnh Tòa A tầng 2 · 04/02/2026 10:00
                    </div>
                </div>
                <div class="mt-4 pt-3.5 border-t border-[#E5E7EB]/60">
                    <a href="{{ route('tech.tasks.show', 15) }}" class="inline-flex items-center px-4 py-2 border border-[#E5E7EB] bg-white rounded-[8px] text-[12.5px] font-medium text-[#374151] hover:bg-[#F9FBFA] hover:text-[#0E4D3C] transition-colors shadow-2xs">
                        Mở công việc →
                    </a>
                </div>
            </div>

            <!-- Task 4 -->
            <div class="bg-[#F8FAF8] border border-[#E5E7EB] hover:border-[#B8D5C7] rounded-[14px] p-6 flex flex-col justify-between transition-all">
                <div>
                    <div class="flex items-center justify-between mb-2.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] text-[11.5px] font-semibold bg-[#FFF4DB] text-[#8F5316]">
                            Đang xử lý
                        </span>
                    </div>
                    <div class="font-bold text-[#111827] text-[14px]">
                        #21 · Đèn thoát hiểm tầng 3 không sáng
                    </div>
                    <div class="text-[12.5px] text-[#6B7280] mt-1.5">
                        Cầu thang thoát hiểm Tòa A tầng 3 · 04/02/2026 10:30
                    </div>
                </div>
                <div class="mt-4 pt-3.5 border-t border-[#E5E7EB]/60">
                    <a href="{{ route('tech.tasks.show', 21) }}" class="inline-flex items-center px-4 py-2 border border-[#E5E7EB] bg-white rounded-[8px] text-[12.5px] font-medium text-[#374151] hover:bg-[#F9FBFA] hover:text-[#0E4D3C] transition-colors shadow-2xs">
                        Mở công việc →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
