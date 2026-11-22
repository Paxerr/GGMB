@extends('layouts.app', [
    'title' => 'Chỉnh sửa phương tiện · GGMB',
    'active' => 'vehicles',
    'breadcrumbs' => ['Quản trị', 'Xe & đăng ký', 'Chỉnh sửa']
])

@section('content')
<div class="space-y-6">
    <span class="sr-only">GGMB</span>

    <!-- Tiêu đề & Phụ đề -->
    <div>
        <nav class="flex items-center text-[12px] text-[#6B7280] space-x-1.5 mb-1.5">
            <span>Quản trị</span>
            <span>/</span>
            <a href="{{ route('vehicles.index') }}" class="hover:text-[#0E4D3C]">Xe & đăng ký</a>
            <span>/</span>
            <span class="text-[#111827] font-medium">Chỉnh sửa</span>
        </nav>
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight">
            Chỉnh sửa phương tiện
        </h1>
        <p class="mt-0.5 text-[13.5px] text-[#6B7280]">
            {{ $vehicle->LicensePlate ?? '29-B1 100.01' }} · Cập nhật thông tin gắn với căn hộ.
        </p>
    </div>

    <!-- Khối form 688px -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-6 sm:p-[25px] w-full max-w-[688px] shadow-none">
        <form method="POST" action="{{ route('vehicles.update', $vehicle->VehicleId ?? 1) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Hàng 1: Biển số & Loại xe (2 cols) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="LicensePlate" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                        Biển số *
                    </label>
                    <input
                        type="text"
                        id="LicensePlate"
                        name="LicensePlate"
                        value="{{ old('LicensePlate', $vehicle->LicensePlate ?? '29-B1 100.01') }}"
                        required
                        class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] uppercase"
                    />
                </div>

                <div>
                    <label for="VehicleType" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                        Loại xe *
                    </label>
                    <div class="relative">
                        <select
                            id="VehicleType"
                            name="VehicleType"
                            required
                            class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                        >
                            <option value="MOTORBIKE" {{ ($vehicle->VehicleType ?? '') === 'MOTORBIKE' ? 'selected' : '' }}>Xe máy · MOTORBIKE</option>
                            <option value="CAR" {{ ($vehicle->VehicleType ?? '') === 'CAR' ? 'selected' : '' }}>Ô tô · CAR</option>
                            <option value="ELECTRIC_BIKE" {{ ($vehicle->VehicleType ?? '') === 'ELECTRIC_BIKE' ? 'selected' : '' }}>Xe máy điện · ELECTRIC</option>
                            <option value="BICYCLE" {{ ($vehicle->VehicleType ?? '') === 'BICYCLE' ? 'selected' : '' }}>Xe đạp · BICYCLE</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">
                            ▾
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hàng 2: Căn hộ liên kết -->
            <div>
                <label for="ApartmentId" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                    Căn hộ *
                </label>
                <div class="relative">
                    <select
                        id="ApartmentId"
                        name="ApartmentId"
                        required
                        class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                    >
                        @foreach ($apartments as $apt)
                            <option value="{{ $apt->ApartmentId }}" {{ ($vehicle->ApartmentId ?? 1) == $apt->ApartmentId ? 'selected' : '' }}>
                                {{ $apt->ApartmentNumber }} · Tầng {{ $apt->floor?->FloorNumber ?? 1 }} ({{ $apt->floor?->building?->BuildingName ?? 'Tòa A' }})
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">
                        ▾
                    </div>
                </div>
            </div>

            <!-- Hàng 3: Nút Hủy & Lưu thay đổi -->
            <div class="flex items-center justify-between pt-3">
                <a
                    href="{{ route('vehicles.show', $vehicle->VehicleId ?? 1) }}"
                    class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-medium rounded-[8px] transition-colors flex items-center justify-center cursor-pointer select-none"
                >
                    Hủy
                </a>
                <button
                    type="submit"
                    class="h-[40px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                >
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
