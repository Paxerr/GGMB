@extends('layouts.portal', [
    'title' => 'Ghi điện nước · GGMB',
    'portalType' => 'tech',
    'activeTab' => 'utilities'
])

@section('content')
<div class="space-y-8 sm:space-y-10">
    <!-- Subtitle & Page Heading -->
    <div>
        <div class="text-[12.5px] font-semibold text-[#6B7280] mb-1.5 flex items-center gap-1.5">
            <span>Cổng kỹ thuật</span>
            <span>/</span>
            <span class="text-[#111827]">Tòa A</span>
        </div>
        <h1 class="text-[26px] font-bold text-[#111827] tracking-tight">
            Ghi điện nước
        </h1>
        <p class="mt-1.5 text-[13.5px] text-[#6B7280]">
            Nhập chỉ số điện/nước cho các căn hộ theo kỳ.
        </p>
    </div>

    <!-- Main Card -->
    <div class="bg-white border border-[#E5E7EB] rounded-[18px] p-7 sm:p-8 shadow-none">
        <!-- Card Header Info -->
        <div class="text-[15px] font-bold text-[#111827] pb-5 mb-7 border-b border-[#F3F4F6]">
            Tòa A / Tầng 1 / {{ $feeType?->Name ?? 'Điện' }} / {{ $currentPeriod ?? now()->format('m/Y') }}
        </div>
        <span class="sr-only">NHẬP CHỈ SỐ · {{ count($apartments) }} CĂN</span>

        <form action="{{ route('tech.utilities.store') }}" method="POST" id="meterForm">
            @csrf
            <input type="hidden" name="fee_type_id" value="{{ $feeType?->FeeTypeId ?? 1 }}">
            <input type="hidden" name="billing_period" value="{{ $currentPeriod ?? now()->format('m/Y') }}">

            <!-- Responsive Grid of Apartment Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-5 sm:gap-6">
                @foreach ($apartments as $apt)
                    <div class="bg-[#F8FAF8] border border-[#E5E7EB] rounded-[14px] p-6 space-y-4 hover:border-[#CBD5E1] transition-all">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-[#111827] text-[14px]">
                                Căn {{ $apt['code'] }}
                            </span>
                            <span class="status-badge inline-flex items-center px-2 py-0.5 rounded-[6px] text-[11px] font-semibold bg-[#FFF4DB] text-[#8F5316]">
                                Chưa nhập
                            </span>
                        </div>

                        <div class="text-[12.5px] text-[#6B7280]">
                            Chỉ số {{ $previousPeriod ?? 'Kỳ trước' }}: <strong class="text-[#374151]">{{ $apt['prev'] }}</strong>
                        </div>
                        <input type="hidden" name="prev_meters[{{ $apt['id'] }}]" value="{{ $apt['prev'] }}">

                        <div>
                            <input type="number" 
                                   name="meters[{{ $apt['id'] }}]" 
                                   data-prev="{{ $apt['prev'] }}" 
                                   placeholder="Nhập số ≥ {{ $apt['prev'] }}" 
                                   min="{{ $apt['prev'] }}" 
                                   class="meter-input w-full h-[40px] px-3.5 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] transition-colors shadow-2xs">
                            <div class="meter-error text-[11px] text-rose-600 hidden mt-1.5 font-medium">Số mới phải ≥ {{ $apt['prev'] }}</div>
                        </div>

                        <div class="text-[12.5px] text-[#6B7280]">
                            Tiêu thụ: <span class="consumption-val font-semibold text-[#9CA3AF]">—</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Bottom Note and Action Buttons -->
            <div class="mt-8 pt-6 border-t border-[#F3F4F6] flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                <p class="text-[12.5px] text-[#6B7280]">
                    Nhập ít nhất 1 dòng; số mới phải lớn hơn hoặc bằng số kỳ trước. Sau khi lưu, ban quản lý sẽ đối soát và chốt số.
                </p>

                <div class="flex items-center space-x-3 shrink-0">
                    <a href="{{ route('tech.tasks') }}" class="px-5 py-2.5 border border-[#E5E7EB] bg-white text-[#374151] hover:bg-[#F9FBFA] text-[13px] font-semibold rounded-[8px] transition-colors">
                        Hủy
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer shadow-xs">
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
