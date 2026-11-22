@extends('layouts.portal', [
    'title' => 'Ghi điện nước · GGMB',
    'portalType' => 'tech',
    'activeTab' => 'utilities'
])

@section('content')
<div class="space-y-6">
    <!-- Subtitle & Page Heading -->
    <div>
        <div class="text-[12.5px] font-medium text-[#6B7280] mb-1">
            Cổng kỹ thuật / Tòa A
        </div>
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Ghi điện nước
        </h1>
        <p class="mt-0.5 text-[13px] text-[#6B7280]">
            Nhập chỉ số điện/nước cho các căn hộ theo kỳ.
        </p>
    </div>

    <!-- Main Card -->
    <div class="bg-white border border-[#E5E7EB] rounded-[16px] p-6 shadow-none">
        <!-- Card Header Info -->
        <div class="text-[15px] font-bold text-[#111827] pb-4 mb-5 border-b border-[#E5E7EB]">
            Tòa A / Tầng 1 / Điện / 03/2026
        </div>
        <span class="sr-only">NHẬP CHỈ SỐ · 8 CĂN</span>

        <form action="{{ route('tech.utilities.store') }}" method="POST" id="meterForm">
            @csrf

            @php
                $apartments = [
                    ['id' => 1, 'code' => '0101', 'prev' => 142],
                    ['id' => 2, 'code' => '0102', 'prev' => 149],
                    ['id' => 3, 'code' => '0103', 'prev' => 156],
                    ['id' => 4, 'code' => '0104', 'prev' => 163],
                    ['id' => 5, 'code' => '0105', 'prev' => 170],
                    ['id' => 6, 'code' => '0106', 'prev' => 177],
                    ['id' => 7, 'code' => '0107', 'prev' => 184],
                    ['id' => 8, 'code' => '0108', 'prev' => 159],
                ];
            @endphp

            <!-- 2x4 / Responsive Grid of 8 Apartment Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($apartments as $apt)
                    <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[12px] p-4.5 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-[#111827] text-[14px]">
                                Căn {{ $apt['code'] }}
                            </span>
                            <span class="status-badge inline-flex items-center px-2 py-0.5 rounded-[6px] text-[11px] font-semibold bg-[#FFF4DB] text-[#8F5316]">
                                Chưa nhập
                            </span>
                        </div>

                        <div class="text-[12px] text-[#6B7280]">
                            Chỉ số 02/2026: <strong class="text-[#374151]">{{ $apt['prev'] }}</strong>
                        </div>

                        <div>
                            <input type="number" 
                                   name="meters[{{ $apt['id'] }}]" 
                                   data-prev="{{ $apt['prev'] }}" 
                                   placeholder="Nhập số ≥ {{ $apt['prev'] }}" 
                                   min="{{ $apt['prev'] }}" 
                                   class="meter-input w-full h-[38px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13px] text-[#111827] focus:outline-none focus:border-[#0E4D3C]">
                            <div class="meter-error text-[11px] text-rose-600 hidden mt-1">Số mới phải ≥ {{ $apt['prev'] }}</div>
                        </div>

                        <div class="text-[12px] text-[#6B7280]">
                            Tiêu thụ: <span class="consumption-val font-semibold text-[#9CA3AF]">—</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Bottom Note and Action Buttons -->
            <div class="mt-6 pt-4 border-t border-[#E5E7EB] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <p class="text-[12.5px] text-[#6B7280]">
                    Nhập ít nhất 1 dòng; số mới phải lớn hơn hoặc bằng số kỳ trước. Sau khi lưu, ban quản lý sẽ đối soát và chốt số.
                </p>

                <div class="flex items-center space-x-3 shrink-0">
                    <a href="{{ route('tech.tasks') }}" class="px-5 py-2 border border-[#E5E7EB] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[13px] font-medium rounded-[8px] transition-colors">
                        Hủy
                    </a>
                    <button type="submit" class="px-5 py-2 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-medium rounded-[8px] transition-colors cursor-pointer">
                        Lưu chỉ số
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.meter-input');

        inputs.forEach(input => {
            input.addEventListener('input', function() {
                const prev = parseFloat(this.dataset.prev);
                const card = this.closest('.bg-\\[\\#F8FAF8\\]');
                const consumptionEl = card.querySelector('.consumption-val');
                const badgeEl = card.querySelector('.status-badge');
                const errorEl = card.querySelector('.meter-error');
                const val = this.value.trim();

                if (val !== '') {
                    const current = parseFloat(val);
                    if (!isNaN(current)) {
                        if (current >= prev) {
                            const diff = current - prev;
                            consumptionEl.innerText = diff + ' kWh';
                            consumptionEl.className = 'consumption-val font-bold text-[#0E4D3C]';
                            badgeEl.innerText = 'Đã nhập';
                            badgeEl.className = 'status-badge inline-flex items-center px-2 py-0.5 rounded-[6px] text-[11px] font-semibold bg-[#E4EFE9] text-[#0E4D3C]';
                            this.classList.remove('border-rose-400');
                            errorEl.classList.add('hidden');
                        } else {
                            consumptionEl.innerText = 'Lỗi';
                            consumptionEl.className = 'consumption-val font-bold text-rose-600';
                            badgeEl.innerText = 'Chưa hợp lệ';
                            badgeEl.className = 'status-badge inline-flex items-center px-2 py-0.5 rounded-[6px] text-[11px] font-semibold bg-rose-50 text-rose-700';
                            this.classList.add('border-rose-400');
                            errorEl.classList.remove('hidden');
                        }
                    }
                } else {
                    consumptionEl.innerText = '—';
                    consumptionEl.className = 'consumption-val font-semibold text-[#9CA3AF]';
                    badgeEl.innerText = 'Chưa nhập';
                    badgeEl.className = 'status-badge inline-flex items-center px-2 py-0.5 rounded-[6px] text-[11px] font-semibold bg-[#FFF4DB] text-[#8F5316]';
                    this.classList.remove('border-rose-400');
                    errorEl.classList.add('hidden');
                }
            });
        });
    });
</script>
@endsection
