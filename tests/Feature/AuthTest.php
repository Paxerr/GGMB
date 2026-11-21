<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Kiểm tra hiển thị màn hình đăng nhập.
     */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Đăng nhập GGMB');
        $response->assertSee('Đăng nhập để truy cập chức năng theo vai trò và phạm vi được cấp.');
        $response->assertSee('Giới thiệu hệ thống GGMB');
        $response->assertSee('Đăng nhập hệ thống');
        $response->assertSee('Tên đăng nhập');
        $response->assertSee('Mật khẩu');
        $response->assertSee('Đăng nhập →');
        $response->assertSee('GGMB · [Tên doanh nghiệp vận hành]');
    }

    /**
     * Kiểm tra người dùng đăng nhập thành công với thông tin hợp lệ.
     */
    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'UserName' => 'testuser01',
            'PasswordHash' => Hash::make('password123'),
            'Status' => 'ACTIVE',
            'IsDeleted' => false,
        ]);

        $response = $this->post('/login', [
            'UserName' => 'testuser01',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard');
    }

    /**
     * Kiểm tra không thể đăng nhập với mật khẩu sai.
     */
    public function test_users_cannot_authenticate_with_invalid_password(): void
    {
        User::factory()->create([
            'UserName' => 'testuser02',
            'PasswordHash' => Hash::make('password123'),
            'Status' => 'ACTIVE',
            'IsDeleted' => false,
        ]);

        $response = $this->post('/login', [
            'UserName' => 'testuser02',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('UserName');
    }

    /**
     * Kiểm tra đăng xuất thành công.
     */
    public function test_users_can_logout(): void
    {
        $user = User::factory()->create([
            'UserName' => 'testuser03',
            'PasswordHash' => Hash::make('password123'),
            'Status' => 'ACTIVE',
            'IsDeleted' => false,
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}
