<?php

namespace App\Http\Controllers;

use App\DTOs\TicketDTO;
use App\Exceptions\BusinessException;
use App\Http\Requests\Ticket\AssignTicketRequest;
use App\Http\Requests\Ticket\CancelTicketRequest;
use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Http\Requests\Ticket\VerifyTicketRequest;
use App\Models\Apartment;
use App\Models\Ticket;
use App\Models\TicketAssignment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class TicketController extends Controller
{
    /**
     * Danh sách yêu cầu hỗ trợ dạng Kanban (SCR-TCK-01).
     */
    public function index(Request $request): View
    {
        $apartments = Apartment::where('IsDeleted', false)
            ->orderBy('ApartmentNumber')
            ->get();

        $staff = User::whereIn('Role', ['SUPPORT', 'TECHNICIAN', 'MANAGER'])
            ->where('IsDeleted', false)
            ->orderBy('FullName')
            ->get();

        $creators = User::where('IsDeleted', false)
            ->orderBy('FullName')
            ->get();

        $query = Ticket::with(['creator', 'apartment', 'assignment.assignedTo', 'attachments'])
            ->where('IsDeleted', false);

        if ($request->filled('category') && $request->input('category') !== 'ALL') {
            $query->where('Category', $request->input('category'));
        }

        if ($request->filled('creator_id')) {
            $query->where('CreatedByUserId', (int) $request->input('creator_id'));
        }

        if ($request->filled('assignee_id')) {
            $assigneeId = (int) $request->input('assignee_id');
            $query->whereHas('assignment', function ($q) use ($assigneeId): void {
                $q->where('AssignedToUserId', $assigneeId);
            });
        }

        if ($request->filled('apartment_id')) {
            $query->where('ApartmentId', (int) $request->input('apartment_id'));
        }

        if ($request->filled('keyword')) {
            $kw = trim((string) $request->input('keyword'));
            $query->where(function ($q) use ($kw): void {
                $q->where('Subject', 'like', "%{$kw}%")
                    ->orWhere('Description', 'like', "%{$kw}%");
            });
        }

        $allTickets = $query->orderByDesc('TicketId')->get();

        $stepMap = [
            'WAITING' => 'Bước 1 / 5',
            'ASSIGNED' => 'Bước 2 / 5',
            'PROCESSING' => 'Bước 3 / 5',
            'RESOLVED' => 'Bước 4 / 5',
            'CLOSED' => 'Bước 5 / 5',
            'CANCELLED' => 'Dừng xử lý · lưu lịch sử',
        ];

        $statusLabelMap = [
            'WAITING' => 'Chờ xử lý',
            'ASSIGNED' => 'Đã giao',
            'PROCESSING' => 'Đang xử lý',
            'RESOLVED' => 'Đã xử lý',
            'CLOSED' => 'Đã đóng',
            'CANCELLED' => 'Đã hủy',
        ];

        $tickets = $allTickets->map(function (Ticket $t) use ($stepMap, $statusLabelMap) {
            $assigneeName = $t->assignment?->assignedTo
                ? "{$t->assignment->assignedTo->UserId} · {$t->assignment->assignedTo->FullName}"
                : null;

            return (object) [
                'id' => $t->TicketId,
                'category' => $t->Category ?? 'Khác',
                'title' => $t->Subject,
                'description' => $t->Description,
                'apartment' => $t->apartment?->ApartmentNumber ?? '—',
                'apartment_id' => $t->ApartmentId,
                'creator' => $t->creator ? "{$t->creator->UserId} · {$t->creator->FullName}" : 'Cư dân',
                'creator_name' => $t->creator?->FullName ?? 'Cư dân',
                'created_at' => $t->CreatedAt ? Carbon::parse($t->CreatedAt)->format('d/m/Y H:i') : '—',
                'resolved_at' => $t->ResolvedAt ? Carbon::parse($t->ResolvedAt)->format('d/m/Y H:i') : null,
                'assigned_at' => $t->assignment?->AssignedAt ? Carbon::parse($t->assignment->AssignedAt)->format('d/m/Y H:i') : null,
                'status' => $t->Status,
                'status_label' => $statusLabelMap[$t->Status] ?? $t->Status,
                'assignee' => $assigneeName,
                'step' => $stepMap[$t->Status] ?? '—',
                'has_attachment' => $t->attachments->isNotEmpty(),
            ];
        });

        $columns = [
            'WAITING' => [
                'title' => 'Chờ xử lý',
                'step' => 'Bước 1 / 5',
                'count' => $tickets->where('status', 'WAITING')->count(),
                'remaining' => max(0, $tickets->where('status', 'WAITING')->count() - 2),
            ],
            'ASSIGNED' => [
                'title' => 'Đã giao',
                'step' => 'Bước 2 / 5',
                'count' => $tickets->where('status', 'ASSIGNED')->count(),
                'remaining' => max(0, $tickets->where('status', 'ASSIGNED')->count() - 2),
            ],
            'PROCESSING' => [
                'title' => 'Đang xử lý',
                'step' => 'Bước 3 / 5',
                'count' => $tickets->where('status', 'PROCESSING')->count(),
                'remaining' => max(0, $tickets->where('status', 'PROCESSING')->count() - 2),
            ],
            'RESOLVED' => [
                'title' => 'Đã xử lý',
                'step' => 'Bước 4 / 5',
                'count' => $tickets->where('status', 'RESOLVED')->count(),
                'remaining' => max(0, $tickets->where('status', 'RESOLVED')->count() - 2),
            ],
            'CLOSED' => [
                'title' => 'Đã đóng',
                'step' => 'Bước 5 / 5',
                'count' => $tickets->where('status', 'CLOSED')->count(),
                'remaining' => max(0, $tickets->where('status', 'CLOSED')->count() - 2),
            ],
            'CANCELLED' => [
                'title' => 'Đã hủy',
                'step' => 'Dừng xử lý · lưu lịch sử',
                'count' => $tickets->where('status', 'CANCELLED')->count(),
                'remaining' => max(0, $tickets->where('status', 'CANCELLED')->count() - 2),
            ],
        ];

        return view('tickets.index', [
            'tickets' => $tickets,
            'columns' => $columns,
            'apartments' => $apartments,
            'staff' => $staff,
            'creators' => $creators,
        ]);
    }

    /**
     * Tạo yêu cầu hỗ trợ mới (SCR-TCK-03).
     */
    public function store(StoreTicketRequest $request): RedirectResponse
    {
        $dto = TicketDTO::fromStoreRequest($request, auth()->id() ?? 1);
        $ticket = Ticket::create($dto->toModelArray());

        Cache::forget('dashboard_stats');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Tạo yêu cầu #{$ticket->TicketId} thành công.",
                'data' => $ticket,
            ]);
        }

        return redirect()->route('tickets.index')
            ->with('success', "Tạo yêu cầu #{$ticket->TicketId} thành công.");
    }

    /**
     * Cập nhật yêu cầu hỗ trợ.
     */
    public function update(int $id, UpdateTicketRequest $request): RedirectResponse
    {
        $ticket = Ticket::findOrFail($id);

        $dto = TicketDTO::fromUpdateRequest($request, $ticket->CreatedByUserId, $ticket->ApartmentId);
        $updateData = [
            'Subject' => $dto->subject,
            'Description' => $dto->description,
            'Category' => $dto->category,
        ];

        if ($request->filled('ApartmentId')) {
            $updateData['ApartmentId'] = (int) $request->input('ApartmentId');
        }

        $ticket->update($updateData);

        Cache::forget('dashboard_stats');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Cập nhật yêu cầu #{$ticket->TicketId} thành công.",
                'data' => $ticket,
            ]);
        }

        return redirect()->route('tickets.index')
            ->with('success', "Cập nhật yêu cầu #{$ticket->TicketId} thành công.");
    }

    /**
     * Di chuyển yêu cầu sang trạng thái khác (Kéo thả Kanban).
     */
    public function move(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:WAITING,ASSIGNED,PROCESSING,RESOLVED,CLOSED,CANCELLED'],
        ]);

        $newStatus = $validated['status'];

        if ($ticket->Status === 'CLOSED' && in_array($newStatus, ['CANCELLED'], true)) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể hủy yêu cầu đã hoàn tất và đóng.',
                ], 422);
            }
            throw new BusinessException('Không thể hủy yêu cầu đã hoàn tất và đóng.');
        }

        $oldStatus = $ticket->Status;

        $updateData = [
            'Status' => $newStatus,
        ];

        if (in_array($newStatus, ['RESOLVED', 'CLOSED'], true)) {
            $updateData['ResolvedAt'] = now();
        } elseif (in_array($newStatus, ['WAITING', 'ASSIGNED', 'PROCESSING'], true)) {
            $updateData['ResolvedAt'] = null;
        }

        $ticket->update($updateData);

        Cache::forget('dashboard_stats');

        $statusLabels = [
            'WAITING' => 'Chờ xử lý',
            'ASSIGNED' => 'Đã giao',
            'PROCESSING' => 'Đang xử lý',
            'RESOLVED' => 'Đã xử lý',
            'CLOSED' => 'Đã đóng',
            'CANCELLED' => 'Đã hủy',
        ];

        $newLabel = $statusLabels[$newStatus] ?? $newStatus;

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã chuyển yêu cầu #{$ticket->TicketId} sang {$newLabel}.",
                'ticketId' => $ticket->TicketId,
                'oldStatus' => $oldStatus,
                'newStatus' => $newStatus,
            ]);
        }

        return redirect()->route('tickets.index')
            ->with('success', "Đã chuyển yêu cầu #{$ticket->TicketId} sang {$newLabel}.");
    }

    /**
     * Phân công kỹ thuật viên cho yêu cầu (SCR-TCK-04).
     */
    public function assign(int $id, AssignTicketRequest $request): RedirectResponse
    {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->Status === 'CLOSED' || $ticket->Status === 'CANCELLED') {
            throw new BusinessException('Không thể phân công yêu cầu đã đóng hoặc đã hủy.');
        }

        $techUserId = (int) $request->validated('AssignedToUserId');
        $user = User::findOrFail($techUserId);

        TicketAssignment::updateOrCreate(
            ['TicketId' => $ticket->TicketId],
            [
                'AssignedToUserId' => $user->UserId,
                'AssignedAt' => now(),
            ]
        );

        $ticket->update([
            'Status' => 'ASSIGNED',
        ]);

        Cache::forget('dashboard_stats');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã phân công yêu cầu #{$ticket->TicketId} cho {$user->FullName}.",
                'data' => $ticket,
            ]);
        }

        return redirect()->route('tickets.index')
            ->with('success', "Đã phân công yêu cầu #{$ticket->TicketId} cho {$user->FullName}.");
    }

    /**
     * Xác nhận xử lý hoàn tất yêu cầu (SCR-TCK-05).
     */
    public function verify(int $id, VerifyTicketRequest $request): RedirectResponse
    {
        $ticket = Ticket::findOrFail($id);

        $actionInput = (string) $request->validated('action');
        $action = match ($actionInput) {
            'CLOSE' => 'CLOSED',
            'REOPEN', 'PROCESSING' => 'PROCESSING',
            default => 'RESOLVED',
        };

        $ticket->update([
            'Status' => $action,
            'ResolvedAt' => in_array($action, ['CLOSED', 'RESOLVED'], true) ? now() : null,
        ]);

        Cache::forget('dashboard_stats');

        $label = match ($action) {
            'CLOSED' => 'đóng',
            'PROCESSING' => 'chuyển lại xử lý',
            default => 'xử lý xong',
        };

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã xác nhận {$label} yêu cầu #{$ticket->TicketId}.",
                'data' => $ticket,
            ]);
        }

        return redirect()->route('tickets.index')
            ->with('success', "Đã xác nhận {$label} yêu cầu #{$ticket->TicketId}.");
    }

    /**
     * Hủy yêu cầu hỗ trợ (SCR-TCK-06).
     */
    public function cancel(int $id, CancelTicketRequest $request): RedirectResponse
    {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->Status === 'CLOSED') {
            throw new BusinessException('Không thể hủy yêu cầu đã hoàn tất và đóng.');
        }

        $ticket->update([
            'Status' => 'CANCELLED',
        ]);

        Cache::forget('dashboard_stats');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã hủy yêu cầu #{$ticket->TicketId}.",
                'data' => $ticket,
            ]);
        }

        return redirect()->route('tickets.index')
            ->with('success', "Đã hủy yêu cầu #{$ticket->TicketId}.");
    }
}
