@extends('layouts.app', [
    'title' => 'Soạn thông báo mới · GGMB',
    'active' => 'notifications',
    'breadcrumbs' => ['Quản trị', 'Thông báo', 'Soạn mới']
])

@section('content')
<div class="max-w-[760px] mx-auto space-y-6 pb-12">
    <span class="sr-only">GGMB</span>
    <!-- Breadcrumb -->
    <nav class="flex items-center text-[12px] text-[#6B7280] space-x-1.5 mb-1.5">
        <span>Quản trị</span>
        <span>/</span>
        <a href="{{ route('notifications.index') }}" class="hover:text-[#0E4D3C]">Thông báo</a>
        <span>/</span>
        <span class="text-[#111827] font-medium">Soạn thông báo mới</span>
    </nav>

    <!-- Header động theo Scope -->
    <div class="space-y-0.5" id="pageHeaderContainer">
        <h1 class="text-[24px] font-bold text-[#111827] tracking-tight" id="pageTitle">
            Soạn thông báo mới
        </h1>
        <p class="text-[13.5px] text-[#6B7280] hidden" id="pageSubtitle">
            Bước chọn người nhận trong biểu mẫu thông báo.
        </p>
    </div>

    <!-- Form Container -->
    <div class="bg-white border border-[#E5E7EB] rounded-[14px] p-6 shadow-none">
        <form id="notificationCreateForm" method="POST" action="{{ route('notifications.store') }}" onsubmit="event.preventDefault(); alert('Đã gửi thông báo thành công (Demo UI)!'); window.location.href='{{ route('notifications.index') }}';">
            @csrf
            <div class="space-y-4">
                <!-- Tiêu đề * -->
                <div>
                    <label for="notif_title" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                        Tiêu đề *
                    </label>
                    <input
                        type="text"
                        id="notif_title"
                        name="title"
                        required
                        placeholder="Nhập tiêu đề thông báo"
                        value="Thông báo lịch bảo trì thang máy"
                        class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                    />
                </div>

                <!-- Nội dung * -->
                <div>
                    <label for="notif_body" class="block text-[12px] font-semibold text-[#374151] mb-1.5">
                        Nội dung *
                    </label>
                    <textarea
                        id="notif_body"
                        name="body"
                        rows="4"
                        required
                        placeholder="Nhập nội dung thông báo cho cư dân"
                        class="w-full px-3 py-2.5 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                    >Thang máy tòa A bảo trì ngày 08/02/2026, 08:00–11:00. Vui lòng sử dụng thang bộ trong thời gian này.</textarea>
                </div>

                <!-- Khu vực điều khiển Scope động -->
                <div id="dynamicScopeFields">
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-6 mt-6 border-t border-[#E5E7EB] flex items-center justify-between">
                <button
                    type="button"
                    id="cancelBtn"
                    onclick="window.location.href='{{ route('notifications.index') }}'"
                    class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-medium rounded-[8px] transition-colors cursor-pointer select-none"
                >
                    Hủy
                </button>
                <button
                    type="submit"
                    class="h-[40px] px-6 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                >
                    Xem trước và gửi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    let currentScope = urlParams.get('scope') || 'building';

    function setScope(scope) {
        currentScope = scope;
        const pageTitle = document.getElementById('pageTitle');
        const pageSubtitle = document.getElementById('pageSubtitle');
        const cancelBtn = document.getElementById('cancelBtn');
        const container = document.getElementById('dynamicScopeFields');

        if (scope === 'floor') {
            pageTitle.textContent = 'Thông báo · Người nhận theo tầng';
            pageSubtitle.textContent = 'Bước chọn người nhận trong biểu mẫu thông báo.';
            pageSubtitle.classList.remove('hidden');
            cancelBtn.textContent = 'Quay lại soạn';
            cancelBtn.onclick = () => setScope('building');

            container.innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Phạm vi *</label>
                            <div class="relative">
                                <select onchange="setScope(this.value)" class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] cursor-pointer">
                                    <option value="building">Tòa nhà ▾</option>
                                    <option value="floor" selected>Tầng ▾</option>
                                    <option value="apartment">Căn hộ ▾</option>
                                    <option value="user">Cá nhân ▾</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Tầng nhận *</label>
                            <div class="relative">
                                <select class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] cursor-pointer">
                                    <option value="1">Tầng 1 ▾</option>
                                    <option value="2" selected>Tầng 2 ▾</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else if (scope === 'apartment') {
            pageTitle.textContent = 'Thông báo · Người nhận theo căn hộ';
            pageSubtitle.textContent = 'Chọn một hoặc nhiều căn hộ nhận thông báo.';
            pageSubtitle.classList.remove('hidden');
            cancelBtn.textContent = 'Quay lại soạn';
            cancelBtn.onclick = () => setScope('building');

            container.innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Phạm vi *</label>
                            <div class="relative">
                                <select onchange="setScope(this.value)" class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] cursor-pointer">
                                    <option value="building">Tòa nhà ▾</option>
                                    <option value="floor">Tầng ▾</option>
                                    <option value="apartment" selected>Căn hộ ▾</option>
                                    <option value="user">Cá nhân ▾</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Căn hộ *</label>
                            <div class="relative">
                                <select class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] cursor-pointer">
                                    <option value="0101" selected>0101 ▾</option>
                                    <option value="0102">0102 ▾</option>
                                    <option value="0103">0103 ▾</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else if (scope === 'user') {
            pageTitle.textContent = 'Thông báo · Người nhận cá nhân';
            pageSubtitle.textContent = 'Chọn người nhận cụ thể, không gán cá nhân vào phạm vi tòa/tầng.';
            pageSubtitle.classList.remove('hidden');
            cancelBtn.textContent = 'Quay lại soạn';
            cancelBtn.onclick = () => setScope('building');

            container.innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Phạm vi *</label>
                            <div class="relative">
                                <select onchange="setScope(this.value)" class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] cursor-pointer">
                                    <option value="building">Tòa nhà ▾</option>
                                    <option value="floor">Tầng ▾</option>
                                    <option value="apartment">Căn hộ ▾</option>
                                    <option value="user" selected>Cá nhân ▾</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Tìm cư dân *</label>
                            <input type="text" placeholder="Họ tên / tên đăng nhập / SĐT" class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C]" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Người nhận đã chọn</label>
                            <input type="text" value="Nguyễn An · resident01" class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none" />
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Số người nhận</label>
                            <input type="text" readonly value="01 · không trùng lặp" class="w-full h-[40px] px-3 bg-[#F8FAF8] border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#6B7280] focus:outline-none" />
                        </div>
                    </div>
                </div>
            `;
        } else {
            pageTitle.textContent = 'Soạn thông báo mới';
            pageSubtitle.textContent = '';
            pageSubtitle.classList.add('hidden');
            cancelBtn.textContent = 'Hủy';
            cancelBtn.onclick = () => window.location.href='{{ route('notifications.index') }}';

            container.innerHTML = `
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Phạm vi nhận *</label>
                        <div class="relative">
                            <select onchange="setScope(this.value)" class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] cursor-pointer">
                                <option value="building" selected>Tòa nhà ▾</option>
                                <option value="floor">Tầng ▾</option>
                                <option value="apartment">Căn hộ ▾</option>
                                <option value="user">Cá nhân ▾</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold text-[#374151] mb-1.5">Tòa nhà *</label>
                        <div class="relative">
                            <select class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] cursor-pointer">
                                <option selected>GGMB Residence · Tòa A ▾</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#6B7280]">▾</div>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    setScope(currentScope);
</script>
@endsection
