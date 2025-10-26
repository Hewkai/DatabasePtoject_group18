<?php

namespace App\Providers\Filament; 

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use Filament\Support\Facades\FilamentColor;

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
            ->default()
            ->id('admin')
            ->path('admin')

            ->brandName('COMP Admin')
            ->brandLogoHeight('2.5rem')
            ->favicon(asset('images/favicon.png'))
            
            ->colors([
                'primary' => Color::Blue,
                'gray' => Color::Slate,
                'success' => Color::Green,
                'warning' => Color::Amber,
                'danger' => Color::Red,
            ])
            
            ->font('Inter')
            
            ->darkMode(false)
            
            ->sidebarWidth('16rem')
            ->sidebarCollapsibleOnDesktop()
            
            ->maxContentWidth('full')
            
            ->authGuard('web')
            ->login()
            
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
            ])
            ->authMiddleware([
                \App\Http\Middleware\Authenticate::class,
            ])
            
            ->navigationGroups([
                'Quick Links',
                'Products Management',
                'Settings',
            ])

            ->navigationItems([
                NavigationItem::make('Back to Website')
                    ->url('/', shouldOpenInNewTab: false)
                    ->icon('heroicon-o-home')
                    ->group('Quick Links')
                    ->sort(-2),
                NavigationItem::make('Admin Dashboard')
                    ->url('/admin/dashboard', shouldOpenInNewTab: false)
                    ->icon('heroicon-o-chart-bar')
                    ->group('Quick Links')
                    ->sort(-1),
            ])

            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])

            ->renderHook(
                'panels::body.end',
                fn (): string => '<style>
                    .fi-sidebar {
                        background: white !important;
                        border-right: 1px solid #e5e7eb !important;
                    }
                    
                    /* แยก Quick Links ให้ชัดเจน */
                    .fi-sidebar-group:first-child {
                        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important;
                        margin: 0.5rem !important;
                        padding: 0.75rem !important;
                        border-radius: 1rem !important;
                        border: 2px solid #93c5fd !important;
                        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.1) !important;
                    }
                    
                    .fi-sidebar-group:first-child .fi-sidebar-group-label {
                        color: #1e40af !important;
                        font-weight: 700 !important;
                        font-size: 0.8rem !important;
                        text-transform: uppercase !important;
                        letter-spacing: 0.05em !important;
                        margin-bottom: 0.5rem !important;
                    }
                    
                    .fi-sidebar-group:first-child .fi-sidebar-item {
                        background: white !important;
                        border: 1px solid #bfdbfe !important;
                        margin: 0.25rem 0 !important;
                        font-weight: 600 !important;
                    }
                    
                    .fi-sidebar-group:first-child .fi-sidebar-item:hover {
                        background: white !important;
                        border-color: #2563eb !important;
                        transform: translateX(4px) scale(1.02) !important;
                        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2) !important;
                    }
                    
                    .fi-sidebar-group:first-child .fi-sidebar-item svg {
                        color: #2563eb !important;
                    }
                    
                    /* เส้นแบ่งหลัง Quick Links */
                    .fi-sidebar-group:first-child::after {
                        content: "" !important;
                        display: block !important;
                        height: 2px !important;
                        background: linear-gradient(to right, #dbeafe, transparent) !important;
                        margin: 1rem 0 0.5rem 0 !important;
                    }
                    
                    .fi-sidebar-item {
                        border-radius: 0.75rem !important;
                        margin: 0.25rem 0.5rem !important;
                        transition: all 0.2s ease !important;
                    }
                    
                    .fi-sidebar-item:hover {
                        background: #f3f4f6 !important;
                        transform: translateX(4px) !important;
                    }
                    
                    .fi-sidebar-item-active {
                        background: #eff6ff !important;
                        color: #2563eb !important;
                        font-weight: 600 !important;
                    }
                    
                    .fi-topbar {
                        background: white !important;
                        border-bottom: 1px solid #e5e7eb !important;
                    }
                    
                    .fi-btn-primary {
                        background: #2563eb !important;
                        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.3) !important;
                    }
                    
                    .fi-btn-primary:hover {
                        background: #1d4ed8 !important;
                        transform: translateY(-1px) !important;
                    }
                    
                    .fi-section {
                        border-radius: 1rem !important;
                        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1) !important;
                    }

                    .fi-ta-row:hover {
                        background: #f9fafb !important;
                    }

                    .fi-input {
                        border-radius: 0.5rem !important;
                    }
                    
                    .fi-input:focus {
                        border-color: #2563eb !important;
                        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
                    }
                </style>'
            );
    }
}