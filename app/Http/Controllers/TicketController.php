<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    /**
     * Danh sách yêu cầu hỗ trợ dạng Kanban (Bám sát Ảnh 2).
     */
    public function index(Request $request): View
    {
        $apartments = Apartment::where('IsDeleted', false)
            ->orderBy('ApartmentNumber')
            ->get();

        $tickets = collect([
            (object) [
                'id' => 1,
                'category' => 'Tài khoản',
                'title' => 'Không xem được thông báo phí',
                'description' => 'Không xem được thông báo phí trên cổng cư dân.',
                'apartment' => '0101',
                'creator' => '10 · Nguyễn An',
                'creator_name' => 'Nguyễn An',
                'created_at' => '02/02/2026 08:30',
                'status' => 'WAITING',
                'status_label' => 'Chờ xử lý',
                'assignee' => null,
                'step' => 'Bước 1 / 5',
                'has_attachment' => false,
            ],
            (object) [
                'id' => 2,
                'category' => 'Xe',
                'title' => 'Sai thông tin phương tiện hiển thị',
                'description' => 'Biển số xe máy của căn hộ đang hiển thị sai 1 ký tự.',
                'apartment' => '0102',
                'creator' => '11 · Trần Bình',
                'creator_name' => 'Trần Bình',
                'created_at' => '03/02/2026',
                'status' => 'ASSIGNED',
                'status_label' => 'Đã giao',
                'assignee' => '6 · Lê Anh Hỗ trợ',
                'step' => 'Bước 2 / 5',
                'has_attachment' => false,
            ],
            (object) [
                'id' => 3,
                'category' => 'Kỹ thuật',
                'title' => 'Đèn hành lang tầng 1 không sáng',
                'description' => 'Đèn hành lang trước cửa căn 0103 bị chập chờn.',
                'apartment' => '0103',
                'creator' => '12 · Lê Chi',
                'creator_name' => 'Lê Chi',
                'created_at' => '04/02/2026',
                'status' => 'PROCESSING',
                'status_label' => 'Đang xử lý',
                'assignee' => '7 · Phạm Hà Hỗ trợ',
                'step' => 'Bước 3 / 5',
                'has_attachment' => false,
            ],
            (object) [
                'id' => 4,
                'category' => 'Hóa đơn',
                'title' => 'Đề nghị giải thích khoản phí quản lý',
                'description' => 'Cần giải thích cách tính phí quản lý tháng 01.',
                'apartment' => '0104',
                'creator' => '13 · Hoàng Dũng',
                'creator_name' => 'Hoàng Dũng',
                'created_at' => '05/02/2026',
                'status' => 'RESOLVED',
                'status_label' => 'Đã xử lý',
                'assignee' => '2 · Trần Thu Hỗ trợ',
                'step' => 'Bước 4 / 5',
                'has_attachment' => true,
            ],
            (object) [
                'id' => 5,
                'category' => 'Phản ánh',
                'title' => 'Phản ánh tiếng ồn sau 22 giờ',
                'description' => 'Căn hộ tầng trên thường xuyên gây ồn sau 22h đêm.',
                'apartment' => '0105',
                'creator' => '14 · Vũ Hà',
                'creator_name' => 'Vũ Hà',
                'created_at' => '06/02/2026',
                'status' => 'CLOSED',
                'status_label' => 'Đã đóng',
                'assignee' => '3 · Lê Anh Hỗ trợ',
                'step' => 'Bước 5 / 5',
                'has_attachment' => false,
            ],
            (object) [
                'id' => 6,
                'category' => 'Khác',
                'title' => 'Đề nghị hướng dẫn sử dụng cổng cư dân',
                'description' => 'Hỏi về cách đổi mật khẩu ứng dụng cư dân.',
                'apartment' => '0106',
                'creator' => '15 · Đỗ Nam',
                'creator_name' => 'Đỗ Nam',
                'created_at' => '07/02/2026',
                'status' => 'CANCELLED',
                'status_label' => 'Đã hủy',
                'assignee' => null,
                'step' => 'Dừng xử lý · lưu lịch sử',
                'has_attachment' => false,
            ],
            (object) [
                'id' => 7,
                'category' => 'Tài khoản',
                'title' => 'Không nhận được thông báo mới',
                'description' => 'Ứng dụng không đẩy thông báo tin tức tòa nhà.',
                'apartment' => '0107',
                'creator' => '16 · Ngô Lan',
                'creator_name' => 'Ngô Lan',
                'created_at' => '08/02/2026',
                'status' => 'WAITING',
                'status_label' => 'Chờ xử lý',
                'assignee' => null,
                'step' => 'Bước 1 / 5',
                'has_attachment' => false,
            ],
            (object) [
                'id' => 8,
                'category' => 'Xe',
                'title' => 'Không xem được xe đã đăng ký',
                'description' => 'Đã đăng ký xe máy nhưng không thấy trong danh sách.',
                'apartment' => '0108',
                'creator' => '17 · Bùi Mai',
                'creator_name' => 'Bùi Mai',
                'created_at' => '09/02/2026',
                'status' => 'ASSIGNED',
                'status_label' => 'Đã giao',
                'assignee' => '6 · Lê Anh Hỗ trợ',
                'step' => 'Bước 2 / 5',
                'has_attachment' => false,
            ],
            (object) [
                'id' => 9,
                'category' => 'Kỹ thuật',
                'title' => 'Rò nước hành lang tầng 2',
                'description' => 'Khu vực van nước tầng 2 có hiện tượng rò rỉ.',
                'apartment' => '0201',
                'creator' => '18 · Đặng Oanh',
                'creator_name' => 'Đặng Oanh',
                'created_at' => '10/02/2026',
                'status' => 'PROCESSING',
                'status_label' => 'Đang xử lý',
                'assignee' => '7 · Phạm Hà Hỗ trợ',
                'step' => 'Bước 3 / 5',
                'has_attachment' => false,
            ],
            (object) [
                'id' => 10,
                'category' => 'Hóa đơn',
                'title' => 'Đối chiếu tiền điện kỳ 02/2026',
                'description' => 'Cư dân đề nghị đối chiếu tiền điện kỳ 02/2026 với chỉ số công tơ của căn 0202.',
                'apartment' => '0202',
                'creator' => 'Phan Nam / Căn 0202',
                'creator_name' => 'Phan Nam',
                'created_at' => '11/02/2026 08:30',
                'resolved_at' => '11/02/2026 16:00',
                'status' => 'RESOLVED',
                'status_label' => 'Đã xử lý',
                'assignee' => '2 · Trần Thu Hỗ trợ',
                'assigned_at' => '11/02/2026 09:00',
                'attachment' => 'minh-chung-10.jpg',
                'attachment_type' => 'JPG',
                'attachment_size' => '120 KB',
                'step' => 'Bước 4 / 5',
                'has_attachment' => true,
                'reply_history' => [
                    [
                        'sender' => 'Trần Thu Hỗ trợ',
                        'time' => '11/02/2026 15:45',
                        'content' => 'Đã đối chiếu chỉ số và đơn giá; gửi kết quả kiểm tra cho cư dân, chờ xác nhận hoàn tất.',
                    ],
                ],
            ],
            (object) [
                'id' => 11,
                'category' => 'Phản ánh',
                'title' => 'Phản ánh đỗ xe chắn lối đi',
                'description' => 'Có xe lạ đỗ trước sảnh chắn lối đi bộ.',
                'apartment' => '0203',
                'creator' => '20 · Mai Phương',
                'creator_name' => 'Mai Phương',
                'created_at' => '12/02/2026',
                'status' => 'CLOSED',
                'status_label' => 'Đã đóng',
                'assignee' => '3 · Lê Anh Hỗ trợ',
                'step' => 'Bước 5 / 5',
                'has_attachment' => false,
            ],
            (object) [
                'id' => 12,
                'category' => 'Khác',
                'title' => 'Hướng dẫn nhận thông báo trên web',
                'description' => 'Hỏi cách bật thông báo trên trình duyệt web.',
                'apartment' => '0204',
                'creator' => '21 · Vũ Quang',
                'creator_name' => 'Vũ Quang',
                'created_at' => '13/02/2026',
                'status' => 'CANCELLED',
                'status_label' => 'Đã hủy',
                'assignee' => null,
                'step' => 'Dừng xử lý · lưu lịch sử',
                'has_attachment' => false,
            ],
        ]);

        $columns = [
            'WAITING' => [
                'key' => 'WAITING',
                'title' => 'Chờ xử lý',
                'count' => 17,
                'step' => 'Bước 1 / 5',
                'bg_header' => 'bg-[#f1f5f9]',
                'badge_color' => 'bg-slate-100 text-slate-700',
                'remaining' => 15,
            ],
            'ASSIGNED' => [
                'key' => 'ASSIGNED',
                'title' => 'Đã giao',
                'count' => 17,
                'step' => 'Bước 2 / 5',
                'bg_header' => 'bg-[#eef2ff]',
                'badge_color' => 'bg-blue-50 text-[#2864ad]',
                'remaining' => 15,
            ],
            'PROCESSING' => [
                'key' => 'PROCESSING',
                'title' => 'Đang xử lý',
                'count' => 17,
                'step' => 'Bước 3 / 5',
                'bg_header' => 'bg-[#f5f3ff]',
                'badge_color' => 'bg-purple-50 text-purple-700',
                'remaining' => 15,
            ],
            'RESOLVED' => [
                'key' => 'RESOLVED',
                'title' => 'Đã xử lý',
                'count' => 17,
                'step' => 'Bước 4 / 5',
                'bg_header' => 'bg-[#ecfdf5]',
                'badge_color' => 'bg-emerald-50 text-emerald-700',
                'remaining' => 15,
            ],
            'CLOSED' => [
                'key' => 'CLOSED',
                'title' => 'Đã đóng',
                'count' => 16,
                'step' => 'Bước 5 / 5',
                'bg_header' => 'bg-[#f0fdf4]',
                'badge_color' => 'bg-green-50 text-green-700',
                'remaining' => 14,
            ],
            'CANCELLED' => [
                'key' => 'CANCELLED',
                'title' => 'Đã hủy',
                'count' => 16,
                'step' => 'Dừng xử lý · lưu lịch sử',
                'bg_header' => 'bg-[#fdf2f2]',
                'badge_color' => 'bg-rose-50 text-rose-700',
                'remaining' => 14,
            ],
        ];

        $staffList = [
            ['id' => 2, 'name' => 'Trần Thu Hỗ trợ', 'department' => 'Chăm sóc cư dân'],
            ['id' => 3, 'name' => 'Lê Anh Hỗ trợ', 'department' => 'Chăm sóc cư dân'],
            ['id' => 4, 'name' => 'Phạm Hà Hỗ trợ', 'department' => 'Chăm sóc cư dân'],
        ];

        return view('tickets.index', [
            'tickets' => $tickets,
            'columns' => $columns,
            'apartments' => $apartments,
            'staffList' => $staffList,
        ]);
    }

    /**
     * Tạo phiếu sự cố mới.
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('tickets.index')->with('success', 'Tạo phiếu sự cố mới thành công.');
    }

    /**
     * Cập nhật phiếu sự cố.
     */
    public function update(int $id, Request $request): RedirectResponse
    {
        return redirect()->route('tickets.index')->with('success', "Cập nhật yêu cầu #{$id} thành công.");
    }

    /**
     * Phân công người xử lý.
     */
    public function assign(int $id, Request $request): RedirectResponse
    {
        return redirect()->route('tickets.index')->with('success', "Phân công người xử lý cho yêu cầu #{$id} thành công.");
    }

    /**
     * Nghiệm thu & đóng phiếu.
     */
    public function verify(int $id, Request $request): RedirectResponse
    {
        return redirect()->route('tickets.index')->with('success', "Nghiệm thu và đóng yêu cầu #{$id} thành công.");
    }

    /**
     * Hủy yêu cầu hỗ trợ.
     */
    public function cancel(int $id, Request $request): RedirectResponse
    {
        return redirect()->route('tickets.index')->with('success', "Đã hủy yêu cầu #{$id} thành công.");
    }
}
