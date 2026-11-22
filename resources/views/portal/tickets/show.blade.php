@extends('layouts.portal', [
    'title' => 'Chi tiết yêu cầu của tôi · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'tickets'
])

@section('content')
<div class="space-y-7">
    <!-- Subtitle & Page Heading -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="text-[12.5px] font-semibold text-[#6B7280] mb-1 flex items-center gap-1.5">
                <a href="{{ route('portal.tickets') }}" class="hover:text-[#0E4D3C] transition-colors">Yêu cầu hỗ trợ</a>
                <span>/</span>
                <span class="text-[#111827]">Chi tiết #{{ $id ?? 1 }}</span>
            </div>
            <h1 class="text-[26px] font-bold text-[#111827] tracking-tight">
                Chi tiết yêu cầu và phản hồi
            </h1>
            <span class="sr-only">Chi tiết yêu cầu của tôi</span>
            <p class="mt-1 text-[13.5px] text-[#6B7280]">
                #{{ $id ?? 1 }} · Không xem được thông báo phí
            </p>
        </div>

        <a href="{{ route('portal.tickets') }}" class="inline-flex items-center gap-1.5 px-4 py-2 border border-[#E5E7EB] bg-white hover:bg-[#F9FBFA] text-[#374151] hover:text-[#0E4D3C] text-[13px] font-semibold rounded-[10px] transition-colors shrink-0">
            <span>← Quay lại danh sách</span>
        </a>
    </div>

    <!-- Modern Segmented Progress Bar -->
    <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-5 sm:p-6 shadow-2xs">
        <div class="flex items-center justify-between mb-3.5">
            <div class="text-[12px] font-bold text-[#6B7280] uppercase tracking-wider">Tiến trình xử lý</div>
            <span class="text-[12px] font-semibold text-[#0E4D3C] bg-[#E4EFE9] px-2.5 py-0.5 rounded-full">
                Bước 2 / 4 · Đang xử lý
            </span>
        </div>

        <!-- 4-Stage Segmented Bar -->
        <div class="grid grid-cols-4 gap-2 mb-3">
            <div class="h-1.5 rounded-full bg-[#0E4D3C]"></div>
            <div class="h-1.5 rounded-full bg-[#0E4D3C]"></div>
            <div class="h-1.5 rounded-full bg-gray-200"></div>
            <div class="h-1.5 rounded-full bg-gray-200"></div>
        </div>

        <div class="grid grid-cols-4 gap-2 text-[12px]">
            <div>
                <div class="font-bold text-[#0E4D3C] flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Tiếp nhận</span>
                </div>
                <div class="text-[11px] text-[#6B7280] mt-0.5">02/02/2026</div>
            </div>
            <div>
                <div class="font-bold text-[#0E4D3C] flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-[#0E4D3C] animate-pulse"></span>
                    <span>Phân công</span>
                </div>
                <div class="text-[11px] text-[#6B7280] mt-0.5">Đang xử lý</div>
            </div>
            <div class="opacity-50">
                <div class="font-medium text-[#6B7280]">Thực hiện</div>
                <div class="text-[11px] text-[#9CA3AF] mt-0.5">Chờ xử lý</div>
            </div>
            <div class="opacity-50">
                <div class="font-medium text-[#6B7280]">Hoàn thành</div>
                <div class="text-[11px] text-[#9CA3AF] mt-0.5">Nghiệm thu</div>
            </div>
        </div>
    </div>

    <!-- Thông tin chi tiết & Form phản hồi -->
    <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-5 sm:p-7 shadow-xs space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-[#F3F4F6]">
            <h2 class="text-[17px] font-bold text-[#111827]">
                Thông tin chi tiết
            </h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-[12px] font-semibold bg-[#E4EFE9] text-[#0E4D3C]">
                Chờ xử lý
            </span>
            <span class="sr-only">Chờ xử lý · Chưa phân công</span>
        </div>

        <!-- Row 1: Tình trạng & Thông tin yêu cầu -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pb-5 border-b border-[#F3F4F6] text-[13px]">
            <div class="p-5 bg-[#F8FAF8] rounded-[12px] border border-[#E5E7EB]/60">
                <div class="text-[11.5px] font-semibold text-[#6B7280] uppercase tracking-wider">Người gửi & Căn hộ</div>
                <div class="font-bold text-[#111827] mt-1 text-[14px]">
                    Nguyễn An · Căn 0101
                </div>
                <div class="text-[12px] text-[#6B7280] mt-0.5">Nhóm: Tài khoản & Hồ sơ</div>
            </div>

            <div class="p-5 bg-[#F8FAF8] rounded-[12px] border border-[#E5E7EB]/60">
                <div class="text-[11.5px] font-semibold text-[#6B7280] uppercase tracking-wider">Thời gian tiếp nhận</div>
                <div class="font-bold text-[#111827] mt-1 text-[14px]">
                    02/02/2026 08:30
                </div>
                <div class="text-[12px] text-amber-700 font-medium mt-0.5">Trạng thái: Chưa phân công</div>
            </div>
        </div>

        <!-- Row 2: Nội dung yêu cầu -->
        <div class="space-y-2">
            <div class="text-[11.5px] font-semibold text-[#6B7280] uppercase tracking-wider">
                Nội dung yêu cầu
            </div>
            <div class="p-5 bg-[#F8FAF8] rounded-[12px] border border-[#E5E7EB] text-[14px] text-[#111827] leading-relaxed">
                Không xem được thông báo phí
            </div>
        </div>

        <!-- Row 3: Form gửi phản hồi -->
        <form action="{{ route('portal.tickets.reply', $id ?? 1) }}" method="POST" class="pt-5 border-t border-[#F3F4F6] space-y-4">
            @csrf
            <div>
                <label class="block text-[13px] font-bold text-[#111827] mb-2">
                    Gửi phản hồi bổ sung cho BQL <span class="text-rose-500">*</span>
                </label>
                <textarea name="reply_content" rows="4" required placeholder="Nhập thêm thông tin, mô tả chi tiết hơn hoặc phản hồi cho kỹ thuật viên..." class="w-full p-3.5 bg-white border border-[#E5E7EB] focus:border-[#0E4D3C] rounded-[10px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none transition-colors shadow-2xs"></textarea>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center space-x-3 pt-2">
                <a href="{{ route('portal.tickets') }}" class="px-5 py-2.5 border border-[#E5E7EB] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[13px] font-semibold rounded-[10px] transition-colors">
                    Về yêu cầu của tôi
                </a>
                <button type="submit" class="px-6 py-2.5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[10px] shadow-xs transition-colors cursor-pointer">
                    Gửi phản hồi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
