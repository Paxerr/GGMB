<!-- Modal Popup: Lập hóa đơn mới (Bám sát Ảnh 9) -->
<div
    id="createInvoiceModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="create-invoice-title"
    role="dialog"
    aria-modal="true"
>
    <div
        id="createInvoiceBackdrop"
        onclick="closeCreateInvoiceModal()"
        class="fixed inset-0 bg-black/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="createInvoicePanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[688px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeCreateInvoiceModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[18px] font-bold text-[#111827] mt-1" id="create-invoice-title">
                    Lập hóa đơn mới
                </h3>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('invoices.store') }}" method="POST">
                @csrf
                <input type="hidden" name="total_amount" id="inv_total_amount" value="0">
                <div class="px-6 py-5 space-y-4">
                    <!-- Hàng 1: Căn hộ * & Kỳ thanh toán * -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="inv_apartment" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Căn hộ <span class="text-rose-600">*</span>
                            </label>
                            <div class="relative">
                                <select id="inv_apartment" name="ApartmentId" required class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer">
                                    <option value="" disabled selected>Chọn căn hộ ▾</option>
                                    @foreach ($apartments as $apt)
                                        <option value="{{ $apt->ApartmentId }}">{{ $apt->ApartmentNumber }} · Tầng {{ $apt->floor->FloorNumber ?? 1 }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                            </div>
                        </div>

                        <div>
                            <label for="inv_period" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Kỳ thanh toán <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="text"
                                id="inv_period"
                                name="BillingPeriod"
                                required
                                value="02/2026"
                                placeholder="MM/YYYY"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 2: Hạn thanh toán * & Người tạo -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="inv_due_date" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Hạn thanh toán <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="date"
                                id="inv_due_date"
                                name="DueDate"
                                required
                                value="{{ date('Y-m-d', strtotime('+10 days')) }}"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>

                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                                Người tạo
                            </label>
                            <input
                                type="text"
                                readonly
                                value="1 · manager01"
                                class="w-full h-[40px] px-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#6B7280] cursor-not-allowed select-none focus:outline-none font-medium"
                            />
                        </div>
                    </div>

                    <!-- Bảng các khoản phí chọn lọc (Bám sát Ảnh 9) -->
                    <div class="border border-[#E5E7EB] rounded-[8px] overflow-hidden">
                        <div class="bg-[#F2F6F4] flex h-[36px] items-center text-[12px] font-semibold text-[#374151] px-3 border-b border-[#E5E7EB]">
                            <div class="w-[200px]">Khoản phí</div>
                            <div class="w-[110px]">Số lượng</div>
                            <div class="w-[110px] text-right">Đơn giá (đ)</div>
                            <div class="flex-1 text-right">Thành tiền (đ)</div>
                        </div>

                        @php
                            $feeItems = [
                                ['name' => 'Điện (kWh)', 'qty' => 'Từ chỉ số', 'price' => 3500, 'amount' => 122500],
                                ['name' => 'Nước (m³)', 'qty' => 'Từ chỉ số', 'price' => 18000, 'amount' => 126000],
                                ['name' => 'Quản lý (m²)', 'qty' => 'Diện tích', 'price' => 12000, 'amount' => 720000],
                                ['name' => 'Gửi xe (xe/tháng)', 'qty' => 'Nhập', 'price' => 100000, 'amount' => 100000],
                                ['name' => 'Internet (tháng)', 'qty' => 'Nhập', 'price' => 200000, 'amount' => 200000],
                            ];
                        @endphp

                        @foreach ($feeItems as $idx => $f)
                            <div class="flex h-[42px] items-center text-[13px] border-b last:border-b-0 border-[#E5E7EB] px-3 hover:bg-[#F9FBFA]">
                                <label class="w-[200px] flex items-center gap-2 cursor-pointer select-none">
                                    <input
                                        type="checkbox"
                                        class="fee-checkbox rounded-[4px] border-[#E5E7EB] text-[#0E4D3C] focus:ring-0 cursor-pointer"
                                        data-amount="{{ $f['amount'] }}"
                                        onchange="updateTotalInvoiceAmount()"
                                    />
                                    <span class="font-medium text-[#111827]">{{ $f['name'] }}</span>
                                </label>
                                <div class="w-[110px] text-xs text-[#6B7280]">{{ $f['qty'] }}</div>
                                <div class="w-[110px] text-right font-mono text-[#374151]">{{ number_format($f['price'], 0, ',', '.') }}</div>
                                <div class="flex-1 text-right font-mono text-[#6B7280] fee-item-amount">—</div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Tổng tiền các khoản đã chọn -->
                    <div class="flex items-center justify-between pt-2">
                        <span class="text-[13px] font-semibold text-[#6B7280]">
                            Tổng tiền các khoản đã chọn
                        </span>
                        <span class="text-[20px] font-bold text-[#0E4D3C] font-mono" id="totalInvoiceSelectedAmount">
                            0 đ
                        </span>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-[#F2F6F4] border-t border-[#E5E7EB] flex items-center justify-between rounded-b-[16px]">
                    <button
                        type="button"
                        onclick="closeCreateInvoiceModal()"
                        class="h-[38px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[38px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Lập hóa đơn
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCreateInvoiceModal() {
        const modal = document.getElementById('createInvoiceModal');
        const backdrop = document.getElementById('createInvoiceBackdrop');
        const panel = document.getElementById('createInvoicePanel');

        if (!modal || !backdrop || !panel) return;

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeCreateInvoiceModal() {
        const modal = document.getElementById('createInvoiceModal');
        const backdrop = document.getElementById('createInvoiceBackdrop');
        const panel = document.getElementById('createInvoicePanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function updateTotalInvoiceAmount() {
        let total = 0;
        document.querySelectorAll('.fee-checkbox').forEach(cb => {
            const amountCell = cb.closest('.flex').querySelector('.fee-item-amount');
            const amt = parseInt(cb.dataset.amount) || 0;
            if (cb.checked) {
                total += amt;
                amountCell.textContent = amt.toLocaleString('vi-VN');
                amountCell.classList.add('font-semibold', 'text-[#111827]');
            } else {
                amountCell.textContent = '—';
                amountCell.classList.remove('font-semibold', 'text-[#111827]');
            }
        });
        document.getElementById('totalInvoiceSelectedAmount').textContent = total.toLocaleString('vi-VN') + ' đ';
        const hiddenTotal = document.getElementById('inv_total_amount');
        if (hiddenTotal) hiddenTotal.value = total;
    }

    function simulateCreateInvoice() {
        closeCreateInvoiceModal();
        if (window.showToast) {
            window.showToast('Đã lập hóa đơn mới thành công!');
        }
    }
</script>
