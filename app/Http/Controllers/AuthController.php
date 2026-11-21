<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Hiển thị giao diện đăng nhập GGMB.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Xử lý xác thực đăng nhập.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'UserName' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'UserName.required' => 'Vui lòng nhập tên đăng nhập.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        if (Auth::attempt([
            'UserName' => $credentials['UserName'],
            'password' => $credentials['password'],
            'IsDeleted' => false,
            'Status' => 'ACTIVE',
        ])) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'UserName' => 'Tên đăng nhập hoặc mật khẩu không chính xác, hoặc tài khoản chưa kích hoạt.',
        ])->onlyInput('UserName');
    }

    /**
     * Đăng xuất khỏi hệ thống.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
