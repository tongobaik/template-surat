<?php

namespace App\Filament\Widgets;

use App\Models\Kelas;
use App\Models\Siswa;
use Filament\Widgets\ChartWidget;

class SiswaPerTingkatChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Siswa Per Tingkat';

    protected function getData(): array
    {
        $kelasVII = Siswa::whereHas('kelas', function ($query) {
            $query->where('tingkat', 'VII');
        })->count();

        $kelasVIII = Siswa::whereHas('kelas', function ($query) {
            $query->where('tingkat', 'VIII');
        })->count();

        $kelasIX = Siswa::whereHas('kelas', function ($query) {
            $query->where('tingkat', 'IX');
        })->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Siswa',
                    'data' => [$kelasVII, $kelasVIII, $kelasIX],
                    'backgroundColor' => ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                    'borderColor' => ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                    'borderWidth' => 3,
                ],
            ],
            'labels' => ['Kelas VII', 'Kelas VIII', 'Kelas IX'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
