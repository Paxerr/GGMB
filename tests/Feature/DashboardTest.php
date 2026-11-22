<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'Role' => 'MANAGER',
            'Status' => 'ACTIVE',
        ]);
        $this->actingAs($this->adminUser);
    }

    /**
     * Kiểm tra màn hình Dashboard (Tổng quan vận hành) hiển thị đúng cấu trúc và các phần riêng biệt.
     */
    public function test_dashboard_screen_can_be_rendered(): void
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(200);

        // Sidebar
        $response->assertSee('GGMB');
        $response->assertSee('QUẢN LÝ CHUNG CƯ');
        $response->assertSee('Tổng quan');
        $response->assertSee('Tòa & tầng');
        $response->assertSee('Căn hộ');
        $response->assertSee('Cư dân');
        $response->assertSee('Xe & đăng ký');
        $response->assertSee('Điện & nước');
        $response->assertSee('Hóa đơn');
        $response->assertSee('Yêu cầu hỗ trợ');
        $response->assertSee('Thông báo');
        $response->assertSee('Biểu phí');
        $response->assertSee('Tài khoản');

        // Header
        $response->assertSee('Thông báo');
        $response->assertSee('Tài khoản');

        // Main content
        $response->assertSee('Tổng quan vận hành');
        $response->assertSee('Theo dõi căn hộ, cư dân, công nợ và yêu cầu hỗ trợ trong phạm vi quản lý.');
        $response->assertSee('CĂN HỘ');
        $response->assertSee('CƯ DÂN');
        $response->assertSee('PHƯƠNG TIỆN');
        $response->assertSee('YÊU CẦU');
        $response->assertSee('Doanh Thu');
        $response->assertSee('Nợ phí:');

        // Footer
        $response->assertSee('GGMB · [Tên doanh nghiệp vận hành]');
        $response->assertSee('© 2026 [Tên doanh nghiệp] · Hệ thống quản lý chung cư');
    }
}
