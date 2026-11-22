@extends('layouts.app', [
    'title' => 'Sổ chỉ số điện nước · GGMB',
    'active' => 'utilities',
    'breadcrumbs' => ['GGMB', 'Điện & nước']
])

@section('content')
<div class="w-full space-y-6">
    @if (session('success'))
        <div class="p-4 bg-[#e6f5ec] border border-[#c3e6cb] text-[#16734b] text-[14px] rounded-[4px] flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#16734b] font-bold text-lg leading-none cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Tiêu đề & Phụ đề -->
    <div>
        <h1 class="text-[26px] leading-[34px] font-bold text-[#111827] tracking-tight">
            Sổ chỉ số điện nước
        </h1>
        <p class="mt-1 text-[13px] leading-[20px] text-[#6b7280]">
            Ghi nhận chỉ số điện, nước theo căn hộ và kỳ; đối chiếu số kỳ trước.
        </p>
    </div>

    <!-- Heading & Action Button Row -->
    <div class="flex items-center justify-between">
        <h2 class="text-[16px] font-bold text-[#111827]">
            Danh sách chỉ số
        </h2>
        <div class="flex items-center gap-2.5">
            <button
                type="button"
                onclick="openHistoryDrawer({apartment: '0101', type: 'Điện', period: '02/2026', old_num: 103, new_num: 142, usage: 39})"
                class="px-4 py-2 bg-white border border-[#e5e7eb] hover:bg-[#f9fafb] text-[#374151] text-[13px] font-medium rounded-[8px] transition-colors cursor-pointer"
            >
                Lịch sử
            </button>
            <button
                type="button"
                onclick="openFirstTimeModal()"
                class="px-4 py-2 bg-[#0e4d3c] hover:bg-[#0a3d2f] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer shadow-sm"
            >
                ＋ Nhập chỉ số
            </button>
        </div>
    </div>

    <!-- Filter Card: 3 Filter Fields -->
    <div class="bg-white border border-[#e5e7eb] rounded-[14px] p-4 shadow-none">
        <form method="GET" action="{{ route('utilities.index') }}" class="flex flex-wrap items-center gap-3 sm:gap-4 flex-1">
            <!-- Kỳ ghi -->
            <div class="flex-1 min-w-[200px]">
                <label for="filterUtilityPeriod" class="sr-only">
                    Kỳ ghi
                </label>
                <div class="relative">
                    <select
                        id="filterUtilityPeriod"
                        name="period"
                        onchange="this.form.submit()"
                        class="w-full h-[40px] px-3 bg-white border border-[#e5e7eb] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0e4d3c] focus:ring-1 focus:ring-[#0e4d3c] cursor-pointer"
                    >
                        <option value="">Tất cả kỳ ghi</option>
                        <option value="02/2026" {{ request('period') === '02/2026' ? 'selected' : '' }}>02/2026</option>
                        <option value="01/2026" {{ request('period') === '01/2026' ? 'selected' : '' }}>01/2026</option>
                        <option value="12/2025" {{ request('period') === '12/2025' ? 'selected' : '' }}>12/2025</option>
                    </select>
                </div>
            </div>

            <!-- Căn hộ -->
            <div class="flex-1 min-w-[200px]">
                <label for="filterUtilityApartment" class="sr-only">
                    Căn hộ
                </label>
                <div class="relative">
                    <select
                        id="filterUtilityApartment"
                        name="apartment_id"
                        onchange="this.form.submit()"
                        class="w-full h-[40px] px-3 bg-white border border-[#e5e7eb] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0e4d3c] focus:ring-1 focus:ring-[#0e4d3c] cursor-pointer"
                    >
                        <option value="">Tất cả căn hộ</option>
                        @foreach ($apartments as $apt)
                            <option value="{{ $apt->ApartmentId }}" {{ request('apartment_id') == $apt->ApartmentId ? 'selected' : '' }}>
                                {{ $apt->ApartmentNumber }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Loại chỉ số -->
            <div class="flex-1 min-w-[200px]">
                <label for="filterUtilityType" class="sr-only">
                    Loại chỉ số
                </label>
                <div class="relative">
                    <select
                        id="filterUtilityType"
                        name="type"
                        onchange="this.form.submit()"
                        class="w-full h-[40px] px-3 bg-white border border-[#e5e7eb] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0e4d3c] focus:ring-1 focus:ring-[#0e4d3c] cursor-pointer"
                    >
                        <option value="ALL">Điện & nước</option>
                        <option value="Điện" {{ request('type') === 'Điện' ? 'selected' : '' }}>Điện</option>
                        <option value="Nước" {{ request('type') === 'Nước' ? 'selected' : '' }}>Nước</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button
                    type="submit"
                    class="h-[40px] px-4 bg-white border border-[#e5e7eb] hover:bg-[#f9fafb] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer"
                >
                    Lọc
                </button>
                <a
                    href="{{ route('utilities.index') }}"
                    class="h-[40px] px-4 bg-[#f3f4f6] hover:bg-[#e5e7eb] rounded-[8px] text-[13px] font-medium text-[#374151] transition-colors inline-flex items-center justify-center"
                >
                    Đặt lại
                </a>
            </div>
        </form>
    </div>

    <!-- Bảng dữ liệu Sổ chỉ số -->
    <div class="bg-white border border-[#e5e7eb] rounded-[14px] overflow-hidden shadow-none">
        <!-- Table Header -->
        <div class="bg-[#f2f6f4] border-b border-[#e5e7eb] flex h-[44px] items-center text-[#374151] text-[12px] font-semibold select-none">
            <div class="w-[60px] min-w-[50px] px-3 border-r border-[#E5E7EB] h-full flex items-center">ID</div>
            <div class="w-[110px] min-w-[90px] px-3 border-r border-[#E5E7EB] h-full flex items-center">Căn hộ</div>
            <div class="w-[100px] min-w-[80px] px-3 border-r border-[#E5E7EB] h-full flex items-center">Loại</div>
            <div class="w-[120px] min-w-[100px] px-3 border-r border-[#E5E7EB] h-full flex items-center">Kỳ ghi</div>
            <div class="w-[100px] min-w-[80px] px-3 border-r border-[#E5E7EB] h-full flex items-center">Số cũ</div>
            <div class="w-[100px] min-w-[80px] px-3 border-r border-[#E5E7EB] h-full flex items-center">Số mới</div>
            <div class="w-[100px] min-w-[80px] px-3 border-r border-[#E5E7EB] h-full flex items-center">Tiêu thụ</div>
            <div class="w-[150px] min-w-[120px] px-3 border-r border-[#E5E7EB] h-full flex items-center">Người ghi</div>
            <div class="flex-1 min-w-[160px] px-3 h-full flex items-center text-[#0e4d3c]">Thao tác</div>
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
                class="bg-white border-b last:border-b-0 border-[#E5E7EB] flex h-[52px] items-center text-[#374151] text-[13.5px] hover:bg-[#F9FBFA] transition-colors cursor-pointer"
                onclick="if(!event.target.closest('button')) openHistoryDrawer({{ $row->id }})"
            >
                <div class="w-[60px] min-w-[50px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-normal">{{ $row->id }}</div>
                <div class="w-[110px] min-w-[90px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-semibold text-[#111827]">{{ $row->apartment }}</div>
                <div class="w-[100px] min-w-[80px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-normal text-[#374151]">{{ $row->type }}</div>
                <div class="w-[120px] min-w-[100px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-normal">{{ $row->period }}</div>
                <div class="w-[100px] min-w-[80px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-normal">{{ $row->old_num }}</div>
                <div class="w-[100px] min-w-[80px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-normal text-[#111827]">{{ $row->new_num }}</div>
                <div class="w-[100px] min-w-[80px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-semibold text-[#111827]">{{ $row->usage }}</div>
                <div class="w-[150px] min-w-[120px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-normal text-[#6B7280]">{{ $row->recorder }}</div>
                <div class="flex-1 min-w-[160px] px-3 h-full flex items-center gap-1.5 text-[13px]">
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openHistoryDrawer({{ $row->id }});"
                        title="Xem lịch sử chỉ số"
                        class="p-1.5 text-[#0E4D3C] hover:bg-[#E4EFE9] rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span class="sr-only">Lịch sử</span>
                    </button>
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openCorrectModal({{ $row->id }});"
                        title="Đính chính chỉ số"
                        class="p-1.5 text-[#374151] hover:text-[#0E4D3C] hover:bg-[#F3F4F6] rounded-[6px] transition-colors cursor-pointer inline-flex items-center justify-center"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="sr-only">Đính chính</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Dòng chú thích nghiệp vụ (Bám sát Ảnh 1 & 2) -->
    <div class="p-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[13px] text-[#6B7280]">
        Tiêu thụ = số mới – số kỳ trước; số mới ≥ số kỳ trước. Kiểm tra căn hộ và kỳ trước khi lưu.
    </div>

    <!-- Thanh phân trang & Nút "Nhập chỉ số lần đầu" (Bám sát Ảnh 1 & 2) -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1 pb-6">
        <div>
            <button
                type="button"
                onclick="openFirstTimeModal()"
                class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
            >
                Nhập chỉ số lần đầu
            </button>
        </div>

        @include('layouts.partials.pagination', ['paginator' => $readings])
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
