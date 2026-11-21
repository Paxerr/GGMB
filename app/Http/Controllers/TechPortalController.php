<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TechPortalController extends Controller
{
    /**
     * Bàn việc hiện trường (Ảnh 8 / SCR-TECH-01)
     */
    public function tasks(): View
    {
        return view('tech.tasks.index');
    }

    /**
     * Chi tiết công việc được giao (Ảnh 9 / SCR-TECH-02)
     */
    public function taskShow(string|int $id): View
    {
        return view('tech.tasks.show', [
            'id' => $id,
        ]);
    }

    /**
     * Gửi kết quả xử lý công việc kỹ thuật
     */
    public function taskComplete(Request $request, string|int $id): RedirectResponse
    {
        return redirect()->route('tech.tasks')
            ->with('success', 'Đã gửi kết quả công việc thành công! Trạng thái đã được chuyển sang Đã xử lý.');
    }

    /**
     * Ghi điện nước hiện trường (Ảnh 10 / SCR-TECH-03)
     */
    public function utilities(): View
    {
        return view('tech.utilities.index');
    }

    /**
     * Lưu chỉ số điện nước đã ghi nhận
     */
    public function utilitiesStore(Request $request): RedirectResponse
    {
        return redirect()->route('tech.utilities')
            ->with('success', 'Đã lưu thành công chỉ số điện nước kỳ 03/2026!');
    }
}
