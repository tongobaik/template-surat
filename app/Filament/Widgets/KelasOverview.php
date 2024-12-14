<?php

namespace App\Filament\Widgets;

use App\Models\Kelas;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class KelasOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Kelas', Kelas::query()->count())
                ->icon('heroicon-m-building-storefront')
                ->color('primary'),
            Stat::make('Kelas VII', Kelas::query()->where('tingkat', 'VII')->count())
                ->icon('heroicon-m-building-office-2')
                ->color('success'),
            Stat::make('Kelas VIII', Kelas::query()->where('tingkat', 'VIII')->count())
                ->icon('heroicon-m-building-office-2')
                ->color('success'),
            Stat::make('Kelas IX', Kelas::query()->where('tingkat', 'IX')->count())
                ->icon('heroicon-m-building-office-2')
                ->color('success'),
        ];
    }
}
