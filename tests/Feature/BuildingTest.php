<?php

namespace Tests\Feature;

use App\Models\Building;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuildingTest extends TestCase
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
     * Kiểm tra hiển thị màn hình Quản lý tòa và tầng (SCR-BLD-01) bao gồm popup modal thêm & sửa.
     */
    public function test_building_and_floor_screen_can_be_rendered(): void
    {
        $response = $this->get('/buildings');

        $response->assertStatus(200);

        // Sidebar active state
        $response->assertSee('Tòa & tầng');

        // Header & Breadcrumb
        $response->assertSee('GGMB');
        $response->assertSee('Tòa & tầng');

        // Toolbar & Actions
        $response->assertSee('Tòa nhà');
        $response->assertSee('Chỉnh sửa tòa');
        $response->assertSee('Thêm tòa nhà');
        $response->assertSee('＋ Thêm tầng mới');

        // Table
        $response->assertSee('Mã tầng');
        $response->assertSee('Số tầng');
        $response->assertSee('Căn hộ / Thao tác');
        $response->assertSee('Xem');
        $response->assertSee('Xóa');

        // Create Popup modal HTML exists
        $response->assertSee('createBuildingModal');
        $response->assertSee('Tên tòa nhà *');
        $response->assertSee('Tạo tòa nhà');
        $response->assertSee('Hủy');

        // Edit Popup modal HTML exists
        $response->assertSee('editBuildingModal');
        $response->assertSee('Chỉnh sửa tòa nhà');
        $response->assertSee('Lưu thay đổi');
    }

    /**
     * Kiểm tra hiển thị màn hình Thêm tòa nhà độc lập (SCR-BLD-02).
     */
    public function test_create_building_screen_can_be_rendered(): void
    {
        $response = $this->get('/buildings/create');

        $response->assertStatus(200);
        $response->assertSee('Thêm tòa nhà');
        $response->assertSee('Tên tòa nhà *');
        $response->assertSee('Nhập tên tòa nhà');
        $response->assertSee('Tạo tòa nhà');
        $response->assertSee('Hủy');
    }

    /**
     * Kiểm tra hiển thị màn hình Chỉnh sửa tòa nhà độc lập (SCR-BLD-03).
     */
    public function test_edit_building_screen_can_be_rendered(): void
    {
        $building = Building::factory()->create([
            'BuildingName' => 'GGMB Residence · Tòa A',
        ]);

        $response = $this->get('/buildings/'.$building->BuildingId.'/edit');

        $response->assertStatus(200);
        $response->assertSee('Chỉnh sửa tòa nhà');
        $response->assertSee('GGMB Residence · Tòa A');
        $response->assertSee('Tên tòa nhà *');
        $response->assertSee('Lưu thay đổi');
        $response->assertSee('Hủy');
    }

    /**
     * Kiểm tra tạo tòa nhà mới qua form popup thành công.
     */
    public function test_can_create_new_building(): void
    {
        $response = $this->post('/buildings', [
            'BuildingName' => 'Tòa B · GGMB Residence',
        ]);

        $this->assertDatabaseHas('Building', [
            'BuildingName' => 'Tòa B · GGMB Residence',
            'IsDeleted' => false,
        ]);

        $newBuilding = Building::where('BuildingName', 'Tòa B · GGMB Residence')->first();
        $response->assertRedirect('/buildings?building_id='.$newBuilding->BuildingId);
        $response->assertSessionHas('status');
    }

    /**
     * Kiểm tra cập nhật thông tin tòa nhà thành công.
     */
    public function test_can_update_building(): void
    {
        $building = Building::factory()->create([
            'BuildingName' => 'Tòa Cũ',
        ]);

        $response = $this->put('/buildings/'.$building->BuildingId, [
            'BuildingName' => 'Tòa Mới Đã Sửa',
        ]);

        $this->assertDatabaseHas('Building', [
            'BuildingId' => $building->BuildingId,
            'BuildingName' => 'Tòa Mới Đã Sửa',
        ]);

        $response->assertRedirect('/buildings?building_id='.$building->BuildingId);
        $response->assertSessionHas('status');
    }

    /**
     * Kiểm tra kiểm thực khi thiếu tên tòa nhà.
     */
    public function test_building_name_is_required(): void
    {
        $response = $this->post('/buildings', [
            'BuildingName' => '',
        ]);

        $response->assertSessionHasErrors('BuildingName');
    }
}
