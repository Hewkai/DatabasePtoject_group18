<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * ถ้าไม่ได้ auth และไม่ได้ขอ JSON ให้ redirect ไปหน้า login ของแอดมิน
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : '/admin/login';
    }
}
