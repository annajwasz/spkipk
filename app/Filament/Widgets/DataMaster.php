<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\SubKriteriaResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

use Filament\Tables\Columns\TextColumn;

class DataMaster extends BaseWidget
{
    protected static ?int $sort = 5;
    protected static ?string $maxHeight = null;
    protected int | string | array $columnSpan = 'full';
    protected static bool $isLazy = false;
    
    public function table(Table $table): Table
    {
        return $table
            ->query(SubKriteriaResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->columns([
                TextColumn::make('kriteria.nama')
                ->label('Kriteria')
                ->sortable()
                ->searchable(),
            TextColumn::make('nama')
                ->label('Sub Kriteria')
                ->sortable()
                ->searchable(),
            TextColumn::make('deskripsi')
                ->sortable()
                ->searchable(),
            TextColumn::make('prioritas')
                ->label('Prioritas')
                ->sortable(),
            TextColumn::make('bobot')
                ->label('Bobot')
                ->formatStateUsing(fn ($state) => number_format($state, 4))
                ->sortable(),
            ])
            ->contentGrid([
                'md' => 2,
                'lg' => 3,
                'xl' => 4,
            ])
            ->striped();
    }

    public static function canView(): bool
    {
        return true;
    }
}
