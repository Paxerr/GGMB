@extends('layouts.app', [
    'title' => 'Thêm căn hộ · GGMB',
    'active' => 'apartments',
    'breadcrumbs' => ['GGMB', 'Căn hộ']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    <!-- Header Title & Subtitle (SCR-APT-04) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
            Thêm căn hộ
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#334b5d]">
            Tạo bản ghi Apartment mới trong hệ thống
        </p>
    </div>

    <!-- Form Container (Width: 688px max) -->
    <div class="w-full max-w-[688px] bg-white border border-solid border-[#d9e4ec] rounded-[4px] shadow-sm overflow-hidden" data-name="03 · Modal">
        <!-- Header -->
        <div class="px-6 pt-4 pb-3 border-b border-[#d9e4ec]">
            <span class="text-[11px] font-bold uppercase tracking-wider text-[#52697c]">
                BIỂU MẪU / MODAL
            </span>
            <h2 class="text-[22px] font-bold text-[#122d40] mt-1">
                Thêm căn hộ
            </h2>
            <p class="text-[13px] text-[#52697c] mt-0.5">
                Các trường có dấu * là bắt buộc
            </p>
        </div>

        <form action="{{ route('apartments.store') }}" method="POST">
            @csrf

            <div class="px-6 py-5 space-y-4" data-name="Nội dung">
                <!-- Nhóm trường: Tòa & Tầng (2 cols) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" data-name="Nhóm trường">
                    <!-- Tòa · qua Floor.BuildingId -->
                    <div>
                        <label for="buildingIdSelect" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Tòa · qua Floor.BuildingId
                        </label>
                        <div class="relative">
                            <select
                                id="buildingIdSelect"
                                onchange="filterFloors(this.value)"
                                class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] rounded-[4px] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                            >
                                @foreach ($buildings as $b)
                                    <option value="{{ $b->BuildingId }}">
                                        {{ $b->BuildingId }} · {{ $b->BuildingName }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                                ▾
                            </div>
                        </div>
                    </div>

                    <!-- Tầng · FloorId * -->
                    <div>
                        <label for="floorIdSelect" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                            Tầng · FloorId <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select
                                id="floorIdSelect"
                                name="FloorId"
                                required
                                class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] rounded-[4px] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                            >
                                <option value="">Chọn tầng ▾</option>
                                @foreach ($floors as $f)
                                    <option
                                        value="{{ $f->FloorId }}"
                                        data-building-id="{{ $f->BuildingId }}"
                                        {{ old('FloorId') == $f->FloorId ? 'selected' : '' }}
                                    >
                                        Tầng {{ $f->FloorNumber }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                                ▾
                            </div>
                        </div>
                        @error('FloorId')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Số căn hộ · ApartmentNumber * -->
                <div>
                    <label for="apartmentNumber" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                        Số căn hộ · ApartmentNumber <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="apartmentNumber"
                        name="ApartmentNumber"
                        value="{{ old('ApartmentNumber') }}"
                        required
                        maxlength="20"
                        placeholder="Nhập tối đa 20 ký tự"
                        class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] rounded-[4px] text-[14px] leading-[20px] text-[#334b5d] placeholder:text-[#52697c] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] transition-colors"
                    >
                    @error('ApartmentNumber')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Trạng thái · Status * -->
                <div>
                    <label for="statusSelect" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                        Trạng thái · Status <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select
                            id="statusSelect"
                            name="Status"
                            required
                            class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] rounded-[4px] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                        >
                            <option value="VACANT" {{ old('Status', 'VACANT') === 'VACANT' ? 'selected' : '' }}>VACANT · Trống</option>
                            <option value="OCCUPIED" {{ old('Status') === 'OCCUPIED' ? 'selected' : '' }}>OCCUPIED · Đang ở</option>
                            <option value="SUSPENDED" {{ old('Status') === 'SUSPENDED' ? 'selected' : '' }}>SUSPENDED · Ngừng hoạt động</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                            ▾
                        </div>
                    </div>
                    @error('Status')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mô tả · Description -->
                <div>
                    <label for="description" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                        Mô tả · Description
                    </label>
                    <textarea
                        id="description"
                        name="Description"
                        rows="3"
                        maxlength="500"
                        placeholder="Nhập mô tả, có thể để trống"
                        class="w-full p-3 bg-white border border-solid border-[#d9e4ec] rounded-[4px] text-[14px] leading-[20px] text-[#334b5d] placeholder:text-[#52697c] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] transition-colors resize-y"
                    >{{ old('Description') }}</textarea>
                    @error('Description')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="h-[72px] px-6 border-t border-[#d9e4ec] flex items-center justify-between bg-white flex-shrink-0">
                <a
                    href="{{ route('apartments.index') }}"
                    class="w-[136px] h-[40px] border border-[#d9e4ec] bg-white hover:bg-gray-50 text-[#334b5d] rounded-[4px] font-medium text-[14px] transition-colors cursor-pointer flex items-center justify-center select-none"
                >
                    Đóng / Hủy
                </a>
                <button
                    type="submit"
                    class="w-[204px] h-[40px] bg-[#2864ad] hover:bg-[#205391] text-white rounded-[4px] font-semibold text-[14px] transition-colors cursor-pointer flex items-center justify-center select-none"
                >
                    Tạo căn hộ
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function filterFloors(buildingId) {
        const floorSelect = document.getElementById('floorIdSelect');
        if (!floorSelect) return;
        const options = floorSelect.querySelectorAll('option[data-building-id]');
        let hasMatch = false;
        options.forEach(opt => {
            if (!buildingId || opt.dataset.buildingId === buildingId) {
                opt.style.display = '';
                if (!hasMatch && !floorSelect.value) {
                    opt.selected = true;
                    hasMatch = true;
                }
            } else {
                opt.style.display = 'none';
                if (opt.selected) {
                    opt.selected = false;
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const bSelect = document.getElementById('buildingIdSelect');
        if (bSelect) {
            filterFloors(bSelect.value);
        }
    });
</script>
@endsection
