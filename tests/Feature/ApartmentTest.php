<?php

namespace Tests\Feature;

use App\Models\Apartment;
use App\Models\ApartmentResident;
use App\Models\Building;
use App\Models\Floor;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApartmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Kiểm tra hiển thị màn hình Quản lý căn hộ (SCR-APT-01).
     */
    public function test_apartment_screen_can_be_rendered(): void
    {
        $response = $this->get('/apartments');

        $response->assertStatus(200);

        // Sidebar active state
        $response->assertSee('Căn hộ');

        // Header & Breadcrumb
        $response->assertSee('GGMB');
        $response->assertSee('Danh sách căn hộ');
        $response->assertSee('Tra cứu, tạo và cập nhật căn hộ');

        // Filters
        $response->assertSee('Tòa · BuildingId');
        $response->assertSee('Tầng · FloorId');
        $response->assertSee('Trạng thái · Status');
        $response->assertSee('＋ Thêm căn hộ');

        // Table headers
        $response->assertSee('ID');
        $response->assertSee('Số căn hộ');
        $response->assertSee('Tầng');
        $response->assertSee('Trạng thái');
        $response->assertSee('Mô tả');
        $response->assertSee('Thao tác');

        // Footer note
        $response->assertSee('Chọn bản ghi để mở drawer');
    }

    /**
     * Kiểm tra danh sách hiển thị căn hộ từ cơ sở dữ liệu.
     */
    public function test_apartment_list_displays_records_and_filters(): void
    {
        $building = Building::factory()->create(['BuildingName' => 'GGMB Residence · Tòa A']);
        $floor = Floor::factory()->create(['BuildingId' => $building->BuildingId, 'FloorNumber' => 1]);

        $apt = Apartment::factory()->create([
            'FloorId' => $floor->FloorId,
            'ApartmentNumber' => '0101',
            'Status' => 'OCCUPIED',
            'Description' => 'Căn hộ tầng 1, số 01',
            'IsDeleted' => false,
        ]);

        $response = $this->get('/apartments?status=OCCUPIED');

        $response->assertStatus(200);
        $response->assertSee('0101');
        $response->assertSee('OCCUPIED');
        $response->assertSee('Căn hộ tầng 1, số 01');
        $response->assertSee('Xem');
        $response->assertSee('Sửa');
    }

    /**
     * Kiểm tra Drawer chi tiết căn hộ (SCR-APT-03).
     */
    public function test_apartment_detail_drawer_renders_with_relations(): void
    {
        $building = Building::factory()->create(['BuildingName' => 'GGMB Residence · Tòa A']);
        $floor = Floor::factory()->create(['BuildingId' => $building->BuildingId, 'FloorNumber' => 1]);

        $apt = Apartment::factory()->create([
            'FloorId' => $floor->FloorId,
            'ApartmentNumber' => '0101',
            'Status' => 'OCCUPIED',
            'Description' => 'Căn hộ tầng 1, số 01',
            'IsDeleted' => false,
        ]);

        $user = User::factory()->create([
            'FullName' => 'Nguyễn An',
            'Role' => 'RESIDENT',
        ]);

        ApartmentResident::factory()->create([
            'ApartmentId' => $apt->ApartmentId,
            'UserId' => $user->UserId,
            'StartDate' => '2024-01-01',
            'Status' => 'ACTIVE',
        ]);

        Vehicle::factory()->create([
            'ApartmentId' => $apt->ApartmentId,
            'LicensePlate' => '29A-10001',
            'VehicleType' => 'MOTORBIKE',
        ]);

        $response = $this->get('/apartments?selected_id='.$apt->ApartmentId);

        $response->assertStatus(200);
        $response->assertSee('CHI TIẾT / DRAWER');
        $response->assertSee('Căn hộ 0101');
        $response->assertSee('ApartmentId = '.$apt->ApartmentId);
        $response->assertSee('OCCUPIED');
        $response->assertSee('Số căn · ApartmentNumber');
        $response->assertSee('Mô tả · Description');
        $response->assertSee('CƯ DÂN · ApartmentResident → User');
        $response->assertSee('Nguyễn An');
        $response->assertSee('XE THUỘC CĂN HỘ · Vehicle');
        $response->assertSee('29A-10001 / MOTORBIKE');
        $response->assertSee('ĐIỆN / NƯỚC');
        $response->assertSee('Đóng');
        $response->assertSee('Chỉnh sửa');
    }

    /**
     * Kiểm tra route chi tiết căn hộ trực tiếp (/apartments/{apartment}).
     */
    public function test_apartment_show_route(): void
    {
        $building = Building::factory()->create(['BuildingName' => 'GGMB Residence · Tòa A']);
        $floor = Floor::factory()->create(['BuildingId' => $building->BuildingId, 'FloorNumber' => 1]);

        $apt = Apartment::factory()->create([
            'FloorId' => $floor->FloorId,
            'ApartmentNumber' => '0102',
            'Status' => 'OCCUPIED',
            'Description' => 'Căn hộ tầng 1, số 02',
        ]);

        // HTML response
        $htmlResponse = $this->get('/apartments/'.$apt->ApartmentId);
        $htmlResponse->assertStatus(200);
        $htmlResponse->assertSee('Căn hộ 0102');

        // JSON response
        $jsonResponse = $this->getJson('/apartments/'.$apt->ApartmentId);
        $jsonResponse->assertStatus(200);
        $jsonResponse->assertJsonFragment([
            'ApartmentNumber' => '0102',
        ]);
    }

    /**
     * Kiểm tra màn hình thêm căn hộ (SCR-APT-04).
     */
    public function test_create_apartment_screen_can_be_rendered(): void
    {
        $building = Building::factory()->create(['BuildingName' => 'GGMB Residence · Tòa A']);
        Floor::factory()->create(['BuildingId' => $building->BuildingId, 'FloorNumber' => 1]);

        $response = $this->get('/apartments/create');

        $response->assertStatus(200);
        $response->assertSee('Thêm căn hộ');
        $response->assertSee('BIỂU MẪU / MODAL');
        $response->assertSee('Các trường có dấu * là bắt buộc');
        $response->assertSee('Tòa · qua Floor.BuildingId');
        $response->assertSee('Tầng · FloorId');
        $response->assertSee('Số căn hộ · ApartmentNumber');
        $response->assertSee('Trạng thái · Status');
        $response->assertSee('Mô tả · Description');
        $response->assertSee('Tạo căn hộ');
        $response->assertSee('Đóng / Hủy');
    }

    /**
     * Kiểm tra tạo căn hộ thành công qua POST /apartments.
     */
    public function test_apartment_can_be_created_successfully(): void
    {
        $building = Building::factory()->create();
        $floor = Floor::factory()->create(['BuildingId' => $building->BuildingId, 'FloorNumber' => 2]);

        $postData = [
            'FloorId' => $floor->FloorId,
            'ApartmentNumber' => '0208',
            'Status' => 'VACANT',
            'Description' => 'Căn hộ mới tạo',
        ];

        $response = $this->post('/apartments', $postData);

        $response->assertRedirect('/apartments');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('Apartment', [
            'FloorId' => $floor->FloorId,
            'ApartmentNumber' => '0208',
            'Status' => 'VACANT',
            'Description' => 'Căn hộ mới tạo',
            'IsDeleted' => false,
        ]);
    }

    /**
     * Kiểm tra validate số căn hộ trùng trên cùng một tầng.
     */
    public function test_apartment_creation_validates_uniqueness_on_same_floor(): void
    {
        $building = Building::factory()->create();
        $floor = Floor::factory()->create(['BuildingId' => $building->BuildingId, 'FloorNumber' => 1]);

        Apartment::factory()->create([
            'FloorId' => $floor->FloorId,
            'ApartmentNumber' => '0101',
            'IsDeleted' => false,
        ]);

        $response = $this->post('/apartments', [
            'FloorId' => $floor->FloorId,
            'ApartmentNumber' => '0101',
            'Status' => 'VACANT',
        ]);

        $response->assertSessionHasErrors(['ApartmentNumber']);
    }

    /**
     * Kiểm tra màn hình chỉnh sửa căn hộ (SCR-APT-05).
     */
    public function test_edit_apartment_screen_can_be_rendered(): void
    {
        $building = Building::factory()->create(['BuildingName' => 'GGMB Residence · Tòa A']);
        $floor = Floor::factory()->create(['BuildingId' => $building->BuildingId, 'FloorNumber' => 1]);

        $apt = Apartment::factory()->create([
            'FloorId' => $floor->FloorId,
            'ApartmentNumber' => '0105',
            'Status' => 'OCCUPIED',
            'Description' => 'Mô tả gốc',
        ]);

        $response = $this->get('/apartments/'.$apt->ApartmentId.'/edit');

        $response->assertStatus(200);
        $response->assertSee('Chỉnh sửa căn hộ');
        $response->assertSee('0105');
        $response->assertSee('OCCUPIED');
        $response->assertSee('Mô tả gốc');
        $response->assertSee('Lưu thay đổi');
        $response->assertSee('Đóng / Hủy');
    }

    /**
     * Kiểm tra cập nhật căn hộ thành công qua PUT /apartments/{apartment}.
     */
    public function test_apartment_can_be_updated_successfully(): void
    {
        $building = Building::factory()->create();
        $floor = Floor::factory()->create(['BuildingId' => $building->BuildingId, 'FloorNumber' => 1]);

        $apt = Apartment::factory()->create([
            'FloorId' => $floor->FloorId,
            'ApartmentNumber' => '0106',
            'Status' => 'OCCUPIED',
            'Description' => 'Mô tả ban đầu',
        ]);

        $response = $this->put('/apartments/'.$apt->ApartmentId, [
            'ApartmentNumber' => '0106-EDIT',
            'Status' => 'VACANT',
            'Description' => 'Mô tả đã sửa',
        ]);

        $response->assertRedirect('/apartments');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('Apartment', [
            'ApartmentId' => $apt->ApartmentId,
            'ApartmentNumber' => '0106-EDIT',
            'Status' => 'VACANT',
            'Description' => 'Mô tả đã sửa',
        ]);
    }

    /**
     * Kiểm tra cập nhật không cho phép trùng với căn hộ khác cùng tầng.
     */
    public function test_apartment_update_validates_uniqueness_against_other_apartments(): void
    {
        $building = Building::factory()->create();
        $floor = Floor::factory()->create(['BuildingId' => $building->BuildingId, 'FloorNumber' => 1]);

        Apartment::factory()->create([
            'FloorId' => $floor->FloorId,
            'ApartmentNumber' => '0101',
        ]);

        $apt2 = Apartment::factory()->create([
            'FloorId' => $floor->FloorId,
            'ApartmentNumber' => '0102',
        ]);

        $response = $this->put('/apartments/'.$apt2->ApartmentId, [
            'ApartmentNumber' => '0101', // Duplicate of apt1
            'Status' => 'VACANT',
        ]);

        $response->assertSessionHasErrors(['ApartmentNumber']);
    }

    /**
     * Kiểm tra cập nhật trạng thái căn hộ (SCR-APT-06).
     */
    public function test_apartment_status_can_be_updated(): void
    {
        $building = Building::factory()->create();
        $floor = Floor::factory()->create(['BuildingId' => $building->BuildingId, 'FloorNumber' => 1]);

        $apt = Apartment::factory()->create([
            'FloorId' => $floor->FloorId,
            'ApartmentNumber' => '0505',
            'Status' => 'VACANT',
        ]);

        $response = $this->patch('/apartments/'.$apt->ApartmentId.'/status', [
            'Status' => 'SUSPENDED',
        ]);

        $response->assertRedirect('/apartments');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('Apartment', [
            'ApartmentId' => $apt->ApartmentId,
            'Status' => 'SUSPENDED',
        ]);
    }

    /**
     * Kiểm tra hiển thị popup thay đổi trạng thái căn hộ khi có status_id.
     */
    public function test_status_apartment_modal_can_be_rendered(): void
    {
        $building = Building::factory()->create();
        $floor = Floor::factory()->create(['BuildingId' => $building->BuildingId, 'FloorNumber' => 5]);

        $apt = Apartment::factory()->create([
            'FloorId' => $floor->FloorId,
            'ApartmentNumber' => '0505',
            'Status' => 'VACANT',
        ]);

        $response = $this->get('/apartments?status_id='.$apt->ApartmentId);

        $response->assertStatus(200);
        $response->assertSee('Ngừng hoạt động căn hộ');
        $response->assertSee('Trạng thái hiện tại');
        $response->assertSee('Trạng thái dự kiến');
        $response->assertSee('Xác nhận ngừng');
    }
}
