<?php

namespace App\Filament\Resources\Users\Widgets;

use App\Models\User;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::withoutRole('admin')->count())
                ->icon('heroicon-o-user-group'),
            Stat::make('User Roles', User::role('user')->count())
                ->icon('heroicon-o-user'),
            Stat::make('Active Users', User::withoutRole('admin')->where('is_active', true)->count())
                ->icon('heroicon-o-user'),
        ];
    }
}
