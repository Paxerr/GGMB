<?php

namespace App\Http\Controllers;

use App\DTOs\PortalProfileDTO;
use App\DTOs\PortalTicketDTO;
use App\Http\Requests\Portal\ReplyPortalTicketRequest;
use App\Http\Requests\Portal\StorePortalTicketRequest;
use App\Http\Requests\Portal\UpdatePortalProfileRequest;
use App\Models\ApartmentResident;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ResidentPortalController extends Controller
{
    /**
     * Lấy thông tin người dùng cư dân hiện tại (hoặc cư dân mẫu đầu tiên nếu chưa đăng nhập).
     */
    protected function getCurrentResident(): User
    {
        /** @var User|null $user */
        $user = auth()->user();

        if ($user && $user->Role === 'RESIDENT') {
            return $user;
        }

        return User::where('Role', 'RESIDENT')->where('IsDeleted', false)->first()
            ?? User::firstOrFail();
    }

    /**
     * Trang chủ Cổng cư dân (SCR-PORTAL-01).
     */
    public function dashboard(): View
    {
        $user = $this->getCurrentResident();

        $activeResidency = ApartmentResident::with(['apartment.floor.building', 'apartment.vehicles'])
            ->where('UserId', $user->UserId)
            ->where('Status', 'ACTIVE')
            ->first();

        $apartment = $activeResidency?->apartment;

        $unpaidInvoices = $apartment
            ? Invoice::where('ApartmentId', $apartment->ApartmentId)
                ->whereIn('Status', ['PENDING', 'UNPAID', 'OVERDUE'])
                ->get()
            : collect([]);

        $unpaidTotal = $unpaidInvoices->sum('TotalAmount');

        $openTickets = Ticket::where('CreatedByUserId', $user->UserId)
            ->whereNotIn('Status', ['RESOLVED', 'CLOSED', 'CANCELLED'])
            ->get();

        $notifications = NotificationRecipient::with('notification')
            ->where('UserId', $user->UserId)
            ->where('IsDeleted', false)
            ->take(5)
            ->get();

        return view('portal.dashboard', [
            'user' => $user,
            'apartment' => $apartment,
            'unpaidTotal' => $unpaidTotal,
            'unpaidInvoices' => $unpaidInvoices,
            'openTicketsCount' => $openTickets->count(),
            'openTickets' => $openTickets,
            'notifications' => $notifications,
        ]);
    }

    /**
     * Hóa đơn & thanh toán Cổng cư dân (SCR-PORTAL-02).
     */
    public function invoices(): View
    {
        $user = $this->getCurrentResident();

        $activeResidency = ApartmentResident::with(['apartment.floor.building'])
            ->where('UserId', $user->UserId)
            ->where('Status', 'ACTIVE')
            ->first();

        $apartment = $activeResidency?->apartment;

        $invoices = $apartment
            ? Invoice::with(['items.feeType'])
                ->where('ApartmentId', $apartment->ApartmentId)
                ->orderByDesc('BillingPeriod')
                ->get()
            : collect([]);

        $debtTotal = $invoices->whereIn('Status', ['PENDING', 'UNPAID', 'OVERDUE'])->sum('TotalAmount');

        return view('portal.invoices', [
            'user' => $user,
            'apartment' => $apartment,
            'invoices' => $invoices,
            'debtTotal' => $debtTotal,
        ]);
    }

    /**
     * Gửi yêu cầu hỗ trợ Cổng cư dân (SCR-PORTAL-03).
     */
    public function tickets(): View
    {
        $user = $this->getCurrentResident();

        $activeResidency = ApartmentResident::where('UserId', $user->UserId)
            ->where('Status', 'ACTIVE')
            ->first();

        $myTickets = Ticket::with(['assignment.assignedTo', 'responses'])
            ->where('CreatedByUserId', $user->UserId)
            ->where('IsDeleted', false)
            ->orderByDesc('TicketId')
            ->get();

        return view('portal.tickets.create', [
            'user' => $user,
            'apartmentId' => $activeResidency?->ApartmentId,
            'myTickets' => $myTickets,
        ]);
    }

    /**
     * Tiếp nhận yêu cầu hỗ trợ mới từ Cư dân.
     */
    public function ticketStore(StorePortalTicketRequest $request): RedirectResponse|JsonResponse
    {
        $user = $this->getCurrentResident();

        $activeResidency = ApartmentResident::where('UserId', $user->UserId)
            ->where('Status', 'ACTIVE')
            ->first();

        $dto = PortalTicketDTO::fromRequest($request, $user->UserId, $activeResidency?->ApartmentId);
        $ticket = Ticket::create($dto->toModelArray());

        Cache::forget('dashboard_stats');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Gửi yêu cầu hỗ trợ #{$ticket->TicketId} thành công! Ban quản lý sẽ sớm xử lý.",
                'data' => $ticket,
            ]);
        }

        return redirect()->route('portal.tickets')
            ->with('success', "Gửi yêu cầu hỗ trợ #{$ticket->TicketId} thành công! Ban quản lý sẽ sớm xử lý.");
    }

    /**
     * Chi tiết yêu cầu của tôi (SCR-PORTAL-04).
     */
    public function ticketShow(string|int $id): View
    {
        $ticket = Ticket::with(['creator', 'apartment', 'assignment.assignedTo', 'responses.respondedBy', 'attachments'])
            ->where('IsDeleted', false)
            ->findOrFail((int) $id);

        return view('portal.tickets.show', [
            'id' => $id,
            'ticket' => $ticket,
        ]);
    }

    /**
     * Gửi phản hồi bổ sung cho yêu cầu.
     */
    public function ticketReply(ReplyPortalTicketRequest $request, string|int $id): RedirectResponse|JsonResponse
    {
        $user = $this->getCurrentResident();
        $ticket = Ticket::where('IsDeleted', false)->findOrFail((int) $id);

        TicketResponse::create([
            'TicketId' => $ticket->TicketId,
            'RespondedByUserId' => $user->UserId,
            'Content' => (string) $request->validated('content'),
            'CreatedAt' => now(),
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Gửi phản hồi thành công! Thông tin đã được cập nhật tới Ban quản lý.',
            ]);
        }

        return redirect()->route('portal.tickets.show', $id)
            ->with('success', 'Gửi phản hồi thành công! Thông tin đã được cập nhật tới Ban quản lý.');
    }

    /**
     * Xem thông báo riêng hoặc chung (SCR-PORTAL-05).
     */
    public function notificationShow(string|int $id): View
    {
        $user = $this->getCurrentResident();
        $notification = Notification::where('IsDeleted', false)->findOrFail((int) $id);

        // Đánh dấu đã đọc
        NotificationRecipient::where('NotificationId', $notification->NotificationId)
            ->where('UserId', $user->UserId)
            ->update(['IsRead' => true]);

        return view('portal.notifications.show', [
            'id' => $id,
            'notification' => $notification,
        ]);
    }

    /**
     * Thông tin cá nhân Cư dân (SCR-PORTAL-06).
     */
    public function profile(): View
    {
        $user = $this->getCurrentResident();

        $activeResidency = ApartmentResident::with(['apartment.floor.building', 'apartment.vehicles'])
            ->where('UserId', $user->UserId)
            ->where('Status', 'ACTIVE')
            ->first();

        return view('portal.profile', [
            'user' => $user,
            'apartment' => $activeResidency?->apartment,
            'vehicles' => $activeResidency?->apartment?->vehicles ?? collect([]),
        ]);
    }

    /**
     * Cập nhật liên hệ Cư dân (SCR-PORTAL-07).
     */
    public function profileEdit(): View
    {
        $user = $this->getCurrentResident();

        return view('portal.profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Lưu cập nhật thông tin liên hệ.
     */
    public function profileUpdate(UpdatePortalProfileRequest $request): RedirectResponse|JsonResponse
    {
        $user = $this->getCurrentResident();
        $dto = PortalProfileDTO::fromRequest($request);

        $user->update($dto->toModelArray());

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thông tin liên hệ thành công!',
                'data' => $user,
            ]);
        }

        return redirect()->route('portal.profile')
            ->with('success', 'Cập nhật thông tin liên hệ thành công!');
    }
}
