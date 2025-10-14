<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        // ถ้าเข้าหน้า /admin/login แล้วล็อกอินอยู่ ให้เด้งเข้าหน้า /admin
        if ($request->user()) {
            return redirect('/admin');
        }

        return $next($request);
    }
}
