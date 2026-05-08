<?php

namespace App\Providers\Filament;

use App\Filament\Auth\Pages\CustomLogin;
use App\Filament\Widgets\AccountWidget as WidgetsAccountWidget;
use App\Models\User;
use AzGasim\FilamentUnsavedChangesModal\FilamentUnsavedChangesModalPlugin;
use DutchCodingCompany\FilamentDeveloperLogins\FilamentDeveloperLoginsPlugin;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(CustomLogin::class)
            ->profile(isSimple: false)
            ->colors([
                'primary' => Color::Blue,
            ])
            ->userMenuItems([
                Action::make('go-to-knowledge-base')
                    ->label('Go to Knowledge Base')
                    ->icon('heroicon-o-book-open')
                    ->url(fn(): string => route('knowledge-base'))
                    ->visible(fn(): bool => !auth()->user()?->must_change_password),
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->font('Poppins')
            ->emailVerification()
            ->emailChangeVerification()
            ->passwordReset()
            ->unsavedChangesAlerts()
            ->sidebarCollapsibleOnDesktop()
            ->resourceCreatePageRedirect('index')
            ->resourceEditPageRedirect('index')
            ->brandLogo(asset('mocsblue.png'))
            ->darkModeBrandLogo(asset('mocswhite.png'))
            ->brandLogoHeight('55px')
            ->plugins([
                FilamentUnsavedChangesModalPlugin::make()
                    ->modalWidth('lg'),
                FilamentDeveloperLoginsPlugin::make()
                    ->enabled(app()->environment('local'))
                    ->switchable(false)
                    ->users(fn() => User::pluck('email', 'name')->toArray()),
            ])  
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                WidgetsAccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
