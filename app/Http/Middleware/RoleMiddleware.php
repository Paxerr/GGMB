<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('login');
        }

        if (empty($roles)) {
            return $next($request);
        }

        $allowedRoles = array_map('strtoupper', $roles);
        $userRole = strtoupper((string) ($user->Role ?? ''));

        // Quản lý (MANAGER hoặc ADMIN) có toàn quyền quản trị và giám sát các phân hệ
        if (in_array($userRole, ['MANAGER', 'ADMIN'], true)) {
            return $next($request);
        }

        if (! in_array($userRole, $allowedRoles, true)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Bạn không có quyền thực hiện thao tác này.'], 403);
            }

            abort(403, 'Tài khoản của bạn không có quyền truy cập chức năng này.');
        }

        return $next($request);
    }
}
