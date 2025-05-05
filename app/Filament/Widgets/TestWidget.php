<?php

namespace App\Filament\Widgets;

use App\Models\Kriteria;
use App\Models\Mahasiswa;
use App\Models\SubKriteria;
use App\Models\parameter;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Kriteria', Kriteria::count()),
            Stat::make('SubKriteria', Subkriteria::count()),
            Stat::make('Jumlah Pendaftar', Mahasiswa::has('parameter')->count())
                ->description('Total Mahasiswa yang telah mendaftar')
                ->color('info')
                ->chart(Mahasiswa::has('parameter')
                    ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->pluck('total')
                    ->toArray()),
            Stat::make('Validasi Data', Parameter::whereIn('status', ['valid', 'tidak_valid'])->count() . '/' . Parameter::count())
                ->description('Total data yang telah divalidasi')
                // ->descriptionIcon('heroicon-m-check-circle')
                ->color('info')
                ->chart(Parameter::selectRaw('DATE(created_at) as date, COUNT(*) as total')
                    ->whereIn('status', ['valid', 'tidak_valid'])
                    ->groupBy('date')
                    ->orderBy('date')
                    ->pluck('total')
                    ->toArray()),

        ];
    }
}
