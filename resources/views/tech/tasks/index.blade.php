@extends('layouts.portal', [
    'title' => 'Bàn việc hiện trường · GGMB',
    'portalType' => 'tech',
    'activeTab' => 'tasks'
])

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-[26px] font-semibold text-[#122d40] leading-tight">
            Bàn việc hiện trường
        </h1>
        <p class="mt-1 text-[14px] text-[#52697c]">
            Công việc kỹ thuật được giao cho bạn; không hiển thị yêu cầu ngoài phạm vi phụ trách.
        </p>
    </div>

    <!-- 3 Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-5 shadow-sm">
            <span class="block text-[12px] font-semibold text-[#52697c] tracking-wider uppercase">
                ĐANG XỬ LÝ
            </span>
            <div class="text-[26px] font-bold text-[#122d40] mt-1">
                17
            </div>
        </div>

        <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-5 shadow-sm">
            <span class="block text-[12px] font-semibold text-[#52697c] tracking-wider uppercase">
                ĐÃ PHÂN CÔNG
            </span>
            <div class="text-[26px] font-bold text-[#122d40] mt-1">
                0
            </div>
        </div>

        <div class="bg-white border border-[#d9e4ec] rounded-[4px] p-5 shadow-sm">
            <span class="block text-[12px] font-semibold text-[#52697c] tracking-wider uppercase">
                ĐÃ XỬ LÝ
            </span>
            <div class="text-[26px] font-bold text-[#122d40] mt-1">
                0
            </div>
        </div>
    </div>

    <!-- 2 Columns: Task list + Preview -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Left: Danh sách công việc (6 cols) -->
        <div class="lg:col-span-6 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-[14px] font-semibold text-[#122d40] uppercase tracking-wide">
                    VIỆC CỦA TÔI · 17
                </h2>
                <select class="h-[34px] px-3 bg-white border border-[#d9e4ec] rounded-[4px] text-[13px] text-[#122d40] focus:outline-none focus:border-[#2864ad]">
                    <option value="PROCESSING" selected>Đang xử lý</option>
                    <option value="ASSIGNED">Đã phân công</option>
                    <option value="RESOLVED">Đã xử lý</option>
                </select>
            </div>

            <!-- Task Cards -->
            <div class="space-y-3" id="taskListContainer">
                <!-- Task 1 (Active) -->
                <div onclick="selectTask(3)" id="task-card-3" class="task-card cursor-pointer bg-white border-2 border-[#2864AD] rounded-[4px] p-4 shadow-sm transition-all">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-[#122d40] text-[14px]">
                            #3 · Đèn hành lang tầng 1 không sáng
                        </span>
                        <span class="text-[12px] font-semibold text-[#2864ad] flex items-center">
                            Đang xem ➔
                        </span>
                    </div>
                    <div class="text-[12px] text-[#52697c] mt-2">
                        Hành lang Tòa A tầng 1 · 04/02/2026 09:00
                    </div>
                </div>

                <!-- Task 2 -->
                <div onclick="selectTask(9)" id="task-card-9" class="task-card cursor-pointer bg-white border border-[#d9e4ec] hover:border-[#2864ad] rounded-[4px] p-4 shadow-sm transition-all">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-[#122d40] text-[14px]">
                            #9 · Rò nước hành lang tầng 2
                        </span>
                    </div>
                    <div class="text-[12px] text-[#52697c] mt-2">
                        Hành lang Tòa A tầng 2 · 04/02/2026 09:30
                    </div>
                </div>

                <!-- Task 3 -->
                <div onclick="selectTask(15)" id="task-card-15" class="task-card cursor-pointer bg-white border border-[#d9e4ec] hover:border-[#2864ad] rounded-[4px] p-4 shadow-sm transition-all">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-[#122d40] text-[14px]">
                            #15 · Ổ cắm sảnh tầng 2 mất điện
                        </span>
                    </div>
                    <div class="text-[12px] text-[#52697c] mt-2">
                        Sảnh Tòa A tầng 2 · 04/02/2026 10:00
                    </div>
                </div>

                <!-- Task 4 -->
                <div onclick="selectTask(21)" id="task-card-21" class="task-card cursor-pointer bg-white border border-[#d9e4ec] hover:border-[#2864ad] rounded-[4px] p-4 shadow-sm transition-all">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-[#122d40] text-[14px]">
                            #21 · Đèn thoát hiểm tầng 3 không sáng
                        </span>
                    </div>
                    <div class="text-[12px] text-[#52697c] mt-2">
                        Cầu thang thoát hiểm Tòa A tầng 3 · 04/02/2026 10:30
                    </div>
                </div>
            </div>

            <!-- Footer Pagination Notice -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pt-2 text-[13px] text-[#52697c] gap-2">
                <span>Hiển thị 4 / 17 phiếu được phân công</span>
                <button type="button" onclick="loadMoreTasks()" class="h-[36px] px-4 bg-white border border-[#d9e4ec] hover:bg-slate-50 text-[#334b5d] font-medium rounded-[4px] transition-colors cursor-pointer text-center">
                    Xem 13 phiếu còn lại
                </button>
            </div>
        </div>

        <!-- Right: Chi tiết công việc đang xem (6 cols) -->
        <div class="lg:col-span-6 bg-white border border-[#d9e4ec] rounded-[4px] p-6 shadow-sm space-y-6">
            <div>
                <h3 class="text-[16px] font-bold text-[#122d40] uppercase tracking-wide" id="previewTitle">
                    #3 · ĐÈN HÀNH LANG TẦNG 1 KHÔNG SÁNG
                </h3>
                <p class="text-[13px] text-[#52697c] mt-1" id="previewLocation">
                    Tòa A · Tầng 1 · Căn 0103 / Khu vực công cộng
                </p>
            </div>

            <div class="space-y-4 border-t border-[#d9e4ec] pt-4 text-[13px]">
                <div>
                    <span class="block text-[12px] font-semibold text-[#52697c] uppercase tracking-wide">Người phân công</span>
                    <span class="block text-[#122d40] mt-0.5" id="previewAssigner">Ban quản lý chung cư</span>
                </div>

                <div>
                    <span class="block text-[12px] font-semibold text-[#52697c] uppercase tracking-wide">Người phụ trách</span>
                    <span class="block text-[#122d40] mt-0.5" id="previewAssignee">Vũ Hoàng Kỹ thuật · 04/02/2026 09:00</span>
                </div>

                <div>
                    <span class="block text-[12px] font-semibold text-[#52697c] uppercase tracking-wide">Trạng thái</span>
                    <span class="block font-medium text-amber-600 mt-0.5" id="previewStatus">Đang xử lý · chưa gửi kết quả</span>
                </div>
            </div>

            <div class="pt-4 border-t border-[#d9e4ec]">
                <a href="{{ route('tech.tasks.show', 3) }}" id="previewActionBtn" class="inline-flex items-center justify-center h-[40px] px-6 bg-[#2864AD] hover:bg-[#1e4d87] text-white font-medium text-[14px] rounded-[4px] transition-colors shadow-sm">
                    Mở chi tiết công việc
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    const taskDetails = {
        3: {
            title: '#3 · ĐÈN HÀNH LANG TẦNG 1 KHÔNG SÁNG',
            location: 'Tòa A · Tầng 1 · Căn 0103 / Khu vực công cộng',
            assigner: 'Ban quản lý chung cư',
            assignee: 'Vũ Hoàng Kỹ thuật · 04/02/2026 09:00',
            status: 'Đang xử lý · chưa gửi kết quả',
            url: "{{ route('tech.tasks.show', 3) }}"
        },
        9: {
            title: '#9 · RÒ NƯỚC HÀNH LANG TẦNG 2',
            location: 'Tòa A · Tầng 2 · Căn 0204 / Khu vực công cộng',
            assigner: 'Ban quản lý chung cư',
            assignee: 'Vũ Hoàng Kỹ thuật · 04/02/2026 09:30',
            status: 'Đang xử lý · chưa gửi kết quả',
            url: "{{ route('tech.tasks.show', 9) }}"
        },
        15: {
            title: '#15 · Ổ CẮM SẢNH TẦNG 2 MẤT ĐIỆN',
            location: 'Tòa A · Tầng 2 · Sảnh thang máy',
            assigner: 'Ban quản lý chung cư',
            assignee: 'Vũ Hoàng Kỹ thuật · 04/02/2026 10:00',
            status: 'Đang xử lý · chưa gửi kết quả',
            url: "{{ route('tech.tasks.show', 15) }}"
        },
        21: {
            title: '#21 · ĐÈN THOÁT HIỂM TẦNG 3 KHÔNG SÁNG',
            location: 'Tòa A · Tầng 3 · Cầu thang thoát hiểm số 1',
            assigner: 'Ban quản lý chung cư',
            assignee: 'Vũ Hoàng Kỹ thuật · 04/02/2026 10:30',
            status: 'Đang xử lý · chưa gửi kết quả',
            url: "{{ route('tech.tasks.show', 21) }}"
        }
    };

    function selectTask(id) {
        const item = taskDetails[id];
        if (!item) return;

        document.getElementById('previewTitle').innerText = item.title;
        document.getElementById('previewLocation').innerText = item.location;
        document.getElementById('previewAssigner').innerText = item.assigner;
        document.getElementById('previewAssignee').innerText = item.assignee;
        document.getElementById('previewStatus').innerText = item.status;
        document.getElementById('previewActionBtn').href = item.url;

        document.querySelectorAll('.task-card').forEach(card => {
            card.classList.remove('border-2', 'border-[#2864AD]');
            card.classList.add('border', 'border-[#d9e4ec]');
            const arrow = card.querySelector('.text-\\[\\#2864ad\\]');
            if (arrow) arrow.remove();
        });

        const activeCard = document.getElementById(`task-card-${id}`);
        if (activeCard) {
            activeCard.classList.remove('border', 'border-[#d9e4ec]');
            activeCard.classList.add('border-2', 'border-[#2864AD]');
            const header = activeCard.querySelector('.flex');
            if (header && !header.querySelector('.text-\\[\\#2864ad\\]')) {
                const span = document.createElement('span');
                span.className = 'text-[12px] font-semibold text-[#2864ad] flex items-center';
                span.innerText = 'Đang xem ➔';
                header.appendChild(span);
            }
        }
    }

    function loadMoreTasks() {
        if (window.showToast) {
            window.showToast('Đang tải danh sách 13 phiếu còn lại...');
        }
    }
</script>
@endsection
