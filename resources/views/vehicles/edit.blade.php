@extends('layouts.app', [
    'title' => 'Chỉnh sửa phương tiện · GGMB',
    'active' => 'vehicles',
    'breadcrumbs' => ['GGMB', 'Xe & đăng ký']
])

@section('content')
<div class="max-w-[1216px] mx-auto space-y-6">
    <!-- Tiêu đề & Phụ đề (28 · SCR-VEH-04) -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
            Chỉnh sửa phương tiện
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#334b5d]">
            {{ $vehicle->LicensePlate ?? '29-B1 100.01' }} · Cập nhật thông tin gắn với căn hộ.
        </p>
    </div>

    <!-- Khối form 688px -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 sm:p-[25px] w-full max-w-[688px]">
        <form method="POST" action="{{ route('vehicles.update', $vehicle->VehicleId ?? 1) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Hàng 1: Biển số & Loại xe (2 cols) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="LicensePlate" class="block text-[12px] leading-[17px] font-semibold text-[#334b5d] mb-1.5">
                        Biển số *
                    </label>
                    <input
                        type="text"
                        id="LicensePlate"
                        name="LicensePlate"
                        value="{{ old('LicensePlate', $vehicle->LicensePlate ?? '29-B1 100.01') }}"
                        required
                        class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] uppercase"
                    />
                </div>

                <div>
                    <label for="VehicleType" class="block text-[12px] leading-[17px] font-semibold text-[#334b5d] mb-1.5">
                        Loại xe *
                    </label>
                    <div class="relative">
                        <select
                            id="VehicleType"
                            name="VehicleType"
                            required
                            class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                        >
                            <option value="MOTORBIKE" {{ ($vehicle->VehicleType ?? '') === 'MOTORBIKE' ? 'selected' : '' }}>Xe máy · MOTORBIKE</option>
                            <option value="CAR" {{ ($vehicle->VehicleType ?? '') === 'CAR' ? 'selected' : '' }}>Ô tô · CAR</option>
                            <option value="ELECTRIC_BIKE" {{ ($vehicle->VehicleType ?? '') === 'ELECTRIC_BIKE' ? 'selected' : '' }}>Xe máy điện · ELECTRIC</option>
                            <option value="BICYCLE" {{ ($vehicle->VehicleType ?? '') === 'BICYCLE' ? 'selected' : '' }}>Xe đạp · BICYCLE</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                            ▾
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hàng 2: Căn hộ liên kết -->
            <div>
                <label for="ApartmentId" class="block text-[12px] leading-[17px] font-semibold text-[#334b5d] mb-1.5">
                    Căn hộ *
                </label>
                <div class="relative">
                    <select
                        id="ApartmentId"
                        name="ApartmentId"
                        required
                        class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] leading-[20px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] cursor-pointer"
                    >
                        @foreach ($apartments as $apt)
                            <option value="{{ $apt->ApartmentId }}" {{ ($vehicle->ApartmentId ?? 1) == $apt->ApartmentId ? 'selected' : '' }}>
                                {{ $apt->ApartmentNumber }} · Tầng {{ $apt->floor?->FloorNumber ?? 1 }} ({{ $apt->floor?->building?->BuildingName ?? 'Tòa A' }})
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                        ▾
                    </div>
                </div>
            </div>

            <!-- Hàng 3: Nút Hủy & Lưu thay đổi -->
            <div class="flex items-center justify-between pt-3">
                <a
                    href="{{ route('vehicles.show', $vehicle->VehicleId ?? 1) }}"
                    class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors flex items-center justify-center cursor-pointer select-none"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-8 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
                >
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
