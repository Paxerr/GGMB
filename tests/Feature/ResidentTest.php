<?php

namespace Tests\Feature;

use App\Models\Apartment;
use App\Models\ApartmentResident;
use App\Models\Building;
use App\Models\Floor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResidentTest extends TestCase
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
     * Kiểm tra hiển thị màn hình Quản lý cư dân (SCR-RES-01).
     */
    public function test_resident_screen_can_be_rendered(): void
    {
        $response = $this->get('/residents');

        $response->assertStatus(200);

        // Sidebar active state
        $response->assertSee('Cư dân');

        // Header & Breadcrumbs
        $response->assertSee('GGMB');
        $response->assertSee('Danh bạ cư dân');
        $response->assertSee('Thông tin tài khoản cư dân và quan hệ cư trú');

        // Filters
        $response->assertSee('Họ tên / CCCD / SĐT');
        $response->assertSee('Căn hộ · ApartmentId');
        $response->assertSee('Trạng thái cư trú');
        $response->assertSee('＋ Tiếp nhận cư dân');

        // Table headers
        $response->assertSee('UserId');
        $response->assertSee('Họ tên');
        $response->assertSee('CCCD');
        $response->assertSee('Điện thoại');
        $response->assertSee('Căn hộ');
        $response->assertSee('Cư trú');
        $response->assertSee('Thao tác');
    }

    /**
     * Kiểm tra danh sách hiển thị cư dân từ cơ sở dữ liệu.
     */
    public function test_resident_list_displays_records_from_database(): void
    {
        $building = Building::factory()->create(['BuildingName' => 'GGMB Residence · Tòa A']);
        $floor = Floor::factory()->create(['BuildingId' => $building->BuildingId, 'FloorNumber' => 1]);
        $apartment = Apartment::factory()->create(['FloorId' => $floor->FloorId, 'ApartmentNumber' => '0101']);

        $user = User::factory()->create([
            'FullName' => 'Nguyễn An',
            'CitizenId' => '079000000010',
            'Phone' => '0910000010',
            'Role' => 'RESIDENT',
            'Status' => 'ACTIVE',
        ]);

        ApartmentResident::factory()->create([
            'ApartmentId' => $apartment->ApartmentId,
            'UserId' => $user->UserId,
            'Status' => 'ACTIVE',
        ]);

        $response = $this->get('/residents');

        $response->assertStatus(200);
        $response->assertSee('Nguyễn An');
        $response->assertSee('079000000010');
        $response->assertSee('0910000010');
        $response->assertSee('0101');
        $response->assertSee('Đang cư trú');
        $response->assertSee('Xem hồ sơ');
    }

    /**
     * Kiểm tra lọc cư dân theo từ khóa (Họ tên / CCCD / SĐT).
     */
    public function test_resident_filter_by_keyword(): void
    {
        $user1 = User::factory()->create([
            'FullName' => 'Nguyễn Văn Tìm Kiếm',
            'CitizenId' => '079111222333',
            'Phone' => '0901111222',
            'Role' => 'RESIDENT',
        ]);

        $user2 = User::factory()->create([
            'FullName' => 'Trần Văn Khác Biệt',
            'CitizenId' => '079444555666',
            'Phone' => '0903333444',
            'Role' => 'RESIDENT',
        ]);

        // Tìm theo tên user1
        $response = $this->get('/residents?keyword=Tìm+Kiếm');
        $response->assertStatus(200);
        $response->assertSee('Nguyễn Văn Tìm Kiếm');
        $response->assertDontSee('Trần Văn Khác Biệt');

        // Tìm theo CCCD user2
        $responseCCCD = $this->get('/residents?keyword=079444555666');
        $responseCCCD->assertStatus(200);
        $responseCCCD->assertSee('Trần Văn Khác Biệt');
        $responseCCCD->assertDontSee('Nguyễn Văn Tìm Kiếm');
    }

    /**
     * Kiểm tra lọc cư dân theo căn hộ (ApartmentId).
     */
    public function test_resident_filter_by_apartment(): void
    {
        $building = Building::factory()->create();
        $floor = Floor::factory()->create(['BuildingId' => $building->BuildingId]);
        $apt1 = Apartment::factory()->create(['FloorId' => $floor->FloorId, 'ApartmentNumber' => '0201']);
        $apt2 = Apartment::factory()->create(['FloorId' => $floor->FloorId, 'ApartmentNumber' => '0202']);

        $user1 = User::factory()->create(['FullName' => 'Cư Dân Phòng 201', 'Role' => 'RESIDENT']);
        $user2 = User::factory()->create(['FullName' => 'Cư Dân Phòng 202', 'Role' => 'RESIDENT']);

        ApartmentResident::factory()->create(['ApartmentId' => $apt1->ApartmentId, 'UserId' => $user1->UserId]);
        ApartmentResident::factory()->create(['ApartmentId' => $apt2->ApartmentId, 'UserId' => $user2->UserId]);

        $response = $this->get('/residents?apartment_id='.$apt1->ApartmentId);
        $response->assertStatus(200);
        $response->assertSee('Cư Dân Phòng 201');
        $response->assertDontSee('Cư Dân Phòng 202');
    }

    /**
     * Kiểm tra API chi tiết cư dân trả về dữ liệu JSON cho drawer.
     */
    public function test_resident_show_api_returns_json_details(): void
    {
        $building = Building::factory()->create(['BuildingName' => 'GGMB Residence · Tòa A']);
        $floor = Floor::factory()->create(['BuildingId' => $building->BuildingId, 'FloorNumber' => 2]);
        $apt = Apartment::factory()->create(['FloorId' => $floor->FloorId, 'ApartmentNumber' => '0205']);

        $user = User::factory()->create([
            'FullName' => 'Lê Thị Chi Tiết',
            'CitizenId' => '079999888777',
            'Phone' => '0988777666',
            'Email' => 'chitiet@ggmb.vn',
            'Role' => 'RESIDENT',
        ]);

        ApartmentResident::factory()->create([
            'ApartmentId' => $apt->ApartmentId,
            'UserId' => $user->UserId,
            'StartDate' => '2024-05-01',
            'Status' => 'ACTIVE',
        ]);

        $response = $this->getJson('/residents/'.$user->UserId);
        $response->assertStatus(200);
        $response->assertJson([
            'user_id' => $user->UserId,
            'full_name' => 'Lê Thị Chi Tiết',
            'citizen_id' => '079999888777',
            'phone' => '0988777666',
            'email' => 'chitiet@ggmb.vn',
            'apartment_number' => '0205',
            'residence_status' => 'ACTIVE',
        ]);
    }

    /**
     * Kiểm tra tiếp nhận cư dân mới (SCR-RES-03).
     */
    public function test_resident_can_be_created_and_assigned_to_apartment(): void
    {
        $building = Building::factory()->create();
        $floor = Floor::factory()->create(['BuildingId' => $building->BuildingId]);
        $apt = Apartment::factory()->create(['FloorId' => $floor->FloorId, 'ApartmentNumber' => '0301', 'Status' => 'VACANT']);

        $payload = [
            'apartment_id' => $apt->ApartmentId,
            'full_name' => 'Trần Văn Tiếp Nhận',
            'citizen_id' => '079123456789',
            'phone' => '0912345678',
            'email' => 'tiepnhan@ggmb.vn',
            'start_date' => '2026-03-01',
        ];

        $response = $this->post('/residents', $payload);
        $response->assertRedirect('/residents');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('User', [
            'FullName' => 'Trần Văn Tiếp Nhận',
            'CitizenId' => '079123456789',
            'Phone' => '0912345678',
            'Role' => 'RESIDENT',
        ]);

        $this->assertDatabaseHas('ApartmentResident', [
            'ApartmentId' => $apt->ApartmentId,
            'Status' => 'ACTIVE',
        ]);

        $this->assertDatabaseHas('Apartment', [
            'ApartmentId' => $apt->ApartmentId,
            'Status' => 'OCCUPIED',
        ]);
    }

    /**
     * Kiểm tra hiển thị màn hình Chi tiết cư dân (SCR-RES-02).
     */
    public function test_resident_show_page_can_be_rendered(): void
    {
        $building = Building::factory()->create(['BuildingName' => 'Tòa A']);
        $floor = Floor::factory()->create(['BuildingId' => $building->BuildingId, 'FloorNumber' => 1]);
        $apt = Apartment::factory()->create(['FloorId' => $floor->FloorId, 'ApartmentNumber' => '0101']);

        $user = User::factory()->create([
            'FullName' => 'Nguyễn Văn An',
            'CitizenId' => '079000000010',
            'Phone' => '0910000010',
            'Email' => 'nguyenan123@gmail.com',
            'Role' => 'RESIDENT',
            'Status' => 'ACTIVE',
        ]);

        ApartmentResident::factory()->create([
            'ApartmentId' => $apt->ApartmentId,
            'UserId' => $user->UserId,
            'Status' => 'ACTIVE',
            'StartDate' => '2024-01-01',
        ]);

        $response = $this->get('/residents/'.$user->UserId);
        $response->assertStatus(200);

        // Header & Titles
        $response->assertSee('Chi tiết cư dân');
        $response->assertSee('Nguyễn Văn An');
        $response->assertSee('Căn hộ 0101');
        $response->assertSee('Đang cư trú');

        // Fields
        $response->assertSee('Tên đăng nhập');
        $response->assertSee('Quan hệ với chủ hộ');
        $response->assertSee('079000000010');
        $response->assertSee('0910000010');
        $response->assertSee('nguyenan123@gmail.com');
        $response->assertSee('Chỉnh sửa thông tin');
        $response->assertSee('Quay lại danh bạ');
    }

    /**
     * Kiểm tra hiển thị màn hình Chỉnh sửa cư dân (SCR-RES-04).
     */
    public function test_resident_edit_page_can_be_rendered(): void
    {
        $user = User::factory()->create([
            'FullName' => 'Nguyễn Văn An',
            'Role' => 'RESIDENT',
        ]);

        $response = $this->get('/residents/'.$user->UserId.'/edit');
        $response->assertStatus(200);
        $response->assertSee('Chỉnh sửa thông tin cư dân');
        $response->assertSee('Nguyễn Văn An');
        $response->assertSee('Lưu thay đổi');
    }

    /**
     * Kiểm tra cập nhật thông tin cư dân.
     */
    public function test_resident_can_be_updated(): void
    {
        $user = User::factory()->create([
            'FullName' => 'Tên Cũ',
            'Phone' => '0900000001',
            'Role' => 'RESIDENT',
        ]);

        $payload = [
            'full_name' => 'Tên Mới Đã Cập Nhật',
            'phone' => '0999888777',
            'citizen_id' => '079999999999',
            'email' => 'tenmoi@ggmb.vn',
        ];

        $response = $this->put('/residents/'.$user->UserId, $payload);
        $response->assertRedirect('/residents/'.$user->UserId);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('User', [
            'UserId' => $user->UserId,
            'FullName' => 'Tên Mới Đã Cập Nhật',
            'Phone' => '0999888777',
            'Email' => 'tenmoi@ggmb.vn',
        ]);
    }

    /**
     * Kiểm tra thay đổi trạng thái cư dân sang INACTIVE (SCR-RES-05).
     */
    public function test_resident_status_can_be_updated_to_inactive(): void
    {
        $apartment = Apartment::factory()->create(['ApartmentNumber' => '0101']);
        $user = User::factory()->create([
            'FullName' => 'Lê Cư Dân',
            'Role' => 'RESIDENT',
            'Status' => 'ACTIVE',
        ]);

        $residency = ApartmentResident::factory()->create([
            'ApartmentId' => $apartment->ApartmentId,
            'UserId' => $user->UserId,
            'Status' => 'ACTIVE',
        ]);

        $response = $this->patch("/residents/{$user->UserId}/status", [
            'Status' => 'INACTIVE',
        ]);

        $response->assertRedirect('/residents');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('User', [
            'UserId' => $user->UserId,
            'Status' => 'INACTIVE',
        ]);

        $this->assertDatabaseHas('ApartmentResident', [
            'ApartmentResidentId' => $residency->ApartmentResidentId,
            'Status' => 'INACTIVE',
        ]);
    }

    /**
     * Kiểm tra thay đổi trạng thái cư dân sang ACTIVE (SCR-RES-05).
     */
    public function test_resident_status_can_be_updated_to_active(): void
    {
        $apartment = Apartment::factory()->create(['ApartmentNumber' => '0102']);
        $user = User::factory()->create([
            'FullName' => 'Trần Cư Dân',
            'Role' => 'RESIDENT',
            'Status' => 'INACTIVE',
        ]);

        $residency = ApartmentResident::factory()->create([
            'ApartmentId' => $apartment->ApartmentId,
            'UserId' => $user->UserId,
            'Status' => 'INACTIVE',
        ]);

        $response = $this->patch("/residents/{$user->UserId}/status", [
            'Status' => 'ACTIVE',
        ]);

        $response->assertRedirect('/residents');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('User', [
            'UserId' => $user->UserId,
            'Status' => 'ACTIVE',
        ]);

        $this->assertDatabaseHas('ApartmentResident', [
            'ApartmentResidentId' => $residency->ApartmentResidentId,
            'Status' => 'ACTIVE',
        ]);
    }

    /**
     * Kiểm tra hiển thị màn hình Tạo cư dân mới (SCR-RES-03).
     */
    public function test_resident_create_screen_can_be_rendered(): void
    {
        $response = $this->get('/residents/create');

        $response->assertStatus(200);
        $response->assertSee('Tạo cư dân mới');
        $response->assertSee('Tên đăng nhập');
        $response->assertSee('Họ và tên');
        $response->assertSee('Mật khẩu ban đầu');
        $response->assertSee('Căn hộ');
        $response->assertSee('Tạo cư dân');
        $response->assertSee('THÔNG TIN LIÊN QUAN');
    }
}
