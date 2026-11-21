<?php

namespace Tests\Feature;

use Tests\TestCase;

class PortalTest extends TestCase
{
    public function test_resident_portal_dashboard_loads(): void
    {
        $response = $this->get('/portal');
        $response->assertStatus(200);
        $response->assertSee('Xin chào, Nguyễn An');
        $response->assertSee('HÓA ĐƠN CHỜ THANH TOÁN');
        $response->assertSee('1.685.000 đ');
        $response->assertSee('HỒ SƠ CĂN HỘ 0101');
        $response->assertSee('YÊU CẦU ĐANG MỞ');
    }

    public function test_resident_portal_invoices_loads(): void
    {
        $response = $this->get('/portal/invoices');
        $response->assertStatus(200);
        $response->assertSee('Hóa đơn & thanh toán');
        $response->assertSee('THÔNG BÁO PHÍ · 01/2026');
        $response->assertSee('842.500 đ');
        $response->assertSee('Thanh toán trực tiếp');
    }

    public function test_resident_portal_tickets_create_loads(): void
    {
        $response = $this->get('/portal/tickets');
        $response->assertStatus(200);
        $response->assertSee('Gửi yêu cầu hỗ trợ');
        $response->assertSee('Đèn trong căn hộ bị hỏng');
        $response->assertSee('THEO DÕI YÊU CẦU CỦA TÔI');
    }

    public function test_resident_portal_ticket_store(): void
    {
        $response = $this->post('/portal/tickets', [
            'title' => 'Đèn phòng ngủ không sáng',
            'category' => 'TECHNICAL',
            'description' => 'Bóng đèn trần phòng ngủ chập chờn rồi tắt hẳn.',
        ]);

        $response->assertRedirect('/portal/tickets');
        $response->assertSessionHas('success');
    }

    public function test_resident_portal_ticket_show_loads(): void
    {
        $response = $this->get('/portal/tickets/1');
        $response->assertStatus(200);
        $response->assertSee('Chi tiết yêu cầu của tôi');
        $response->assertSee('Chờ xử lý · Chưa phân công');
        $response->assertSee('Không xem được thông báo phí');
        $response->assertSee('Gửi phản hồi');
    }

    public function test_resident_portal_ticket_reply(): void
    {
        $response = $this->post('/portal/tickets/1/reply', [
            'reply_content' => 'Tôi đã thử đăng nhập lại nhưng vẫn không thấy.',
        ]);

        $response->assertRedirect('/portal/tickets/1');
        $response->assertSessionHas('success');
    }

    public function test_resident_portal_notification_show_loads(): void
    {
        $response = $this->get('/portal/notifications/4');
        $response->assertStatus(200);
        $response->assertSee('Thông báo riêng căn hộ 0101');
        $response->assertSee('Nguyễn Minh Quản lý · Ban quản lý');
        $response->assertSee('Vui lòng liên hệ ban quản lý để xác nhận thông tin cư trú.');
    }

    public function test_resident_portal_profile_loads(): void
    {
        $response = $this->get('/portal/profile');
        $response->assertStatus(200);
        $response->assertSee('Thông tin cá nhân');
        $response->assertSee('resident01 · Nguyễn An');
        $response->assertSee('079000000010');
        $response->assertSee('0910000010 / nguyenan123@gmail.com');
    }

    public function test_resident_portal_profile_edit_loads(): void
    {
        $response = $this->get('/portal/profile/edit');
        $response->assertStatus(200);
        $response->assertSee('Cập nhật liên hệ');
        $response->assertSee('0910000010');
        $response->assertSee('nguyenan123@gmail.com');
    }

    public function test_resident_portal_profile_update(): void
    {
        $response = $this->post('/portal/profile', [
            'phone' => '0910000011',
            'email' => 'nguyenan_new@gmail.com',
        ]);

        $response->assertRedirect('/portal/profile');
        $response->assertSessionHas('success');
    }

    public function test_tech_portal_tasks_index_loads(): void
    {
        $response = $this->get('/tech/tasks');
        $response->assertStatus(200);
        $response->assertSee('Bàn việc hiện trường');
        $response->assertSee('ĐANG XỬ LÝ');
        $response->assertSee('#3 · Đèn hành lang tầng 1 không sáng');
        $response->assertSee('Vũ Hoàng Kỹ thuật · tech03');
    }

    public function test_tech_portal_task_show_loads(): void
    {
        $response = $this->get('/tech/tasks/3');
        $response->assertStatus(200);
        $response->assertSee('Chi tiết công việc được giao');
        $response->assertSee('#3 · Đèn hành lang tầng 1 không sáng');
        $response->assertSee('Nội dung kết quả');
    }

    public function test_tech_portal_task_complete(): void
    {
        $response = $this->post('/tech/tasks/3/complete', [
            'result_content' => 'Đã thay mới bóng đèn LED 18W và kiểm tra công tắc hoạt động tốt.',
        ]);

        $response->assertRedirect('/tech/tasks');
        $response->assertSessionHas('success');
    }

    public function test_tech_portal_utilities_index_loads(): void
    {
        $response = $this->get('/tech/utilities');
        $response->assertStatus(200);
        $response->assertSee('Ghi điện nước');
        $response->assertSee('NHẬP CHỈ SỐ · 8 CĂN');
        $response->assertSee('0101');
        $response->assertSee('142');
    }

    public function test_tech_portal_utilities_store(): void
    {
        $response = $this->post('/tech/utilities', [
            'meters' => [
                1 => 180,
                2 => 195,
            ],
        ]);

        $response->assertRedirect('/tech/utilities');
        $response->assertSessionHas('success');
    }
}
