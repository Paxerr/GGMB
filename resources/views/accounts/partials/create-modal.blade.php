<!-- Modal Popup: Thêm tài khoản (Bám sát Ảnh Thêm tài khoản) -->
<div
    id="createAccountModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="create-account-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Background backdrop -->
    <div
        id="createAccountBackdrop"
        onclick="closeCreateAccountModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="createAccountPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[620px] border border-[#d9e4ec] rounded-[4px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header (Bám sát Ảnh) -->
            <div class="px-7 pt-6 pb-3">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeCreateAccountModal()"
                        class="text-slate-400 hover:text-slate-700 text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#122d40] mt-1" id="create-account-title">
                    Thêm tài khoản
                </h3>
                <p class="text-[13px] text-[#52697c] mt-0.5">
                    Tạo thông tin đăng nhập và vai trò; các trường * là bắt buộc.
                </p>
            </div>

            <!-- Modal Form -->
            <form method="POST" action="{{ route('accounts.store') }}" onsubmit="event.preventDefault(); closeCreateAccountModal(); if(window.showToast) window.showToast('Tạo tài khoản mới thành công.');">
                @csrf
                <div class="px-7 pb-6 space-y-4">
                    <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        THÔNG TIN TÀI KHOẢN MỚI
                    </span>

                    <!-- Hàng 1: Tên đăng nhập * & Mật khẩu ban đầu * -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Tên đăng nhập *
                            </label>
                            <input
                                type="text"
                                required
                                placeholder="Nhập tên đăng nhập duy nhất"
                                class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Mật khẩu ban đầu *
                            </label>
                            <input
                                type="password"
                                required
                                placeholder="Nhập mật khẩu · được che ký tự"
                                class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 2: Họ tên * & Điện thoại -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Họ tên *
                            </label>
                            <input
                                type="text"
                                required
                                placeholder="Nhập họ tên"
                                class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Điện thoại
                            </label>
                            <input
                                type="text"
                                placeholder="Nhập số điện thoại (tùy chọn)"
                                class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 3: Email & Căn cước -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Email
                            </label>
                            <input
                                type="email"
                                placeholder="Nhập email (tùy chọn)"
                                class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Căn cước
                            </label>
                            <input
                                type="text"
                                placeholder="Nhập số căn cước (tùy chọn)"
                                class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 4: Vai trò * & Bộ phận -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Vai trò *
                            </label>
                            <div class="relative">
                                <select class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                                    <option value="" disabled selected>Chọn vai trò ▾</option>
                                    <option value="Quản lý">Quản lý</option>
                                    <option value="Hỗ trợ">Hỗ trợ</option>
                                    <option value="Kỹ thuật">Kỹ thuật</option>
                                    <option value="Bảo vệ">Bảo vệ</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#52697c]">▾</div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Bộ phận
                            </label>
                            <input
                                type="text"
                                placeholder="Nhập bộ phận (nếu có)"
                                class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] placeholder-[#8a9ba8] focus:outline-none focus:border-[#2864ad] focus:ring-1 focus:ring-[#2864ad]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 5: Trạng thái & Hint -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                        <div>
                            <label class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Trạng thái
                            </label>
                            <div class="relative">
                                <select class="w-full h-[40px] px-3 bg-white border border-[#d9e4ec] text-[13px] text-[#334b5d] appearance-none focus:outline-none focus:border-[#2864ad] cursor-pointer">
                                    <option value="ACTIVE" selected>Hoạt động · mặc định ▾</option>
                                    <option value="LOCKED">Bị khóa</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#52697c]">▾</div>
                            </div>
                        </div>
                        <div class="pt-4 text-[11px] leading-tight text-[#b91c1c]">
                            Khóa tài khoản chỉ chặn truy cập; không xóa hồ sơ hoặc lịch sử giao dịch.
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-7 py-4 border-t border-[#d9e4ec] flex items-center justify-between">
                    <button
                        type="button"
                        onclick="closeCreateAccountModal()"
                        class="h-[40px] px-6 bg-white border border-[#d9e4ec] hover:bg-[#f0f4f8] text-[#334b5d] text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[40px] px-6 bg-[#2864ad] hover:bg-[#205391] text-white text-[14px] font-semibold rounded-[4px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Tạo tài khoản
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCreateAccountModal() {
        const modal = document.getElementById('createAccountModal');
        const backdrop = document.getElementById('createAccountBackdrop');
        const panel = document.getElementById('createAccountPanel');

        if (!modal || !backdrop || !panel) return;

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeCreateAccountModal() {
        const modal = document.getElementById('createAccountModal');
        const backdrop = document.getElementById('createAccountBackdrop');
        const panel = document.getElementById('createAccountPanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }
</script>
