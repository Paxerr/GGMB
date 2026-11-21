@extends('layouts.app', [
    'title' => 'Soạn thông báo mới · GGMB',
    'active' => 'notifications',
    'breadcrumbs' => ['GGMB', 'Thông báo']
])

@section('content')
<div class="max-w-[760px] mx-auto space-y-6 pb-12">
    <!-- Breadcrumb (Bám sát Ảnh 1, 3, 4, 5) -->
    <nav class="flex items-center text-[13px] leading-[18px] text-[#52697c] space-x-2">
        <a href="{{ route('dashboard') }}" class="hover:text-[#2864ad] transition-colors">GGMB</a>
        <span>/</span>
        <a href="{{ route('notifications.index') }}" class="hover:text-[#2864ad] transition-colors">Thông báo</a>
    </nav>

    <!-- Header động theo Scope (Bám sát Ảnh 1, 3, 4, 5) -->
    <div class="space-y-1" id="pageHeaderContainer">
        <h1 class="text-[26px] leading-[32px] font-bold text-[#122d40]" id="pageTitle">
            Soạn thông báo mới
        </h1>
        <p class="text-[14px] leading-[20px] text-[#52697c] hidden" id="pageSubtitle">
            Bước chọn người nhận trong biểu mẫu thông báo.
        </p>
    </div>

    <!-- Form Container (Bám sát Ảnh 1, 3, 4, 5) -->
    <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-6 shadow-xs">
        <form id="notificationCreateForm" method="POST" action="{{ route('notifications.store') }}" onsubmit="event.preventDefault(); alert('Đã gửi thông báo thành công (Demo UI)!'); window.location.href='{{ route('notifications.index') }}';">
            @csrf
            <div class="space-y-4">
                <!-- Tiêu đề * -->
                <div>
                    <label for="notif_title" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                        Tiêu đề *
                    </label>
                    <input
                        type="text"
                        id="notif_title"
                        name="title"
                        required
                        placeholder="Nhập tiêu đề thông báo"
                        value="Thông báo lịch bảo trì thang máy"
                        class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                    />
                </div>

                <!-- Nội dung * -->
                <div>
                    <label for="notif_body" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                        Nội dung *
                    </label>
                    <textarea
                        id="notif_body"
                        name="body"
                        rows="4"
                        required
                        placeholder="Nhập nội dung thông báo cho cư dân"
                        class="w-full px-3 py-2.5 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                    >Thang máy tòa A bảo trì ngày 08/02/2026, 08:00–11:00. Vui lòng sử dụng thang bộ trong thời gian này.</textarea>
                </div>

                <!-- Khu vực điều khiển Scope động -->
                <div id="dynamicScopeFields">
                    <!-- Sẽ render bằng JS bám sát Ảnh 1 (Tòa nhà), Ảnh 3 (Tầng), Ảnh 4 (Căn hộ), Ảnh 5 (Cá nhân) -->
                </div>
            </div>

            <!-- Footer Buttons (Hủy / Quay lại soạn bên trái, Xem trước và gửi bên phải) -->
            <div class="pt-6 mt-6 border-t border-[#d9e4ec] flex items-center justify-between">
                <button
                    type="button"
                    id="cancelBtn"
                    onclick="window.location.href='{{ route('notifications.index') }}'"
                    class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                >
                    Hủy
                </button>
                <button
                    type="submit"
                    class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
                >
                    Xem trước và gửi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Kiểm tra URL query param ?scope=...
    const urlParams = new URLSearchParams(window.location.search);
    let currentScope = urlParams.get('scope') || 'building';

    function setScope(scope) {
        currentScope = scope;
        const pageTitle = document.getElementById('pageTitle');
        const pageSubtitle = document.getElementById('pageSubtitle');
        const cancelBtn = document.getElementById('cancelBtn');
        const container = document.getElementById('dynamicScopeFields');

        if (scope === 'floor') {
            // Ảnh 3: Thông báo · Người nhận theo tầng
            pageTitle.textContent = 'Thông báo · Người nhận theo tầng';
            pageSubtitle.textContent = 'Bước chọn người nhận trong biểu mẫu thông báo.';
            pageSubtitle.classList.remove('hidden');
            cancelBtn.textContent = 'Quay lại soạn';
            cancelBtn.onclick = () => setScope('building');

            container.innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">Phạm vi *</label>
                            <div class="relative">
                                <select onchange="setScope(this.value)" class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                                    <option value="building">Tòa nhà ▾</option>
                                    <option value="floor" selected>Tầng ▾</option>
                                    <option value="apartment">Căn hộ ▾</option>
                                    <option value="user">Cá nhân ▾</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">Tòa nhà *</label>
                            <div class="relative">
                                <select class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                                    <option selected>GGMB Residence · Tòa A ▾</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">Tầng nhận *</label>
                            <div class="relative">
                                <select class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                                    <option value="1">Tầng 1 ▾</option>
                                    <option value="2" selected>Tầng 2 ▾</option>
                                    <option value="3">Tầng 3 ▾</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">Đối tượng</label>
                            <input type="text" readonly value="Cư dân đang cư trú" class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] focus:outline-none" />
                        </div>
                    </div>
                </div>
            `;
        } else if (scope === 'apartment') {
            // Ảnh 4: Thông báo · Người nhận theo căn hộ
            pageTitle.textContent = 'Thông báo · Người nhận theo căn hộ';
            pageSubtitle.textContent = 'Bước chọn người nhận trong biểu mẫu thông báo.';
            pageSubtitle.classList.remove('hidden');
            cancelBtn.textContent = 'Quay lại soạn';
            cancelBtn.onclick = () => setScope('building');

            container.innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">Phạm vi *</label>
                            <div class="relative">
                                <select onchange="setScope(this.value)" class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                                    <option value="building">Tòa nhà ▾</option>
                                    <option value="floor">Tầng ▾</option>
                                    <option value="apartment" selected>Căn hộ ▾</option>
                                    <option value="user">Cá nhân ▾</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">Tòa nhà *</label>
                            <div class="relative">
                                <select class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                                    <option selected>GGMB Residence · Tòa A ▾</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">Tầng *</label>
                            <div class="relative">
                                <select class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                                    <option value="1" selected>Tầng 1 ▾</option>
                                    <option value="2">Tầng 2 ▾</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">Căn hộ nhận *</label>
                            <div class="relative">
                                <select class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                                    <option value="0101" selected>0101 ▾</option>
                                    <option value="0102">0102 ▾</option>
                                    <option value="0103">0103 ▾</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else if (scope === 'user') {
            // Ảnh 5: Thông báo · Người nhận cá nhân
            pageTitle.textContent = 'Thông báo · Người nhận cá nhân';
            pageSubtitle.textContent = 'Chọn người nhận cụ thể, không gán cá nhân vào phạm vi tòa/tầng.';
            pageSubtitle.classList.remove('hidden');
            cancelBtn.textContent = 'Quay lại soạn';
            cancelBtn.onclick = () => setScope('building');

            container.innerHTML = `
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">Phạm vi *</label>
                            <div class="relative">
                                <select onchange="setScope(this.value)" class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                                    <option value="building">Tòa nhà ▾</option>
                                    <option value="floor">Tầng ▾</option>
                                    <option value="apartment">Căn hộ ▾</option>
                                    <option value="user" selected>Cá nhân ▾</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">Tìm cư dân *</label>
                            <input type="text" placeholder="Họ tên / tên đăng nhập / SĐT" class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad]" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">Người nhận đã chọn</label>
                            <input type="text" value="Nguyễn An · resident01" class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] focus:outline-none" />
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">Số người nhận</label>
                            <input type="text" readonly value="01 · không trùng lặp" class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] focus:outline-none" />
                        </div>
                    </div>
                </div>
            `;
        } else {
            // Ảnh 1: Soạn thông báo mới (Tòa nhà)
            pageTitle.textContent = 'Soạn thông báo mới';
            pageSubtitle.textContent = '';
            pageSubtitle.classList.add('hidden');
            cancelBtn.textContent = 'Hủy';
            cancelBtn.onclick = () => window.location.href='{{ route('notifications.index') }}';

            container.innerHTML = `
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">Phạm vi nhận *</label>
                        <div class="relative">
                            <select onchange="setScope(this.value)" class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                                <option value="building" selected>Tòa nhà ▾</option>
                                <option value="floor">Tầng ▾</option>
                                <option value="apartment">Căn hộ ▾</option>
                                <option value="user">Cá nhân ▾</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">Tòa nhà *</label>
                        <div class="relative">
                            <select class="w-full h-[42px] px-3 bg-white border border-[#d9e4ec] text-[14px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                                <option selected>GGMB Residence · Tòa A ▾</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">▾</div>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    // Khởi tạo scope ban đầu
    setScope(currentScope);
</script>
@endsection
