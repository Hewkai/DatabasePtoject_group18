<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Providers\Filament\AdminPanelProvider;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withProviders([
        RouteServiceProvider::class,      // ให้ Breeze/Filament redirect หลัง login ไปที่ HOME ('/')
        AdminPanelProvider::class,        // Filament แอดมินพาเนล
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        // สมัคร middleware เพิ่มได้ที่นี่
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // จัดการ exception เพิ่มได้ที่นี่
    })
    ->create();
