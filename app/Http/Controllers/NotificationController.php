<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Bảng tin tòa nhà (Bám sát Ảnh 9).
     */
    public function index(Request $request): View
    {
        $notifications = collect([
            (object) [
                'id' => 1,
                'title' => 'Thông báo lịch bảo trì thang máy',
                'body' => 'Thang máy tòa A bảo trì ngày 08/02/2026, 08:00–11:00. Vui lòng sử dụng thang bộ trong thời gian này.',
                'scope' => 'Tòa nhà',
                'scope_detail' => 'Toàn tòa A · GGMB Residence',
                'creator' => '1 · Nguyễn Minh Quản lý',
                'created_at' => '01/02/2026 08:00',
                'read_count' => 10,
                'unread_count' => 20,
                'total_count' => 30,
                'recipients' => [
                    ['stt' => 1, 'name' => 'Nguyễn An', 'apartment' => '0101', 'read' => false, 'read_label' => 'Chưa đọc'],
                    ['stt' => 2, 'name' => 'Trần Bình', 'apartment' => '0102', 'read' => false, 'read_label' => 'Chưa đọc'],
                    ['stt' => 3, 'name' => 'Lê Chi', 'apartment' => '0103', 'read' => true, 'read_label' => 'Đã đọc'],
                    ['stt' => 4, 'name' => 'Phạm Dũng', 'apartment' => '0104', 'read' => false, 'read_label' => 'Chưa đọc'],
                    ['stt' => 5, 'name' => 'Hoàng Giang', 'apartment' => '0105', 'read' => false, 'read_label' => 'Chưa đọc'],
                    ['stt' => 6, 'name' => 'Vũ Hà', 'apartment' => '0106', 'read' => true, 'read_label' => 'Đã đọc'],
                ],
            ],
            (object) [
                'id' => 2,
                'title' => 'Nhắc thanh toán phí tháng 02/2026',
                'body' => 'Ban quản lý xin gửi thông báo nhắc lịch thanh toán phí dịch vụ và tiền điện nước tháng 02/2026 trước ngày 10/02/2026.',
                'scope' => 'Tất cả',
                'scope_detail' => 'Tất cả cư dân · GGMB Residence',
                'creator' => '1 · Nguyễn Minh Quản lý',
                'created_at' => '01/03/2026 08:00',
                'read_count' => 10,
                'unread_count' => 20,
                'total_count' => 30,
                'recipients' => [
                    ['stt' => 1, 'name' => 'Nguyễn An', 'apartment' => '0101', 'read' => true, 'read_label' => 'Đã đọc'],
                    ['stt' => 2, 'name' => 'Trần Bình', 'apartment' => '0102', 'read' => false, 'read_label' => 'Chưa đọc'],
                    ['stt' => 3, 'name' => 'Lê Chi', 'apartment' => '0103', 'read' => true, 'read_label' => 'Đã đọc'],
                ],
            ],
            (object) [
                'id' => 3,
                'title' => 'Cập nhật xử lý yêu cầu kỹ thuật',
                'body' => 'Kỹ thuật viên đã kiểm tra và khắc phục xong sự cố rò rỉ van nước hành lang tầng 2. Cảm ơn cư dân đã phản ánh kịp thời.',
                'scope' => 'Tầng',
                'scope_detail' => 'Tầng 2, Tòa A · GGMB Residence',
                'creator' => '2 · Trần Thu Hỗ trợ',
                'created_at' => '15/02/2026 14:00',
                'read_count' => 3,
                'unread_count' => 5,
                'total_count' => 8,
                'recipients' => [
                    ['stt' => 1, 'name' => 'Đặng Oanh', 'apartment' => '0201', 'read' => true, 'read_label' => 'Đã đọc'],
                    ['stt' => 2, 'name' => 'Phan Nam', 'apartment' => '0202', 'read' => true, 'read_label' => 'Đã đọc'],
                    ['stt' => 3, 'name' => 'Mai Phương', 'apartment' => '0203', 'read' => false, 'read_label' => 'Chưa đọc'],
                ],
            ],
            (object) [
                'id' => 4,
                'title' => 'Thông báo riêng căn hộ 0101',
                'body' => 'Gửi cư dân căn hộ 0101: Yêu cầu cập nhật thông tin biển số xe của quý cư dân đã được tiếp nhận và xử lý.',
                'scope' => 'Căn hộ',
                'scope_detail' => 'Căn hộ 0101 · Tòa A',
                'creator' => '1 · Nguyễn Minh Quản lý',
                'created_at' => '20/02/2026 09:00',
                'read_count' => 0,
                'unread_count' => 1,
                'total_count' => 1,
                'recipients' => [
                    ['stt' => 1, 'name' => 'Nguyễn An', 'apartment' => '0101', 'read' => false, 'read_label' => 'Chưa đọc'],
                ],
            ],
        ]);

        return view('notifications.index', [
            'notifications' => $notifications,
        ]);
    }

    /**
     * Soạn thông báo mới (Bám sát Ảnh 1, 3, 4, 5).
     */
    public function create(Request $request): View
    {
        return view('notifications.create');
    }

    /**
     * Soạn thông báo mới.
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('notifications.index')->with('success', 'Gửi thông báo thành công.');
    }

    /**
     * Cập nhật thông báo.
     */
    public function update(int $id, Request $request): RedirectResponse
    {
        return redirect()->route('notifications.index')->with('success', "Cập nhật thông báo #{$id} thành công.");
    }
}
