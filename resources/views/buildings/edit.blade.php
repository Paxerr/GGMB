@extends('layouts.app', [
    'title' => 'Chỉnh sửa tòa nhà · GGMB',
    'active' => 'buildings',
    'breadcrumbs' => ['GGMB', 'Tòa & tầng']
])

@section('content')
<div class="w-full space-y-5">
    <!-- Tiêu đề nghiệp vụ -->
    <div>
        <h1 class="text-[24px] leading-[32px] font-bold text-[#111827]">
            Chỉnh sửa tòa nhà
        </h1>
        <p class="mt-1 text-[13.5px] leading-[20px] text-[#6B7280]">
            {{ $building->BuildingName ?? 'GGMB Residence · Tòa A' }}
        </p>
    </div>

    <!-- Thông tin và quy tắc (Popup / Form box) -->
    <div class="w-full max-w-[688px] bg-white border border-[#E5E7EB] rounded-[14px] p-6 shadow-xs" data-name="Thông tin">
        <form action="{{ route('buildings.update', $building->BuildingId ?? 1) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Nhóm trường: Tên tòa nhà * -->
                <div class="space-y-1.5 w-full sm:w-[312px]">
                    <label for="BuildingName" class="block text-[12px] leading-[18px] font-semibold text-[#374151]">
                        Tên tòa nhà *
                    </label>
                    <input
                        type="text"
                        id="BuildingName"
                        name="BuildingName"
                        value="{{ old('BuildingName', $building->BuildingName ?? 'GGMB Residence · Tòa A') }}"
                        required
                        autofocus
                        placeholder="Nhập tên tòa nhà"
                        class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] leading-[20px] text-[#111827] placeholder:text-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] transition-colors"
                    >
                    @error('BuildingName')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Thao tác: Hủy & Lưu thay đổi -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a
                        href="{{ route('buildings.index', ['building_id' => $building->BuildingId ?? 1]) }}"
                        class="w-full sm:w-[204px] h-[40px] bg-white hover:bg-[#F9FBFA] border border-[#E5E7EB] rounded-[8px] text-[#374151] text-[13.5px] font-semibold flex items-center justify-center transition-colors cursor-pointer text-center"
                    >
                        Hủy
                    </a>
                    <button
                        type="submit"
                        class="w-full sm:w-[204px] h-[40px] bg-[#0E4D3C] hover:bg-[#0A3D2F] border border-[#0E4D3C] rounded-[8px] text-white text-[13.5px] font-semibold flex items-center justify-center transition-colors cursor-pointer"
                    >
                        Lưu thay đổi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
