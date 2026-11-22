<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\ApartmentResident;
use App\Models\Building;
use App\Models\FeeRate;
use App\Models\FeeType;
use App\Models\Floor;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\MeterReading;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use App\Models\NotificationTarget;
use App\Models\Ticket;
use App\Models\TicketAssignment;
use App\Models\TicketAttachment;
use App\Models\TicketResponse;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class GgmbSeeder extends Seeder
{
    public function run(): void
    {
        // Tắt kiểm tra khóa ngoại để làm sạch và gieo mầm dữ liệu
        Schema::disableForeignKeyConstraints();

        $defaultPassword = Hash::make('password123');

        // ==========================================
        // 1. TÒA NHÀ (Building) - 2 Tòa Hiện Đại
        // ==========================================
        Building::truncate();
        Building::insert([
            [
                'BuildingId' => 1,
                'BuildingName' => 'GGMB Residence · Tòa A',
                'IsDeleted' => false,
                'CreatedAt' => now(),
            ],
            [
                'BuildingId' => 2,
                'BuildingName' => 'GGMB Residence · Tòa B',
                'IsDeleted' => false,
                'CreatedAt' => now(),
            ],
        ]);

        // ==========================================
        // 2. TẦNG (Floor) - Mỗi Tòa 5 Tầng
        // ==========================================
        Floor::truncate();
        $floors = [];
        $floorId = 1;
        // Tòa A (Tầng 1 -> 5, FloorId: 1..5)
        for ($f = 1; $f <= 5; $f++) {
            $floors[] = [
                'FloorId' => $floorId++,
                'BuildingId' => 1,
                'FloorNumber' => $f,
                'IsDeleted' => false,
                'CreatedAt' => now(),
            ];
        }
        // Tòa B (Tầng 1 -> 5, FloorId: 6..10)
        for ($f = 1; $f <= 5; $f++) {
            $floors[] = [
                'FloorId' => $floorId++,
                'BuildingId' => 2,
                'FloorNumber' => $f,
                'IsDeleted' => false,
                'CreatedAt' => now(),
            ];
        }
        Floor::insert($floors);

        // ==========================================
        // 3. CĂN HỘ (Apartment) - 80 Căn Hộ Phong Phú
        // ==========================================
        Apartment::truncate();
        $apartments = [];
        $aptId = 1;

        // Tòa A: 40 căn (ID 1 -> 40, FloorId 1..5)
        for ($f = 1; $f <= 5; $f++) {
            for ($num = 1; $num <= 8; $num++) {
                $aptNum = sprintf('%02d%02d', $f, $num);

                // Trạng thái đa dạng: Đang ở, Trống, Đang hoàn thiện nội thất, Tạm ngừng
                $status = 'OCCUPIED';
                if ($aptId == 31 || $aptId == 32 || ($aptId >= 35 && $aptId <= 38)) {
                    $status = 'VACANT';
                } elseif ($aptId == 33 || $aptId == 34) {
                    $status = 'MAINTENANCE';
                } elseif ($aptId == 39 || $aptId == 40) {
                    $status = 'INACTIVE';
                }

                $area = match ($num) {
                    1, 2 => '68.5m² · 2PN 2WC · Ban công Đông Nam',
                    3, 4 => '85.0m² · 2PN+1 2WC · Hướng Nam thoáng mát',
                    5, 6 => '105.2m² · 3PN 2WC · Căn góc view hồ',
                    7 => '48.0m² · 1PN 1WC · Studio cao cấp',
                    8 => '120.0m² · 3PN 3WC · Căn góc view nội khu',
                };

                $apartments[] = [
                    'ApartmentId' => $aptId++,
                    'FloorId' => $f,
                    'ApartmentNumber' => $aptNum,
                    'Status' => $status,
                    'Description' => "Căn hộ Tòa A, Tầng $f, Số $aptNum ({$area})",
                    'IsDeleted' => false,
                    'CreatedAt' => now(),
                ];
            }
        }

        // Tòa B: 40 căn (ID 41 -> 80, FloorId 6..10)
        for ($f = 1; $f <= 5; $f++) {
            for ($num = 1; $num <= 8; $num++) {
                $floorDbId = 5 + $f;
                $aptNum = sprintf('B%02d%02d', $f, $num);

                $status = ($num === 7 || $num === 8) ? 'VACANT' : 'OCCUPIED';
                if ($f === 5 && $num >= 6) {
                    $status = 'MAINTENANCE';
                }

                $area = match ($num) {
                    1, 2 => '72.0m² · 2PN 2WC · Ban công hướng mát',
                    3, 4 => '90.5m² · 3PN 2WC · Căn sáng tự nhiên',
                    5, 6 => '65.0m² · 2PN 1WC · Thiết kế hiện đại',
                    default => '52.0m² · 1PN+1 1WC · Tối ưu công năng',
                };

                $apartments[] = [
                    'ApartmentId' => $aptId++,
                    'FloorId' => $floorDbId,
                    'ApartmentNumber' => $aptNum,
                    'Status' => $status,
                    'Description' => "Căn hộ Tòa B, Tầng $f, Số $aptNum ({$area})",
                    'IsDeleted' => false,
                    'CreatedAt' => now(),
                ];
            }
        }
        Apartment::insert($apartments);

        // ==========================================
        // 4. NGƯỜI DÙNG & NHÂN SỰ (User) - ~60 Người Dùng
        // ==========================================
        User::truncate();
        $users = [
            // Ban quản lý (Manager)
            ['UserId' => 1, 'UserName' => 'manager01', 'FullName' => 'Nguyễn Minh Quản lý', 'Phone' => '0901000001', 'Email' => 'manager01@ggmb.example', 'CitizenId' => '001085001111', 'Role' => 'MANAGER', 'Department' => 'Ban quản lý', 'Status' => 'ACTIVE'],
            ['UserId' => 2, 'UserName' => 'support01', 'FullName' => 'Trần Thu Hỗ trợ', 'Phone' => '0902000002', 'Email' => 'support01@ggmb.example', 'CitizenId' => '001088002222', 'Role' => 'SUPPORT', 'Department' => 'Chăm sóc cư dân', 'Status' => 'ACTIVE'],
            ['UserId' => 3, 'UserName' => 'support02', 'FullName' => 'Lê Anh Hỗ trợ', 'Phone' => '0903000003', 'Email' => 'support02@ggmb.example', 'CitizenId' => '001090003333', 'Role' => 'SUPPORT', 'Department' => 'Chăm sóc cư dân', 'Status' => 'ACTIVE'],
            ['UserId' => 4, 'UserName' => 'support03', 'FullName' => 'Phạm Hà Hỗ trợ', 'Phone' => '0904000004', 'Email' => 'support03@ggmb.example', 'CitizenId' => '001092004444', 'Role' => 'SUPPORT', 'Department' => 'Chăm sóc cư dân', 'Status' => 'ACTIVE'],
            ['UserId' => 5, 'UserName' => 'tech01', 'FullName' => 'Nguyễn Văn Kỹ thuật', 'Phone' => '0905000005', 'Email' => 'tech01@ggmb.example', 'CitizenId' => '001083005555', 'Role' => 'TECHNICIAN', 'Department' => 'Kỹ thuật', 'Status' => 'ACTIVE'],
            ['UserId' => 6, 'UserName' => 'tech02', 'FullName' => 'Đỗ Quốc Kỹ thuật', 'Phone' => '0906000006', 'Email' => 'tech02@ggmb.example', 'CitizenId' => '001086006666', 'Role' => 'TECHNICIAN', 'Department' => 'Kỹ thuật', 'Status' => 'ACTIVE'],
            ['UserId' => 7, 'UserName' => 'tech03', 'FullName' => 'Vũ Hoàng Kỹ thuật', 'Phone' => '0907000007', 'Email' => 'tech03@ggmb.example', 'CitizenId' => '001089007777', 'Role' => 'TECHNICIAN', 'Department' => 'Kỹ thuật', 'Status' => 'ACTIVE'],
            ['UserId' => 8, 'UserName' => 'support04', 'FullName' => 'Bùi Đức Hỗ trợ', 'Phone' => '0908000008', 'Email' => 'support04@ggmb.example', 'CitizenId' => '001091008888', 'Role' => 'SUPPORT', 'Department' => 'Chăm sóc cư dân', 'Status' => 'ACTIVE'],
            ['UserId' => 9, 'UserName' => 'tech04', 'FullName' => 'Phan Nam Kỹ thuật', 'Phone' => '0909000009', 'Email' => 'tech04@ggmb.example', 'CitizenId' => '001093009999', 'Role' => 'TECHNICIAN', 'Department' => 'Kỹ thuật', 'Status' => 'ACTIVE'],
        ];

        // Danh sách tên cư dân đa dạng, tự nhiên
        $residentProfiles = [
            ['name' => 'Nguyễn An', 'phone' => '0910000010', 'email' => 'nguyenan123@gmail.com', 'cccd' => '079000000010', 'status' => 'ACTIVE'],
            ['name' => 'Trần Thái Bình', 'phone' => '0912111222', 'email' => 'binh.tran@fpt.com.vn', 'cccd' => '001090112233', 'status' => 'ACTIVE'],
            ['name' => 'Lê Khánh Chi', 'phone' => '0983222333', 'email' => 'khanhchi.le@gmail.com', 'cccd' => '031192334455', 'status' => 'ACTIVE'],
            ['name' => 'Phạm Tiến Dũng', 'phone' => '0974333444', 'email' => 'tiendung.pham@viettel.com.vn', 'cccd' => '001088445566', 'status' => 'ACTIVE'],
            ['name' => 'Hoàng Trường Giang', 'phone' => '0965444555', 'email' => 'giang.truong@techcombank.com.vn', 'cccd' => '038094556677', 'status' => 'ACTIVE'],
            ['name' => 'Vũ Thị Thanh Hà', 'phone' => '0906555666', 'email' => 'thanhha.vu@gmail.com', 'cccd' => '001195667788', 'status' => 'ACTIVE'],
            ['name' => 'Đặng Quang Huy', 'phone' => '0937666777', 'email' => 'quanghuy.dang@vinfast.vn', 'cccd' => '079089778899', 'status' => 'ACTIVE'],
            ['name' => 'Bùi Mai Lan', 'phone' => '0988777888', 'email' => 'mailan.bui@gmail.com', 'cccd' => '001193889900', 'status' => 'ACTIVE'],
            ['name' => 'Đỗ Nhật Minh', 'phone' => '0919888999', 'email' => 'nhatminh.do@vietcombank.com.vn', 'cccd' => '024091990011', 'status' => 'ACTIVE'],
            ['name' => 'Phan Hoài Nam', 'phone' => '0901999000', 'email' => 'hoainam.phan@gmail.com', 'cccd' => '048087001122', 'status' => 'ACTIVE'],
            ['name' => 'Nguyễn Hoàng Oanh', 'phone' => '0982000111', 'email' => 'hoangoanh.nguyen@vinschool.edu.vn', 'cccd' => '001196112233', 'status' => 'ACTIVE'],
            ['name' => 'Trần Hồng Phúc', 'phone' => '0973111222', 'email' => 'hongphuc.tran@gmail.com', 'cccd' => '036092223344', 'status' => 'ACTIVE'],
            ['name' => 'Lê Minh Quân', 'phone' => '0964222333', 'email' => 'minhquan.le@vnpt.vn', 'cccd' => '001089334455', 'status' => 'ACTIVE'],
            ['name' => 'Phạm Thu Trang', 'phone' => '0905333444', 'email' => 'thutrang.pham@gmail.com', 'cccd' => '001197445566', 'status' => 'ACTIVE'],
            ['name' => 'Hoàng Anh Tú', 'phone' => '0936444555', 'email' => 'anhtu.hoang@mb.com.vn', 'cccd' => '079093556677', 'status' => 'ACTIVE'],
            ['name' => 'Vũ Hải An', 'phone' => '0987555666', 'email' => 'haian.vu@gmail.com', 'cccd' => '001094667788', 'status' => 'ACTIVE'],
            ['name' => 'Đặng Trọng Bình', 'phone' => '0918666777', 'email' => 'trongbinh.dang@sun.vn', 'cccd' => '048086778899', 'status' => 'ACTIVE'],
            ['name' => 'Bùi Quỳnh Chi', 'phone' => '0909777888', 'email' => 'quynhchi.bui@gmail.com', 'cccd' => '001198889900', 'status' => 'ACTIVE'],
            ['name' => 'Đỗ Việt Dũng', 'phone' => '0981888999', 'email' => 'vietdung.do@gmail.com', 'cccd' => '001085990011', 'status' => 'LOCKED'], // Khóa do nợ phí quá hạn
            ['name' => 'Phan Hương Giang', 'phone' => '0972999000', 'email' => 'huonggiang.phan@gmail.com', 'cccd' => '031194001122', 'status' => 'ACTIVE'],
            ['name' => 'Nguyễn Mạnh Hà', 'phone' => '0963000111', 'email' => 'manhha.nguyen@tiki.vn', 'cccd' => '001090112233', 'status' => 'ACTIVE'],
            ['name' => 'Trần Gia Huy', 'phone' => '0904111222', 'email' => 'giahuy.tran@gmail.com', 'cccd' => '079095223344', 'status' => 'ACTIVE'],
            ['name' => 'Lê Phương Lan', 'phone' => '0935222333', 'email' => 'phuonglan.le@bav.edu.vn', 'cccd' => '001191334455', 'status' => 'ACTIVE'],
            ['name' => 'Phạm Quang Minh', 'phone' => '0986333444', 'email' => 'quangminh.pham@gmail.com', 'cccd' => '038088445566', 'status' => 'ACTIVE'],
            ['name' => 'Hoàng Phương Nam', 'phone' => '0917444555', 'email' => 'phuongnam.hoang@gmail.com', 'cccd' => '001092556677', 'status' => 'ACTIVE'],
            ['name' => 'Vũ Kiều Oanh', 'phone' => '0908555666', 'email' => 'kieuoanh.vu@gmail.com', 'cccd' => '001195667788', 'status' => 'ACTIVE'],
            ['name' => 'Đặng Vĩnh Phúc', 'phone' => '0979666777', 'email' => 'vinhphuc.dang@shb.com.vn', 'cccd' => '079089778899', 'status' => 'ACTIVE'],
            ['name' => 'Bùi Minh Quân', 'phone' => '0961777888', 'email' => 'minhquan.bui@gmail.com', 'cccd' => '001093889900', 'status' => 'ACTIVE'],
            ['name' => 'Đỗ Huyền Trang', 'phone' => '0902888999', 'email' => 'huyentrang.do@gmail.com', 'cccd' => '001197990011', 'status' => 'ACTIVE'],
            ['name' => 'Phan Cẩm Tú', 'phone' => '0933999000', 'email' => 'camtu.phan@gmail.com', 'cccd' => '048196001122', 'status' => 'INACTIVE'], // Đã chuyển nhượng
            // Thêm các cư dân cho Tòa B & Thành viên gia đình
            ['name' => 'Ngô Bảo Châu', 'phone' => '0984111222', 'email' => 'baochau.ngo@gmail.com', 'cccd' => '001092113355', 'status' => 'ACTIVE'],
            ['name' => 'Dương Thùy Linh', 'phone' => '0975222333', 'email' => 'thuylinh.duong@gmail.com', 'cccd' => '001194224466', 'status' => 'ACTIVE'],
            ['name' => 'Lý Quốc Tuấn', 'phone' => '0966333444', 'email' => 'quoctuan.ly@gmail.com', 'cccd' => '079090335577', 'status' => 'ACTIVE'],
            ['name' => 'Hồ Ngọc Mai', 'phone' => '0907444555', 'email' => 'ngocmai.ho@gmail.com', 'cccd' => '001198446688', 'status' => 'ACTIVE'],
            ['name' => 'Tạ Quang Khải', 'phone' => '0938555666', 'email' => 'quangkhai.ta@gmail.com', 'cccd' => '031087557799', 'status' => 'ACTIVE'],
            ['name' => 'Đoàn Thị Thơm', 'phone' => '0989666777', 'email' => 'thithom.doan@gmail.com', 'cccd' => '036195668800', 'status' => 'ACTIVE'],
            ['name' => 'Vương Đình Huệ', 'phone' => '0911777888', 'email' => 'dinhhue.vuong@gmail.com', 'cccd' => '001089779911', 'status' => 'ACTIVE'],
            ['name' => 'Đinh Tiến Đạt', 'phone' => '0902888999', 'email' => 'tiendat.dinh@gmail.com', 'cccd' => '079093880022', 'status' => 'ACTIVE'],
            ['name' => 'Lưu Thị Bích', 'phone' => '0973999000', 'email' => 'thibich.luu@gmail.com', 'cccd' => '001192991133', 'status' => 'ACTIVE'],
            ['name' => 'Chu Văn An', 'phone' => '0964000111', 'email' => 'vanan.chu@gmail.com', 'cccd' => '001084002244', 'status' => 'ACTIVE'],
        ];

        foreach ($residentProfiles as $idx => $profile) {
            $num = $idx + 1;
            $users[] = [
                'UserId' => 10 + $idx,
                'UserName' => sprintf('resident%02d', $num),
                'FullName' => $profile['name'],
                'Phone' => $profile['phone'],
                'Email' => $profile['email'],
                'CitizenId' => $profile['cccd'],
                'Role' => 'RESIDENT',
                'Department' => null,
                'Status' => $profile['status'],
            ];
        }

        // Tài khoản mẫu trực quan (ngắn gọn, dễ nhớ để đăng nhập ngay)
        $users[] = [
            'UserId' => 90,
            'UserName' => 'manager',
            'FullName' => 'Nguyễn Văn Quản Lý',
            'Phone' => '0901234567',
            'Email' => 'manager@ggmb.example',
            'CitizenId' => '001080123456',
            'Role' => 'MANAGER',
            'Department' => 'Ban quản lý',
            'Status' => 'ACTIVE',
        ];
        $users[] = [
            'UserId' => 91,
            'UserName' => 'resident',
            'FullName' => 'Trần Thị Cư Dân',
            'Phone' => '0912345678',
            'Email' => 'resident@ggmb.example',
            'CitizenId' => '079090123456',
            'Role' => 'RESIDENT',
            'Department' => null,
            'Status' => 'ACTIVE',
        ];
        $users[] = [
            'UserId' => 92,
            'UserName' => 'tech',
            'FullName' => 'Lê Kỹ Thuật Viên',
            'Phone' => '0923456789',
            'Email' => 'tech@ggmb.example',
            'CitizenId' => '001085654321',
            'Role' => 'TECHNICIAN',
            'Department' => 'Kỹ thuật',
            'Status' => 'ACTIVE',
        ];
        $users[] = [
            'UserId' => 93,
            'UserName' => 'admin',
            'FullName' => 'Quản Trị Viên Hệ Thống',
            'Phone' => '0909999999',
            'Email' => 'admin@ggmb.example',
            'CitizenId' => '001088999999',
            'Role' => 'ADMIN',
            'Department' => 'Ban giám đốc',
            'Status' => 'ACTIVE',
        ];

        foreach ($users as &$u) {
            $u['PasswordHash'] = $defaultPassword;
            $u['IsDeleted'] = false;
            $u['CreatedAt'] = now();
        }
        User::insert($users);

        // ==========================================
        // 5. CƯ TRÚ (ApartmentResident) - Đa Dạng Hộ Gia Đình
        // ==========================================
        ApartmentResident::truncate();
        $residents = [];
        $resId = 1;

        // Căn hộ 0101 (ApartmentId 1): Cư dân chính Nguyễn An (UserId 10) + cư dân mẫu 'resident' (UserId 91)
        $residents[] = [
            'ApartmentResidentId' => $resId++,
            'ApartmentId' => 1,
            'UserId' => 10,
            'StartDate' => '2024-01-01',
            'EndDate' => null,
            'Status' => 'ACTIVE',
            'IsDeleted' => false,
            'CreatedAt' => now(),
        ];
        $residents[] = [
            'ApartmentResidentId' => $resId++,
            'ApartmentId' => 1,
            'UserId' => 91,
            'StartDate' => '2025-01-01',
            'EndDate' => null,
            'Status' => 'ACTIVE',
            'IsDeleted' => false,
            'CreatedAt' => now(),
        ];

        // Gán các căn hộ 2 -> 30 cho cư dân tương ứng
        for ($i = 2; $i <= 30; $i++) {
            $userId = 9 + $i; // resident02 -> resident30
            $st = ($i === 30) ? 'INACTIVE' : 'ACTIVE';
            $startDate = match ($i % 4) {
                0 => '2023-06-15',
                1 => '2024-01-01',
                2 => '2024-08-20',
                default => '2025-03-10',
            };

            $residents[] = [
                'ApartmentResidentId' => $resId++,
                'ApartmentId' => $i,
                'UserId' => $userId,
                'StartDate' => $startDate,
                'EndDate' => ($st === 'INACTIVE') ? '2026-01-31' : null,
                'Status' => $st,
                'IsDeleted' => false,
                'CreatedAt' => now(),
            ];
        }

        // Căn hộ Tòa B (41 -> 50) có thêm cư dân
        for ($k = 0; $k < 10; $k++) {
            $aptNumId = 41 + $k;
            $uId = 40 + $k; // Các user mở rộng
            $residents[] = [
                'ApartmentResidentId' => $resId++,
                'ApartmentId' => $aptNumId,
                'UserId' => $uId,
                'StartDate' => '2025-05-01',
                'EndDate' => null,
                'Status' => 'ACTIVE',
                'IsDeleted' => false,
                'CreatedAt' => now(),
            ];
        }
        ApartmentResident::insert($residents);

        // ==========================================
        // 6. PHƯƠNG TIỆN (Vehicle) - Biển Số Đẹp, Đủ Loại Xe
        // ==========================================
        Vehicle::truncate();
        $vehiclesList = [
            // Căn hộ 1 (0101): Xe máy theo test + 1 ô tô sang
            ['apt' => 1, 'plate' => '29A-10001', 'type' => 'MOTORBIKE'],
            ['apt' => 1, 'plate' => '30H-888.68', 'type' => 'CAR'],

            // Các căn hộ khác
            ['apt' => 2, 'plate' => '29-E1 123.45', 'type' => 'MOTORBIKE'],
            ['apt' => 2, 'plate' => '30F-567.89', 'type' => 'CAR'],
            ['apt' => 3, 'plate' => '29-G1 456.78', 'type' => 'MOTORBIKE'],
            ['apt' => 4, 'plate' => '51K-999.28', 'type' => 'CAR'],
            ['apt' => 4, 'plate' => '29-MĐ1 888.88', 'type' => 'ELECTRIC_BIKE'],
            ['apt' => 5, 'plate' => '29-B1 789.01', 'type' => 'MOTORBIKE'],
            ['apt' => 6, 'plate' => '30A-666.88', 'type' => 'CAR'],
            ['apt' => 7, 'plate' => '29-P1 345.67', 'type' => 'MOTORBIKE'],
            ['apt' => 8, 'plate' => '15A-345.67', 'type' => 'CAR'],
            ['apt' => 9, 'plate' => '29-H2 567.89', 'type' => 'MOTORBIKE'],
            ['apt' => 10, 'plate' => '29-MĐ2 222.33', 'type' => 'ELECTRIC_BIKE'],
            ['apt' => 11, 'plate' => '30E-456.78', 'type' => 'CAR'],
            ['apt' => 12, 'plate' => '29-K1 890.12', 'type' => 'MOTORBIKE'],
            ['apt' => 13, 'plate' => '43A-678.90', 'type' => 'CAR'],
            ['apt' => 14, 'plate' => '29-D1 234.56', 'type' => 'MOTORBIKE'],
            ['apt' => 15, 'plate' => '29-L5 678.90', 'type' => 'MOTORBIKE'],
            ['apt' => 16, 'plate' => '30G-789.01', 'type' => 'CAR'],
            ['apt' => 17, 'plate' => '29-MĐ3 777.99', 'type' => 'ELECTRIC_BIKE'],
            ['apt' => 18, 'plate' => '29-S1 112.23', 'type' => 'MOTORBIKE'],
            ['apt' => 19, 'plate' => '29-T1 334.45', 'type' => 'MOTORBIKE'],
            ['apt' => 20, 'plate' => '51H-123.45', 'type' => 'CAR'],
            ['apt' => 21, 'plate' => '29-X1 556.67', 'type' => 'MOTORBIKE'],
            ['apt' => 22, 'plate' => '29-Y1 778.89', 'type' => 'MOTORBIKE'],
            ['apt' => 23, 'plate' => '30H-999.00', 'type' => 'CAR'],
            ['apt' => 24, 'plate' => '14A-567.89', 'type' => 'CAR'],
            ['apt' => 25, 'plate' => '29-Z1 990.01', 'type' => 'MOTORBIKE'],
            ['apt' => 26, 'plate' => '29-C1 445.56', 'type' => 'MOTORBIKE'],
            ['apt' => 27, 'plate' => '30K-111.22', 'type' => 'CAR'],
            ['apt' => 28, 'plate' => '29-F1 667.78', 'type' => 'MOTORBIKE'],
            ['apt' => 41, 'plate' => '29A-998.89', 'type' => 'CAR'],
            ['apt' => 41, 'plate' => '29-V1 889.90', 'type' => 'MOTORBIKE'],
            ['apt' => 42, 'plate' => '29-N1 112.34', 'type' => 'MOTORBIKE'],
            ['apt' => 43, 'plate' => '30H-444.55', 'type' => 'CAR'],
        ];

        $vehicles = [];
        foreach ($vehiclesList as $vId => $v) {
            $vehicles[] = [
                'VehicleId' => $vId + 1,
                'ApartmentId' => $v['apt'],
                'LicensePlate' => $v['plate'],
                'VehicleType' => $v['type'],
                'IsDeleted' => false,
                'CreatedAt' => now(),
            ];
        }
        Vehicle::insert($vehicles);

        // ==========================================
        // 7. LOẠI PHÍ (FeeType) & ĐƠN GIÁ (FeeRate)
        // ==========================================
        FeeType::truncate();
        $feeTypes = [
            ['FeeTypeId' => 1, 'Code' => 'ELECTRIC', 'Name' => 'Điện', 'Description' => 'Điện năng tiêu thụ sinh hoạt theo chỉ số công tơ', 'IsActive' => true],
            ['FeeTypeId' => 2, 'Code' => 'WATER', 'Name' => 'Nước', 'Description' => 'Nước sạch sinh hoạt theo chỉ số đồng hồ', 'IsActive' => true],
            ['FeeTypeId' => 3, 'Code' => 'MANAGEMENT', 'Name' => 'Phí quản lý', 'Description' => 'Phí quản lý vận hành tòa nhà và tiện ích chung', 'IsActive' => true],
            ['FeeTypeId' => 4, 'Code' => 'PARKING_MOTO', 'Name' => 'Gửi xe máy', 'Description' => 'Phí trông giữ phương tiện xe máy theo tháng', 'IsActive' => true],
            ['FeeTypeId' => 5, 'Code' => 'PARKING_CAR', 'Name' => 'Gửi ô tô', 'Description' => 'Phí trông giữ ô tô theo vị trí đỗ cố định hàng tháng', 'IsActive' => true],
            ['FeeTypeId' => 6, 'Code' => 'INTERNET', 'Name' => 'Internet', 'Description' => 'Dịch vụ mạng cáp quang băng thông rộng tòa nhà', 'IsActive' => true],
        ];
        FeeType::insert($feeTypes);

        FeeRate::truncate();
        $feeRates = [
            ['FeeRateId' => 1, 'FeeTypeId' => 1, 'UnitPrice' => 3500.00, 'EffectiveFrom' => '2025-01-01', 'EffectiveTo' => null, 'CreatedAt' => now()],
            ['FeeRateId' => 2, 'FeeTypeId' => 2, 'UnitPrice' => 18000.00, 'EffectiveFrom' => '2025-01-01', 'EffectiveTo' => null, 'CreatedAt' => now()],
            ['FeeRateId' => 3, 'FeeTypeId' => 3, 'UnitPrice' => 12000.00, 'EffectiveFrom' => '2025-01-01', 'EffectiveTo' => null, 'CreatedAt' => now()],
            ['FeeRateId' => 4, 'FeeTypeId' => 4, 'UnitPrice' => 100000.00, 'EffectiveFrom' => '2025-01-01', 'EffectiveTo' => null, 'CreatedAt' => now()],
            ['FeeRateId' => 5, 'FeeTypeId' => 5, 'UnitPrice' => 1200000.00, 'EffectiveFrom' => '2025-01-01', 'EffectiveTo' => null, 'CreatedAt' => now()],
            ['FeeRateId' => 6, 'FeeTypeId' => 6, 'UnitPrice' => 220000.00, 'EffectiveFrom' => '2025-01-01', 'EffectiveTo' => null, 'CreatedAt' => now()],
        ];
        FeeRate::insert($feeRates);

        // ==========================================
        // 8. SỔ CHỈ SỐ ĐIỆN NƯỚC (MeterReading) - 3 Kỳ Liên Kế
        // ==========================================
        MeterReading::truncate();
        $readings = [];
        $readingId = 1;

        // Căn 1 (0101): Số điện kỳ 02/2026 bắt buộc Previous = 103, Current = 142, Consumption = 39 (theo Test)
        $elecPrev = [103, 115, 140, 210, 185, 320, 160, 240, 195, 280, 130, 225, 310, 175, 260, 145, 230, 305, 190, 275, 150, 235, 315, 180, 265, 155, 245, 325, 200, 285];
        $elecCurr = [142, 168, 198, 295, 248, 415, 225, 335, 272, 388, 188, 312, 422, 245, 355, 208, 318, 412, 265, 378, 215, 322, 428, 252, 362, 222, 338, 438, 282, 395];

        $waterPrev = [41, 55, 68, 92, 78, 120, 62, 85, 74, 110, 50, 88, 115, 70, 98, 56, 82, 112, 76, 105, 58, 86, 118, 72, 102, 60, 90, 122, 80, 108];
        $waterCurr = [48, 66, 81, 110, 94, 142, 75, 102, 89, 131, 62, 104, 136, 85, 118, 68, 99, 133, 91, 126, 71, 103, 140, 87, 121, 73, 107, 145, 96, 129];

        // Kỳ 01/2026
        for ($i = 0; $i < 30; $i++) {
            $apt = $i + 1;
            $techId = ($i % 3 === 0) ? 5 : (($i % 3 === 1) ? 6 : 7);
            $day = sprintf('%02d', ($i % 25) + 1);

            $readings[] = [
                'MeterReadingId' => $readingId++,
                'ApartmentId' => $apt,
                'FeeTypeId' => 1,
                'RecordedByUserId' => $techId,
                'BillingPeriod' => '01/2026',
                'PreviousReading' => max(0, $elecPrev[$i] - 45),
                'CurrentReading' => $elecPrev[$i],
                'Consumption' => 45,
                'RecordedAt' => "2026-01-$day 08:30:00",
            ];
            $readings[] = [
                'MeterReadingId' => $readingId++,
                'ApartmentId' => $apt,
                'FeeTypeId' => 2,
                'RecordedByUserId' => $techId,
                'BillingPeriod' => '01/2026',
                'PreviousReading' => max(0, $waterPrev[$i] - 8),
                'CurrentReading' => $waterPrev[$i],
                'Consumption' => 8,
                'RecordedAt' => "2026-01-$day 08:35:00",
            ];
        }

        // Kỳ 02/2026
        for ($i = 0; $i < 30; $i++) {
            $apt = $i + 1;
            $techId = ($i % 2 === 0) ? 5 : 7;
            $day = sprintf('%02d', ($i % 26) + 1);
            $eCons = $elecCurr[$i] - $elecPrev[$i];
            $wCons = $waterCurr[$i] - $waterPrev[$i];

            $readings[] = [
                'MeterReadingId' => $readingId++,
                'ApartmentId' => $apt,
                'FeeTypeId' => 1,
                'RecordedByUserId' => $techId,
                'BillingPeriod' => '02/2026',
                'PreviousReading' => $elecPrev[$i],
                'CurrentReading' => $elecCurr[$i],
                'Consumption' => $eCons,
                'RecordedAt' => "2026-02-$day 09:00:00",
            ];
            $readings[] = [
                'MeterReadingId' => $readingId++,
                'ApartmentId' => $apt,
                'FeeTypeId' => 2,
                'RecordedByUserId' => $techId,
                'BillingPeriod' => '02/2026',
                'PreviousReading' => $waterPrev[$i],
                'CurrentReading' => $waterCurr[$i],
                'Consumption' => $wCons,
                'RecordedAt' => "2026-02-$day 09:10:00",
            ];
        }
        MeterReading::insert($readings);

        // ==========================================
        // 9. HÓA ĐƠN & CHI TIẾT (Invoice & InvoiceItem)
        // ==========================================
        Invoice::truncate();
        $invoices = [];
        $amounts1 = [842500, 860000, 877500, 895000, 912500, 930000, 947500, 825000, 842500, 860000, 877500, 895000, 912500, 930000, 947500, 825000, 842500, 860000, 877500, 895000];
        $status1 = ['UNPAID', 'UNPAID', 'OVERDUE', 'PAID', 'UNPAID', 'OVERDUE', 'UNPAID', 'PAID', 'OVERDUE', 'CANCELLED', 'UNPAID', 'PAID', 'UNPAID', 'UNPAID', 'OVERDUE', 'PAID', 'UNPAID', 'OVERDUE', 'UNPAID', 'CANCELLED'];
        $payType1 = [null, null, null, 'OFFLINE', null, null, null, 'ONLINE_MOCK', null, null, null, 'OFFLINE', null, null, null, 'ONLINE_MOCK', null, null, null, null];
        $paidAt1 = [null, null, null, '2026-02-04 10:30:00', null, null, null, '2026-02-08 10:30:00', null, null, null, '2026-02-12 10:30:00', null, null, null, '2026-02-16 10:30:00', null, null, null, null];

        // Kỳ 01/2026 (Hóa đơn 1..20)
        for ($i = 0; $i < 20; $i++) {
            $invoices[] = [
                'InvoiceId' => $i + 1,
                'ApartmentId' => $i + 1,
                'BillingPeriod' => '01/2026',
                'TotalAmount' => $amounts1[$i],
                'DueDate' => '2026-02-10',
                'Status' => $status1[$i],
                'PaymentType' => $payType1[$i],
                'PaidAt' => $paidAt1[$i],
                'CreatedByUserId' => 1,
                'CreatedAt' => '2026-01-02 08:00:00',
                'UpdatedAt' => null,
            ];
        }

        // Kỳ 02/2026 (Hóa đơn 21..40)
        $status2 = ['UNPAID', 'UNPAID', 'UNPAID', 'PAID', 'UNPAID', 'UNPAID', 'UNPAID', 'PAID', 'UNPAID', 'CANCELLED', 'UNPAID', 'PAID', 'UNPAID', 'UNPAID', 'UNPAID', 'PAID', 'UNPAID', 'UNPAID', 'UNPAID', 'CANCELLED'];
        $payType2 = [null, null, null, 'OFFLINE', null, null, null, 'ONLINE_MOCK', null, null, null, 'OFFLINE', null, null, null, 'ONLINE_MOCK', null, null, null, null];
        $paidAt2 = [null, null, null, '2026-03-04 10:30:00', null, null, null, '2026-03-08 10:30:00', null, null, null, '2026-03-12 10:30:00', null, null, null, '2026-03-16 10:30:00', null, null, null, null];

        for ($i = 0; $i < 20; $i++) {
            $invoices[] = [
                'InvoiceId' => 20 + $i + 1,
                'ApartmentId' => $i + 1,
                'BillingPeriod' => '02/2026',
                'TotalAmount' => $amounts1[$i],
                'DueDate' => '2026-03-10',
                'Status' => $status2[$i],
                'PaymentType' => $payType2[$i],
                'PaidAt' => $paidAt2[$i],
                'CreatedByUserId' => 1,
                'CreatedAt' => '2026-02-02 08:00:00',
                'UpdatedAt' => null,
            ];
        }
        Invoice::insert($invoices);

        InvoiceItem::truncate();
        $invoiceItems = [];
        $itemId = 1;
        $elecQty = [35, 40, 45, 50, 55, 60, 65, 30, 35, 40, 45, 50, 55, 60, 65, 30, 35, 40, 45, 50];

        for ($inv = 1; $inv <= 40; $inv++) {
            $q = $elecQty[($inv - 1) % 20];
            $invoiceItems[] = [
                'InvoiceItemId' => $itemId++,
                'InvoiceId' => $inv,
                'FeeTypeId' => 1,
                'FeeRateId' => 1,
                'Quantity' => $q,
                'UnitPrice' => 3500.00,
                'Amount' => $q * 3500.00,
            ];
            $invoiceItems[] = [
                'InvoiceItemId' => $itemId++,
                'InvoiceId' => $inv,
                'FeeTypeId' => 3,
                'FeeRateId' => 3,
                'Quantity' => 60.00,
                'UnitPrice' => 12000.00,
                'Amount' => 720000.00,
            ];
        }
        InvoiceItem::insert($invoiceItems);

        // ==========================================
        // 10. PHIẾU YÊU CẦU HỖ TRỢ (Ticket) - 100 Phiếu Thực Tế
        // ==========================================
        Ticket::truncate();
        $tickets = [];

        $subjectMap = [
            'ACCOUNT' => [
                'Không xem được thông báo phí trên ứng dụng',
                'Quên mật khẩu cổng cư dân xin hỗ trợ reset',
                'Cập nhật số điện thoại nhận thông báo biến động phí',
                'Yêu cầu cấp lại mã QR thanh toán cá nhân',
                'Đăng nhập báo tài khoản đang bị khóa cần kiểm tra',
            ],
            'VEHICLE' => [
                'Đăng ký thẻ xe máy mới cho người nhà',
                'Báo mất thẻ từ gửi xe máy xin cấp lại thẻ mới',
                'Đăng ký vị trí đỗ ô tô cố định tầng hầm B1',
                'Biển số xe trên hệ thống hiển thị sai 1 ký tự',
                'Xe lạ đỗ chắn lối ra vào khu vực gửi xe',
            ],
            'TECHNICAL' => [
                'Đèn hành lang tầng 1 không sáng',
                'Vòi nước khu vực bếp bị rò rỉ rỉ nước liên tục',
                'Áp lực nước sinh hoạt yếu vào khung giờ cao điểm',
                'Cửa kính ban công bị kẹt khó đóng mở',
                'Thang máy số 2 phát ra tiếng kêu lạ ở tầng 4',
                'Aptomat tổng bị nhảy khi bật bình nóng lạnh',
            ],
            'BILLING' => [
                'Đối chiếu tiền điện kỳ 02/2026',
                'Thắc mắc khoản phí dịch vụ quản lý căn hộ tháng trước',
                'Đã chuyển khoản ngân hàng nhưng hóa đơn chưa cập nhật',
                'Yêu cầu xuất hóa đơn VAT điện tử cho công ty',
                'Chỉ số nước chênh lệch nhiều so với thực tế sử dụng',
            ],
            'COMPLAINT' => [
                'Phản ánh tiếng ồn sau 22 giờ từ căn hộ tầng trên',
                'Hành lang có rác sinh hoạt để ngoài cửa gây mất vệ sinh',
                'Khói thuốc lá bay qua khe cửa ảnh hưởng trẻ nhỏ',
                'Nuôi thú cưng không rọ mõm ở khu vực thang máy',
                'Nhà hàng xóm khoan đục tường trong giờ nghỉ trưa',
            ],
            'OTHER' => [
                'Đăng ký mượn sảnh sinh hoạt cộng đồng để họp nhóm',
                'Xin cấp phép thi công sửa chữa nội thất căn hộ',
                'Nhờ bảo vệ nhận bưu phẩm bưu kiện kích thước lớn',
                'Hỏi lịch phun thuốc diệt muỗi định kỳ toàn tòa nhà',
                'Ý kiến đóng góp cải tạo khu vui chơi trẻ em ngoài trời',
            ],
        ];

        $categories = ['ACCOUNT', 'VEHICLE', 'TECHNICAL', 'BILLING', 'COMPLAINT', 'OTHER'];
        $statuses = ['WAITING', 'ASSIGNED', 'PROCESSING', 'RESOLVED', 'CLOSED', 'CANCELLED'];

        for ($i = 1; $i <= 100; $i++) {
            $userNum = 10 + (($i - 1) % 30);
            $aptId = (($i - 1) % 30) + 1;
            if (in_array($i, [13, 26, 39, 52, 65, 78, 91])) {
                $aptId = null;
            }

            // Ticket 1 và Ticket 3 phải giữ nguyên theo Feature Test
            if ($i === 1) {
                $cat = 'ACCOUNT';
                $st = 'WAITING';
                $subject = 'Không xem được thông báo phí';
                $desc = 'Tôi đăng nhập cổng cư dân nhưng không thấy bảng thông báo phí tháng này hiển thị, nhờ BQL kiểm tra giúp.';
            } elseif ($i === 3) {
                $cat = 'TECHNICAL';
                $st = 'PROCESSING';
                $subject = 'Đèn hành lang tầng 1 không sáng';
                $desc = 'Bóng đèn chiếu sáng hành lang trước cửa căn hộ 0103 bị chập chờn rồi tắt ngóm, hành lang rất tối.';
            } elseif ($i === 2) {
                $cat = 'BILLING';
                $st = 'ASSIGNED';
                $subject = 'Đối chiếu tiền điện kỳ 02/2026';
                $desc = 'Nhờ ban quản lý gửi bảng chi tiết đo chỉ số công tơ điện kỳ 02/2026 để đối chiếu lại.';
            } else {
                $cat = $categories[($i - 1) % 6];
                $st = $statuses[($i - 1) % 6];
                $list = $subjectMap[$cat];
                $subject = $list[($i - 1) % count($list)]." (#$i)";
                $desc = "Cư dân gửi yêu cầu phản ánh #$i liên quan đến $cat. Đề nghị bộ phận chuyên trách kiểm tra hiện trường và phản hồi sớm.";
            }

            $day = sprintf('%02d', (($i - 1) % 27) + 1);
            $createdAt = "2026-02-$day 08:30:00";
            $resolvedAt = ($st === 'RESOLVED' || $st === 'CLOSED') ? "2026-02-$day 16:30:00" : null;

            $tickets[] = [
                'TicketId' => $i,
                'CreatedByUserId' => $userNum,
                'ApartmentId' => $aptId,
                'Subject' => $subject,
                'Description' => $desc,
                'Status' => $st,
                'Category' => $cat,
                'CreatedAt' => $createdAt,
                'UpdatedAt' => null,
                'ResolvedAt' => $resolvedAt,
                'IsDeleted' => false,
                'DeletedAt' => null,
            ];
        }
        Ticket::insert($tickets);

        // ==========================================
        // 11. PHÂN CÔNG XỬ LÝ (TicketAssignment)
        // ==========================================
        TicketAssignment::truncate();
        $assignments = [];
        $assignId = 1;

        for ($i = 1; $i <= 100; $i++) {
            $mod = ($i - 1) % 6;
            // Ticket 3 gán cho tech03 (UserId 7) theo Test
            if ($i === 3) {
                $assignments[] = [
                    'TicketAssignmentId' => $assignId++,
                    'TicketId' => 3,
                    'AssignedToUserId' => 7, // tech03
                    'AssignedAt' => '2026-02-03 09:15:00',
                ];

                continue;
            }

            // Các ticket khác có trạng thái ASSIGNED, PROCESSING, RESOLVED, CLOSED
            if ($mod >= 1 && $mod <= 4) {
                // Phân bổ nhân sự kỹ thuật (5, 6, 7) và hỗ trợ (2, 3, 4)
                $assignee = match ($mod) {
                    1 => 6, // tech02
                    2 => 7, // tech03
                    3 => 2, // support01
                    4 => 3, // support02
                    default => 5,
                };
                $day = sprintf('%02d', (($i - 1) % 27) + 1);
                $assignments[] = [
                    'TicketAssignmentId' => $assignId++,
                    'TicketId' => $i,
                    'AssignedToUserId' => $assignee,
                    'AssignedAt' => "2026-02-$day 09:30:00",
                ];
            }
        }
        TicketAssignment::insert($assignments);

        // ==========================================
        // 12. PHẢN HỒI YÊU CẦU (TicketResponse)
        // ==========================================
        TicketResponse::truncate();
        $responses = [];
        $respId = 1;

        for ($i = 1; $i <= 100; $i++) {
            if ($i % 2 === 0 || $i === 3) {
                $respUser = ($i % 3 === 0) ? 5 : (($i % 3 === 1) ? 2 : 7);
                $day = sprintf('%02d', (($i - 1) % 27) + 1);

                $responses[] = [
                    'TicketResponseId' => $respId++,
                    'TicketId' => $i,
                    'RespondedByUserId' => $respUser,
                    'Content' => ($i === 3)
                        ? 'Kỹ thuật viên đã kiểm tra hiện trường, xác nhận hỏng tăng phô đèn led. Đang tiến hành thay bóng mới.'
                        : "Ban quản lý đã tiếp nhận thông tin yêu cầu #$i và đang phối hợp xử lý theo quy trình.",
                    'CreatedAt' => "2026-02-$day 10:15:00",
                ];
            }
        }
        TicketResponse::insert($responses);

        // ==========================================
        // 13. FILE ĐÍNH KÈM (TicketAttachment)
        // ==========================================
        TicketAttachment::truncate();
        $attachments = [];
        for ($k = 1; $k <= 10; $k++) {
            $tId = $k * 10;
            $uId = 10 + (($k - 1) % 15);
            $attachments[] = [
                'TicketAttachmentId' => $k,
                'TicketId' => $tId,
                'FileName' => "minh-chung-$tId.jpg",
                'FilePath' => "/demo/tickets/$tId/minh-chung-$tId.jpg",
                'ContentType' => 'image/jpeg',
                'FileSize' => 125000 + ($k * 1024),
                'UploadedByUserId' => $uId,
                'UploadedAt' => now(),
                'IsDeleted' => false,
                'DeletedAt' => null,
            ];
        }
        TicketAttachment::insert($attachments);

        // ==========================================
        // 14. BẢNG TIN & THÔNG BÁO (Notification & Targets)
        // ==========================================
        Notification::truncate();
        $notifications = [
            [
                'NotificationId' => 1,
                'CreatedByUserId' => 1,
                'Title' => 'Thông báo lịch bảo trì thang máy',
                'Content' => 'Ban quản lý xin thông báo lịch bảo trì kỹ thuật định kỳ hệ thống thang máy Tòa A vào Chủ nhật, từ 08:00 đến 11:30. Quý cư dân vui lòng sử dụng thang máy phụ hoặc thang bộ trong thời gian trên.',
                'TargetType' => 'BUILDING',
                'CreatedAt' => '2026-02-01 08:00:00',
                'IsDeleted' => false,
                'DeletedAt' => null,
            ],
            [
                'NotificationId' => 2,
                'CreatedByUserId' => 1,
                'Title' => 'Nhắc thanh toán phí tháng 02/2026',
                'Content' => 'Kính gửi Quý cư dân, thông báo phí dịch vụ, tiền điện nước sinh hoạt kỳ tháng 02/2026 đã được phát hành. Kính đề nghị Quý cư dân hoàn tất thanh toán trước ngày 10/03/2026 để tránh gián đoạn dịch vụ.',
                'TargetType' => 'ALL',
                'CreatedAt' => '2026-03-01 08:00:00',
                'IsDeleted' => false,
                'DeletedAt' => null,
            ],
            [
                'NotificationId' => 3,
                'CreatedByUserId' => 2,
                'Title' => 'Cập nhật xử lý yêu cầu kỹ thuật tầng 2',
                'Content' => 'Đội kỹ thuật tòa nhà đang thực hiện kiểm tra áp lực nước và bảo dưỡng hộp gen kỹ thuật tại Tầng 2.',
                'TargetType' => 'FLOOR',
                'CreatedAt' => '2026-02-15 14:00:00',
                'IsDeleted' => false,
                'DeletedAt' => null,
            ],
            [
                'NotificationId' => 4,
                'CreatedByUserId' => 1,
                'Title' => 'Thông báo riêng căn hộ 0101',
                'Content' => 'Vui lòng liên hệ ban quản lý để xác nhận thông tin cư trú.',
                'TargetType' => 'APARTMENT',
                'CreatedAt' => '2026-02-20 09:00:00',
                'IsDeleted' => false,
                'DeletedAt' => null,
            ],
            [
                'NotificationId' => 5,
                'CreatedByUserId' => 1,
                'Title' => 'Kế hoạch diễn tập phương án Phòng cháy chữa cháy & Cứu hộ cứu nạn 2026',
                'Content' => 'Nhằm nâng cao kỹ năng thoát hiểm và an toàn PCCC cho toàn thể cư dân, Ban quản lý phối hợp cùng Công an PCCC quận tổ chức buổi diễn tập thực tế vào sáng thứ 7 tuần này. Kính mời toàn thể cư dân tham gia đông đủ.',
                'TargetType' => 'ALL',
                'CreatedAt' => '2026-02-25 10:00:00',
                'IsDeleted' => false,
                'DeletedAt' => null,
            ],
            [
                'NotificationId' => 6,
                'CreatedByUserId' => 1,
                'Title' => 'Kế hoạch súc xả bể nước sinh hoạt ngầm toàn khu',
                'Content' => 'Thông báo kế hoạch thau rửa bể nước ngầm định kỳ nhằm đảm bảo chất lượng nước sinh hoạt tốt nhất. Thời gian thực hiện: Từ 22h00 đêm thứ 6 đến 05h00 sáng thứ 7. Nước sinh hoạt sẽ tạm ngắt trong thời gian này.',
                'TargetType' => 'BUILDING',
                'CreatedAt' => '2026-02-28 15:00:00',
                'IsDeleted' => false,
                'DeletedAt' => null,
            ],
        ];
        Notification::insert($notifications);

        NotificationTarget::truncate();
        $notifTargets = [
            ['NotificationTargetId' => 1, 'NotificationId' => 1, 'BuildingId' => 1, 'FloorId' => null, 'ApartmentId' => null, 'IsDeleted' => false, 'DeletedAt' => null],
            ['NotificationTargetId' => 2, 'NotificationId' => 2, 'BuildingId' => 1, 'FloorId' => null, 'ApartmentId' => null, 'IsDeleted' => false, 'DeletedAt' => null],
            ['NotificationTargetId' => 3, 'NotificationId' => 3, 'BuildingId' => null, 'FloorId' => 2, 'ApartmentId' => null, 'IsDeleted' => false, 'DeletedAt' => null],
            ['NotificationTargetId' => 4, 'NotificationId' => 4, 'BuildingId' => null, 'FloorId' => null, 'ApartmentId' => 1, 'IsDeleted' => false, 'DeletedAt' => null],
            ['NotificationTargetId' => 5, 'NotificationId' => 5, 'BuildingId' => 1, 'FloorId' => null, 'ApartmentId' => null, 'IsDeleted' => false, 'DeletedAt' => null],
            ['NotificationTargetId' => 6, 'NotificationId' => 6, 'BuildingId' => 1, 'FloorId' => null, 'ApartmentId' => null, 'IsDeleted' => false, 'DeletedAt' => null],
        ];
        NotificationTarget::insert($notifTargets);

        // Người nhận thông báo
        NotificationRecipient::truncate();
        $recipients = [];
        $recipId = 1;

        // Notification 1, 2, 5, 6 gửi cho các cư dân
        for ($u = 10; $u <= 40; $u++) {
            $recipients[] = [
                'NotificationRecipientId' => $recipId++,
                'NotificationId' => 1,
                'UserId' => $u,
                'IsRead' => ($u % 3 === 0),
                'IsDeleted' => false,
                'DeletedAt' => null,
            ];
            $recipients[] = [
                'NotificationRecipientId' => $recipId++,
                'NotificationId' => 2,
                'UserId' => $u,
                'IsRead' => ($u % 2 === 0),
                'IsDeleted' => false,
                'DeletedAt' => null,
            ];
            $recipients[] = [
                'NotificationRecipientId' => $recipId++,
                'NotificationId' => 5,
                'UserId' => $u,
                'IsRead' => ($u % 4 === 0),
                'IsDeleted' => false,
                'DeletedAt' => null,
            ];
        }

        // Notification 3 cho tầng 2 (UserId 18..25)
        for ($u = 18; $u <= 25; $u++) {
            $recipients[] = [
                'NotificationRecipientId' => $recipId++,
                'NotificationId' => 3,
                'UserId' => $u,
                'IsRead' => ($u % 2 === 0),
                'IsDeleted' => false,
                'DeletedAt' => null,
            ];
        }

        // Notification 4 cho riêng căn hộ 0101 (UserId 10)
        $recipients[] = [
            'NotificationRecipientId' => $recipId++,
            'NotificationId' => 4,
            'UserId' => 10,
            'IsRead' => false,
            'IsDeleted' => false,
            'DeletedAt' => null,
        ];

        NotificationRecipient::insert($recipients);

        // Bật lại kiểm tra khóa ngoại sau khi hoàn tất
        Schema::enableForeignKeyConstraints();
    }
}
