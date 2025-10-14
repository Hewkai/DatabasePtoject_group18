<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * URI ที่ยกเว้น CSRF (อย่าใส่ /admin)
     */
    protected $except = [
        'api/*',
    ];
}
