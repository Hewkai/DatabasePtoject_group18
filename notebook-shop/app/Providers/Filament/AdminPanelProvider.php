<?php

namespace App\Providers\Filament; 

use Filament\Panel;
use Filament\PanelProvider;

use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use App\Http\Middleware\VerifyCsrfToken;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()               // หรือชื่อ panel ของคุณ
            ->id('admin')
            ->path('admin')
            ->brandName('Notebook Shop Admin')
            ->authGuard('web')        // << สำคัญ: ให้ใช้ guard 'web'
            ->login()                 // ใช้หน้าล็อกอินของ Filament

            // สแกน Resource / Page / Widget อัตโนมัติ
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')

            // Middleware พื้นฐานให้ทำงานในพาเนล
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
            ])

            // ใช้ middleware auth ของแอปสำหรับการป้องกันหลังบ้าน
            ->authMiddleware([
                \App\Http\Middleware\Authenticate::class,
            ]);
    }
}
