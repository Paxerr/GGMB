@extends('layouts.app', [
    'title' => 'Chỉnh sửa căn hộ · GGMB',
    'active' => 'apartments',
    'breadcrumbs' => ['GGMB', 'Căn hộ']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    <!-- Header Title & Subtitle (SCR-APT-05) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
            Chỉnh sửa căn hộ
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#334b5d]">
            Cập nhật số căn và mô tả
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
                Chỉnh sửa căn hộ {{ $apartment->ApartmentNumber }}
            </h2>
            <p class="text-[13px] text-[#52697c] mt-0.5">
                ApartmentId = {{ $apartment->ApartmentId }} · FloorId = {{ $apartment->FloorId }} · Status = {{ $apartment->Status }}
            </p>
        </div>

        <form action="{{ route('apartments.update', $apartment->ApartmentId) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="px-6 py-5 space-y-4" data-name="Nội dung">
                <!-- Số căn hộ · ApartmentNumber * -->
                <div>
                    <label for="editApartmentNumber" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                        Số căn hộ · ApartmentNumber <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="editApartmentNumber"
                        name="ApartmentNumber"
                        value="{{ old('ApartmentNumber', $apartment->ApartmentNumber) }}"
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
                    <label for="editStatus" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                        Trạng thái · Status <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select
                            id="editStatus"
                            name="Status"
                            required
                            class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] rounded-[4px] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                        >
                            <option value="OCCUPIED" {{ old('Status', $apartment->Status) === 'OCCUPIED' ? 'selected' : '' }}>OCCUPIED · Đang ở</option>
                            <option value="VACANT" {{ old('Status', $apartment->Status) === 'VACANT' ? 'selected' : '' }}>VACANT · Trống</option>
                            <option value="SUSPENDED" {{ old('Status', $apartment->Status) === 'SUSPENDED' ? 'selected' : '' }}>SUSPENDED · Ngừng hoạt động</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                            ▾
                        </div>
                    </div>
                    @error('Status')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CƯ DÂN · ApartmentResident → User -->
                <div data-name="Cư dân">
                    <div class="text-[12px] font-semibold uppercase text-[#334b5d] tracking-wide mb-2">
                        CƯ DÂN · ApartmentResident → User
                    </div>
                    <div class="border border-[#d9e4ec] overflow-hidden">
                        <div class="bg-[#e4edf3] border-b border-[#d9e4ec] flex h-[38px] items-center text-[12px] font-semibold text-[#334b5d]">
                            <div class="w-[200px] min-w-[200px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                Họ tên
                            </div>
                            <div class="w-[170px] min-w-[170px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                Ngày vào
                            </div>
                            <div class="w-[140px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                Cư trú
                            </div>
                            <div class="flex-1 px-3 h-full flex items-center">
                                Thao tác
                            </div>
                        </div>

                        <div>
                            @forelse ($apartment->residents as $res)
                                <div class="border-b last:border-b-0 border-[#d9e4ec] flex h-[44px] items-center text-[13px] text-[#334b5d]">
                                    <div class="w-[200px] min-w-[200px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium">
                                        {{ $res->user->FullName ?? '—' }}
                                    </div>
                                    <div class="w-[170px] min-w-[170px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                        {{ $res->StartDate ? \Carbon\Carbon::parse($res->StartDate)->format('d/m/Y') : '01/01/2024' }}
                                    </div>
                                    <div class="w-[140px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                        <span class="inline-block px-2 py-0.5 text-xs font-semibold {{ $res->Status === 'ACTIVE' ? 'bg-[#e6f5ec] text-[#16734b]' : 'bg-gray-100 text-[#52697c]' }}">
                                            {{ $res->Status }}
                                        </span>
                                    </div>
                                    <div class="flex-1 px-3 h-full flex items-center">
                                        <button type="button" class="text-xs text-[#c53030] hover:underline font-semibold cursor-pointer">
                                            Khai trừ
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="p-3 text-center text-[13px] text-[#52697c]">
                                    Chưa có cư dân liên kết
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- XE THUỘC CĂN HỘ · Vehicle -->
                <div data-name="Xe">
                    <div class="text-[12px] font-semibold uppercase text-[#334b5d] tracking-wide mb-2">
                        XE THUỘC CĂN HỘ · Vehicle
                    </div>
                    <div class="border border-[#d9e4ec] overflow-hidden">
                        <div class="bg-[#e4edf3] border-b border-[#d9e4ec] flex h-[38px] items-center text-[12px] font-semibold text-[#334b5d]">
                            <div class="w-[200px] min-w-[200px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                Biển số xe
                            </div>
                            <div class="w-[170px] min-w-[170px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                Ngày đăng ký
                            </div>
                            <div class="w-[140px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                Loại xe
                            </div>
                            <div class="flex-1 px-3 h-full flex items-center">
                                Thao tác
                            </div>
                        </div>

                        <div>
                            @forelse ($apartment->vehicles as $v)
                                <div class="border-b last:border-b-0 border-[#d9e4ec] flex h-[44px] items-center text-[13px] text-[#334b5d]">
                                    <div class="w-[200px] min-w-[200px] px-3 border-r border-[#d9e4ec] h-full flex items-center font-medium">
                                        {{ $v->LicensePlate }}
                                    </div>
                                    <div class="w-[170px] min-w-[170px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                        01/01/2024
                                    </div>
                                    <div class="w-[140px] min-w-[140px] px-3 border-r border-[#d9e4ec] h-full flex items-center">
                                        {{ $v->VehicleType === 'CAR' ? 'Ô tô' : 'Xe máy' }}
                                    </div>
                                    <div class="flex-1 px-3 h-full flex items-center">
                                        <button type="button" class="text-xs text-[#c53030] hover:underline font-semibold cursor-pointer">
                                            Khai trừ
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="p-3 text-center text-[13px] text-[#52697c]">
                                    Không có phương tiện đăng ký
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Mô tả · Description -->
                <div>
                    <label for="editDescription" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                        Mô tả · Description
                    </label>
                    <textarea
                        id="editDescription"
                        name="Description"
                        rows="3"
                        maxlength="500"
                        placeholder="Nhập mô tả, có thể để trống"
                        class="w-full p-3 bg-white border border-solid border-[#d9e4ec] rounded-[4px] text-[14px] leading-[20px] text-[#334b5d] placeholder:text-[#52697c] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] transition-colors resize-y"
                    >{{ old('Description', $apartment->Description) }}</textarea>
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
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
