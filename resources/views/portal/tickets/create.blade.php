@extends('layouts.portal', [
    'title' => 'Gửi yêu cầu hỗ trợ · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'tickets'
])

@section('content')
<div class="space-y-7">
    <!-- Header Title & Subtitle -->
    <div>
        <div class="text-[12.5px] font-semibold text-[#6B7280] mb-1 flex items-center gap-1.5">
            <span>Cổng cư dân</span>
            <span>/</span>
            <span class="text-[#111827]">Tòa A</span>
        </div>
        <h1 class="text-[26px] font-bold text-[#111827] tracking-tight">
            Gửi yêu cầu hỗ trợ
        </h1>
        <p class="mt-1 text-[13.5px] text-[#6B7280]">
            Gửi yêu cầu hỗ trợ; theo dõi tình trạng và trao đổi với ban quản lý.
        </p>
    </div>

    <!-- Form Card: Thông tin cần cung cấp -->
    <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-5 sm:p-7 shadow-xs">
            <div class="flex items-center justify-between pb-5 border-b border-[#F3F4F6] mb-6">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-[8px] bg-[#E4EFE9] text-[#0E4D3C] flex items-center justify-center font-bold">
                        <svg class="w-4 h-4 text-[#0E4D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <h2 class="text-[16px] font-bold text-[#111827]">
                        Thông tin cần cung cấp
                    </h2>
                </div>
                <span class="text-[12px] text-[#6B7280]">Các mục gắn <span class="text-rose-500 font-bold">*</span> là bắt buộc</span>
            </div>

            <form action="{{ route('portal.tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <!-- Row 1: Tiêu đề & Loại yêu cầu -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">
                            Tiêu đề yêu cầu <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="title" value="Đèn trong căn hộ bị hỏng" required class="w-full h-[40px] px-3.5 bg-white border border-[#E5E7EB] focus:border-[#0E4D3C] rounded-[10px] text-[13.5px] text-[#111827] focus:outline-none transition-colors shadow-2xs">
                    </div>
                    <div>
                        <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">
                            Nhóm nghiệp vụ <span class="text-rose-500">*</span>
                        </label>
                        <select name="category" class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] focus:border-[#0E4D3C] rounded-[10px] text-[13.5px] text-[#111827] focus:outline-none transition-colors shadow-2xs cursor-pointer">
                            <option value="TECHNICAL" selected>Kỹ thuật & Sửa chữa</option>
                            <option value="ACCOUNT">Tài khoản & Hồ sơ</option>
                            <option value="VEHICLE">Phương tiện & Thẻ xe</option>
                            <option value="INVOICE">Hóa đơn & Biểu phí</option>
                            <option value="FEEDBACK">Phản ánh dịch vụ</option>
                            <option value="OTHER">Vấn đề khác</option>
                        </select>
                    </div>
                </div>

                <!-- Row 2: Căn hộ -->
                <div>
                    <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">
                        Căn hộ phát sinh sự cố <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" value="Căn 0101 · thuộc hồ sơ của bạn" readonly class="w-full h-[40px] px-3.5 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[10px] text-[13px] text-[#6B7280] select-none cursor-not-allowed font-medium">
                        <div class="absolute right-3.5 top-2.5 text-[#0E4D3C] text-[12px] font-semibold flex items-center gap-1">
                            <span>✓ Đã xác thực</span>
                        </div>
                    </div>
                </div>

                <!-- Row 3: Mô tả sự cố -->
                <div>
                    <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">
                        Mô tả chi tiết sự cố <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="description" rows="4" placeholder="Nhập vị trí và hiện tượng cần kiểm tra (ví dụ: đèn chùm phòng khách nhấp nháy, vòi sen rò rỉ nước...)" class="w-full p-3.5 bg-white border border-[#E5E7EB] focus:border-[#0E4D3C] rounded-[10px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none transition-colors shadow-2xs"></textarea>
                </div>

                <!-- Row 4: Ảnh / video minh chứng -->
                <div>
                    <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">
                        Ảnh / video minh chứng (tùy chọn)
                    </label>
                    <div class="bg-[#F8FAF8] border-2 border-dashed border-[#E5E7EB] hover:border-[#0E4D3C] rounded-[12px] p-5 text-center transition-colors">
                        <div class="text-[13px] text-[#6B7280] mb-2.5" id="ticketFileLabel">
                            Kéo thả tệp hoặc bấm nút để chọn ảnh sự cố · Không bắt buộc
                        </div>
                        <label class="inline-flex items-center gap-2 px-4 py-2 border border-[#E5E7EB] bg-white rounded-[8px] text-[13px] font-semibold text-[#374151] hover:text-[#0E4D3C] hover:bg-[#F9FBFA] transition-colors cursor-pointer shadow-2xs">
                            <svg class="w-4 h-4 text-[#0E4D3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            <input type="file" name="attachment" class="sr-only" onchange="document.getElementById('ticketFileLabel').innerText = this.files[0]?.name || 'Chưa chọn tệp · Không bắt buộc'">
                            <span>Chọn tệp từ máy</span>
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-3 pt-3 border-t border-[#F3F4F6]">
                    <a href="{{ route('portal.dashboard') }}" class="px-5 py-2.5 border border-[#E5E7EB] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[13px] font-semibold rounded-[10px] transition-colors">
                        Hủy
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[10px] shadow-xs transition-colors cursor-pointer">
                        Gửi yêu cầu
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bottom Card: Theo dõi yêu cầu của tôi -->
    <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-7 shadow-xs">
        <div class="flex items-center justify-between pb-5 border-b border-[#F3F4F6] mb-5">
            <div>
                <h2 class="text-[17px] font-bold text-[#111827] tracking-tight">
                    Theo dõi yêu cầu của tôi
                </h2>
                <span class="sr-only">THEO DÕI YÊU CẦU CỦA TÔI</span>
                <p class="text-[13px] text-[#6B7280] mt-0.5">Danh sách các yêu cầu đang được BQL tiếp nhận và xử lý</p>
            </div>
            <span class="text-[12px] font-semibold text-[#0E4D3C] bg-[#E4EFE9] px-3 py-1 rounded-[6px]">
                4 yêu cầu
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <!-- Ticket 1 -->
            <a href="{{ route('portal.tickets.show', 1) }}" class="p-5 rounded-[14px] bg-[#F8FAF8] hover:bg-[#E4EFE9]/30 border border-[#E5E7EB] hover:border-[#B8D5C7] transition-all group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between text-[12px] mb-2">
                        <span class="font-mono font-bold text-[#0E4D3C]">#1</span>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-[#E4EFE9] text-[#0E4D3C]">Chờ xử lý</span>
                    </div>
                    <h3 class="font-bold text-[13.5px] text-[#111827] group-hover:text-[#0E4D3C] transition-colors line-clamp-2">
                        Không xem được thông báo phí
                    </h3>
                    <p class="text-[12px] text-[#6B7280] mt-1">
                        Căn 0101 · Nhóm Tài khoản
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-[#E5E7EB]/70 flex items-center justify-between text-[11.5px] text-[#6B7280]">
                    <span>02/02/2026</span>
                    <span class="font-medium text-[#0E4D3C] group-hover:underline">Chi tiết →</span>
                </div>
            </a>

            <!-- Ticket 31 -->
            <a href="{{ route('portal.tickets.show', 1) }}" class="p-5 rounded-[14px] bg-[#F8FAF8] hover:bg-[#E4EFE9]/30 border border-[#E5E7EB] hover:border-[#B8D5C7] transition-all group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between text-[12px] mb-2">
                        <span class="font-mono font-bold text-[#0E4D3C]">#31</span>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-[#E4EFE9] text-[#0E4D3C]">Chờ xử lý</span>
                    </div>
                    <h3 class="font-bold text-[13.5px] text-[#111827] group-hover:text-[#0E4D3C] transition-colors line-clamp-2">
                        Đề nghị cập nhật email liên hệ
                    </h3>
                    <p class="text-[12px] text-[#6B7280] mt-1">
                        Căn 0101 · Nhóm Tài khoản
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-[#E5E7EB]/70 flex items-center justify-between text-[11.5px] text-[#6B7280]">
                    <span>10/02/2026</span>
                    <span class="font-medium text-[#0E4D3C] group-hover:underline">Chi tiết →</span>
                </div>
            </a>

            <!-- Ticket 61 -->
            <a href="{{ route('portal.tickets.show', 1) }}" class="p-5 rounded-[14px] bg-[#F8FAF8] hover:bg-[#E4EFE9]/30 border border-[#E5E7EB] hover:border-[#B8D5C7] transition-all group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between text-[12px] mb-2">
                        <span class="font-mono font-bold text-[#0E4D3C]">#61</span>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-[#E4EFE9] text-[#0E4D3C]">Chờ xử lý</span>
                    </div>
                    <h3 class="font-bold text-[13.5px] text-[#111827] group-hover:text-[#0E4D3C] transition-colors line-clamp-2">
                        Đề nghị cập nhật số điện thoại
                    </h3>
                    <p class="text-[12px] text-[#6B7280] mt-1">
                        Căn 0101 · Nhóm Tài khoản
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-[#E5E7EB]/70 flex items-center justify-between text-[11.5px] text-[#6B7280]">
                    <span>18/02/2026</span>
                    <span class="font-medium text-[#0E4D3C] group-hover:underline">Chi tiết →</span>
                </div>
            </a>

            <!-- Ticket 91 -->
            <a href="{{ route('portal.tickets.show', 1) }}" class="p-5 rounded-[14px] bg-[#F8FAF8] hover:bg-[#E4EFE9]/30 border border-[#E5E7EB] hover:border-[#B8D5C7] transition-all group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between text-[12px] mb-2">
                        <span class="font-mono font-bold text-[#0E4D3C]">#91</span>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-[#E4EFE9] text-[#0E4D3C]">Chờ xử lý</span>
                    </div>
                    <h3 class="font-bold text-[13.5px] text-[#111827] group-hover:text-[#0E4D3C] transition-colors line-clamp-2">
                        Sai họ tên trong hồ sơ cư dân
                    </h3>
                    <p class="text-[12px] text-[#6B7280] mt-1">
                        Căn 0101 · Nhóm Cư dân
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-[#E5E7EB]/70 flex items-center justify-between text-[11.5px] text-[#6B7280]">
                    <span>25/02/2026</span>
                    <span class="font-medium text-[#0E4D3C] group-hover:underline">Chi tiết →</span>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
