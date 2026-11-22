@extends('layouts.app', [
    'title' => 'Chỉnh sửa căn hộ · GGMB',
    'active' => 'apartments',
    'breadcrumbs' => ['GGMB', 'Căn hộ']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    <!-- Header Title & Subtitle (SCR-APT-05) -->
    <div>
        <h1 class="text-[24px] leading-[32px] font-bold text-[#111827]">
            Chỉnh sửa căn hộ
        </h1>
        <p class="mt-1 text-[13.5px] leading-[20px] text-[#6B7280]">
            Cập nhật số căn và mô tả
        </p>
    </div>

    <!-- Form Container (Width: 688px max) -->
    <div class="w-full max-w-[688px] bg-white border border-[#E5E7EB] rounded-[14px] shadow-xs overflow-hidden" data-name="03 · Modal">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-[#E5E7EB] bg-[#F2F6F4]">
            <span class="text-[11px] font-bold uppercase tracking-wider text-[#6B7280]">
                BIỂU MẪU / MODAL
            </span>
            <h2 class="text-[18px] font-bold text-[#111827] mt-1">
                Chỉnh sửa căn hộ {{ $apartment->ApartmentNumber }}
            </h2>
            <p class="text-[13px] text-[#6B7280] mt-0.5">
                ApartmentId = {{ $apartment->ApartmentId }} · FloorId = {{ $apartment->FloorId }} · Status = {{ $apartment->Status }}
            </p>
        </div>

        <form action="{{ route('apartments.update', $apartment->ApartmentId) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="px-6 py-5 space-y-4" data-name="Nội dung">
                <!-- Số căn hộ · ApartmentNumber * -->
                <div>
                    <label for="editApartmentNumber" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                        Số căn hộ · ApartmentNumber <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="editApartmentNumber"
                        name="ApartmentNumber"
                        value="{{ old('ApartmentNumber', $apartment->ApartmentNumber) }}"
                        required
                        maxlength="20"
                        placeholder="Nhập tối đa 20 ký tự"
                        class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] leading-[20px] text-[#111827] placeholder:text-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] transition-colors"
                    >
                    @error('ApartmentNumber')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Trạng thái · Status * -->
                <div>
                    <label for="editStatus" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                        Trạng thái · Status <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <select
                            id="editStatus"
                            name="Status"
                            required
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] leading-[20px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                        >
                            <option value="OCCUPIED" {{ old('Status', $apartment->Status) === 'OCCUPIED' ? 'selected' : '' }}>OCCUPIED · Đang ở</option>
                            <option value="VACANT" {{ old('Status', $apartment->Status) === 'VACANT' ? 'selected' : '' }}>VACANT · Trống</option>
                            <option value="SUSPENDED" {{ old('Status', $apartment->Status) === 'SUSPENDED' ? 'selected' : '' }}>SUSPENDED · Ngừng hoạt động</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">
                            ▾
                        </div>
                    </div>
                    @error('Status')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CƯ DÂN · ApartmentResident → User -->
                <div data-name="Cư dân">
                    <div class="text-[12px] font-semibold uppercase text-[#374151] tracking-wide mb-2">
                        CƯ DÂN · ApartmentResident → User
                    </div>
                    <div class="border border-[#E5E7EB] rounded-[8px] overflow-hidden">
                        <div class="bg-[#F2F6F4] border-b border-[#E5E7EB] flex h-[38px] items-center text-[12px] font-semibold text-[#374151]">
                            <div class="w-[200px] min-w-[200px] px-3 border-r border-[#E5E7EB] h-full flex items-center">
                                Họ tên
                            </div>
                            <div class="w-[170px] min-w-[170px] px-3 border-r border-[#E5E7EB] h-full flex items-center">
                                Ngày vào
                            </div>
                            <div class="w-[140px] min-w-[140px] px-3 border-r border-[#E5E7EB] h-full flex items-center">
                                Cư trú
                            </div>
                            <div class="flex-1 px-3 h-full flex items-center">
                                Thao tác
                            </div>
                        </div>

                        <div>
                            @forelse ($apartment->residents as $res)
                                <div class="border-b last:border-b-0 border-[#E5E7EB] flex h-[44px] items-center text-[13px] text-[#374151]">
                                    <div class="w-[200px] min-w-[200px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-medium">
                                        {{ $res->user->FullName ?? '—' }}
                                    </div>
                                    <div class="w-[170px] min-w-[170px] px-3 border-r border-[#E5E7EB] h-full flex items-center text-[#6B7280]">
                                        {{ $res->StartDate ? \Carbon\Carbon::parse($res->StartDate)->format('d/m/Y') : '01/01/2024' }}
                                    </div>
                                    <div class="w-[140px] min-w-[140px] px-3 border-r border-[#E5E7EB] h-full flex items-center">
                                        <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded-[6px] {{ $res->Status === 'ACTIVE' ? 'bg-[#E4EFE9] text-[#0E4D3C]' : 'bg-gray-100 text-[#6B7280]' }}">
                                            {{ $res->Status }}
                                        </span>
                                    </div>
                                    <div class="flex-1 px-3 h-full flex items-center">
                                        <button type="button" class="text-xs text-rose-600 hover:underline font-semibold cursor-pointer">
                                            Khai trừ
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="p-3 text-center text-[13px] text-[#6B7280]">
                                    Chưa có cư dân liên kết
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- XE THUỘC CĂN HỘ · Vehicle -->
                <div data-name="Xe">
                    <div class="text-[12px] font-semibold uppercase text-[#374151] tracking-wide mb-2">
                        XE THUỘC CĂN HỘ · Vehicle
                    </div>
                    <div class="border border-[#E5E7EB] rounded-[8px] overflow-hidden">
                        <div class="bg-[#F2F6F4] border-b border-[#E5E7EB] flex h-[38px] items-center text-[12px] font-semibold text-[#374151]">
                            <div class="w-[200px] min-w-[200px] px-3 border-r border-[#E5E7EB] h-full flex items-center">
                                Biển số xe
                            </div>
                            <div class="w-[170px] min-w-[170px] px-3 border-r border-[#E5E7EB] h-full flex items-center">
                                Ngày đăng ký
                            </div>
                            <div class="w-[140px] min-w-[140px] px-3 border-r border-[#E5E7EB] h-full flex items-center">
                                Loại xe
                            </div>
                            <div class="flex-1 px-3 h-full flex items-center">
                                Thao tác
                            </div>
                        </div>

                        <div>
                            @forelse ($apartment->vehicles as $v)
                                <div class="border-b last:border-b-0 border-[#E5E7EB] flex h-[44px] items-center text-[13px] text-[#374151]">
                                    <div class="w-[200px] min-w-[200px] px-3 border-r border-[#E5E7EB] h-full flex items-center font-medium">
                                        {{ $v->LicensePlate }}
                                    </div>
                                    <div class="w-[170px] min-w-[170px] px-3 border-r border-[#E5E7EB] h-full flex items-center text-[#6B7280]">
                                        01/01/2024
                                    </div>
                                    <div class="w-[140px] min-w-[140px] px-3 border-r border-[#E5E7EB] h-full flex items-center">
                                        {{ $v->VehicleType === 'CAR' ? 'Ô tô' : 'Xe máy' }}
                                    </div>
                                    <div class="flex-1 px-3 h-full flex items-center">
                                        <button type="button" class="text-xs text-rose-600 hover:underline font-semibold cursor-pointer">
                                            Khai trừ
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="p-3 text-center text-[13px] text-[#6B7280]">
                                    Không có phương tiện đăng ký
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Mô tả · Description -->
                <div>
                    <label for="editDescription" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                        Mô tả · Description
                    </label>
                    <textarea
                        id="editDescription"
                        name="Description"
                        rows="3"
                        maxlength="500"
                        placeholder="Nhập mô tả, có thể để trống"
                        class="w-full p-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] leading-[20px] text-[#111827] placeholder:text-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] transition-colors resize-y"
                    >{{ old('Description', $apartment->Description) }}</textarea>
                    @error('Description')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-6 py-4 bg-[#F2F6F4] border-t border-[#E5E7EB] flex items-center justify-between">
                <a
                    href="{{ route('apartments.index') }}"
                    class="h-[38px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] rounded-[8px] font-semibold text-[13px] transition-colors cursor-pointer flex items-center justify-center select-none"
                >
                    Đóng / Hủy
                </a>
                <button
                    type="submit"
                    class="h-[38px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white rounded-[8px] font-semibold text-[13px] transition-colors cursor-pointer flex items-center justify-center select-none shadow-sm"
                >
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
