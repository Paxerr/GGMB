@extends('layouts.portal', [
    'title' => 'Chi tiết công việc được giao · GGMB',
    'portalType' => 'tech',
    'activeTab' => 'tasks'
])

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-[26px] font-semibold text-[#122d40] leading-tight">
            Chi tiết công việc được giao
        </h1>
        <p class="mt-1 text-[14px] text-[#52697c]">
            #{{ $id ?? 3 }} · Đèn hành lang tầng 1 không sáng
        </p>
    </div>

    <!-- 2 Columns Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Left: Thông tin & Form kết quả (8 cols) -->
        <div class="lg:col-span-8 bg-white border border-[#d9e4ec] rounded-[4px] p-6 sm:p-8 shadow-sm space-y-6">
            <!-- Tình trạng -->
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c] uppercase tracking-wide">
                    Tình trạng
                </span>
                <div class="mt-1 text-[14px] font-medium text-[#122d40]">
                    Đang xử lý · Căn 0103 · Nhóm Kỹ thuật
                </div>
            </div>

            <!-- Người gửi -->
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c] uppercase tracking-wide">
                    Người gửi
                </span>
                <div class="mt-1 text-[14px] text-[#334b5d]">
                    Lê Chi · 04/02/2026 08:30
                </div>
            </div>

            <!-- Người phụ trách -->
            <div>
                <span class="block text-[12px] font-semibold text-[#52697c] uppercase tracking-wide">
                    Người phụ trách
                </span>
                <div class="mt-1 text-[14px] text-[#334b5d]">
                    Vũ Hoàng Kỹ thuật · 04/02/2026 09:00
                </div>
            </div>

            <!-- Form kết quả -->
            <form action="{{ route('tech.tasks.complete', $id ?? 3) }}" method="POST" enctype="multipart/form-data" class="space-y-4 pt-2 border-t border-[#d9e4ec]">
                @csrf
                <div>
                    <label class="block text-[13px] font-semibold text-[#334b5d] mb-1.5">
                        Nội dung kết quả <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="result_content" rows="4" required placeholder="Nhập công việc đã thực hiện và kết quả kiểm tra" class="w-full p-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[14px] text-[#122d40] placeholder-[#94a3b8] focus:outline-none focus:border-[#2864ad]"></textarea>
                </div>

                <!-- Action buttons -->
                <div class="flex items-center space-x-3 pt-2">
                    <a href="{{ route('tech.tasks') }}" class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-slate-50 text-[#334b5d] font-medium text-[14px] rounded-[4px] flex items-center transition-colors">
                        Về bàn việc
                    </a>
                    <button type="submit" class="h-[40px] px-6 bg-[#2864AD] hover:bg-[#1e4d87] text-white font-medium text-[14px] rounded-[4px] transition-colors cursor-pointer shadow-sm">
                        Gửi kết quả
                    </button>
                </div>
            </form>
        </div>

        <!-- Right: Thông tin liên quan & Ảnh (4 cols) -->
        <div class="lg:col-span-4 bg-white border border-[#d9e4ec] rounded-[4px] p-6 shadow-sm space-y-4">
            <div>
                <h3 class="text-[14px] font-semibold text-[#122d40] uppercase tracking-wide">
                    THÔNG TIN LIÊN QUAN
                </h3>
            </div>

            <div>
                <label class="block text-[13px] font-medium text-[#334b5d] mb-1.5">
                    Ảnh kết quả · không bắt buộc
                </label>
                <label class="relative block w-full border border-dashed border-[#d9e4ec] bg-[#f8fafc] hover:bg-slate-50 transition-colors rounded-[4px] p-8 text-center cursor-pointer">
                    <input type="file" name="result_image" class="sr-only" onchange="document.getElementById('techImageSpan').innerText = this.files[0]?.name || 'Chưa chọn tệp'">
                    <div class="text-[13px] font-medium text-[#2864ad]">
                        Ảnh kết quả · chọn tệp
                    </div>
                    <div class="text-[12px] text-[#52697c] mt-1" id="techImageSpan">
                        Chưa chọn tệp
                    </div>
                </label>
            </div>
        </div>
    </div>
</div>
@endsection
