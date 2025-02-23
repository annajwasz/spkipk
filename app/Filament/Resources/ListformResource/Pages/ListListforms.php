<?php

namespace App\Filament\Resources\ListformResource\Pages;

use App\Filament\Resources\ListformResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListListforms extends ListRecords
{
    protected static string $resource = ListformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
