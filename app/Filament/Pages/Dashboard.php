<?php

namespace App\Filament\Pages;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $title = 'Beranda';

    public function getWidgets(): array
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->hasRole('mahasiswa')) { {
                return [
                    \App\Filament\Widgets\CustomAccountWidget::class,
                ];
            }
        }
        return Filament::getWidgets();
    }
}
