<?php

namespace Tests\Feature;

use App\Models\Apartment;
use App\Models\Building;
use App\Models\Floor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketAndNotificationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'Role' => 'ADMIN',
            'Status' => 'ACTIVE',
        ]);

        $building = Building::factory()->create();
        $floor = Floor::factory()->create(['BuildingId' => $building->BuildingId]);
        Apartment::factory()->create(['FloorId' => $floor->FloorId]);
    }

    public function test_tickets_index_renders_kanban_board(): void
    {
        $response = $this->actingAs($this->user)->get(route('tickets.index'));

        $response->assertStatus(200);
        $response->assertSee('Quản lý yêu cầu hỗ trợ');
        $response->assertSee('Chờ xử lý');
        $response->assertSee('Đã giao');
        $response->assertSee('Đang xử lý');
        $response->assertSee('Đã xử lý');
        $response->assertSee('Đã đóng');
        $response->assertSee('Đã hủy');
        $response->assertSee('Không xem được thông báo phí');
        $response->assertSee('Đối chiếu tiền điện kỳ 02/2026');
    }

    public function test_ticket_actions_redirect_successfully(): void
    {
        $storeRes = $this->actingAs($this->user)->post(route('tickets.store'), [
            'title' => 'Test',
            'description' => 'Test desc',
            'category' => 'Tài khoản',
        ]);
        $storeRes->assertRedirect(route('tickets.index'));

        $assignRes = $this->actingAs($this->user)->post(route('tickets.assign', 1), [
            'assignee_id' => 2,
        ]);
        $assignRes->assertRedirect(route('tickets.index'));

        $verifyRes = $this->actingAs($this->user)->post(route('tickets.verify', 1), [
            'result' => 'OK',
        ]);
        $verifyRes->assertRedirect(route('tickets.index'));

        $cancelRes = $this->actingAs($this->user)->post(route('tickets.cancel', 1), [
            'reason' => 'Duplicate',
        ]);
        $cancelRes->assertRedirect(route('tickets.index'));
    }

    public function test_notifications_index_renders_correctly(): void
    {
        $response = $this->actingAs($this->user)->get(route('notifications.index'));

        $response->assertStatus(200);
        $response->assertSee('Bảng tin tòa nhà');
        $response->assertSee('Thông báo lịch bảo trì thang máy');
        $response->assertSee('Nhắc thanh toán phí tháng 02/2026');
        $response->assertSee('Toàn tòa A');
    }

    public function test_invoice_cancel_action_redirects(): void
    {
        $response = $this->actingAs($this->user)->post(route('invoices.cancel', 1));

        $response->assertRedirect(route('invoices.index'));
    }

    public function test_notifications_create_screen_renders(): void
    {
        $response = $this->actingAs($this->user)->get(route('notifications.create'));

        $response->assertStatus(200);
        $response->assertSee('Soạn thông báo mới');
    }

    public function test_fee_rates_screens_render(): void
    {
        $resIndex = $this->actingAs($this->user)->get(route('fee-rates.index'));
        $resIndex->assertStatus(200);
        $resIndex->assertSee('Cấu hình biểu phí');

        $resShow = $this->actingAs($this->user)->get(route('fee-rates.show', 1));
        $resShow->assertStatus(200);
        $resShow->assertSee('Chi tiết loại phí');

        $resCreate = $this->actingAs($this->user)->get(route('fee-rates.create'));
        $resCreate->assertStatus(200);
        $resCreate->assertSee('Thêm loại phí');

        $resEdit = $this->actingAs($this->user)->get(route('fee-rates.edit', 1));
        $resEdit->assertStatus(200);
        $resEdit->assertSee('Chỉnh sửa loại phí');

        $resDeact = $this->actingAs($this->user)->get(route('fee-rates.deactivate', 1));
        $resDeact->assertStatus(200);
        $resDeact->assertSee('Ngừng sử dụng loại phí');

        $resAct = $this->actingAs($this->user)->get(route('fee-rates.activate', 1));
        $resAct->assertStatus(200);
        $resAct->assertSee('Kích hoạt lại loại phí');

        $resRate = $this->actingAs($this->user)->get(route('fee-rates.rates.create', 1));
        $resRate->assertStatus(200);
        $resRate->assertSee('Thêm đơn giá mới');
    }

    public function test_accounts_screens_render(): void
    {
        $resIndex = $this->actingAs($this->user)->get(route('accounts.index'));
        $resIndex->assertStatus(200);
        $resIndex->assertSee('Quản trị tài khoản');

        $resShow = $this->actingAs($this->user)->get(route('accounts.show', 2));
        $resShow->assertStatus(200);
        $resShow->assertSee('Chi tiết tài khoản');

        $resEdit = $this->actingAs($this->user)->get(route('accounts.edit', 2));
        $resEdit->assertStatus(200);
        $resEdit->assertSee('Chỉnh sửa tài khoản');

        $resLock = $this->actingAs($this->user)->get(route('accounts.lock', 2));
        $resLock->assertStatus(200);
        $resLock->assertSee('Khóa tài khoản');

        $resUnlock = $this->actingAs($this->user)->get(route('accounts.unlock', 2));
        $resUnlock->assertStatus(200);
        $resUnlock->assertSee('Mở khóa tài khoản');
    }

    public function test_vehicles_and_utilities_render(): void
    {
        $resVeh = $this->actingAs($this->user)->get(route('vehicles.index'));
        $resVeh->assertStatus(200);
        $resVeh->assertSee('Đăng ký xe mới');

        $resUtil = $this->actingAs($this->user)->get(route('utilities.index'));
        $resUtil->assertStatus(200);
        $resUtil->assertSee('Sổ chỉ số điện nước');
    }
}
