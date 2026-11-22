<?php

namespace App\Http\Controllers;

use App\DTOs\AccountDTO;
use App\Exceptions\BusinessException;
use App\Http\Requests\Account\StoreAccountRequest;
use App\Http\Requests\Account\UpdateAccountRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Danh sách tài khoản nhân sự nội bộ (SCR-ACC-01).
     */
    public function index(Request $request): View
    {
        $query = User::where('IsDeleted', false);

        // Lọc theo vai trò
        $roleFilter = $request->query('role', 'INTERNAL');
        if ($roleFilter === 'INTERNAL') {
            $query->whereIn('Role', ['MANAGER', 'SUPPORT', 'TECHNICIAN', 'SECURITY']);
        } elseif ($roleFilter === 'RESIDENT') {
            $query->where('Role', 'RESIDENT');
        } elseif ($roleFilter !== 'ALL' && $roleFilter !== '') {
            $query->where('Role', $roleFilter);
        }

        // Lọc theo từ khóa: Họ tên / Tên đăng nhập / Email
        if ($request->filled('keyword')) {
            $kw = trim((string) $request->query('keyword'));
            $query->where(function ($q) use ($kw): void {
                $q->where('FullName', 'like', "%{$kw}%")
                    ->orWhere('UserName', 'like', "%{$kw}%")
                    ->orWhere('Email', 'like', "%{$kw}%")
                    ->orWhere('Phone', 'like', "%{$kw}%");
            });
        }

        $accounts = $query->orderBy('UserId')->paginate(10)->withQueryString();

        return view('accounts.index', [
            'accounts' => $accounts,
        ]);
    }

    /**
     * Xem chi tiết tài khoản (SCR-ACC-02).
     */
    public function show(int $id): View
    {
        $account = User::where('IsDeleted', false)->findOrFail($id);

        return view('accounts.show', [
            'account' => $account,
        ]);
    }

    /**
     * Mở form thêm tài khoản mới (SCR-ACC-03).
     */
    public function create(): View
    {
        return view('accounts.create');
    }

    /**
     * Lưu tài khoản mới vào cơ sở dữ liệu.
     */
    public function store(StoreAccountRequest $request): RedirectResponse
    {
        $dto = AccountDTO::fromStoreRequest($request);

        $account = User::create($dto->toModelArray());

        return redirect()->route('accounts.index')
            ->with('success', "Đã tạo tài khoản '{$account->UserName}' ({$account->FullName}) thành công.");
    }

    /**
     * Chỉnh sửa tài khoản (SCR-ACC-04).
     */
    public function edit(int $id): View
    {
        $account = User::where('IsDeleted', false)->findOrFail($id);

        return view('accounts.edit', [
            'account' => $account,
        ]);
    }

    /**
     * Cập nhật thông tin tài khoản.
     */
    public function update(int $id, UpdateAccountRequest $request): RedirectResponse
    {
        $account = User::where('IsDeleted', false)->findOrFail($id);

        $dto = AccountDTO::fromUpdateRequest($request, $account->UserName);
        $account->update($dto->toModelArray());

        return redirect()->route('accounts.show', $account->UserId)
            ->with('success', "Đã lưu thay đổi thông tin tài khoản '{$account->UserName}' thành công.");
    }

    /**
     * Màn hình Khóa tài khoản (SCR-ACC-05).
     */
    public function lock(int $id): View
    {
        $account = User::where('IsDeleted', false)->findOrFail($id);

        return view('accounts.lock', [
            'account' => $account,
        ]);
    }

    /**
     * Xác nhận khóa tài khoản với kiểm tra quy định nghiệp vụ.
     */
    public function confirmLock(int $id, Request $request): RedirectResponse
    {
        $account = User::where('IsDeleted', false)->findOrFail($id);

        // Không cho phép tự khóa tài khoản của chính mình
        if ($account->UserId === auth()->id()) {
            throw new BusinessException('Bạn không thể tự khóa tài khoản đang đăng nhập của chính mình.');
        }

        // Không cho phép khóa Quản lý duy nhất còn hoạt động
        if ($account->Role === 'MANAGER') {
            $activeManagersCount = User::where('Role', 'MANAGER')
                ->where('Status', 'ACTIVE')
                ->where('IsDeleted', false)
                ->count();

            if ($activeManagersCount <= 1) {
                throw new BusinessException('Không thể khóa tài khoản Quản lý duy nhất còn hoạt động của tòa nhà.');
            }
        }

        $account->update(['Status' => 'LOCKED']);

        return redirect()->route('accounts.index')
            ->with('success', "Đã khóa tài khoản '{$account->UserName}' thành công.");
    }

    /**
     * Màn hình Mở khóa tài khoản (SCR-ACC-06).
     */
    public function unlock(int $id): View
    {
        $account = User::where('IsDeleted', false)->findOrFail($id);

        return view('accounts.unlock', [
            'account' => $account,
        ]);
    }

    /**
     * Xác nhận mở khóa tài khoản.
     */
    public function confirmUnlock(int $id, Request $request): RedirectResponse
    {
        $account = User::where('IsDeleted', false)->findOrFail($id);

        $account->update(['Status' => 'ACTIVE']);

        return redirect()->route('accounts.index')
            ->with('success', "Đã mở khóa tài khoản '{$account->UserName}' thành công.");
    }
}
