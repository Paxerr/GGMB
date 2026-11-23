@extends('layouts.portal', [
    'title' => 'Chi tiết công việc được giao · GGMB',
    'portalType' => 'tech',
    'activeTab' => 'tasks'
])

@section('content')
<div class="space-y-8 sm:space-y-10">
    <!-- Subtitle & Page Heading -->
    <div>
        <div class="text-[12.5px] font-semibold text-[#6B7280] mb-1.5 flex items-center gap-1.5">
            <a href="{{ route('tech.tasks') }}" class="hover:text-[#0E4D3C] transition-colors">Bàn việc</a>
            <span>/</span>
            <span class="text-[#111827]">Chi tiết công việc</span>
        </div>
        <h1 class="text-[26px] font-bold text-[#111827] tracking-tight">
            Chi tiết công việc
        </h1>
        <span class="sr-only">Chi tiết công việc được giao</span>
        <p class="mt-1.5 text-[13.5px] text-[#6B7280]">
            #{{ $id ?? 3 }} · Đèn hành lang tầng 1 không sáng
        </p>
    </div>

    <!-- Thông tin chi tiết -->
    <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-7 sm:p-9 shadow-none space-y-7">
        <h2 class="text-[17px] font-bold text-[#111827] pb-5 mb-6 border-b border-[#F3F4F6]">
            Thông tin chi tiết
        </h2>

        <!-- Row 1: Tình trạng & Người gửi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6 border-b border-[#F3F4F6]">
            <div>
                <div class="text-[12px] font-semibold text-[#6B7280] uppercase tracking-wider">
                    Tình trạng
                </div>
                <div class="mt-1.5">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-[6px] text-[12px] font-semibold bg-[#FFF4DB] text-[#8F5316]">
                        Đang xử lý
                    </span>
                </div>
            </div>

            <div>
                <div class="text-[12px] font-semibold text-[#6B7280] uppercase tracking-wider">
                    Người gửi & phân công
                </div>
                <div class="text-[13.5px] font-medium text-[#111827] mt-1.5">
                    Lê Chi (Căn 0103) · Giao lúc 04/02/2026 09:00
                </div>
            </div>
        </div>

        <!-- Row 2: Mô tả sự cố -->
        <div class="py-6 border-b border-[#F3F4F6]">
            <div class="text-[12px] font-semibold text-[#6B7280] uppercase tracking-wider">
                Mô tả
            </div>
            <div class="text-[14px] text-[#111827] mt-1.5">
                Đèn hành lang tầng 1 không sáng
            </div>
        </div>

        <!-- Row 3 & 4: Form kết quả & File upload -->
        <form action="{{ route('tech.tasks.complete', $id ?? 3) }}" method="POST" enctype="multipart/form-data" class="pt-6 space-y-6">
            @csrf
            <input type="hidden" name="status" value="RESOLVED">
            <div>
                <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">
                    Nội dung kết quả <span class="text-rose-500">*</span>
                </label>
                <textarea name="content" rows="4" required placeholder="Mô tả công việc đã xử lý, vật tư thay thế nếu có..." class="w-full p-3.5 bg-white border border-[#E5E7EB] rounded-[10px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C]"></textarea>
            </div>

            <div>
                <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">
                    Ảnh / video minh chứng
                </label>
                <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[12px] p-5 text-center">
                    <div class="text-[12.5px] text-[#6B7280] mb-2.5" id="techResultLabel">
                        Chưa chọn tệp · Không bắt buộc
                    </div>
                    <label class="inline-flex items-center px-4 py-2 border border-[#E5E7EB] bg-white rounded-[8px] text-[12.5px] font-medium text-[#374151] hover:bg-[#F9FBFA] hover:text-[#0E4D3C] transition-colors cursor-pointer shadow-2xs">
                        <input type="file" name="result_image" class="sr-only" onchange="document.getElementById('techResultLabel').innerText = this.files[0]?.name || 'Chưa chọn tệp · Không bắt buộc'">
                        <span>Chọn tệp</span>
                    </label>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center space-x-3 pt-4 border-t border-[#F3F4F6]">
                <a href="{{ route('tech.tasks') }}" class="px-5 py-2.5 border border-[#E5E7EB] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[13px] font-semibold rounded-[10px] transition-colors">
                    Về bàn việc
                </a>
                <button type="submit" class="px-6 py-2.5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[10px] transition-colors cursor-pointer shadow-xs">
                    Gửi kết quả
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
