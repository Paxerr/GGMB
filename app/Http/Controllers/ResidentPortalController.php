<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResidentPortalController extends Controller
{
    /**
     * Trang chủ Cổng cư dân (Ảnh 1 / SCR-PORTAL-01)
     */
    public function dashboard(): View
    {
        return view('portal.dashboard');
    }

    /**
     * Hóa đơn & thanh toán Cổng cư dân (Ảnh 2 / SCR-PORTAL-02)
     */
    public function invoices(): View
    {
        return view('portal.invoices');
    }

    /**
     * Gửi yêu cầu hỗ trợ Cổng cư dân (Ảnh 3 / SCR-PORTAL-03)
     */
    public function tickets(): View
    {
        return view('portal.tickets.create');
    }

    /**
     * Tiếp nhận yêu cầu hỗ trợ mới từ Cư dân
     */
    public function ticketStore(Request $request): RedirectResponse
    {
        return redirect()->route('portal.tickets')
            ->with('success', 'Gửi yêu cầu hỗ trợ thành công! Ban quản lý sẽ sớm kiểm tra và xử lý.');
    }

    /**
     * Chi tiết yêu cầu của tôi (Ảnh 4 / SCR-PORTAL-04)
     */
    public function ticketShow(string|int $id): View
    {
        return view('portal.tickets.show', [
            'id' => $id,
        ]);
    }

    /**
     * Gửi phản hồi bổ sung cho yêu cầu
     */
    public function ticketReply(Request $request, string|int $id): RedirectResponse
    {
        return redirect()->route('portal.tickets.show', $id)
            ->with('success', 'Gửi phản hồi thành công! Thông tin đã được cập nhật tới Ban quản lý.');
    }

    /**
     * Thông báo riêng căn hộ 0101 (Ảnh 5 / SCR-PORTAL-05)
     */
    public function notificationShow(string|int $id): View
    {
        return view('portal.notifications.show', [
            'id' => $id,
        ]);
    }

    /**
     * Thông tin cá nhân Cư dân (Ảnh 6 / SCR-PORTAL-06)
     */
    public function profile(): View
    {
        return view('portal.profile');
    }

    /**
     * Cập nhật liên hệ Cư dân (Ảnh 7 / SCR-PORTAL-07)
     */
    public function profileEdit(): View
    {
        return view('portal.profile.edit');
    }

    /**
     * Lưu cập nhật thông tin liên hệ
     */
    public function profileUpdate(Request $request): RedirectResponse
    {
        return redirect()->route('portal.profile')
            ->with('success', 'Cập nhật thông tin liên hệ thành công!');
    }
}
