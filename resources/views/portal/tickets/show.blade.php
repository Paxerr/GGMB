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

    <!-- Progress Status Stepper -->
    <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-6 shadow-xs">
        <div class="text-[12.5px] font-semibold text-[#6B7280] uppercase tracking-wider mb-4">Tiến trình xử lý</div>
        <div class="grid grid-cols-4 gap-2 text-center text-xs">
            <div class="space-y-1.5">
                <div class="w-8 h-8 mx-auto rounded-full bg-[#0E4D3C] text-white flex items-center justify-center font-bold text-xs shadow-2xs">✓</div>
                <div class="font-bold text-[#0E4D3C]">Tiếp nhận</div>
                <div class="text-[11px] text-[#6B7280]">02/02/2026</div>
            </div>
            <div class="space-y-1.5">
                <div class="w-8 h-8 mx-auto rounded-full bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-xs">2</div>
                <div class="font-bold text-amber-800">Phân công</div>
                <div class="text-[11px] text-[#6B7280]">Đang xử lý</div>
            </div>
            <div class="space-y-1.5 opacity-40">
                <div class="w-8 h-8 mx-auto rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-bold text-xs">3</div>
                <div class="font-medium text-gray-600">Thực hiện</div>
                <div class="text-[11px] text-[#9CA3AF]">Chờ kiểm tra</div>
            </div>
            <div class="space-y-1.5 opacity-40">
                <div class="w-8 h-8 mx-auto rounded-full bg-gray-200 text-gray-600 flex items-center justify-center font-bold text-xs">4</div>
                <div class="font-medium text-gray-600">Hoàn thành</div>
                <div class="text-[11px] text-[#9CA3AF]">Nghiệm thu</div>
            </div>
        </div>
    </div>

    <!-- 2 Columns Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 items-start">
        <!-- Left: Thông tin chi tiết & Form phản hồi (8 cols) -->
        <div class="lg:col-span-8 bg-white border border-[#E5E7EB] rounded-[18px] p-7 sm:p-8 shadow-xs space-y-6">
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
                <div class="p-3.5 bg-[#F8FAF8] rounded-[12px] border border-[#E5E7EB]/60">
                    <div class="text-[12px] text-[#6B7280] font-medium">Người gửi & Căn hộ</div>
                    <div class="font-bold text-[#111827] mt-1 text-[14px]">
                        Nguyễn An · Căn 0101
                    </div>
                    <div class="text-[12px] text-[#6B7280] mt-0.5">Nhóm: Tài khoản & Hồ sơ</div>
                </div>

                <div class="p-3.5 bg-[#F8FAF8] rounded-[12px] border border-[#E5E7EB]/60">
                    <div class="text-[12px] text-[#6B7280] font-medium">Thời gian tạo</div>
                    <div class="font-bold text-[#111827] mt-1 text-[14px]">
                        02/02/2026 08:30
                    </div>
                    <div class="text-[12px] text-amber-700 font-medium mt-0.5">Trạng thái: Chưa phân công</div>
                </div>
            </div>

            <!-- Row 2: Nội dung yêu cầu -->
            <div class="space-y-2">
                <div class="text-[12px] font-bold text-[#6B7280] uppercase tracking-wider">
                    Nội dung yêu cầu
                </div>
                <div class="p-4 bg-[#F8FAF8] rounded-[12px] border border-[#E5E7EB] text-[14px] text-[#111827] leading-relaxed">
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

        <!-- Right: Lưu ý nghiệp vụ (4 cols) -->
        <div class="lg:col-span-4 bg-white border border-[#E5E7EB] rounded-[18px] p-6 shadow-xs text-[13px] text-[#4B5563] space-y-4">
            <h3 class="font-bold text-[#111827] text-[15px] pb-3 border-b border-[#F3F4F6] flex items-center gap-2">
                <span>ℹ️</span>
                <span>Lưu ý nghiệp vụ</span>
            </h3>
            <p class="leading-relaxed">
                Yêu cầu đang chờ bộ phận tiếp nhận; thông tin phân công sẽ xuất hiện khi được cập nhật.
            </p>
            <div class="p-3 bg-[#F8FAF8] rounded-[10px] border border-[#E5E7EB] text-[12.5px] text-[#6B7280]">
                Chỉnh sửa trước khi phân công →
            </div>
            <p class="leading-relaxed text-[12.5px] text-[#6B7280]">
                Mọi phản hồi tại đây sẽ được thông báo trực tiếp đến Kỹ thuật viên phụ trách tòa nhà.
            </p>
        </div>
    </div>
</div>
@endsection
