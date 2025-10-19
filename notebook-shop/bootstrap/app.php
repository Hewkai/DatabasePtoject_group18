<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Providers\Filament\AdminPanelProvider;
use App\Http\Middleware\AdminOnly; // << เพิ่ม use ของมิดเดิลแวร์

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withProviders([
        RouteServiceProvider::class, // ให้ Breeze/Filament redirect หลัง login ไปที่ HOME ('/')
        AdminPanelProvider::class,   // Filament แอดมินพาเนล (ถ้าใช้)
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        // ลงทะเบียน alias มิดเดิลแวร์สำหรับใช้งานใน routes
        $middleware->alias([
            'admin' => AdminOnly::class, // ใช้ใน routes: ->middleware('admin')
        ]);

        // ถ้าต้องการให้ติดกับกลุ่ม web เสมอ (ไม่จำเป็นต้องใส่ปกติ)
        // $middleware->appendToGroup('web', [AdminOnly::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // จัดการ exception เพิ่มได้ที่นี่
    })
    ->create();
