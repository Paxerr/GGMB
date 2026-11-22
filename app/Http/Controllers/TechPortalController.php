<?php

namespace App\Http\Controllers;

use App\DTOs\TechTaskDTO;
use App\DTOs\TechUtilityDTO;
use App\Http\Requests\Tech\CompleteTaskRequest;
use App\Http\Requests\Tech\StoreTechUtilityRequest;
use App\Models\Apartment;
use App\Models\FeeType;
use App\Models\MeterReading;
use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class TechPortalController extends Controller
{
    /**
     * Lấy thông tin tài khoản kỹ thuật viên hiện tại.
     */
    protected function getCurrentTech(): User
    {
        /** @var User|null $user */
        $user = auth()->user();

        if ($user && $user->Role === 'TECHNICIAN') {
            return $user;
        }

        return User::where('Role', 'TECHNICIAN')->where('IsDeleted', false)->first()
            ?? User::firstOrFail();
    }

    /**
     * Bàn việc hiện trường (SCR-TECH-01).
     */
    public function tasks(): View
    {
        $tech = $this->getCurrentTech();

        $query = Ticket::whereHas('assignment', function ($q) use ($tech): void {
            $q->where('AssignedToUserId', $tech->UserId);
        })
            ->with(['creator', 'apartment.floor.building', 'assignment.assignedTo'])
            ->where('IsDeleted', false);

        $tasks = $query->orderByDesc('TicketId')->get();

        $processingCount = $tasks->where('Status', 'PROCESSING')->count();
        $assignedCount = $tasks->where('Status', 'ASSIGNED')->count();
        $resolvedCount = $tasks->whereIn('Status', ['RESOLVED', 'CLOSED'])->count();

        return view('tech.tasks.index', [
            'tasks' => $tasks,
            'processingCount' => $processingCount,
            'assignedCount' => $assignedCount,
            'resolvedCount' => $resolvedCount,
            'tech' => $tech,
        ]);
    }

    /**
     * Chi tiết công việc được giao (SCR-TECH-02).
     */
    public function taskShow(string|int $id): View
    {
        $task = Ticket::with(['creator', 'apartment.floor.building', 'assignment.assignedTo', 'responses.respondedBy', 'attachments'])
            ->where('IsDeleted', false)
            ->findOrFail((int) $id);

        return view('tech.tasks.show', [
            'id' => $id,
            'task' => $task,
        ]);
    }

    /**
     * Gửi kết quả xử lý công việc kỹ thuật.
     */
    public function taskComplete(CompleteTaskRequest $request, string|int $id): RedirectResponse|JsonResponse
    {
        $tech = $this->getCurrentTech();
        $ticket = Ticket::where('IsDeleted', false)->findOrFail((int) $id);

        $dto = TechTaskDTO::fromRequest($request, $ticket->TicketId, $tech->UserId);

        $ticket->update([
            'Status' => $dto->status,
            'ResolvedAt' => $dto->status === 'RESOLVED' ? now() : null,
        ]);

        if (! empty($dto->content)) {
            TicketResponse::create([
                'TicketId' => $ticket->TicketId,
                'RespondedByUserId' => $tech->UserId,
                'Content' => $dto->content,
                'CreatedAt' => now(),
            ]);
        }

        Cache::forget('dashboard_stats');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã cập nhật kết quả xử lý yêu cầu #{$ticket->TicketId} thành công!",
                'data' => $ticket,
            ]);
        }

        return redirect()->route('tech.tasks')
            ->with('success', "Đã cập nhật kết quả xử lý yêu cầu #{$ticket->TicketId} thành công!");
    }

    /**
     * Ghi điện nước hiện trường (SCR-TECH-03).
     */
    public function utilities(): View
    {
        $feeType = FeeType::where('Name', 'like', '%Điện%')->first()
            ?? FeeType::where('Code', 'ELEC')->first()
            ?? FeeType::first();

        $previousPeriod = now()->subMonth()->format('m/Y');
        $currentPeriod = now()->format('m/Y');

        $apartments = Apartment::where('IsDeleted', false)
            ->with(['meterReadings' => function ($q) use ($feeType): void {
                if ($feeType) {
                    $q->where('FeeTypeId', $feeType->FeeTypeId);
                }
                $q->orderByDesc('BillingPeriod');
            }])
            ->orderBy('ApartmentNumber')
            ->get();

        $apartmentsList = $apartments->map(function (Apartment $apt) {
            $latest = $apt->meterReadings->first();
            $prev = $latest ? (float) $latest->CurrentReading : 100.0;

            return [
                'id' => $apt->ApartmentId,
                'code' => $apt->ApartmentNumber,
                'prev' => $prev,
            ];
        })->toArray();

        $feeTypes = FeeType::where('IsActive', true)->get();

        return view('tech.utilities.index', [
            'apartments' => $apartmentsList,
            'feeTypes' => $feeTypes,
            'feeType' => $feeType,
            'previousPeriod' => $previousPeriod,
            'currentPeriod' => $currentPeriod,
        ]);
    }

    /**
     * Lưu chỉ số điện nước đã ghi nhận.
     */
    public function utilitiesStore(StoreTechUtilityRequest $request): RedirectResponse|JsonResponse
    {
        $tech = $this->getCurrentTech();
        $dto = TechUtilityDTO::fromRequest($request, $tech->UserId);

        foreach ($dto->readings as $r) {
            MeterReading::updateOrCreate(
                [
                    'ApartmentId' => $r['apartment_id'],
                    'FeeTypeId' => $r['fee_type_id'],
                    'BillingPeriod' => $r['billing_period'],
                ],
                [
                    'RecordedByUserId' => $dto->recordedByUserId,
                    'PreviousReading' => $r['previous_reading'],
                    'CurrentReading' => $r['current_reading'],
                    'Consumption' => $r['consumption'],
                    'RecordedAt' => now(),
                ]
            );
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã lưu thành công các chỉ số điện nước ghi nhận!',
            ]);
        }

        return redirect()->route('tech.utilities')
            ->with('success', 'Đã lưu thành công các chỉ số điện nước ghi nhận!');
    }
}
