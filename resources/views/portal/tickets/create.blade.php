@extends('layouts.portal', [
    'title' => 'Gửi yêu cầu hỗ trợ · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'tickets'
])

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-[26px] font-semibold text-[#122d40] leading-tight">
            Gửi yêu cầu hỗ trợ
        </h1>
        <p class="mt-1 text-[14px] text-[#52697c]">
            Gửi yêu cầu hỗ trợ; theo dõi tình trạng và trao đổi với ban quản lý.
        </p>
    </div>

    <!-- 2 Columns Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Left: Form Tạo Yêu Cầu (7 cols) -->
        <div class="lg:col-span-7 bg-white border border-[#d9e4ec] rounded-[4px] p-6 shadow-sm space-y-6">
            <div>
                <h2 class="text-[14px] font-semibold text-[#122d40] uppercase tracking-wide">
                    THÔNG TIN YÊU CẦU
                </h2>
            </div>

            <form action="{{ route('portal.tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <!-- Tiêu đề -->
                <div>
                    <label class="block text-[13px] font-medium text-[#334b5d] mb-1.5">
                        Tiêu đề <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" value="Đèn trong căn hộ bị hỏng" required class="w-full h-[40px] px-3.5 bg-white border border-[#d9e4ec] rounded-[4px] text-[14px] text-[#122d40] focus:outline-none focus:border-[#2864ad]">
                </div>

                <!-- Grid 2 cols: Loại yêu cầu & Căn hộ -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[13px] font-medium text-[#334b5d] mb-1.5">
                            Loại yêu cầu <span class="text-rose-500">*</span>
                        </label>
                        <select name="category" class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[14px] text-[#122d40] focus:outline-none focus:border-[#2864ad]">
                            <option value="TECHNICAL" selected>Kỹ thuật</option>
                            <option value="ACCOUNT">Tài khoản</option>
                            <option value="VEHICLE">Phương tiện</option>
                            <option value="INVOICE">Hóa đơn</option>
                            <option value="FEEDBACK">Phản ánh</option>
                            <option value="OTHER">Khác</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-[#334b5d] mb-1.5">
                            Căn hộ <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" value="Căn 0101 · thuộc hồ sơ của bạn" readonly class="w-full h-[40px] px-3.5 bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#52697c] select-none cursor-not-allowed">
                    </div>
                </div>

                <div class="text-[12px] text-[#52697c]">
                    Phân loại hỗ trợ: Tài khoản / Phương tiện / Kỹ thuật / Hóa đơn / Phản ánh / Khác
                </div>

                <!-- Mô tả sự cố -->
                <div>
                    <label class="block text-[13px] font-medium text-[#334b5d] mb-1.5">
                        Mô tả sự cố <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="description" rows="4" placeholder="Nhập vị trí và mô tả hiện tượng cần kiểm tra..." class="w-full p-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[14px] text-[#122d40] placeholder-[#94a3b8] focus:outline-none focus:border-[#2864ad]"></textarea>
                </div>

                <!-- File đính kèm -->
                <div>
                    <label class="block text-[13px] font-medium text-[#334b5d] mb-1.5">
                        Ảnh / video minh chứng · không bắt buộc
                    </label>
                    <label class="relative block w-full border border-dashed border-[#d9e4ec] bg-[#f8fafc] hover:bg-slate-50 transition-colors rounded-[4px] p-6 text-center cursor-pointer">
                        <input type="file" name="attachment" class="sr-only" onchange="document.getElementById('fileNameSpan').innerText = this.files[0]?.name || 'Chưa chọn tệp'">
                        <div class="text-[13px] font-medium text-[#2864ad]">
                            Ảnh minh chứng · chọn tệp
                        </div>
                        <div class="text-[12px] text-[#52697c] mt-1" id="fileNameSpan">
                            Chưa chọn tệp
                        </div>
                    </label>
                </div>

                <!-- Người gửi -->
                <div class="text-[13px] text-[#52697c]">
                    Người gửi: <span class="font-medium text-[#122d40]">Nguyễn An</span>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-3 pt-2">
                    <button type="submit" class="h-[40px] px-6 bg-[#2864AD] hover:bg-[#1e4d87] text-white font-medium text-[14px] rounded-[4px] transition-colors cursor-pointer shadow-sm">
                        Gửi yêu cầu
                    </button>
                    <a href="{{ route('portal.dashboard') }}" class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-slate-50 text-[#334b5d] font-medium text-[14px] rounded-[4px] flex items-center transition-colors">
                        Hủy
                    </a>
                </div>
            </form>
        </div>

        <!-- Right: Danh sách yêu cầu đã gửi (5 cols) -->
        <div class="lg:col-span-5 space-y-4">
            <div>
                <h2 class="text-[14px] font-semibold text-[#122d40] uppercase tracking-wide">
                    THEO DÕI YÊU CẦU CỦA TÔI
                </h2>
            </div>

            <div class="space-y-3">
                <!-- Card 1 -->
                <a href="{{ route('portal.tickets.show', 1) }}" class="block bg-white border border-[#d9e4ec] hover:border-[#2864ad] rounded-[4px] p-4 shadow-sm transition-all group">
                    <div class="font-semibold text-[#122d40] text-[14px] group-hover:text-[#2864ad]">
                        #1 · Không xem được thông báo phí
                    </div>
                    <div class="text-[13px] text-[#52697c] mt-1">
                        Chờ xử lý · Tài khoản · Chưa phân công
                    </div>
                    <div class="text-[12px] text-[#94a3b8] mt-2">
                        02/02/2026 08:30 · Căn 0101
                    </div>
                </a>

                <!-- Card 2 -->
                <a href="{{ route('portal.tickets.show', 31) }}" class="block bg-white border border-[#d9e4ec] hover:border-[#2864ad] rounded-[4px] p-4 shadow-sm transition-all group">
                    <div class="font-semibold text-[#122d40] text-[14px] group-hover:text-[#2864ad]">
                        #31 · Đề nghị cập nhật email liên hệ
                    </div>
                    <div class="text-[13px] text-[#52697c] mt-1">
                        Chờ xử lý · Tài khoản · Chưa phân công
                    </div>
                    <div class="text-[12px] text-[#94a3b8] mt-2">
                        05/02/2026 08:30 · Căn 0101
                    </div>
                </a>

                <!-- Card 3 -->
                <a href="{{ route('portal.tickets.show', 61) }}" class="block bg-white border border-[#d9e4ec] hover:border-[#2864ad] rounded-[4px] p-4 shadow-sm transition-all group">
                    <div class="font-semibold text-[#122d40] text-[14px] group-hover:text-[#2864ad]">
                        #61 · Đề nghị cập nhật số điện thoại
                    </div>
                    <div class="text-[13px] text-[#52697c] mt-1">
                        Chờ xử lý · Tài khoản · Chưa phân công
                    </div>
                    <div class="text-[12px] text-[#94a3b8] mt-2">
                        08/02/2026 08:30 · Căn 0101
                    </div>
                </a>

                <!-- Card 4 -->
                <a href="{{ route('portal.tickets.show', 91) }}" class="block bg-white border border-[#d9e4ec] hover:border-[#2864ad] rounded-[4px] p-4 shadow-sm transition-all group">
                    <div class="font-semibold text-[#122d40] text-[14px] group-hover:text-[#2864ad]">
                        #91 · Sai họ tên trong hồ sơ cư dân
                    </div>
                    <div class="text-[13px] text-[#52697c] mt-1">
                        Chờ xử lý · Tài khoản · Chưa phân công
                    </div>
                    <div class="text-[12px] text-[#94a3b8] mt-2">
                        11/02/2026 08:30 · Căn 0101
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
