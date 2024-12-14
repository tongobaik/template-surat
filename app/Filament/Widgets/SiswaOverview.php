<?php

namespace App\Filament\Widgets;

use App\Models\Siswa;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class SiswaOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Siswa', Siswa::query()->count())
                ->icon('heroicon-m-academic-cap')
                ->color('primary'),
            Stat::make('Sudah Verifikasi', Siswa::query()->where('status_verval', true)->count())
                ->icon('heroicon-m-check-badge')
                ->color('success'),
            Stat::make('Belum Verifikasi', Siswa::query()->where('status_verval', false)->count())
                ->icon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
