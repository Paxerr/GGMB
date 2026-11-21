@extends('layouts.app', [
    'title' => 'Sổ chỉ số điện nước · GGMB',
    'active' => 'utilities',
    'breadcrumbs' => ['GGMB', 'Điện & nước']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    @if (session('success'))
        <div class="p-4 bg-[#e6f5ec] border border-[#c3e6cb] text-[#16734b] text-[14px] rounded-[4px] flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#16734b] font-bold text-lg leading-none cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Tiêu đề & Phụ đề (30 · SCR-MTR-01 · Bám sát Ảnh 1 & 2) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
            Sổ chỉ số điện nước
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#334b5d]">
            Ghi nhận chỉ số điện, nước theo căn hộ và kỳ; đối chiếu số kỳ trước.
        </p>
    </div>

    <!-- Hàng Bộ lọc & Nút Thao tác -->
    <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-4 pt-2">
        <div class="flex flex-wrap items-end gap-3 sm:gap-4 flex-1">
            <!-- Kỳ ghi -->
            <div class="space-y-1.5 w-full sm:w-[220px]">
                <label class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Kỳ ghi
                </label>
                <div class="relative">
                    <select class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer">
                        <option value="02/2026">02/2026 ▾</option>
                        <option value="01/2026">01/2026 ▾</option>
                        <option value="12/2025">12/2025 ▾</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                </div>
            </div>

            <!-- Tầng -->
            <div class="space-y-1.5 w-full sm:w-[220px]">
                <label class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Tầng
                </label>
                <div class="relative">
                    <select class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer">
                        <option value="">Tất cả ▾</option>
                        <option value="1">Tầng 1</option>
                        <option value="2">Tầng 2</option>
                        <option value="3">Tầng 3</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                </div>
            </div>

            <!-- Loại chỉ số -->
            <div class="space-y-1.5 w-full sm:w-[220px]">
                <label class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Loại chỉ số
                </label>
                <div class="relative">
                    <select class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer">
                        <option value="ALL">Điện & nước ▾</option>
                        <option value="Điện">Điện</option>
                        <option value="Nước">Nước</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                </div>
            </div>
        </div>

        <!-- 2 Nút bên phải: Lịch sử & Nhập kỳ -->
        <div class="flex items-center gap-3 shrink-0">
            <button
                type="button"
                onclick="openHistoryDrawer({apartment: '0101', type: 'Điện', period: '02/2026', old_num: 103, new_num: 142, usage: 39})"
                class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer"
            >
                Lịch sử
            </button>
            <button
                type="button"
                onclick="alert('Chức năng nhập chỉ số theo kỳ (Demo UI)')"
                class="h-[40px] px-7 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer shadow-sm"
            >
                Nhập kỳ
            </button>
        </div>
    </div>

    <!-- Bảng dữ liệu Sổ chỉ số (100% full width, không tràn ngang) -->
    <div class="bg-white border border-solid border-[#d9e4ec] overflow-hidden rounded-[4px]">
        <!-- Table Header -->
        <div class="bg-[#e4edf3] border-b border-[#d9e4ec] flex h-[40px] items-center text-[#334b5d] text-[12px] leading-[18px] font-semibold select-none">
            <div class="w-[60px] min-w-[50px] px-3 border-r border-[#d9e4ec] h-full flex items-center">ID</div>
            <div class="w-[110px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Căn hộ</div>
            <div class="w-[100px] min-w-[80px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Loại</div>
            <div class="w-[120px] min-w-[100px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Kỳ ghi</div>
            <div class="w-[100px] min-w-[80px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Số cũ</div>
            <div class="w-[100px] min-w-[80px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Số mới</div>
            <div class="w-[100px] min-w-[80px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Tiêu thụ</div>
            <div class="w-[150px] min-w-[120px] px-3 border-r border-[#d9e4ec] h-full flex items-center">Người ghi</div>
            <div class="flex-1 min-w-[160px] px-3 h-full flex items-center">Thao tác</div>
        </div>

        <!-- Table Rows -->
        @php
            $utilitiesMap = [];
        @endphp
        @foreach ($readings as $row)
            @php
                $rowData = [
                    'id' => $row->id,
                    'apartment' => $row->apartment,
                    'type' => $row->type,
                    'period' => $row->period,
                    'old_num' => $row->old_num,
                    'new_num' => $row->new_num,
                    'usage' => $row->usage,
                    'recorder' => $row->recorder,
                    'unit' => $row->unit ?? 'kWh',
                ];
                $utilitiesMap[$row->id] = $rowData;
            @endphp
            <div
                class="bg-white border-b last:border-b-0 border-[#d9e4ec] flex h-[48px] items-center text-[#334b5d] text-[14px] leading-[20px] hover:bg-[#f8fbfd] transition-colors cursor-pointer"
                onclick="if(!event.target.closest('button')) openHistoryDrawer({{ $row->id }})"
            >
                <div class="w-[60px] min-w-[50px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">{{ $row->id }}</div>
                <div class="w-[110px] min-w-[90px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium text-[#122d40]">{{ $row->apartment }}</div>
                <div class="w-[100px] min-w-[80px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal text-[#334b5d]">{{ $row->type }}</div>
                <div class="w-[120px] min-w-[100px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">{{ $row->period }}</div>
                <div class="w-[100px] min-w-[80px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">{{ $row->old_num }}</div>
                <div class="w-[100px] min-w-[80px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal text-[#122d40]">{{ $row->new_num }}</div>
                <div class="w-[100px] min-w-[80px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal text-[#122d40]">{{ $row->usage }}</div>
                <div class="w-[150px] min-w-[120px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal text-[#334b5d]">{{ $row->recorder }}</div>
                <div class="flex-1 min-w-[160px] px-3 h-full flex items-center text-[14px]">
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openCorrectModal({{ $row->id }});"
                        class="text-[#2864ad] hover:text-[#205391] hover:underline font-medium cursor-pointer transition-colors"
                    >
                        Lịch sử / Đính chính
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Dòng chú thích nghiệp vụ (Bám sát Ảnh 1 & 2) -->
    <div class="p-3 bg-[#f8fafc] border border-dashed border-[#d9e4ec] rounded-[4px] text-[13px] text-[#52697c]">
        Tiêu thụ = số mới – số kỳ trước; số mới ≥ số kỳ trước. Kiểm tra căn hộ và kỳ trước khi lưu.
    </div>

    <!-- Thanh phân trang & Nút "Nhập chỉ số lần đầu" (Bám sát Ảnh 1 & 2) -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1 pb-6">
        <div>
            <button
                type="button"
                onclick="openFirstTimeModal()"
                class="h-[40px] px-5 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
            >
                Nhập chỉ số lần đầu
            </button>
        </div>

        <!-- Phân trang chuẩn Figma: ‹ 1 2 ... 8 › -->
        <div class="w-[204px] h-[40px] bg-white border border-[#d9e4ec] rounded-[4px] flex items-center justify-between px-3 select-none text-[14px] text-[#334b5d]">
            <span class="text-[#a6bece]">‹</span>
            <span class="font-semibold text-[#122d40] border-b-2 border-[#2864ad] pb-0.5">1</span>
            <span class="text-[#334b5d]">2</span>
            <span class="text-[#8a9ba8]">...</span>
            <span class="text-[#334b5d]">8</span>
            <span class="text-[#334b5d] hover:text-[#2864ad] cursor-pointer">›</span>
        </div>
    </div>
</div>

<!-- Partials: Drawer Lịch sử chỉ số, Modal Đính chính chỉ số & Modal Nhập lần đầu -->
@include('utilities.partials.history-drawer')
@include('utilities.partials.correct-modal')
@include('utilities.partials.first-time-modal')

<script>
    window.utilitiesMap = @json($utilitiesMap ?? []);
</script>
@endsection
