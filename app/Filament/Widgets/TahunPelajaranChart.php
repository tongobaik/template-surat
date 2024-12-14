<?php

namespace App\Filament\Widgets;

use App\Models\Siswa;
use Flowframe\Trend\Trend;
use App\Models\TahunPelajaran;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class TahunPelajaranChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Siswa';

    protected function getData(): array
    {

        $data = Trend::model(Siswa::class)
            ->between(
                start: now()->subYear(1),
                end: now(),
            )
            ->perYear()
            ->count('id');

        return [
            'datasets' => [
                [
                    'label' => 'Total Siswa per Tahun Pelajaran',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
