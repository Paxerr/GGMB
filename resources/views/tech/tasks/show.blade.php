@extends('layouts.portal', [
    'title' => 'Chi tiết công việc được giao · GGMB',
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
            Chi tiết công việc
        </h1>
        <span class="sr-only">Chi tiết công việc được giao</span>
        <p class="mt-0.5 text-[13px] text-[#6B7280]">
            #{{ $id ?? 3 }} · Đèn hành lang tầng 1 không sáng
        </p>
    </div>

    <!-- 2 Columns Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Left: Thông tin chi tiết (8 cols) -->
        <div class="lg:col-span-8 bg-white border border-[#E5E7EB] rounded-[16px] p-6 shadow-none">
            <h2 class="text-[15px] font-bold text-[#111827] mb-5">
                Thông tin chi tiết
            </h2>

            <!-- Row 1: Tình trạng & Người gửi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-4">
                <div>
                    <div class="text-[12px] text-[#6B7280]">
                        Tình trạng
                    </div>
                    <div class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] text-[12px] font-semibold bg-[#FFF4DB] text-[#8F5316]">
                            Đang xử lý
                        </span>
                    </div>
                </div>

                <div>
                    <div class="text-[12px] text-[#6B7280]">
                        Người gửi & phân công
                    </div>
                    <div class="text-[13px] font-medium text-[#111827] mt-1">
                        Lê Chi (Căn 0103) · Giao lúc 04/02/2026 09:00
                    </div>
                </div>
            </div>

            <!-- Row 2: Mô tả sự cố -->
            <div class="py-4 border-t border-[#E5E7EB]">
                <div class="text-[12px] text-[#6B7280]">
                    Mô tả
                </div>
                <div class="text-[13.5px] text-[#111827] mt-1">
                    Đèn hành lang tầng 1 không sáng
                </div>
            </div>

            <!-- Row 3 & 4: Form kết quả & File upload -->
            <form action="{{ route('tech.tasks.complete', $id ?? 3) }}" method="POST" enctype="multipart/form-data" class="pt-4 border-t border-[#E5E7EB] space-y-4">
                @csrf
                <div>
                    <label class="block text-[12px] font-medium text-[#374151] mb-1.5">
                        Nội dung kết quả <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="result_content" rows="4" required placeholder="Mô tả công việc đã xử lý, vật tư thay thế nếu có..." class="w-full p-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C]"></textarea>
                </div>

                <div>
                    <label class="block text-[12px] font-medium text-[#374151] mb-1.5">
                        Ảnh / video minh chứng
                    </label>
                    <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] p-4 text-center">
                        <div class="text-[12px] text-[#6B7280] mb-2.5" id="techResultLabel">
                            Chưa chọn tệp · Không bắt buộc
                        </div>
                        <label class="inline-flex items-center px-4 py-1.5 border border-[#E5E7EB] bg-white rounded-[8px] text-[12.5px] font-medium text-[#374151] hover:bg-[#F9FBFA] transition-colors cursor-pointer">
                            <input type="file" name="result_image" class="sr-only" onchange="document.getElementById('techResultLabel').innerText = this.files[0]?.name || 'Chưa chọn tệp · Không bắt buộc'">
                            <span>Chọn tệp</span>
                        </label>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="flex items-center space-x-3 pt-2">
                    <a href="{{ route('tech.tasks') }}" class="px-5 py-2 border border-[#E5E7EB] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[13px] font-medium rounded-[8px] transition-colors">
                        Về bàn việc
                    </a>
                    <button type="submit" class="px-5 py-2 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-medium rounded-[8px] transition-colors cursor-pointer">
                        Gửi kết quả
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
                Ghi rõ kết quả xử lý và vật tư sử dụng (nếu có). Ban quản lý sẽ nghiệm thu sau khi gửi kết quả.
            </p>
        </div>
    </div>
</div>
@endsection
