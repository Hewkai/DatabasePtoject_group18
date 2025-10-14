<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/'; // ← ให้กลับหน้าแรกหลัง login / register
}
