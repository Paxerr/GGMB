@extends('layouts.app', [
    'title' => 'Chỉnh sửa tòa nhà · GGMB',
    'active' => 'buildings',
    'breadcrumbs' => ['GGMB', 'Tòa & tầng']
])

@section('content')
<div class="max-w-[1152px] mx-auto space-y-5">
    <!-- Tiêu đề nghiệp vụ -->
    <div>
        <h1 class="text-[26px] leading-[32px] font-semibold text-[#122d40]">
            Chỉnh sửa tòa nhà
        </h1>
        <p class="mt-1 text-[14px] leading-[20px] text-[#334b5d]">
            {{ $building->BuildingName ?? 'GGMB Residence · Tòa A' }}
        </p>
    </div>

    <!-- Thông tin và quy tắc (Popup / Form box) -->
    <div class="w-full max-w-[688px] bg-white border border-solid border-[#d9e4ec] p-6" data-name="Thông tin">
        <form action="{{ route('buildings.update', $building->BuildingId ?? 1) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Nhóm trường: Tên tòa nhà * -->
                <div class="space-y-1.5 w-full sm:w-[312px]">
                    <label for="BuildingName" class="block text-[12px] leading-[18px] font-semibold text-[#334b5d]">
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
                        class="w-full h-[42px] px-3 bg-white border border-solid border-[#d9e4ec] rounded-[8px] text-[14px] leading-[20px] text-[#334b5d] placeholder:text-[#52697c] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad] transition-colors"
                    >
                    @error('BuildingName')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Thao tác: Hủy & Lưu thay đổi -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a
                        href="{{ route('buildings.index', ['building_id' => $building->BuildingId ?? 1]) }}"
                        class="w-full sm:w-[204px] h-[40px] bg-white hover:bg-gray-50 border border-solid border-[#d9e4ec] rounded-[8px] text-[#334b5d] text-[14px] font-semibold flex items-center justify-center transition-colors cursor-pointer text-center"
                    >
                        Hủy
                    </a>
                    <button
                        type="submit"
                        class="w-full sm:w-[204px] h-[40px] bg-[#2864ad] hover:bg-[#205391] border border-solid border-[#2864ad] rounded-[8px] text-white text-[14px] font-semibold flex items-center justify-center transition-colors cursor-pointer"
                    >
                        Lưu thay đổi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
