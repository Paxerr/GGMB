@extends('layouts.portal', [
    'title' => 'Gửi yêu cầu hỗ trợ · GGMB',
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
            Gửi yêu cầu hỗ trợ
        </h1>
        <p class="mt-0.5 text-[13px] text-[#6B7280]">
            Gửi yêu cầu hỗ trợ; theo dõi tình trạng và trao đổi với ban quản lý.
        </p>
    </div>

    <!-- 2 Columns Layout: Form (Left) & Lưu ý nghiệp vụ (Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Left: Thông tin cần cung cấp (8 cols) -->
        <div class="lg:col-span-8 bg-white border border-[#E5E7EB] rounded-[16px] p-6 shadow-none">
            <h2 class="text-[15px] font-bold text-[#111827] mb-5">
                Thông tin cần cung cấp
            </h2>

            <form action="{{ route('portal.tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <!-- Row 1: 2 cols Tiêu đề & Loại yêu cầu -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[12px] font-medium text-[#374151] mb-1.5">
                            Tiêu đề <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="title" value="Đèn trong căn hộ bị hỏng" required class="w-full h-[38px] px-3.5 bg-white border border-[#E5E7EB] rounded-[8px] text-[13px] text-[#111827] focus:outline-none focus:border-[#0E4D3C]">
                    </div>
                    <div>
                        <label class="block text-[12px] font-medium text-[#374151] mb-1.5">
                            Loại yêu cầu <span class="text-rose-500">*</span>
                        </label>
                        <select name="category" class="w-full h-[38px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] cursor-pointer">
                            <option value="TECHNICAL" selected>Kỹ thuật</option>
                            <option value="ACCOUNT">Tài khoản</option>
                            <option value="VEHICLE">Phương tiện</option>
                            <option value="INVOICE">Hóa đơn</option>
                            <option value="FEEDBACK">Phản ánh</option>
                            <option value="OTHER">Khác</option>
                        </select>
                    </div>
                </div>

                <!-- Row 2: Căn hộ -->
                <div>
                    <label class="block text-[12px] font-medium text-[#374151] mb-1.5">
                        Căn hộ <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" value="Căn 0101 · thuộc hồ sơ của bạn" readonly class="w-full h-[38px] px-3.5 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[13px] text-[#6B7280] select-none cursor-not-allowed">
                </div>

                <!-- Row 3: Mô tả sự cố -->
                <div>
                    <label class="block text-[12px] font-medium text-[#374151] mb-1.5">
                        Mô tả sự cố <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="description" rows="4" placeholder="Nhập vị trí và hiện tượng cần kiểm tra" class="w-full p-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C]"></textarea>
                </div>

                <!-- Row 4: Ảnh / video minh chứng -->
                <div>
                    <label class="block text-[12px] font-medium text-[#374151] mb-1.5">
                        Ảnh / video minh chứng
                    </label>
                    <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] p-4 text-center">
                        <div class="text-[12px] text-[#6B7280] mb-2.5" id="ticketFileLabel">
                            Chưa chọn tệp · Không bắt buộc
                        </div>
                        <label class="inline-flex items-center px-4 py-1.5 border border-[#E5E7EB] bg-white rounded-[8px] text-[12.5px] font-medium text-[#374151] hover:bg-[#F9FBFA] transition-colors cursor-pointer">
                            <input type="file" name="attachment" class="sr-only" onchange="document.getElementById('ticketFileLabel').innerText = this.files[0]?.name || 'Chưa chọn tệp · Không bắt buộc'">
                            <span>Chọn tệp</span>
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-3 pt-2">
                    <a href="{{ route('portal.dashboard') }}" class="px-5 py-2 border border-[#E5E7EB] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[13px] font-medium rounded-[8px] transition-colors">
                        Hủy
                    </a>
                    <button type="submit" class="px-5 py-2 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-medium rounded-[8px] transition-colors cursor-pointer">
                        Gửi yêu cầu
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
                Người gửi: Nguyễn An. Tạo thành công ở trạng thái Chờ xử lý.
            </p>
            <p class="leading-relaxed">
                Yêu cầu của tôi: #1 Không xem được thông báo phí; #31 Đề nghị cập nhật email liên hệ; #61 Đề nghị cập nhật số điện thoại; #91 Sai họ tên trong hồ sơ cư dân.
            </p>
            <p class="leading-relaxed">
                Cả 4 yêu cầu đang Chờ xử lý, chưa phân công. Chỉ xem và phản hồi yêu cầu do bạn gửi.
            </p>
        </div>
    </div>

    <!-- Bottom Card: Theo dõi yêu cầu của tôi -->
    <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-6 shadow-none">
        <h2 class="text-[15px] font-bold text-[#111827] mb-4">
            Theo dõi yêu cầu của tôi
        </h2>
        <span class="sr-only">THEO DÕI YÊU CẦU CỦA TÔI</span>

        <!-- 2x2 Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Card 1 -->
            <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[12px] p-4.5">
                <div class="font-bold text-[#111827] text-[13.5px]">
                    #1 · Không xem được thông báo phí
                </div>
                <div class="text-[12px] text-[#6B7280] mt-1">
                    02/02/2026 · Căn 0101 · Chờ xử lý
                </div>
                <div class="mt-3">
                    <a href="{{ route('portal.tickets.show', 1) }}" class="inline-flex items-center px-3.5 py-1.5 border border-[#E5E7EB] bg-white rounded-[8px] text-[12.5px] font-medium text-[#374151] hover:bg-[#F9FBFA] transition-colors">
                        Xem và phản hồi
                    </a>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[12px] p-4.5">
                <div class="font-bold text-[#111827] text-[13.5px]">
                    #31 · Đề nghị cập nhật email liên hệ
                </div>
                <div class="text-[12px] text-[#6B7280] mt-1">
                    05/02/2026 · Căn 0101 · Chờ xử lý
                </div>
                <div class="mt-3">
                    <a href="{{ route('portal.tickets.show', 31) }}" class="inline-flex items-center px-3.5 py-1.5 border border-[#E5E7EB] bg-white rounded-[8px] text-[12.5px] font-medium text-[#374151] hover:bg-[#F9FBFA] transition-colors">
                        Xem và phản hồi
                    </a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[12px] p-4.5">
                <div class="font-bold text-[#111827] text-[13.5px]">
                    #61 · Đề nghị cập nhật số điện thoại
                </div>
                <div class="text-[12px] text-[#6B7280] mt-1">
                    08/02/2026 · Căn 0101 · Chờ xử lý
                </div>
                <div class="mt-3">
                    <a href="{{ route('portal.tickets.show', 61) }}" class="inline-flex items-center px-3.5 py-1.5 border border-[#E5E7EB] bg-white rounded-[8px] text-[12.5px] font-medium text-[#374151] hover:bg-[#F9FBFA] transition-colors">
                        Xem và phản hồi
                    </a>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[12px] p-4.5">
                <div class="font-bold text-[#111827] text-[13.5px]">
                    #91 · Sai họ tên trong hồ sơ cư dân
                </div>
                <div class="text-[12px] text-[#6B7280] mt-1">
                    11/02/2026 · Căn 0101 · Chờ xử lý
                </div>
                <div class="mt-3">
                    <a href="{{ route('portal.tickets.show', 91) }}" class="inline-flex items-center px-3.5 py-1.5 border border-[#E5E7EB] bg-white rounded-[8px] text-[12.5px] font-medium text-[#374151] hover:bg-[#F9FBFA] transition-colors">
                        Xem và phản hồi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
