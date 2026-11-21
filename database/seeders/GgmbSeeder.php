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
        // Disable foreign keys during seeding
        Schema::disableForeignKeyConstraints();

        // 1. Building
        Building::truncate();
        Building::create([
            'BuildingId' => 1,
            'BuildingName' => 'GGMB Residence - Toa A',
        ]);

        // 2. Floor
        Floor::truncate();
        $floors = [
            ['FloorId' => 1, 'BuildingId' => 1, 'FloorNumber' => 1],
            ['FloorId' => 2, 'BuildingId' => 1, 'FloorNumber' => 2],
            ['FloorId' => 3, 'BuildingId' => 1, 'FloorNumber' => 3],
            ['FloorId' => 4, 'BuildingId' => 1, 'FloorNumber' => 4],
            ['FloorId' => 5, 'BuildingId' => 1, 'FloorNumber' => 5],
        ];
        Floor::insert($floors);

        // 3. Apartment (40 apartments)
        Apartment::truncate();
        $apartments = [];
        for ($f = 1; $f <= 5; $f++) {
            for ($num = 1; $num <= 8; $num++) {
                $id = ($f - 1) * 8 + $num;
                $aptNum = sprintf('%02d%02d', $f, $num);

                $status = 'OCCUPIED';
                if ($id == 31 || $id == 32 || ($id >= 33 && $id <= 38)) {
                    $status = 'AVAILABLE';
                } elseif ($id == 39 || $id == 40) {
                    $status = 'INACTIVE';
                }

                $apartments[] = [
                    'ApartmentId' => $id,
                    'FloorId' => $f,
                    'ApartmentNumber' => $aptNum,
                    'Status' => $status,
                    'Description' => "Căn hộ tầng $f, số ".sprintf('%02d', $num),
                    'IsDeleted' => false,
                    'CreatedAt' => now(),
                ];
            }
        }
        Apartment::insert($apartments);

        // 4. User (39 users)
        User::truncate();
        $defaultPassword = Hash::make('password123'); // Standardized for login

        $users = [
            ['UserId' => 1, 'UserName' => 'manager01', 'FullName' => 'Nguyễn Minh Quản lý', 'Phone' => '0900000001', 'Email' => 'manager01@ggmb.example', 'CitizenId' => '079000000001', 'Role' => 'MANAGER', 'Department' => 'Ban quản lý', 'Status' => 'ACTIVE'],
            ['UserId' => 2, 'UserName' => 'support01', 'FullName' => 'Trần Thu Hỗ trợ', 'Phone' => '0900000002', 'Email' => 'support01@ggmb.example', 'CitizenId' => '079000000002', 'Role' => 'SUPPORT', 'Department' => 'Chăm sóc cư dân', 'Status' => 'ACTIVE'],
            ['UserId' => 3, 'UserName' => 'support02', 'FullName' => 'Lê Anh Hỗ trợ', 'Phone' => '0900000003', 'Email' => 'support02@ggmb.example', 'CitizenId' => '079000000003', 'Role' => 'SUPPORT', 'Department' => 'Chăm sóc cư dân', 'Status' => 'ACTIVE'],
            ['UserId' => 4, 'UserName' => 'support03', 'FullName' => 'Phạm Hà Hỗ trợ', 'Phone' => '0900000004', 'Email' => 'support03@ggmb.example', 'CitizenId' => '079000000004', 'Role' => 'SUPPORT', 'Department' => 'Chăm sóc cư dân', 'Status' => 'ACTIVE'],
            ['UserId' => 5, 'UserName' => 'tech01', 'FullName' => 'Nguyễn Văn Kỹ thuật', 'Phone' => '0900000005', 'Email' => 'tech01@ggmb.example', 'CitizenId' => '079000000005', 'Role' => 'TECHNICIAN', 'Department' => 'Kỹ thuật', 'Status' => 'ACTIVE'],
            ['UserId' => 6, 'UserName' => 'tech02', 'FullName' => 'Đỗ Quốc Kỹ thuật', 'Phone' => '0900000006', 'Email' => 'tech02@ggmb.example', 'CitizenId' => '079000000006', 'Role' => 'TECHNICIAN', 'Department' => 'Kỹ thuật', 'Status' => 'ACTIVE'],
            ['UserId' => 7, 'UserName' => 'tech03', 'FullName' => 'Vũ Hoàng Kỹ thuật', 'Phone' => '0900000007', 'Email' => 'tech03@ggmb.example', 'CitizenId' => '079000000007', 'Role' => 'TECHNICIAN', 'Department' => 'Kỹ thuật', 'Status' => 'ACTIVE'],
            ['UserId' => 8, 'UserName' => 'security01', 'FullName' => 'Bùi Đức Bảo vệ', 'Phone' => '0900000008', 'Email' => 'security01@ggmb.example', 'CitizenId' => '079000000008', 'Role' => 'SECURITY', 'Department' => 'An ninh', 'Status' => 'ACTIVE'],
            ['UserId' => 9, 'UserName' => 'security02', 'FullName' => 'Phan Nam Bảo vệ', 'Phone' => '0900000009', 'Email' => 'security02@ggmb.example', 'CitizenId' => '079000000009', 'Role' => 'SECURITY', 'Department' => 'An ninh', 'Status' => 'ACTIVE'],
        ];

        $residentNames = [
            'Nguyễn An', 'Trần Bình', 'Lê Chi', 'Phạm Dũng', 'Hoàng Giang', 'Vũ Hà', 'Đặng Huy', 'Bùi Lan', 'Đỗ Minh', 'Phan Nam',
            'Nguyễn Oanh', 'Trần Phúc', 'Lê Quân', 'Phạm Trang', 'Hoàng Tú', 'Vũ An', 'Đặng Bình', 'Bùi Chi', 'Đỗ Dũng', 'Phan Giang',
            'Nguyễn Hà', 'Trần Huy', 'Lê Lan', 'Phạm Minh', 'Hoàng Nam', 'Vũ Oanh', 'Đặng Phúc', 'Bùi Quân', 'Đỗ Trang', 'Phan Tú',
        ];

        for ($i = 0; $i < 30; $i++) {
            $num = $i + 1;
            $status = ($num === 30) ? 'INACTIVE' : 'ACTIVE';
            $users[] = [
                'UserId' => 10 + $i,
                'UserName' => sprintf('resident%02d', $num),
                'FullName' => $residentNames[$i],
                'Phone' => sprintf('09100000%02d', $num),
                'Email' => sprintf('resident%02d@ggmb.example', $num),
                'CitizenId' => sprintf('079000000%02d', $num),
                'Role' => 'RESIDENT',
                'Department' => null,
                'Status' => $status,
            ];
        }

        foreach ($users as &$u) {
            $u['PasswordHash'] = $defaultPassword;
            $u['IsDeleted'] = false;
            $u['CreatedAt'] = now();
        }
        User::insert($users);

        // 5. ApartmentResident (30 rows)
        ApartmentResident::truncate();
        $residents = [];
        for ($i = 1; $i <= 30; $i++) {
            $residents[] = [
                'ApartmentResidentId' => $i,
                'ApartmentId' => $i,
                'UserId' => 9 + $i,
                'StartDate' => '2024-01-01',
                'EndDate' => null,
                'Status' => 'ACTIVE',
                'IsDeleted' => false,
                'CreatedAt' => now(),
            ];
        }
        ApartmentResident::insert($residents);

        // 6. Vehicle (25 rows)
        Vehicle::truncate();
        $carApts = [4, 8, 12, 16, 20, 24];
        $vehicles = [];
        for ($i = 1; $i <= 25; $i++) {
            $type = in_array($i, $carApts) ? 'CAR' : 'MOTORBIKE';
            $vehicles[] = [
                'VehicleId' => $i,
                'ApartmentId' => $i,
                'LicensePlate' => sprintf('29A-%05d', 10000 + $i),
                'VehicleType' => $type,
                'IsDeleted' => false,
                'CreatedAt' => now(),
            ];
        }
        Vehicle::insert($vehicles);

        // 7. FeeType (5 rows)
        FeeType::truncate();
        $feeTypes = [
            ['FeeTypeId' => 1, 'Code' => 'ELECTRIC', 'Name' => 'Điện', 'Description' => 'Điện năng tiêu thụ', 'IsActive' => true],
            ['FeeTypeId' => 2, 'Code' => 'WATER', 'Name' => 'Nước', 'Description' => 'Nước sinh hoạt', 'IsActive' => true],
            ['FeeTypeId' => 3, 'Code' => 'MANAGEMENT', 'Name' => 'Phí quản lý', 'Description' => 'Phí quản lý căn hộ theo tháng', 'IsActive' => true],
            ['FeeTypeId' => 4, 'Code' => 'PARKING', 'Name' => 'Gửi xe', 'Description' => 'Phí gửi xe theo tháng', 'IsActive' => true],
            ['FeeTypeId' => 5, 'Code' => 'INTERNET', 'Name' => 'Internet', 'Description' => 'Dịch vụ Internet', 'IsActive' => true],
        ];
        FeeType::insert($feeTypes);

        // 8. FeeRate (5 rows)
        FeeRate::truncate();
        $feeRates = [
            ['FeeRateId' => 1, 'FeeTypeId' => 1, 'UnitPrice' => 3500.00, 'EffectiveFrom' => '2025-01-01', 'EffectiveTo' => null, 'CreatedAt' => now()],
            ['FeeRateId' => 2, 'FeeTypeId' => 2, 'UnitPrice' => 18000.00, 'EffectiveFrom' => '2025-01-01', 'EffectiveTo' => null, 'CreatedAt' => now()],
            ['FeeRateId' => 3, 'FeeTypeId' => 3, 'UnitPrice' => 12000.00, 'EffectiveFrom' => '2025-01-01', 'EffectiveTo' => null, 'CreatedAt' => now()],
            ['FeeRateId' => 4, 'FeeTypeId' => 4, 'UnitPrice' => 100000.00, 'EffectiveFrom' => '2025-01-01', 'EffectiveTo' => null, 'CreatedAt' => now()],
            ['FeeRateId' => 5, 'FeeTypeId' => 5, 'UnitPrice' => 200000.00, 'EffectiveFrom' => '2025-01-01', 'EffectiveTo' => null, 'CreatedAt' => now()],
        ];
        FeeRate::insert($feeRates);

        // 9. MeterReading (60 rows)
        MeterReading::truncate();
        $readings = [];
        $readingId = 1;
        // Electricity (1) & Water (2) for 30 apartments
        $elecPrev = [103, 106, 109, 112, 115, 118, 121, 124, 127, 130, 133, 136, 139, 142, 145, 148, 151, 154, 157, 160, 163, 166, 169, 172, 175, 178, 181, 184, 187, 190];
        $elecCurr = [142, 149, 156, 163, 170, 177, 184, 159, 166, 173, 180, 187, 194, 201, 208, 183, 190, 197, 204, 211, 218, 225, 232, 207, 214, 221, 228, 235, 242, 249];
        $elecCons = [39, 43, 47, 51, 55, 59, 63, 35, 39, 43, 47, 51, 55, 59, 63, 35, 39, 43, 47, 51, 55, 59, 63, 35, 39, 43, 47, 51, 55, 59];

        $waterPrev = [41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70];
        $waterCurr = [48, 51, 54, 57, 60, 51, 54, 57, 60, 63, 66, 57, 60, 63, 66, 69, 72, 63, 66, 69, 72, 75, 78, 69, 72, 75, 78, 81, 84, 75];
        $waterCons = [7, 9, 11, 13, 15, 5, 7, 9, 11, 13, 15, 5, 7, 9, 11, 13, 15, 5, 7, 9, 11, 13, 15, 5, 7, 9, 11, 13, 15, 5];

        for ($i = 0; $i < 30; $i++) {
            $aptId = $i + 1;
            $day = sprintf('%02d', ($i % 28) + 1);
            $recTime = "2026-03-$day 09:00:00";

            $readings[] = [
                'MeterReadingId' => $readingId++,
                'ApartmentId' => $aptId,
                'FeeTypeId' => 1,
                'RecordedByUserId' => 5,
                'BillingPeriod' => '02/2026',
                'PreviousReading' => $elecPrev[$i],
                'CurrentReading' => $elecCurr[$i],
                'Consumption' => $elecCons[$i],
                'RecordedAt' => $recTime,
            ];
            $readings[] = [
                'MeterReadingId' => $readingId++,
                'ApartmentId' => $aptId,
                'FeeTypeId' => 2,
                'RecordedByUserId' => 5,
                'BillingPeriod' => '02/2026',
                'PreviousReading' => $waterPrev[$i],
                'CurrentReading' => $waterCurr[$i],
                'Consumption' => $waterCons[$i],
                'RecordedAt' => $recTime,
            ];
        }
        MeterReading::insert($readings);

        // 10. Invoice (40 rows)
        Invoice::truncate();
        $invoices = [];
        $amounts1 = [842500, 860000, 877500, 895000, 912500, 930000, 947500, 825000, 842500, 860000, 877500, 895000, 912500, 930000, 947500, 825000, 842500, 860000, 877500, 895000];
        $status1 = ['UNPAID', 'UNPAID', 'OVERDUE', 'PAID', 'UNPAID', 'OVERDUE', 'UNPAID', 'PAID', 'OVERDUE', 'CANCELLED', 'UNPAID', 'PAID', 'UNPAID', 'UNPAID', 'OVERDUE', 'PAID', 'UNPAID', 'OVERDUE', 'UNPAID', 'CANCELLED'];
        $payType1 = [null, null, null, 'OFFLINE', null, null, null, 'ONLINE_MOCK', null, null, null, 'OFFLINE', null, null, null, 'ONLINE_MOCK', null, null, null, null];
        $paidAt1 = [null, null, null, '2026-02-04 10:30:00', null, null, null, '2026-02-08 10:30:00', null, null, null, '2026-02-12 10:30:00', null, null, null, '2026-02-16 10:30:00', null, null, null, null];

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
                'CreatedAt' => '2026-01-02 08:00:00',
                'UpdatedAt' => null,
            ];
        }
        Invoice::insert($invoices);

        // 11. InvoiceItem (80 rows)
        InvoiceItem::truncate();
        $invoiceItems = [];
        $itemId = 1;
        $elecQty = [35, 40, 45, 50, 55, 60, 65, 30, 35, 40, 45, 50, 55, 60, 65, 30, 35, 40, 45, 50];
        // 40 invoices, each has 2 items: 1 Electricity (FeeType 1, FeeRate 1) and 1 Management (FeeType 3, FeeRate 3)
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

        // 12. Ticket (100 rows)
        Ticket::truncate();
        $tickets = [];
        $categories = ['ACCOUNT', 'VEHICLE', 'TECHNICAL', 'BILLING', 'COMPLAINT', 'OTHER'];
        $statuses = ['OPEN', 'ASSIGNED', 'IN_PROGRESS', 'RESOLVED', 'CLOSED', 'REJECTED'];

        for ($i = 1; $i <= 100; $i++) {
            $userNum = 10 + (($i - 1) % 30);
            $aptId = (($i - 1) % 30) + 1;
            // Null apartment for some requests
            if (in_array($i, [13, 26, 39, 52, 65, 78, 91])) {
                $aptId = null;
            }

            $cat = $categories[($i - 1) % 6];
            $st = $statuses[($i - 1) % 6];

            $day = sprintf('%02d', (($i - 1) % 27) + 1);
            $createdAt = "2026-02-$day 08:30:00";
            $resolvedAt = ($st === 'RESOLVED' || $st === 'CLOSED') ? "2026-02-$day 16:00:00" : null;

            $subjectMap = [
                'ACCOUNT' => "Không đăng nhập được ứng dụng #$i",
                'VEHICLE' => "Đăng ký xe máy mới #$i",
                'TECHNICAL' => "Đèn hành lang bị hỏng #$i",
                'BILLING' => "Kiểm tra hóa đơn tháng #$i",
                'COMPLAINT' => "Phản ánh tiếng ồn #$i",
                'OTHER' => "Yêu cầu cập nhật thông tin #$i",
            ];

            $tickets[] = [
                'TicketId' => $i,
                'CreatedByUserId' => $userNum,
                'ApartmentId' => $aptId,
                'Subject' => $subjectMap[$cat],
                'Description' => "Cư dân gửi yêu cầu số $i. Vui lòng kiểm tra và phản hồi theo quy trình.",
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

        // 13. TicketAssignment (67 rows)
        TicketAssignment::truncate();
        $assignments = [];
        $assignId = 1;
        // Non-OPEN/REJECTED tickets get assignments
        for ($i = 1; $i <= 100; $i++) {
            $mod = ($i - 1) % 6;
            // mod 1 (ASSIGNED) -> tech 6
            // mod 2 (IN_PROGRESS) -> tech 7
            // mod 3 (RESOLVED) -> support 2
            // mod 4 (CLOSED) -> support 3
            if ($mod >= 1 && $mod <= 4) {
                $techMap = [1 => 6, 2 => 7, 3 => 2, 4 => 3];
                $day = sprintf('%02d', (($i - 1) % 27) + 1);
                $assignments[] = [
                    'TicketAssignmentId' => $assignId++,
                    'TicketId' => $i,
                    'AssignedToUserId' => $techMap[$mod],
                    'AssignedAt' => "2026-02-$day 09:00:00",
                ];
            }
        }
        TicketAssignment::insert($assignments);

        // 14. TicketResponse (50 rows)
        TicketResponse::truncate();
        $responses = [];
        $respId = 1;
        for ($i = 1; $i <= 100; $i++) {
            if ($i % 2 === 0 && $respId <= 50) {
                $mod = ($i - 1) % 6;
                $userMap = [1 => 3, 3 => 2, 5 => 4];
                $respUser = $userMap[$mod] ?? 2;
                $day = sprintf('%02d', (($i - 1) % 27) + 1);

                $responses[] = [
                    'TicketResponseId' => $respId++,
                    'TicketId' => $i,
                    'RespondedByUserId' => $respUser,
                    'Content' => "Đã tiếp nhận yêu cầu #$i; đang cập nhật tiến độ xử lý.",
                    'CreatedAt' => "2026-02-$day 10:00:00",
                ];
            }
        }
        TicketResponse::insert($responses);

        // 15. TicketAttachment (10 rows)
        TicketAttachment::truncate();
        $attachments = [];
        for ($k = 1; $k <= 10; $k++) {
            $tId = $k * 10;
            $uId = 19 + (($k - 1) % 3) * 10;
            $attachments[] = [
                'TicketAttachmentId' => $k,
                'TicketId' => $tId,
                'FileName' => "minh-chung-$tId.jpg",
                'FilePath' => "/demo/tickets/$tId/minh-chung-$tId.jpg",
                'ContentType' => 'image/jpeg',
                'FileSize' => 120000 + $tId,
                'UploadedByUserId' => $uId,
                'UploadedAt' => now(),
                'IsDeleted' => false,
                'DeletedAt' => null,
            ];
        }
        TicketAttachment::insert($attachments);

        // 16. Notification (4 rows)
        Notification::truncate();
        $notifications = [
            ['NotificationId' => 1, 'CreatedByUserId' => 1, 'Title' => 'Thông báo lịch bảo trì thang máy', 'Content' => 'Thang máy tòa A bảo trì định kỳ vào Chủ nhật, 08:00–11:00.', 'TargetType' => 'BUILDING', 'CreatedAt' => '2026-02-01 08:00:00', 'IsDeleted' => false, 'DeletedAt' => null],
            ['NotificationId' => 2, 'CreatedByUserId' => 1, 'Title' => 'Nhắc thanh toán phí tháng 02/2026', 'Content' => 'Vui lòng hoàn tất thanh toán trước ngày 10/03/2026.', 'TargetType' => 'ALL', 'CreatedAt' => '2026-03-01 08:00:00', 'IsDeleted' => false, 'DeletedAt' => null],
            ['NotificationId' => 3, 'CreatedByUserId' => 2, 'Title' => 'Cập nhật xử lý yêu cầu kỹ thuật', 'Content' => 'Một số yêu cầu kỹ thuật đang được xử lý.', 'TargetType' => 'FLOOR', 'CreatedAt' => '2026-02-15 14:00:00', 'IsDeleted' => false, 'DeletedAt' => null],
            ['NotificationId' => 4, 'CreatedByUserId' => 1, 'Title' => 'Thông báo riêng căn hộ 0101', 'Content' => 'Vui lòng liên hệ ban quản lý để xác nhận thông tin cư trú.', 'TargetType' => 'APARTMENT', 'CreatedAt' => '2026-02-20 09:00:00', 'IsDeleted' => false, 'DeletedAt' => null],
        ];
        Notification::insert($notifications);

        // 17. NotificationTarget (4 rows)
        NotificationTarget::truncate();
        $notifTargets = [
            ['NotificationTargetId' => 1, 'NotificationId' => 1, 'BuildingId' => 1, 'FloorId' => null, 'ApartmentId' => null, 'IsDeleted' => false, 'DeletedAt' => null],
            ['NotificationTargetId' => 2, 'NotificationId' => 2, 'BuildingId' => 1, 'FloorId' => null, 'ApartmentId' => null, 'IsDeleted' => false, 'DeletedAt' => null],
            ['NotificationTargetId' => 3, 'NotificationId' => 3, 'BuildingId' => null, 'FloorId' => 2, 'ApartmentId' => null, 'IsDeleted' => false, 'DeletedAt' => null],
            ['NotificationTargetId' => 4, 'NotificationId' => 4, 'BuildingId' => null, 'FloorId' => null, 'ApartmentId' => 1, 'IsDeleted' => false, 'DeletedAt' => null],
        ];
        NotificationTarget::insert($notifTargets);

        // 18. NotificationRecipient (69 rows)
        NotificationRecipient::truncate();
        $recipients = [];
        $recipId = 1;

        // Notification 1 (30 recipients: users 10..39)
        for ($u = 10; $u <= 39; $u++) {
            $isRead = ($u % 3 === 0);
            $recipients[] = [
                'NotificationRecipientId' => $recipId++,
                'NotificationId' => 1,
                'UserId' => $u,
                'IsRead' => $isRead,
                'IsDeleted' => false,
                'DeletedAt' => null,
            ];
        }

        // Notification 2 (30 recipients: users 10..39)
        for ($u = 10; $u <= 39; $u++) {
            $isRead = ($u % 3 === 0);
            $recipients[] = [
                'NotificationRecipientId' => $recipId++,
                'NotificationId' => 2,
                'UserId' => $u,
                'IsRead' => $isRead,
                'IsDeleted' => false,
                'DeletedAt' => null,
            ];
        }

        // Notification 3 (users 18..25 on floor 2)
        for ($u = 18; $u <= 25; $u++) {
            $isRead = ($u % 3 === 0);
            $recipients[] = [
                'NotificationRecipientId' => $recipId++,
                'NotificationId' => 3,
                'UserId' => $u,
                'IsRead' => $isRead,
                'IsDeleted' => false,
                'DeletedAt' => null,
            ];
        }

        // Notification 4 (user 10 for apt 0101)
        $recipients[] = [
            'NotificationRecipientId' => $recipId++,
            'NotificationId' => 4,
            'UserId' => 10,
            'IsRead' => false,
            'IsDeleted' => false,
            'DeletedAt' => null,
        ];

        NotificationRecipient::insert($recipients);

        // Re-enable foreign keys
        Schema::enableForeignKeyConstraints();
    }
}
