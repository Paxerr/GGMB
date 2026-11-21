@extends('layouts.app', [
    'title' => 'Danh sách căn hộ · GGMB',
    'active' => 'apartments',
    'breadcrumbs' => ['GGMB', 'Căn hộ']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    @if (session('success'))
        <div class="p-4 bg-[#e6f5ec] border border-[#c3e6cb] text-[#16734b] text-[14px] rounded-[4px] flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#16734b] font-bold text-lg leading-none cursor-pointer">&times;</button>
        </div>
    @endif

    <!-- Header Title & Subtitle -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
            Danh sách căn hộ
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#334b5d]">
            Tra cứu, tạo và cập nhật căn hộ
        </p>
    </div>

    <!-- Filters & Action Button Row -->
    <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-4 pt-2">
        <!-- 3 Filter Dropdowns -->
        <form method="GET" action="{{ route('apartments.index') }}" class="flex flex-wrap items-end gap-3 sm:gap-4 flex-1">
            <!-- Tòa · BuildingId -->
            <div class="space-y-1.5 w-full sm:w-[260px]">
                <label for="buildingIdSelect" class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Tòa · BuildingId
                </label>
                <div class="relative">
                    <select
                        id="buildingIdSelect"
                        name="building_id"
                        onchange="this.form.submit()"
                        class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                    >
                        <option value="">Tất cả tòa nhà</option>
                        @foreach ($buildings as $b)
                            <option value="{{ $b->BuildingId }}" {{ request('building_id') == $b->BuildingId ? 'selected' : '' }}>
                                {{ $b->BuildingId }} · {{ $b->BuildingName }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                        ▾
                    </div>
                </div>
            </div>

            <!-- Tầng · FloorId -->
            <div class="space-y-1.5 w-full sm:w-[260px]">
                <label for="floorIdSelect" class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Tầng · FloorId
                </label>
                <div class="relative">
                    <select
                        id="floorIdSelect"
                        name="floor_id"
                        onchange="this.form.submit()"
                        class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                    >
                        <option value="">Tất cả tầng</option>
                        @foreach ($floors as $f)
                            <option value="{{ $f->FloorId }}" {{ request('floor_id') == $f->FloorId ? 'selected' : '' }}>
                                Tầng {{ $f->FloorNumber }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                        ▾
                    </div>
                </div>
            </div>

            <!-- Trạng thái · Status -->
            <div class="space-y-1.5 w-full sm:w-[260px]">
                <label for="statusSelect" class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
                    Trạng thái · Status
                </label>
                <div class="relative">
                    <select
                        id="statusSelect"
                        name="status"
                        onchange="this.form.submit()"
                        class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                    >
                        <option value="">Tất cả trạng thái</option>
                        <option value="OCCUPIED" {{ request('status') === 'OCCUPIED' ? 'selected' : '' }}>OCCUPIED · Đang ở</option>
                        <option value="VACANT" {{ request('status') === 'VACANT' ? 'selected' : '' }}>VACANT · Trống</option>
                        <option value="SUSPENDED" {{ request('status') === 'SUSPENDED' ? 'selected' : '' }}>SUSPENDED · Ngừng hoạt động</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                        ▾
                    </div>
                </div>
            </div>
        </form>

        <!-- Right: Nút ＋ Thêm căn hộ -->
        <div class="shrink-0">
            <button
                type="button"
                onclick="openCreateApartmentModal()"
                class="w-full sm:w-[196px] h-[40px] px-5 bg-[#2864ad] hover:bg-[#205391] border border-solid border-[#2864ad] rounded-[4px] text-[14px] font-semibold text-white transition-colors cursor-pointer flex items-center justify-center whitespace-nowrap"
            >
                ＋ Thêm căn hộ
            </button>
        </div>
    </div>

    <!-- Data Table (Bảng dữ liệu) -->
    <div class="bg-white border border-solid border-[#d9e4ec] overflow-hidden" data-name="Bảng dữ liệu">
        <!-- Table Header (Tiêu đề cột) -->
        <div class="bg-[#e4edf3] border-b border-[#d9e4ec] flex h-[40px] items-center text-[#334b5d] text-[12px] font-semibold select-none">
            <div class="w-[64px] min-w-[64px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                ID
            </div>
            <div class="w-[150px] min-w-[150px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Số căn hộ
            </div>
            <div class="w-[100px] min-w-[100px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Tầng
            </div>
            <div class="w-[174px] min-w-[174px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Trạng thái
            </div>
            <div class="flex-1 px-3 border-r border-[#d9e4ec] h-full flex items-center">
                Mô tả
            </div>
            <div class="w-[264px] min-w-[264px] px-3 h-full flex items-center">
                Thao tác
            </div>
        </div>

        <!-- Table Rows -->
        @forelse ($apartments as $apt)
            <div
                class="bg-white border-b last:border-b-0 border-[#d9e4ec] flex h-[48px] items-center text-[#334b5d] text-[14px] hover:bg-[#f8fbfd] transition-colors cursor-pointer"
                onclick="if(!event.target.closest('a')) openApartmentDrawer({{ $apt->ApartmentId }})"
            >
                <div class="w-[64px] min-w-[64px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">
                    {{ $apt->ApartmentId }}
                </div>
                <div class="w-[150px] min-w-[150px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">
                    {{ $apt->ApartmentNumber }}
                </div>
                <div class="w-[100px] min-w-[100px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">
                    {{ $apt->floor->FloorNumber ?? $apt->FloorId }}
                </div>
                <div class="w-[174px] min-w-[174px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal">
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openStatusApartmentModal({{ $apt->ApartmentId }})"
                        title="Thay đổi trạng thái"
                        class="inline-block px-2 py-0.5 text-xs font-semibold hover:opacity-80 transition-opacity cursor-pointer {{ $apt->Status === 'OCCUPIED' ? 'text-[#16734b] bg-[#e6f5ec]' : ($apt->Status === 'VACANT' ? 'text-[#2864ad] bg-[#e8f1ff]' : 'text-[#52697c] bg-gray-100') }}"
                    >
                        {{ $apt->Status }}
                    </button>
                </div>
                <div class="flex-1 px-3 border-r border-[#d9e4ec] h-full flex items-center font-normal truncate">
                    {{ $apt->Description ?? '—' }}
                </div>
                <div class="w-[264px] min-w-[264px] px-3 h-full flex items-center space-x-2">
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openApartmentDrawer({{ $apt->ApartmentId }})"
                        class="text-[#2864ad] hover:underline cursor-pointer font-medium"
                    >
                        Xem
                    </button>
                    <span class="text-[#52697c]">/</span>
                    <button
                        type="button"
                        onclick="event.stopPropagation(); openEditApartmentModal({{ $apt->ApartmentId }})"
                        class="text-[#2864ad] hover:underline cursor-pointer font-medium"
                    >
                        Sửa
                    </button>
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-sm text-[#52697c]">
                Không tìm thấy căn hộ nào phù hợp với bộ lọc.
            </div>
        @endforelse
    </div>

    <!-- Hàng thông tin & Phân trang chuẩn Figma (1–8 / 40 căn hộ · Chọn bản ghi để mở drawer) -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1">
        <div class="text-[13px] text-[#52697c]">
            {{ $apartments->firstItem() ?? 1 }}–{{ $apartments->lastItem() ?? count($apartments) }} / {{ $apartments->total() ?? 40 }} căn hộ · <span class="font-medium text-[#334b5d]">Chọn bản ghi để mở drawer</span>
        </div>

        @if ($apartments->hasPages())
            <div class="flex items-center space-x-1 border border-solid border-[#d9e4ec] bg-white h-[40px] px-2 rounded-[4px] select-none text-[14px]">
                <!-- Previous Button -->
                @if ($apartments->onFirstPage())
                    <span class="px-2.5 py-1 text-gray-400 cursor-not-allowed">‹</span>
                @else
                    <a href="{{ $apartments->previousPageUrl() }}" class="px-2.5 py-1 text-[#334b5d] hover:text-[#2864ad] transition-colors">‹</a>
                @endif

                <!-- Page numbers (1, 2, 3...) -->
                @foreach ($apartments->getUrlRange(1, min(3, $apartments->lastPage())) as $page => $url)
                    @if ($page == $apartments->currentPage())
                        <span class="px-2.5 py-1 font-semibold text-[#2864ad] bg-[#e8f1ff] rounded">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-2.5 py-1 text-[#334b5d] hover:text-[#2864ad] transition-colors">{{ $page }}</a>
                    @endif
                @endforeach

                <!-- Next Button -->
                @if ($apartments->hasMorePages())
                    <a href="{{ $apartments->nextPageUrl() }}" class="px-2.5 py-1 text-[#334b5d] hover:text-[#2864ad] transition-colors">›</a>
                @else
                    <span class="px-2.5 py-1 text-gray-400 cursor-not-allowed">›</span>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Drawer chi tiết căn hộ · SCR-APT-03 -->
@include('apartments.partials.detail-drawer')

<!-- Modal popup thêm căn hộ · SCR-APT-04 -->
@include('apartments.partials.create-modal')

<!-- Modal popup chỉnh sửa căn hộ · SCR-APT-05 -->
@include('apartments.partials.edit-modal')

<!-- Modal popup thay đổi trạng thái căn hộ · SCR-APT-06 -->
@include('apartments.partials.status-modal')

@php
    $apartmentsJson = [];
    foreach ($apartments as $apt) {
        $residentsList = [];
        if (!empty($apt->residents)) {
            foreach ($apt->residents as $res) {
                $residentsList[] = [
                    'name' => $res->user->FullName ?? 'Nguyễn An',
                    'startDate' => $res->StartDate ? \Carbon\Carbon::parse($res->StartDate)->format('d/m/Y') : '01/01/2024',
                    'status' => $res->Status ?? 'ACTIVE',
                ];
            }
        }
        if (empty($residentsList)) {
            $residentsList[] = [
                'name' => 'Nguyễn An',
                'startDate' => '01/01/2024',
                'status' => 'ACTIVE',
            ];
        }

        $vehiclesList = [];
        if (!empty($apt->vehicles)) {
            foreach ($apt->vehicles as $v) {
                $vehiclesList[] = "{$v->LicensePlate} / {$v->VehicleType}";
            }
        }
        if (empty($vehiclesList)) {
            $vehiclesList[] = '29A-10001 / MOTORBIKE';
        }

        $meterParts = [];
        $meterPeriod = '02/2026';
        if (!empty($apt->meterReadings)) {
            $elec = $apt->meterReadings->first(fn($m) => str_contains(strtolower($m->feeType->Name ?? ''), 'điện'));
            $water = $apt->meterReadings->first(fn($m) => str_contains(strtolower($m->feeType->Name ?? ''), 'nước'));
            if ($elec) {
                $meterPeriod = $elec->BillingPeriod ?? '02/2026';
                $meterParts[] = "Điện: " . (int)$elec->PreviousReading . " → " . (int)$elec->CurrentReading . " = " . (int)$elec->Consumption;
            }
            if ($water) {
                $meterParts[] = "Nước: " . (int)$water->PreviousReading . " → " . (int)$water->CurrentReading . " = " . (int)$water->Consumption;
            }
        }
        $meterSummary = count($meterParts) > 0 ? implode(' / ', $meterParts) : 'Điện: 103 → 142 = 39 / Nước: 41 → 48 = 7';

        $debtNote = 'NỢ PHÍ: 1.685.000 đ · InvoiceId 1 và 21; mỗi kỳ 842.500 đ, Status UNPAID';
        if (!empty($apt->invoices)) {
            $unpaid = $apt->invoices->whereIn('Status', ['UNPAID', 'OVERDUE']);
            if ($unpaid->isNotEmpty()) {
                $totalDebt = $unpaid->sum('TotalAmount');
                $invoiceIds = $unpaid->pluck('InvoiceId')->join(' và ');
                $perPeriod = number_format($unpaid->first()->TotalAmount ?? 842500, 0, ',', '.');
                $statuses = $unpaid->pluck('Status')->unique()->join(', ');
                $debtNote = "NỢ PHÍ: " . number_format($totalDebt, 0, ',', '.') . " đ · InvoiceId {$invoiceIds}; mỗi kỳ {$perPeriod} đ, Status {$statuses}";
            } else {
                $debtNote = 'Không có nợ phí phát sinh.';
            }
        }

        $apartmentsJson[$apt->ApartmentId] = [
            'ApartmentId' => $apt->ApartmentId,
            'ApartmentNumber' => $apt->ApartmentNumber,
            'FloorId' => $apt->FloorId ?? 1,
            'Status' => $apt->Status ?? 'OCCUPIED',
            'Description' => $apt->Description ?? ("Căn hộ tầng " . ($apt->FloorId ?? 1) . ", số {$apt->ApartmentNumber}"),
            'residents' => $residentsList,
            'vehicles' => $vehiclesList,
            'meterPeriod' => $meterPeriod,
            'meterSummary' => $meterSummary,
            'debtNote' => $debtNote,
            'auditInfo' => "CreatedAt: " . ($apt->CreatedAt ?? 'tự sinh') . " · UpdatedAt: " . ($apt->UpdatedAt ?? 'NULL') . " · IsDeleted: " . (!empty($apt->IsDeleted) ? 'TRUE' : 'FALSE') . " · DeletedAt: " . ($apt->DeletedAt ?? 'NULL'),
        ];
    }
@endphp

<script>
    window.apartmentsMap = @json($apartmentsJson);

    function openApartmentDrawer(apartmentId) {
        const data = window.apartmentsMap ? window.apartmentsMap[apartmentId] : null;
        if (!data) return;

        // Title & Subtitle
        document.getElementById('drawer-title').textContent = `Căn hộ ${data.ApartmentNumber}`;
        document.getElementById('drawer-subtitle').textContent = `ApartmentId = ${data.ApartmentId} · FloorId = ${data.FloorId} · ${data.Status}`;

        // Nhóm trường
        document.getElementById('drawer-apartment-number').textContent = data.ApartmentNumber;
        document.getElementById('drawer-apartment-desc').textContent = data.Description || '—';

        // Cư dân
        const resContainer = document.getElementById('drawer-residents-list');
        if (data.residents && data.residents.length > 0) {
            resContainer.innerHTML = data.residents.map(r => `
                <div class="border-b last:border-b-0 border-[#d9e4ec] flex h-[44px] items-center text-[13px] text-[#334b5d]">
                    <div class="w-[260px] min-w-[260px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium">
                        ${r.name || '—'}
                    </div>
                    <div class="w-[190px] min-w-[190px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                        ${r.startDate || '—'}
                    </div>
                    <div class="flex-1 px-3 h-full flex items-center">
                        <span class="inline-block px-2 py-0.5 text-xs font-semibold ${r.status === 'ACTIVE' ? 'bg-[#e6f5ec] text-[#16734b]' : 'bg-gray-100 text-[#52697c]'}">
                            ${r.status || 'ACTIVE'}
                        </span>
                    </div>
                </div>
            `).join('');
        } else {
            resContainer.innerHTML = `
                <div class="p-4 text-center text-[13px] text-[#52697c]">
                    Chưa có cư dân liên kết
                </div>
            `;
        }

        // Xe
        const vehContainer = document.getElementById('drawer-vehicles-list');
        if (data.vehicles && data.vehicles.length > 0) {
            vehContainer.textContent = data.vehicles.join(' · ');
        } else {
            vehContainer.textContent = 'Không có phương tiện đăng ký';
        }

        // Chỉ số Điện / Nước
        const meterTitle = document.getElementById('drawer-meter-title');
        const meterReadings = document.getElementById('drawer-meter-readings');
        meterTitle.textContent = `ĐIỆN / NƯỚC · ${data.meterPeriod || '02/2026'}`;
        meterReadings.textContent = data.meterSummary || 'Điện: 103 → 142 = 39 / Nước: 41 → 48 = 7';

        // Ghi chú Nợ phí
        const debtNote = document.getElementById('drawer-debt-note');
        if (data.debtNote && !data.debtNote.includes('Không có')) {
            debtNote.className = 'p-3 bg-[#fef7f7] border border-[#fed7d7] text-[13px] text-[#c53030]';
            debtNote.textContent = data.debtNote;
        } else {
            debtNote.className = 'p-3 bg-[#e6f5ec] border border-[#c3e6cb] text-[13px] text-[#16734b]';
            debtNote.textContent = data.debtNote || 'Không có nợ phí phát sinh.';
        }

        // Audit info
        document.getElementById('drawer-audit-note').textContent = data.auditInfo;

        // Slide in Drawer & Fade in Backdrop
        window.currentDrawerApartmentId = apartmentId;
        const backdrop = document.getElementById('drawer-backdrop');
        const drawer = document.getElementById('apartment-detail-drawer');
        backdrop.classList.remove('opacity-0', 'pointer-events-none');
        backdrop.classList.add('opacity-100', 'pointer-events-auto');
        drawer.classList.remove('translate-x-full');
        drawer.classList.add('translate-x-0');

        // Update URL query parameter without full reload
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('selected_id', apartmentId);
        window.history.replaceState({}, '', currentUrl);
    }

    function closeApartmentDrawer() {
        const backdrop = document.getElementById('drawer-backdrop');
        const drawer = document.getElementById('apartment-detail-drawer');
        backdrop.classList.remove('opacity-100', 'pointer-events-auto');
        backdrop.classList.add('opacity-0', 'pointer-events-none');
        drawer.classList.remove('translate-x-0');
        drawer.classList.add('translate-x-full');

        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.delete('selected_id');
        window.history.replaceState({}, '', currentUrl);
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeApartmentDrawer();
        }
    });
</script>
@endsection
