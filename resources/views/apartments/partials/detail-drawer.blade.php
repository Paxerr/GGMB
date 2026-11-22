<!-- Backdrop (Nền ngữ cảnh bất hoạt · SCR-APT-03) -->
<div
    id="drawer-backdrop"
    onclick="closeApartmentDrawer()"
    class="fixed inset-0 bg-black/40 z-40 transition-opacity duration-300 {{ isset($selectedApartment) ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none' }}"
></div>

<!-- 03 · Drawer (Slide-over Chi tiết căn hộ · 680px) -->
<aside
    id="apartment-detail-drawer"
    data-name="03 · Drawer"
    class="fixed top-0 right-0 z-50 h-full w-full max-w-[680px] bg-white shadow-2xl flex flex-col transition-transform duration-300 ease-in-out transform {{ isset($selectedApartment) ? 'translate-x-0' : 'translate-x-full' }}"
    aria-label="Chi tiết căn hộ"
>
    <!-- Drawer Header -->
    <div class="px-6 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] flex-shrink-0">
        <div class="flex items-center justify-between">
            <span class="text-[11px] font-bold uppercase tracking-wider text-[#6B7280]">
                CHI TIẾT / DRAWER
            </span>
            <button
                type="button"
                onclick="closeApartmentDrawer()"
                class="text-[26px] leading-none text-[#6B7280] hover:text-[#111827] transition-colors cursor-pointer p-1"
                aria-label="Đóng drawer"
            >
                &times;
            </button>
        </div>
        <h2 id="drawer-title" class="text-[20px] font-bold text-[#111827] mt-1">
            Căn hộ {{ $selectedApartment->ApartmentNumber ?? '0101' }}
        </h2>
        <p id="drawer-subtitle" class="text-[13px] text-[#6B7280] mt-0.5">
            ApartmentId = {{ $selectedApartment->ApartmentId ?? '1' }} · FloorId = {{ $selectedApartment->FloorId ?? '1' }} · {{ isset($selectedApartment) ? $selectedApartment->status_label : 'Đang ở' }} <span class="sr-only">{{ $selectedApartment->Status ?? 'OCCUPIED' }}</span>
        </p>
    </div>

    <!-- Drawer Body (Nội dung) -->
    <div class="px-6 py-5 overflow-y-auto flex-1 space-y-5" data-name="Nội dung">
        <!-- Nhóm trường -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" data-name="Nhóm trường">
            <!-- Số căn · ApartmentNumber -->
            <div>
                <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                    Số căn · ApartmentNumber
                </label>
                <div id="drawer-apartment-number" class="h-[40px] px-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[13.5px] font-bold text-[#111827] flex items-center">
                    {{ $selectedApartment->ApartmentNumber ?? '0101' }}
                </div>
            </div>

            <!-- Mô tả · Description -->
            <div>
                <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                    Mô tả · Description
                </label>
                <div id="drawer-apartment-desc" class="h-[40px] px-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#374151] flex items-center truncate">
                    {{ $selectedApartment->Description ?? 'Căn hộ tầng 1, số 01' }}
                </div>
            </div>
        </div>

        <!-- Cư dân · ApartmentResident → User -->
        <div data-name="Cư dân">
            <div class="text-[12px] font-semibold uppercase text-[#374151] tracking-wide mb-2">
                CƯ DÂN · ApartmentResident → User
            </div>
            <div class="border border-[#E5E7EB] rounded-[8px] overflow-hidden">
                <!-- Tiêu đề cột -->
                <div class="bg-[#F2F6F4] border-b border-[#E5E7EB] flex h-[38px] items-center text-[12px] font-semibold text-[#374151]">
                    <div class="w-[260px] min-w-[260px] px-3 border-r border-[#E5E7EB] h-full flex items-center">
                        Họ tên
                    </div>
                    <div class="w-[190px] min-w-[190px] px-3 border-r border-[#E5E7EB] h-full flex items-center">
                        Ngày vào
                    </div>
                    <div class="flex-1 px-3 h-full flex items-center">
                        Cư trú
                    </div>
                </div>

                <!-- Danh sách cư dân -->
                <div id="drawer-residents-list">
                    @if (isset($selectedApartment) && $selectedApartment->residents->isNotEmpty())
                        @foreach ($selectedApartment->residents as $res)
                            <div class="border-b last:border-b-0 border-[#E5E7EB] flex h-[44px] items-center text-[13px] text-[#374151]">
                                <div class="w-[260px] min-w-[260px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-medium text-[#111827]">
                                    {{ $res->user->FullName ?? '—' }}
                                </div>
                                <div class="w-[190px] min-w-[190px] px-3 border-r border-[#E5E7EB] h-full flex items-center text-[#6B7280]">
                                    {{ $res->StartDate ? \Carbon\Carbon::parse($res->StartDate)->format('d/m/Y') : '01/01/2024' }}
                                </div>
                                <div class="flex-1 px-3 h-full flex items-center">
                                    <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded-[6px] {{ $res->Status === 'ACTIVE' ? 'bg-[#E4EFE9] text-[#0E4D3C]' : 'bg-gray-100 text-[#6B7280]' }}">
                                        {{ $res->Status === 'ACTIVE' ? 'Đang cư trú' : 'Đã rời đi' }}
                                        <span class="sr-only">{{ $res->Status }}</span>
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="border-b last:border-b-0 border-[#E5E7EB] flex h-[44px] items-center text-[13px] text-[#374151]">
                            <div class="w-[260px] min-w-[260px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-medium text-[#111827]">
                                Nguyễn An
                            </div>
                            <div class="w-[190px] min-w-[190px] px-3 border-r border-[#E5E7EB] h-full flex items-center text-[#6B7280]">
                                01/01/2024
                            </div>
                            <div class="flex-1 px-3 h-full flex items-center">
                                <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded-[6px] bg-[#E4EFE9] text-[#0E4D3C]">
                                    ACTIVE
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Xe thuộc căn hộ · Vehicle -->
        <div data-name="Xe">
            <div class="text-[12px] font-semibold uppercase text-[#374151] tracking-wide mb-2">
                XE THUỘC CĂN HỘ · Vehicle
            </div>
            <div id="drawer-vehicles-list" class="p-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827]">
                @if (isset($selectedApartment) && $selectedApartment->vehicles->isNotEmpty())
                    {{ $selectedApartment->vehicles->map(fn($v) => "{$v->LicensePlate} / {$v->VehicleType}")->join(' · ') }}
                @else
                    29A-10001 / MOTORBIKE
                @endif
            </div>
        </div>

        <!-- Chỉ số Điện / Nước -->
        <div data-name="Chỉ số">
            <div id="drawer-meter-title" class="text-[12px] font-semibold uppercase text-[#374151] tracking-wide mb-2">
                ĐIỆN / NƯỚC · 02/2026
            </div>
            <div id="drawer-meter-readings" class="p-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] font-semibold">
                @if (isset($selectedApartment) && $selectedApartment->meterReadings->isNotEmpty())
                    @php
                        $elec = $selectedApartment->meterReadings->first(fn($m) => str_contains(strtolower($m->feeType->Name ?? ''), 'điện'));
                        $water = $selectedApartment->meterReadings->first(fn($m) => str_contains(strtolower($m->feeType->Name ?? ''), 'nước'));
                        $parts = [];
                        if ($elec) {
                            $parts[] = "Điện: " . (int)$elec->PreviousReading . " → " . (int)$elec->CurrentReading . " = " . (int)$elec->Consumption;
                        }
                        if ($water) {
                            $parts[] = "Nước: " . (int)$water->PreviousReading . " → " . (int)$water->CurrentReading . " = " . (int)$water->Consumption;
                        }
                    @endphp
                    {{ count($parts) > 0 ? implode(' / ', $parts) : 'Điện: 103 → 142 = 39 / Nước: 41 → 48 = 7' }}
                @else
                    Điện: 103 → 142 = 39 / Nước: 41 → 48 = 7
                @endif
            </div>
        </div>

        <!-- Ghi chú nghiệp vụ · Nợ phí -->
        <div data-name="Ghi chú nghiệp vụ - Nợ phí">
            <div id="drawer-debt-note" class="p-3.5 bg-[#FEF3C7] border border-[#FDE68A] rounded-[8px] text-[13px] text-[#92400E] font-medium">
                @if (isset($selectedApartment) && $selectedApartment->invoices->isNotEmpty())
                    @php
                        $unpaid = $selectedApartment->invoices->whereIn('Status', ['UNPAID', 'OVERDUE']);
                        $totalDebt = $unpaid->sum('TotalAmount');
                    @endphp
                    @if ($unpaid->isNotEmpty())
                        NỢ PHÍ: {{ number_format($totalDebt, 0, ',', '.') }} đ · InvoiceId {{ $unpaid->pluck('InvoiceId')->join(' và ') }}; mỗi kỳ {{ number_format($unpaid->first()->TotalAmount ?? 842500, 0, ',', '.') }} đ, Status {{ $unpaid->pluck('Status')->unique()->join(', ') }}
                    @else
                        Không có nợ phí phát sinh.
                    @endif
                @else
                    NỢ PHÍ: 1.685.000 đ · InvoiceId 1 và 21; mỗi kỳ 842.500 đ, Status UNPAID
                @endif
            </div>
        </div>

        <!-- Ghi chú nghiệp vụ · Audit metadata -->
        <div data-name="Ghi chú nghiệp vụ - Hệ thống">
            <div id="drawer-audit-note" class="p-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[12px] text-[#6B7280]">
                @if (isset($selectedApartment))
                    CreatedAt: {{ $selectedApartment->CreatedAt ?? 'tự sinh' }} · UpdatedAt: {{ $selectedApartment->UpdatedAt ?? 'NULL' }} · IsDeleted: {{ $selectedApartment->IsDeleted ? 'TRUE' : 'FALSE' }} · DeletedAt: {{ $selectedApartment->DeletedAt ?? 'NULL' }}
                @else
                    CreatedAt tự sinh · UpdatedAt NULL · IsDeleted FALSE · DeletedAt NULL
                @endif
            </div>
        </div>
    </div>

    <!-- Drawer Footer Actions -->
    <div class="px-6 py-4 border-t border-[#E5E7EB] flex items-center justify-between bg-[#F2F6F4] flex-shrink-0">
        <button
            type="button"
            onclick="closeApartmentDrawer()"
            class="h-[38px] px-5 border border-[#E5E7EB] bg-white hover:bg-[#F9FBFA] text-[#374151] rounded-[8px] font-semibold text-[13px] transition-colors cursor-pointer flex items-center justify-center select-none"
        >
            Đóng
        </button>
        <button
            type="button"
            id="drawer-edit-btn"
            onclick="const aptId = window.currentDrawerApartmentId || ({{ $selectedApartment->ApartmentId ?? '1' }}); closeApartmentDrawer(); openEditApartmentModal(aptId);"
            class="h-[38px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white rounded-[8px] font-semibold text-[13px] transition-colors cursor-pointer flex items-center justify-center select-none shadow-sm"
        >
            Chỉnh sửa
        </button>
    </div>
</aside>
