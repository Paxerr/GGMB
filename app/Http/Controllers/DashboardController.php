<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\ApartmentResident;
use App\Models\Invoice;
use App\Models\Ticket;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Hiển thị trang Tổng quan vận hành (SCR-DASH-01).
     */
    public function index(Request $request): View
    {
        if ($request->boolean('refresh')) {
            Cache::forget('dashboard_stats');
        }

        $stats = Cache::remember('dashboard_stats', 60, function (): array {
            // 1. Thống kê Căn hộ thực tế từ MySQL
            $totalApartments = Apartment::where('IsDeleted', false)->count();
            $occupiedApartments = Apartment::where('IsDeleted', false)->where('Status', 'OCCUPIED')->count();
            $vacantApartments = Apartment::where('IsDeleted', false)->whereIn('Status', ['VACANT', 'AVAILABLE'])->count();
            $otherApartments = Apartment::where('IsDeleted', false)->whereNotIn('Status', ['OCCUPIED', 'VACANT', 'AVAILABLE'])->count();

            // 2. Thống kê Cư dân đang cư trú
            $totalResidents = ApartmentResident::where('IsDeleted', false)->where('Status', 'ACTIVE')->count();

            // 3. Thống kê Phương tiện & phân loại
            $totalVehicles = Vehicle::where('IsDeleted', false)->count();
            $motorbikes = Vehicle::where('IsDeleted', false)->where('VehicleType', 'MOTORBIKE')->count();
            $cars = Vehicle::where('IsDeleted', false)->where('VehicleType', 'CAR')->count();

            // 4. Thống kê Yêu cầu / Sự cố
            $totalTickets = Ticket::where('IsDeleted', false)->count();
            $pendingTickets = Ticket::where('IsDeleted', false)->whereNotIn('Status', ['RESOLVED', 'CLOSED', 'CANCELLED'])->count();

            // 5. Thống kê Công nợ & Hóa đơn quá hạn
            $overdueQuery = Invoice::where('Status', 'OVERDUE')->orderBy('InvoiceId');
            $overdueCount = $overdueQuery->count();
            $overdueTotal = $overdueQuery->sum('TotalAmount');

            $overdueInvoices = $overdueQuery->take(5)->get();
            $invoicesData = $overdueInvoices->map(function (Invoice $inv) {
                return [
                    'id' => $inv->InvoiceId,
                    'amount' => number_format((float) $inv->TotalAmount, 0, ',', '.').' đ',
                ];
            })->toArray();

            // 6. Doanh thu theo kỳ hóa đơn thực tế từ MySQL
            $periodRevenues = Invoice::select('BillingPeriod', DB::raw('SUM(TotalAmount) as total'))
                ->groupBy('BillingPeriod')
                ->orderBy('BillingPeriod')
                ->take(6)
                ->get();

            $maxTotal = $periodRevenues->max('total') ?: 1;

            $monthlyRevenue = $periodRevenues->map(function ($item) use ($maxTotal) {
                $height = min(170, max(40, (int) round(($item->total / $maxTotal) * 170)));

                return [
                    'month' => 'Kỳ '.$item->BillingPeriod,
                    'height' => $height,
                ];
            })->toArray();

            if (empty($monthlyRevenue)) {
                $monthlyRevenue = [
                    ['month' => 'Tháng 1', 'height' => 170],
                    ['month' => 'Tháng 2', 'height' => 170],
                    ['month' => 'Tháng 3', 'height' => 170],
                    ['month' => 'Tháng 4', 'height' => 170],
                    ['month' => 'Tháng 5', 'height' => 160],
                    ['month' => 'Tháng 6', 'height' => 160],
                ];
            }

            return [
                'totalApartments' => $totalApartments,
                'occupiedApartments' => $occupiedApartments,
                'vacantApartments' => $vacantApartments,
                'otherApartments' => $otherApartments,
                'totalResidents' => $totalResidents,
                'totalVehicles' => $totalVehicles,
                'motorbikes' => $motorbikes,
                'cars' => $cars,
                'totalTickets' => $totalTickets,
                'pendingTickets' => $pendingTickets,
                'overdueCount' => $overdueCount,
                'overdueTotal' => number_format((float) $overdueTotal, 0, ',', '.').' đ',
                'invoicesData' => $invoicesData,
                'monthlyRevenue' => $monthlyRevenue,
            ];
        });

        return view('dashboard', $stats);
    }
}
