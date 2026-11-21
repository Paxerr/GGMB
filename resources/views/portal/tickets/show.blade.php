@extends('layouts.portal', [
    'title' => 'Chi tiết yêu cầu của tôi · GGMB',
    'portalType' => 'resident',
    'activeTab' => 'tickets'
])

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-[26px] font-semibold text-[#122d40] leading-tight">
            Chi tiết yêu cầu của tôi
        </h1>
        <p class="mt-1 text-[14px] text-[#52697c]">
            #{{ $id ?? 1 }} · Không xem được thông báo phí
        </p>
    </div>

    <!-- Main Detail Card -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 sm:p-8 max-w-2xl shadow-sm space-y-6">
        <!-- Tình trạng -->
        <div>
            <span class="block text-[12px] font-semibold text-[#52697c] uppercase tracking-wide">
                Tình trạng
            </span>
            <div class="mt-1 text-[14px] font-medium text-[#122d40]">
                Chờ xử lý · Chưa phân công
            </div>
        </div>

        <!-- Thông tin yêu cầu -->
        <div>
            <span class="block text-[12px] font-semibold text-[#52697c] uppercase tracking-wide">
                Thông tin yêu cầu
            </span>
            <div class="mt-1 text-[14px] text-[#334b5d] space-y-0.5">
                <div>Nguyễn An · Căn 0101 · Nhóm Tài khoản</div>
                <div class="text-[13px] text-[#52697c]">Tạo lúc 02/02/2026 08:30</div>
            </div>
        </div>

        <!-- Nội dung -->
        <div>
            <span class="block text-[12px] font-semibold text-[#52697c] uppercase tracking-wide">
                Nội dung
            </span>
            <div class="mt-1 text-[14px] text-[#122d40]">
                Không xem được thông báo phí
            </div>
        </div>

        <!-- Form phản hồi bổ sung -->
        <form action="{{ route('portal.tickets.reply', $id ?? 1) }}" method="POST" class="space-y-4 pt-2">
            @csrf
            <div>
                <label class="block text-[13px] font-semibold text-[#334b5d] mb-1.5">
                    Nội dung phản hồi <span class="text-rose-500">*</span>
                </label>
                <textarea name="reply_content" rows="4" required placeholder="Nhập thông tin bổ sung cho yêu cầu" class="w-full p-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[14px] text-[#122d40] placeholder-[#94a3b8] focus:outline-none focus:border-[#2864ad]"></textarea>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center space-x-3 pt-2">
                <a href="{{ route('portal.tickets') }}" class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-slate-50 text-[#334b5d] font-medium text-[14px] rounded-[4px] flex items-center transition-colors">
                    Về yêu cầu của tôi
                </a>
                <button type="submit" class="h-[40px] px-6 bg-[#2864AD] hover:bg-[#1e4d87] text-white font-medium text-[14px] rounded-[4px] transition-colors cursor-pointer shadow-sm">
                    Gửi phản hồi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
