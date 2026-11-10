<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Chưa đăng nhập thì chuyển đến trang đăng nhập
        if (! $request->user()) {
            return redirect()->guest(route('login'));
        }
        if ($request->user()->status !== 'active') {
             abort(403, 'Tài khoản của bạn hiện không hoạt động.');
        }
        // Ánh xạ tên role sang role_id trong database
        $roleNames = [
            'admin' => 1,
            'staff' => 2,
            'customer' => 3,
        ];

        $allowedRoleIds = [];

        foreach ($roles as $role) {
            if (isset($roleNames[$role])) {
                $allowedRoleIds[] = $roleNames[$role];
            }
        }

        if (
            empty($allowedRoleIds) ||
            ! in_array((int) $request->user()->role_id, $allowedRoleIds, true)
        ) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }

        return $next($request);
    }
}
