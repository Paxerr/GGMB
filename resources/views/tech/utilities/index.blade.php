@extends('layouts.portal', [
    'title' => 'Ghi điện nước · GGMB',
    'portalType' => 'tech',
    'activeTab' => 'utilities'
])

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-[26px] font-semibold text-[#122d40] leading-tight">
            Ghi điện nước
        </h1>
        <p class="mt-1 text-[14px] text-[#52697c]">
            Kỳ 03/2026 · Điện: kWh - Số mới ≥ số kỳ trước; bằng nhau được ghi nhận tiêu thụ 0.
        </p>
    </div>

    <!-- Filter Controls Card -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-5 shadow-sm">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 items-end">
            <!-- Tòa nhà -->
            <div>
                <label class="block text-[12px] font-semibold text-[#334b5d] uppercase tracking-wide mb-1.5">
                    Tòa nhà
                </label>
                <select class="w-full h-[38px] px-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] focus:outline-none focus:border-[#2864ad]">
                    <option value="1">1 · GGMB Residence · Tòa A</option>
                </select>
            </div>

            <!-- Tầng -->
            <div>
                <label class="block text-[12px] font-semibold text-[#334b5d] uppercase tracking-wide mb-1.5">
                    Tầng
                </label>
                <select class="w-full h-[38px] px-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] focus:outline-none focus:border-[#2864ad]">
                    <option value="1">1 · Tầng 1</option>
                    <option value="2">2 · Tầng 2</option>
                    <option value="3">3 · Tầng 3</option>
                    <option value="4">4 · Tầng 4</option>
                    <option value="5">5 · Tầng 5</option>
                </select>
            </div>

            <!-- Loại chỉ số -->
            <div>
                <label class="block text-[12px] font-semibold text-[#334b5d] uppercase tracking-wide mb-1.5">
                    Loại chỉ số
                </label>
                <select class="w-full h-[38px] px-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] focus:outline-none focus:border-[#2864ad]">
                    <option value="ELECTRICITY" selected>Điện</option>
                    <option value="WATER">Nước</option>
                </select>
            </div>

            <!-- Kỳ ghi -->
            <div>
                <label class="block text-[12px] font-semibold text-[#334b5d] uppercase tracking-wide mb-1.5">
                    Kỳ ghi
                </label>
                <input type="text" value="03/2026" readonly class="w-full h-[38px] px-3 bg-[#f8fafc] border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] select-none">
            </div>

            <!-- Nhân viên -->
            <div>
                <label class="block text-[12px] font-semibold text-[#334b5d] uppercase tracking-wide mb-1.5">
                    Nhân viên
                </label>
                <div class="h-[38px] px-3 flex items-center text-[13px] text-[#52697c]">
                    Vũ Hoàng Kỹ thuật
                </div>
            </div>
        </div>
    </div>

    <!-- Table Form Container -->
    <form action="{{ route('tech.utilities.store') }}" method="POST" id="meterForm" class="bg-white border border-[#d9e4ec] rounded-[4px] shadow-sm overflow-hidden">
        @csrf
        <div class="p-4 border-b border-[#d9e4ec] bg-[#fafbfc]">
            <h2 class="text-[14px] font-bold text-[#122d40] uppercase tracking-wide">
                NHẬP CHỈ SỐ · 8 CĂN
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-[13px] border-collapse">
                <thead>
                    <tr class="bg-[#f0f4f8] text-[#334b5d] font-semibold border-b border-[#d9e4ec]">
                        <th class="py-2.5 px-4 w-16">Mã căn</th>
                        <th class="py-2.5 px-4">Căn hộ</th>
                        <th class="py-2.5 px-4 text-center">Chỉ số trước · chỉ đọc</th>
                        <th class="py-2.5 px-4 text-center w-56">Chỉ số mới · nhập số</th>
                        <th class="py-2.5 px-4 text-center">Tiêu thụ · tự tính</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#d9e4ec] text-[#334b5d]">
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

                    @foreach ($apartments as $apt)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 text-[#52697c] font-medium">{{ $apt['id'] }}</td>
                            <td class="py-3 px-4 font-semibold text-[#122d40]">{{ $apt['code'] }}</td>
                            <td class="py-3 px-4 text-center font-medium text-[#52697c]">
                                <span class="prev-val">{{ $apt['prev'] }}</span>
                            </td>
                            <td class="py-2.5 px-4 text-center">
                                <input type="number" 
                                       name="meters[{{ $apt['id'] }}]" 
                                       data-prev="{{ $apt['prev'] }}" 
                                       placeholder="Nhập số" 
                                       min="{{ $apt['prev'] }}" 
                                       class="meter-input w-36 h-[34px] px-3 text-center border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] focus:outline-none focus:border-[#2864ad]">
                                <div class="meter-error text-[11px] text-rose-600 hidden mt-0.5">Số mới phải ≥ {{ $apt['prev'] }}</div>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="consumption-val text-[#94a3b8] font-semibold">—</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer Notice and Actions -->
        <div class="p-4 bg-[#fafbfc] border-t border-[#d9e4ec] flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-[13px] text-[#52697c]">
                <span id="enteredCount" class="font-bold text-[#122d40]">0</span> / 8 dòng đã nhập · Nhập ít nhất 1 dòng; kiểm tra số mới ≥ số trước và không trùng kỳ.
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('tech.tasks') }}" class="h-[38px] px-6 bg-white border border-[#d9e4ec] hover:bg-slate-50 text-[#334b5d] font-medium text-[13px] rounded-[4px] flex items-center transition-colors">
                    Hủy
                </a>
                <button type="submit" class="h-[38px] px-6 bg-[#2864AD] hover:bg-[#1e4d87] text-white font-medium text-[13px] rounded-[4px] transition-colors cursor-pointer shadow-sm">
                    Lưu chỉ số
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.meter-input');
        const counterEl = document.getElementById('enteredCount');

        function updateState() {
            let count = 0;
            inputs.forEach(input => {
                const prev = parseFloat(input.dataset.prev);
                const row = input.closest('tr');
                const consumptionEl = row.querySelector('.consumption-val');
                const errorEl = row.querySelector('.meter-error');
                const val = input.value.trim();

                if (val !== '') {
                    const current = parseFloat(val);
                    if (!isNaN(current)) {
                        if (current >= prev) {
                            const diff = current - prev;
                            consumptionEl.innerText = diff;
                            consumptionEl.className = 'consumption-val text-[#16734b] font-bold text-[14px]';
                            input.classList.remove('border-rose-400');
                            errorEl.classList.add('hidden');
                            count++;
                        } else {
                            consumptionEl.innerText = 'Lỗi';
                            consumptionEl.className = 'consumption-val text-rose-600 font-bold';
                            input.classList.add('border-rose-400');
                            errorEl.classList.remove('hidden');
                        }
                    }
                } else {
                    consumptionEl.innerText = '—';
                    consumptionEl.className = 'consumption-val text-[#94a3b8] font-semibold';
                    input.classList.remove('border-rose-400');
                    errorEl.classList.add('hidden');
                }
            });

            counterEl.innerText = count;
        }

        inputs.forEach(input => {
            input.addEventListener('input', updateState);
        });
    });
</script>
@endsection
