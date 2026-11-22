<!-- Modal Popup: Tạo cư dân mới (18 · SCR-RES-03 · 688px chuẩn Figma) -->
<div
    id="createResidentModal"
    class="fixed inset-0 z-50 overflow-y-auto hidden"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Background backdrop -->
    <div
        id="createResidentBackdrop"
        onclick="closeCreateResidentModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-[1px] transition-opacity duration-200 opacity-0"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            id="createResidentPanel"
            class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-[688px] border border-[#E5E7EB] rounded-[16px] opacity-0 scale-95 duration-200"
        >
            <!-- Modal Header (Bám sát thiết kế) -->
            <div class="px-7 py-4 bg-[#F2F6F4] border-b border-[#E5E7EB] rounded-t-[16px]">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#6B7280] tracking-wider uppercase select-none">
                        THÔNG TIN
                    </span>
                    <button
                        type="button"
                        onclick="closeCreateResidentModal()"
                        class="text-[#6B7280] hover:text-[#111827] text-2xl leading-none cursor-pointer p-1"
                        aria-label="Đóng"
                    >
                        &times;
                    </button>
                </div>
                <h3 class="text-[20px] font-bold text-[#111827] mt-1" id="modal-title">
                    Tạo cư dân mới
                </h3>
                <p class="text-[13px] text-[#6B7280] mt-0.5">
                    Tạo tài khoản cư dân và tiếp nhận vào căn hộ; * là trường bắt buộc.
                </p>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('residents.store') }}" method="POST">
                @csrf
                <div class="px-7 pb-6 space-y-4">
                    <!-- Hàng 1: Tên đăng nhập * & Họ và tên * (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="create_user_name" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Tên đăng nhập <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="text"
                                id="create_user_name"
                                name="user_name"
                                value="{{ old('user_name') }}"
                                required
                                placeholder="Ví dụ: cudan01"
                                class="w-full h-[42px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                        <div>
                            <label for="create_full_name" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Họ và tên <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="text"
                                id="create_full_name"
                                name="full_name"
                                value="{{ old('full_name') }}"
                                required
                                placeholder="Ví dụ: Nguyễn Văn An"
                                class="w-full h-[42px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 2: Mật khẩu ban đầu * & Căn cước (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="create_password" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Mật khẩu ban đầu <span class="text-rose-600">*</span>
                            </label>
                            <input
                                type="password"
                                id="create_password"
                                name="password"
                                required
                                placeholder="Tối thiểu 6 ký tự"
                                class="w-full h-[42px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                        <div>
                            <label for="create_citizen_id" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Căn cước
                            </label>
                            <input
                                type="text"
                                id="create_citizen_id"
                                name="citizen_id"
                                value="{{ old('citizen_id') }}"
                                placeholder="Số CCCD 12 chữ số"
                                class="w-full h-[42px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 3: Điện thoại & Email (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="create_phone" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Điện thoại
                            </label>
                            <input
                                type="tel"
                                id="create_phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="Ví dụ: 0910000010"
                                class="w-full h-[42px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                        <div>
                            <label for="create_email" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Email
                            </label>
                            <input
                                type="email"
                                id="create_email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nguyenan@email.com"
                                class="w-full h-[42px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] placeholder-[#9CA3AF] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>

                    <!-- Hàng 4: Căn hộ tiếp nhận & Ngày bắt đầu cư trú (2 cột) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="create_apartment_id" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Căn hộ <span class="text-rose-600">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    id="create_apartment_id"
                                    name="apartment_id"
                                    required
                                    class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] appearance-none focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C] cursor-pointer"
                                >
                                    <option value="" disabled selected>Chọn căn hộ tiếp nhận…</option>
                                    @foreach ($apartments as $apt)
                                        <option value="{{ $apt->ApartmentId }}" {{ old('apartment_id') == $apt->ApartmentId ? 'selected' : '' }}>
                                            Căn {{ $apt->ApartmentNumber }} · Tầng {{ $apt->floor->FloorNumber ?? $apt->FloorId }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-[#334b5d]">
                                    ▾
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="create_start_date" class="block text-[12px] font-semibold text-[#334b5d] mb-1.5">
                                Ngày bắt đầu cư trú
                            </label>
                            <input
                                type="date"
                                id="create_start_date"
                                name="start_date"
                                value="{{ old('start_date', date('Y-m-d')) }}"
                                class="w-full h-[40px] px-3 bg-white border border-[#E5E7EB] rounded-[8px] text-[13.5px] text-[#111827] focus:outline-none focus:border-[#0E4D3C] focus:ring-1 focus:ring-[#0E4D3C]"
                            />
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-7 py-4 border-t border-[#E5E7EB] flex items-center justify-between rounded-b-[16px] bg-white">
                    <button
                        type="button"
                        onclick="closeCreateResidentModal()"
                        class="h-[40px] px-5 bg-white border border-[#E5E7EB] hover:bg-[#F9FBFA] text-[#374151] text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none"
                    >
                        Hủy
                    </button>
                    <button
                        type="submit"
                        class="h-[40px] px-5 bg-[#0E4D3C] hover:bg-[#0A3D2F] text-white text-[13.5px] font-semibold rounded-[8px] transition-colors cursor-pointer select-none shadow-sm"
                    >
                        Tiếp nhận cư dân
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCreateResidentModal() {
        const modal = document.getElementById('createResidentModal');
        const backdrop = document.getElementById('createResidentBackdrop');
        const panel = document.getElementById('createResidentPanel');

        if (!modal || !backdrop || !panel) return;

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        });
    }

    function closeCreateResidentModal() {
        const modal = document.getElementById('createResidentModal');
        const backdrop = document.getElementById('createResidentBackdrop');
        const panel = document.getElementById('createResidentPanel');

        if (!modal || !backdrop || !panel) return;

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    // Tự động mở popup nếu URL có tham số ?create=1
    document.addEventListener('DOMContentLoaded', function() {
        if (new URLSearchParams(window.location.search).get('create') === '1') {
            openCreateResidentModal();
        }
    });
</script>
