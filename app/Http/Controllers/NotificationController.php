<?php

namespace App\Http\Controllers;

use App\DTOs\NotificationDTO;
use App\Http\Requests\Notification\StoreNotificationRequest;
use App\Http\Requests\Notification\UpdateNotificationRequest;
use App\Models\Apartment;
use App\Models\ApartmentResident;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use App\Models\NotificationTarget;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Bảng tin tòa nhà (SCR-NTF-01).
     */
    public function index(Request $request): View
    {
        $notifications = Notification::with([
            'creator',
            'recipients.user.apartmentResidents.apartment',
            'targets.building',
            'targets.floor',
            'targets.apartment',
        ])
            ->where('IsDeleted', false)
            ->orderByDesc('NotificationId')
            ->get()
            ->map(function (Notification $ntf) {
                $readCount = $ntf->recipients->where('IsRead', true)->count();
                $unreadCount = $ntf->recipients->where('IsRead', false)->count();
                $totalCount = $ntf->recipients->count();

                $scopeLabel = match ($ntf->TargetType) {
                    'BUILDING' => 'Tòa nhà',
                    'FLOOR' => 'Tầng',
                    'APARTMENT' => 'Căn hộ',
                    default => 'Tất cả',
                };

                $scopeDetail = match ($ntf->TargetType) {
                    'BUILDING' => 'Toàn tòa nhà · GGMB Residence',
                    'FLOOR' => 'Theo tầng chỉ định · GGMB Residence',
                    'APARTMENT' => 'Gửi riêng căn hộ',
                    default => 'Tất cả cư dân · GGMB Residence',
                };

                $recipientsList = $ntf->recipients->map(function (NotificationRecipient $rcp, int $idx) {
                    $activeResidency = $rcp->user?->apartmentResidents?->firstWhere('Status', 'ACTIVE');
                    $aptNum = $activeResidency?->apartment?->ApartmentNumber ?? '—';

                    return [
                        'stt' => $idx + 1,
                        'name' => $rcp->user?->FullName ?? 'Cư dân',
                        'apartment' => $aptNum,
                        'read' => (bool) $rcp->IsRead,
                        'read_label' => $rcp->IsRead ? 'Đã đọc' : 'Chưa đọc',
                    ];
                })->toArray();

                return (object) [
                    'id' => $ntf->NotificationId,
                    'title' => $ntf->Title,
                    'body' => $ntf->Content,
                    'scope' => $scopeLabel,
                    'scope_detail' => $scopeDetail,
                    'creator' => $ntf->creator ? "{$ntf->creator->UserId} · {$ntf->creator->FullName}" : 'Ban quản lý',
                    'created_at' => $ntf->CreatedAt ? Carbon::parse($ntf->CreatedAt)->format('d/m/Y H:i') : '—',
                    'read_count' => $readCount,
                    'unread_count' => $unreadCount,
                    'total_count' => $totalCount,
                    'recipients' => $recipientsList,
                ];
            });

        return view('notifications.index', [
            'notifications' => $notifications,
        ]);
    }

    /**
     * Soạn thông báo mới (SCR-NTF-02).
     */
    public function create(Request $request): View
    {
        $buildings = Building::where('IsDeleted', false)->get();
        $floors = Floor::where('IsDeleted', false)->orderBy('FloorNumber')->get();
        $apartments = Apartment::where('IsDeleted', false)->orderBy('ApartmentNumber')->get();

        return view('notifications.create', [
            'buildings' => $buildings,
            'floors' => $floors,
            'apartments' => $apartments,
        ]);
    }

    /**
     * Lưu thông báo mới và tự động gửi tới cư dân mục tiêu.
     */
    public function store(StoreNotificationRequest $request): RedirectResponse
    {
        $dto = NotificationDTO::fromStoreRequest($request, auth()->id() ?? 1);

        DB::transaction(function () use ($dto): void {
            $notification = Notification::create($dto->toModelArray());

            // Lưu Target
            NotificationTarget::create([
                'NotificationId' => $notification->NotificationId,
                'BuildingId' => $dto->buildingId,
                'FloorId' => $dto->floorId,
                'ApartmentId' => ! empty($dto->apartmentIds) ? reset($dto->apartmentIds) : null,
                'IsDeleted' => false,
            ]);

            // Xác định danh sách UserId cư dân nhận thông báo
            $targetUserIds = collect([]);

            if ($dto->targetType === 'ALL') {
                $targetUserIds = User::where('Role', 'RESIDENT')
                    ->where('IsDeleted', false)
                    ->pluck('UserId');
            } elseif ($dto->targetType === 'BUILDING' && $dto->buildingId) {
                $targetUserIds = ApartmentResident::whereHas('apartment.floor', function ($q) use ($dto): void {
                    $q->where('BuildingId', $dto->buildingId);
                })->where('Status', 'ACTIVE')->pluck('UserId');
            } elseif ($dto->targetType === 'FLOOR' && $dto->floorId) {
                $targetUserIds = ApartmentResident::whereHas('apartment', function ($q) use ($dto): void {
                    $q->where('FloorId', $dto->floorId);
                })->where('Status', 'ACTIVE')->pluck('UserId');
            } elseif (! empty($dto->apartmentIds)) {
                $targetUserIds = ApartmentResident::whereIn('ApartmentId', $dto->apartmentIds)
                    ->where('Status', 'ACTIVE')
                    ->pluck('UserId');
            }

            if ($targetUserIds->isEmpty()) {
                $targetUserIds = User::where('Role', 'RESIDENT')->where('IsDeleted', false)->pluck('UserId');
            }

            foreach ($targetUserIds->unique() as $uid) {
                NotificationRecipient::create([
                    'NotificationId' => $notification->NotificationId,
                    'UserId' => $uid,
                    'IsRead' => false,
                    'IsDeleted' => false,
                ]);
            }
        });

        return redirect()->route('notifications.index')
            ->with('success', 'Gửi thông báo thành công.');
    }

    /**
     * Cập nhật thông báo.
     */
    public function update(int $id, UpdateNotificationRequest $request): RedirectResponse
    {
        $notification = Notification::where('IsDeleted', false)->findOrFail($id);

        $notification->update([
            'Title' => (string) $request->validated('Title'),
            'Content' => (string) $request->validated('Content'),
        ]);

        return redirect()->route('notifications.index')
            ->with('success', "Cập nhật thông báo #{$id} thành công.");
    }
}
