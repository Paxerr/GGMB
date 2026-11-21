<!-- Backdrop (Nền ngữ cảnh bất hoạt · SCR-APT-03) -->
<div
    id="drawer-backdrop"
    onclick="closeApartmentDrawer()"
    class="fixed inset-0 bg-[#000000]/40 z-40 transition-opacity duration-300 {{ isset($selectedApartment) ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none' }}"
></div>

<!-- 03 · Drawer (Slide-over Chi tiết căn hộ · 680px) -->
<aside
    id="apartment-detail-drawer"
    data-name="03 · Drawer"
    class="fixed top-0 right-0 z-50 h-full w-full max-w-[680px] bg-white shadow-2xl flex flex-col transition-transform duration-300 ease-in-out transform {{ isset($selectedApartment) ? 'translate-x-0' : 'translate-x-full' }}"
    aria-label="Chi tiết căn hộ"
>
    <!-- Drawer Header -->
    <div class="px-6 pt-4 pb-3 border-b border-[#d9e4ec] flex-shrink-0">
        <div class="flex items-center justify-between">
            <span class="text-[11px] font-bold uppercase tracking-wider text-[#52697c]">
                CHI TIẾT / DRAWER
            </span>
            <button
                type="button"
                onclick="closeApartmentDrawer()"
                class="text-[26px] leading-none text-[#52697c] hover:text-[#122d40] transition-colors cursor-pointer p-1"
                aria-label="Đóng drawer"
            >
                &times;
            </button>
        </div>
        <h2 id="drawer-title" class="text-[22px] font-bold text-[#122d40] mt-1">
            Căn hộ {{ $selectedApartment->ApartmentNumber ?? '0101' }}
        </h2>
        <p id="drawer-subtitle" class="text-[13px] text-[#52697c] mt-0.5">
            ApartmentId = {{ $selectedApartment->ApartmentId ?? '1' }} · FloorId = {{ $selectedApartment->FloorId ?? '1' }} · {{ $selectedApartment->Status ?? 'OCCUPIED' }}
        </p>
    </div>

    <!-- Drawer Body (Nội dung) -->
    <div class="px-6 py-5 overflow-y-auto flex-1 space-y-5" data-name="Nội dung">
        <!-- Nhóm trường -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" data-name="Nhóm trường">
            <!-- Số căn · ApartmentNumber -->
            <div>
                <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                    Số căn · ApartmentNumber
                </label>
                <div id="drawer-apartment-number" class="h-[42px] px-3 bg-[#f8fbfd] border border-[#d9e4ec] text-[14px] font-medium text-[#122d40] flex items-center">
                    {{ $selectedApartment->ApartmentNumber ?? '0101' }}
                </div>
            </div>

            <!-- Mô tả · Description -->
            <div>
                <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                    Mô tả · Description
                </label>
                <div id="drawer-apartment-desc" class="h-[42px] px-3 bg-[#f8fbfd] border border-[#d9e4ec] text-[14px] text-[#122d40] flex items-center truncate">
                    {{ $selectedApartment->Description ?? 'Căn hộ tầng 1, số 01' }}
                </div>
            </div>
        </div>

        <!-- Cư dân · ApartmentResident → User -->
        <div data-name="Cư dân">
            <div class="text-[12px] font-semibold uppercase text-[#334b5d] tracking-wide mb-2">
                CƯ DÂN · ApartmentResident → User
            </div>
            <div class="border border-[#d9e4ec] overflow-hidden">
                <!-- Tiêu đề cột -->
                <div class="bg-[#e4edf3] border-b border-[#d9e4ec] flex h-[38px] items-center text-[12px] font-semibold text-[#334b5d]">
                    <div class="w-[260px] min-w-[260px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                        Họ tên
                    </div>
                    <div class="w-[190px] min-w-[190px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
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
                            <div class="border-b last:border-b-0 border-[#d9e4ec] flex h-[44px] items-center text-[13px] text-[#334b5d]">
                                <div class="w-[260px] min-w-[260px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium">
                                    {{ $res->user->FullName ?? '—' }}
                                </div>
                                <div class="w-[190px] min-w-[190px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                    {{ $res->StartDate ? \Carbon\Carbon::parse($res->StartDate)->format('d/m/Y') : '01/01/2024' }}
                                </div>
                                <div class="flex-1 px-3 h-full flex items-center">
                                    <span class="inline-block px-2 py-0.5 text-xs font-semibold {{ $res->Status === 'ACTIVE' ? 'bg-[#e6f5ec] text-[#16734b]' : 'bg-gray-100 text-[#52697c]' }}">
                                        {{ $res->Status }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="border-b last:border-b-0 border-[#d9e4ec] flex h-[44px] items-center text-[13px] text-[#334b5d]">
                            <div class="w-[260px] min-w-[260px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium">
                                Nguyễn An
                            </div>
                            <div class="w-[190px] min-w-[190px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                01/01/2024
                            </div>
                            <div class="flex-1 px-3 h-full flex items-center">
                                <span class="inline-block px-2 py-0.5 text-xs font-semibold bg-[#e6f5ec] text-[#16734b]">
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
            <div class="text-[12px] font-semibold uppercase text-[#334b5d] tracking-wide mb-2">
                XE THUỘC CĂN HỘ · Vehicle
            </div>
            <div id="drawer-vehicles-list" class="p-3 bg-[#f8fbfd] border border-[#d9e4ec] text-[14px] text-[#122d40]">
                @if (isset($selectedApartment) && $selectedApartment->vehicles->isNotEmpty())
                    {{ $selectedApartment->vehicles->map(fn($v) => "{$v->LicensePlate} / {$v->VehicleType}")->join(' · ') }}
                @else
                    29A-10001 / MOTORBIKE
                @endif
            </div>
        </div>

        <!-- Chỉ số Điện / Nước -->
        <div data-name="Chỉ số">
            <div id="drawer-meter-title" class="text-[12px] font-semibold uppercase text-[#334b5d] tracking-wide mb-2">
                ĐIỆN / NƯỚC · 02/2026
            </div>
            <div id="drawer-meter-readings" class="p-3 bg-[#f8fbfd] border border-[#d9e4ec] text-[14px] text-[#122d40] font-medium">
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
            <div id="drawer-debt-note" class="p-3 bg-[#fef7f7] border border-[#fed7d7] text-[13px] text-[#c53030]">
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
            <div id="drawer-audit-note" class="p-3 bg-[#f8fbfd] border border-[#d9e4ec] text-[12px] text-[#52697c]">
                @if (isset($selectedApartment))
                    CreatedAt: {{ $selectedApartment->CreatedAt ?? 'tự sinh' }} · UpdatedAt: {{ $selectedApartment->UpdatedAt ?? 'NULL' }} · IsDeleted: {{ $selectedApartment->IsDeleted ? 'TRUE' : 'FALSE' }} · DeletedAt: {{ $selectedApartment->DeletedAt ?? 'NULL' }}
                @else
                    CreatedAt tự sinh · UpdatedAt NULL · IsDeleted FALSE · DeletedAt NULL
                @endif
            </div>
        </div>
    </div>

    <!-- Drawer Footer Actions -->
    <div class="h-[72px] px-6 border-t border-[#d9e4ec] flex items-center justify-between bg-white flex-shrink-0">
        <button
            type="button"
            onclick="closeApartmentDrawer()"
            class="w-[136px] h-[40px] border border-[#d9e4ec] bg-white hover:bg-gray-50 text-[#334b5d] rounded-[4px] font-medium text-[14px] transition-colors cursor-pointer flex items-center justify-center select-none"
        >
            Đóng
        </button>
        <button
            type="button"
            id="drawer-edit-btn"
            onclick="const aptId = window.currentDrawerApartmentId || ({{ $selectedApartment->ApartmentId ?? '1' }}); closeApartmentDrawer(); openEditApartmentModal(aptId);"
            class="w-[204px] h-[40px] bg-[#2864ad] hover:bg-[#205391] text-white rounded-[4px] font-semibold text-[14px] transition-colors cursor-pointer flex items-center justify-center select-none"
        >
            Chỉnh sửa
        </button>
    </div>
</aside>
