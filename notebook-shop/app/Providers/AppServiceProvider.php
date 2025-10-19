<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Filament\Facades\Filament; 

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // แปะปุ่มไว้ท้ายหัวข้อ action ของทุกหน้า
        FilamentView::registerRenderHook(
            PanelsRenderHook::PAGE_HEADER_ACTIONS_AFTER,
            function (): string {
                // จำกัดให้เฉพาะ panel id = 'admin' (ถ้ามีหลาย panel)
                $panel = Filament::getCurrentPanel();
                if ($panel?->getId() !== 'admin') {
                    return '';
                }

                return view('filament.parts.back-to-overview')->render();
            }
        );
    }
}
