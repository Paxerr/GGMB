<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Danh sách tài khoản nhân sự nội bộ (Bám sát Ảnh Quản trị tài khoản).
     */
    public function index(Request $request): View
    {
        $accounts = collect([
            (object) [
                'id' => 1,
                'name' => 'Nguyễn Minh Quản lý',
                'username' => 'manager01',
                'email' => 'manager01@ggmb.example',
                'phone' => '0900000001',
                'role' => 'Quản lý',
                'status' => 'ACTIVE',
                'status_label' => 'Hoạt động',
                'is_current_user' => true,
            ],
            (object) [
                'id' => 2,
                'name' => 'Trần Thu Hỗ trợ',
                'username' => 'support01',
                'email' => 'support01@ggmb.example',
                'phone' => '0900000002',
                'role' => 'Hỗ trợ',
                'status' => 'ACTIVE',
                'status_label' => 'Hoạt động',
                'is_current_user' => false,
            ],
            (object) [
                'id' => 3,
                'name' => 'Lê Anh Hỗ trợ',
                'username' => 'support02',
                'email' => 'support02@ggmb.example',
                'phone' => '0900000003',
                'role' => 'Hỗ trợ',
                'status' => 'ACTIVE',
                'status_label' => 'Hoạt động',
                'is_current_user' => false,
            ],
            (object) [
                'id' => 4,
                'name' => 'Phạm Hà Hỗ trợ',
                'username' => 'support03',
                'email' => 'support03@ggmb.example',
                'phone' => '0900000004',
                'role' => 'Hỗ trợ',
                'status' => 'ACTIVE',
                'status_label' => 'Hoạt động',
                'is_current_user' => false,
            ],
            (object) [
                'id' => 5,
                'name' => 'Nguyễn Văn Kỹ thuật',
                'username' => 'tech01',
                'email' => 'tech01@ggmb.example',
                'phone' => '0900000005',
                'role' => 'Kỹ thuật',
                'status' => 'ACTIVE',
                'status_label' => 'Hoạt động',
                'is_current_user' => false,
            ],
            (object) [
                'id' => 6,
                'name' => 'Đỗ Quốc Kỹ thuật',
                'username' => 'tech02',
                'email' => 'tech02@ggmb.example',
                'phone' => '0900000006',
                'role' => 'Kỹ thuật',
                'status' => 'ACTIVE',
                'status_label' => 'Hoạt động',
                'is_current_user' => false,
            ],
        ]);

        return view('accounts.index', [
            'accounts' => $accounts,
        ]);
    }

    /**
     * Xem chi tiết tài khoản (Bám sát Ảnh Chi tiết tài khoản).
     */
    public function show(int $id): View
    {
        $account = (object) [
            'id' => $id,
            'name' => 'Trần Thu Hỗ trợ',
            'username' => 'support01',
            'email' => 'support01@ggmb.example',
            'phone' => '0900000002',
            'role' => 'Hỗ trợ',
            'status' => 'ACTIVE',
            'status_label' => 'Đang hoạt động',
            'citizen_id' => null,
            'department' => null,
        ];

        return view('accounts.show', [
            'account' => $account,
        ]);
    }

    /**
     * Mở form thêm tài khoản mới.
     */
    public function create(): View
    {
        return view('accounts.create');
    }

    /**
     * Lưu tài khoản mới.
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('accounts.index')->with('success', 'Tạo tài khoản mới thành công.');
    }

    /**
     * Chỉnh sửa tài khoản (Bám sát Ảnh Chỉnh sửa tài khoản).
     */
    public function edit(int $id): View
    {
        $account = (object) [
            'id' => $id,
            'name' => 'Trần Thu Hỗ trợ',
            'username' => 'support01',
            'email' => 'support01@ggmb.example',
            'phone' => '0900000002',
            'role' => 'Hỗ trợ',
            'citizen_id' => '',
            'department' => '',
        ];

        return view('accounts.edit', [
            'account' => $account,
        ]);
    }

    /**
     * Cập nhật thông tin tài khoản.
     */
    public function update(int $id, Request $request): RedirectResponse
    {
        return redirect()->route('accounts.show', $id)->with('success', 'Lưu thay đổi thông tin tài khoản thành công.');
    }

    /**
     * Màn hình Khóa tài khoản (Bám sát Ảnh Khóa tài khoản).
     */
    public function lock(int $id): View
    {
        $account = (object) [
            'id' => $id,
            'name' => 'Trần Thu Hỗ trợ',
            'username' => 'support01',
            'status' => 'ACTIVE',
            'status_label' => 'Đang hoạt động',
        ];

        return view('accounts.lock', [
            'account' => $account,
        ]);
    }

    /**
     * Xác nhận khóa tài khoản.
     */
    public function confirmLock(int $id, Request $request): RedirectResponse
    {
        return redirect()->route('accounts.index')->with('success', "Đã khóa tài khoản #{$id} thành công.");
    }

    /**
     * Màn hình Mở khóa tài khoản (Bám sát Ảnh Mở khóa tài khoản).
     */
    public function unlock(int $id): View
    {
        $account = (object) [
            'id' => $id,
            'name' => 'Trần Thu Hỗ trợ',
            'username' => 'support01',
            'status' => 'LOCKED',
            'status_label' => 'Bị khóa',
        ];

        return view('accounts.unlock', [
            'account' => $account,
        ]);
    }

    /**
     * Xác nhận mở khóa tài khoản.
     */
    public function confirmUnlock(int $id, Request $request): RedirectResponse
    {
        return redirect()->route('accounts.index')->with('success', "Đã mở khóa tài khoản #{$id} thành công.");
    }
}
