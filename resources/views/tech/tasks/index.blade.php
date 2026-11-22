@extends('layouts.portal', [
    'title' => 'Bàn việc hiện trường · GGMB',
    'portalType' => 'tech',
    'activeTab' => 'tasks'
])

@section('content')
<div class="space-y-6">
    <!-- Subtitle & Page Heading -->
    <div>
        <div class="text-[12.5px] font-medium text-[#6B7280] mb-1">
            Cổng kỹ thuật / Tòa A
        </div>
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Bàn việc hiện trường
        </h1>
        <p class="mt-0.5 text-[13px] text-[#6B7280]">
            Công việc kỹ thuật được giao cho bạn; không hiển thị yêu cầu ngoài phạm vi phụ trách.
        </p>
    </div>

    <!-- 3 Stat KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Stat Card 1 -->
        <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-5 shadow-none">
            <span class="block text-[13px] font-medium text-[#6B7280]">
                Đang xử lý
            </span>
            <span class="sr-only">ĐANG XỬ LÝ</span>
            <div class="text-[26px] font-bold text-[#111827] mt-1">
                17
            </div>
            <div class="mt-1 text-[12px] text-[#6B7280]">
                Phiếu cần thực hiện
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-5 shadow-none">
            <span class="block text-[13px] font-medium text-[#6B7280]">
                Đã giao
            </span>
            <div class="text-[26px] font-bold text-[#111827] mt-1">
                0
            </div>
            <div class="mt-1 text-[12px] text-[#6B7280]">
                Chưa tiếp nhận
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-5 shadow-none">
            <span class="block text-[13px] font-medium text-[#6B7280]">
                Chờ nghiệm thu
            </span>
            <div class="text-[26px] font-bold text-[#111827] mt-1">
                0
            </div>
            <div class="mt-1 text-[12px] text-[#6B7280]">
                Đã gửi kết quả
            </div>
        </div>
    </div>

    <!-- Main Card: 17 yêu cầu được phân công -->
    <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-6 shadow-none">
        <h2 class="text-[15px] font-bold text-[#111827] mb-5">
            17 yêu cầu được phân công
        </h2>

        <!-- 2-column Grid of Task Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Task 1 -->
            <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[12px] p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] text-[11.5px] font-semibold bg-[#FFF4DB] text-[#8F5316]">
                            Đang xử lý
                        </span>
                    </div>
                    <div class="font-bold text-[#111827] text-[13.5px]">
                        #3 · Đèn hành lang tầng 1 không sáng
                    </div>
                    <div class="text-[12px] text-[#6B7280] mt-1">
                        Căn 0103 · 04/02/2026 09:00
                    </div>
                </div>
                <div class="mt-3.5">
                    <a href="{{ route('tech.tasks.show', 3) }}" class="inline-flex items-center px-3.5 py-1.5 border border-[#E5E7EB] bg-white rounded-[8px] text-[12.5px] font-medium text-[#374151] hover:bg-[#F9FBFA] transition-colors">
                        Mở công việc
                    </a>
                </div>
            </div>

            <!-- Task 2 -->
            <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[12px] p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] text-[11.5px] font-semibold bg-[#FFF4DB] text-[#8F5316]">
                            Đang xử lý
                        </span>
                    </div>
                    <div class="font-bold text-[#111827] text-[13.5px]">
                        #9 · Rò nước hành lang tầng 2
                    </div>
                    <div class="text-[12px] text-[#6B7280] mt-1">
                        Căn 0204 · 04/02/2026 09:30
                    </div>
                </div>
                <div class="mt-3.5">
                    <a href="{{ route('tech.tasks.show', 9) }}" class="inline-flex items-center px-3.5 py-1.5 border border-[#E5E7EB] bg-white rounded-[8px] text-[12.5px] font-medium text-[#374151] hover:bg-[#F9FBFA] transition-colors">
                        Mở công việc
                    </a>
                </div>
            </div>

            <!-- Task 3 -->
            <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[12px] p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] text-[11.5px] font-semibold bg-[#FFF4DB] text-[#8F5316]">
                            Đang xử lý
                        </span>
                    </div>
                    <div class="font-bold text-[#111827] text-[13.5px]">
                        #15 · Ổ cắm sảnh tầng 2 mất điện
                    </div>
                    <div class="text-[12px] text-[#6B7280] mt-1">
                        Sảnh Tòa A tầng 2 · 04/02/2026 10:00
                    </div>
                </div>
                <div class="mt-3.5">
                    <a href="{{ route('tech.tasks.show', 15) }}" class="inline-flex items-center px-3.5 py-1.5 border border-[#E5E7EB] bg-white rounded-[8px] text-[12.5px] font-medium text-[#374151] hover:bg-[#F9FBFA] transition-colors">
                        Mở công việc
                    </a>
                </div>
            </div>

            <!-- Task 4 -->
            <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[12px] p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-[6px] text-[11.5px] font-semibold bg-[#FFF4DB] text-[#8F5316]">
                            Đang xử lý
                        </span>
                    </div>
                    <div class="font-bold text-[#111827] text-[13.5px]">
                        #21 · Đèn thoát hiểm tầng 3 không sáng
                    </div>
                    <div class="text-[12px] text-[#6B7280] mt-1">
                        Cầu thang thoát hiểm Tòa A tầng 3 · 04/02/2026 10:30
                    </div>
                </div>
                <div class="mt-3.5">
                    <a href="{{ route('tech.tasks.show', 21) }}" class="inline-flex items-center px-3.5 py-1.5 border border-[#E5E7EB] bg-white rounded-[8px] text-[12.5px] font-medium text-[#374151] hover:bg-[#F9FBFA] transition-colors">
                        Mở công việc
                    </a>
                </div>
            </div>
        </div>

        <p class="text-[12.5px] text-[#6B7280] mt-6 pt-4 border-t border-[#E5E7EB]">
            Hiển thị các yêu cầu được ban quản lý phân công cho tài khoản tech03.
        </p>
    </div>
</div>
@endsection
