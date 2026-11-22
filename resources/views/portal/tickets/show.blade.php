@extends('layouts.portal', [
    'title' => 'Chi tiết yêu cầu của tôi · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'tickets'
])

@section('content')
<div class="space-y-6">
    <!-- Subtitle & Page Heading -->
    <div>
        <div class="text-[12.5px] font-medium text-[#6B7280] mb-1">
            Cổng cư dân / Tòa A
        </div>
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Chi tiết yêu cầu và phản hồi
        </h1>
        <span class="sr-only">Chi tiết yêu cầu của tôi</span>
        <p class="mt-0.5 text-[13px] text-[#6B7280]">
            #{{ $id ?? 1 }} · Không xem được thông báo phí
        </p>
    </div>

    <!-- 2 Columns Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Left: Thông tin chi tiết (8 cols) -->
        <div class="lg:col-span-8 bg-white border border-[#E5E7EB] rounded-[16px] p-6 shadow-none">
            <h2 class="text-[15px] font-bold text-[#111827] mb-5">
                Thông tin chi tiết
            </h2>

            <!-- Row 1: Tình trạng & Thông tin yêu cầu -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-4">
                <div>
                    <div class="text-[12px] text-[#6B7280]">
                        Tình trạng
                    </div>
                    <div class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] text-[12px] font-semibold bg-[#E4EFE9] text-[#0E4D3C]">
                            Chờ xử lý
                        </span>
                        <span class="sr-only">Chờ xử lý · Chưa phân công</span>
                    </div>
                </div>

                <div>
                    <div class="text-[12px] text-[#6B7280]">
                        Thông tin yêu cầu
                    </div>
                    <div class="text-[13px] font-medium text-[#111827] mt-1">
                        Nguyễn An · Căn 0101 · Nhóm Tài khoản
                    </div>
                    <div class="text-[12px] text-[#6B7280] mt-0.5">
                        Tạo lúc 02/02/2026 08:30
                    </div>
                </div>
            </div>

            <!-- Row 2: Nội dung -->
            <div class="py-4 border-t border-[#E5E7EB]">
                <div class="text-[12px] text-[#6B7280]">
                    Nội dung
                </div>
                <div class="text-[13.5px] text-[#111827] mt-1">
                    Không xem được thông báo phí
                </div>
            </div>

            <!-- Row 3: Form gửi phản hồi -->
            <form action="{{ route('portal.tickets.reply', $id ?? 1) }}" method="POST" class="pt-4 border-t border-[#E5E7EB] space-y-4">
                @csrf
                <div>
                    <label class="block text-[12px] font-medium text-[#374151] mb-1.5">
                        Nội dung phản hồi <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="reply_content" rows="4" required placeholder="Nhập thông tin bổ sung cho yêu cầu" class="w-full p-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C]"></textarea>
                </div>

                <!-- Action buttons -->
                <div class="flex items-center space-x-3 pt-2">
                    <a href="{{ route('portal.tickets') }}" class="px-5 py-2 border border-[#E5E7EB] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[13px] font-medium rounded-[8px] transition-colors">
                        Về yêu cầu của tôi
                    </a>
                    <button type="submit" class="px-5 py-2 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-medium rounded-[8px] transition-colors cursor-pointer">
                        Gửi phản hồi
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
                Yêu cầu đang chờ bộ phận tiếp nhận; thông tin phân công sẽ xuất hiện khi được cập nhật.
            </p>
            <p class="leading-relaxed">
                Chỉnh sửa trước khi phân công →
            </p>
            <p class="leading-relaxed">
                Sau khi phân công, gửi bổ sung bằng phản hồi.
            </p>
        </div>
    </div>
</div>
@endsection
