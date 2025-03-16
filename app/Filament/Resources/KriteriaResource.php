<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KriteriaResource\Pages;
use App\Filament\Resources\KriteriaResource\RelationManagers;
use App\Models\Kriteria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class KriteriaResource extends Resource
{
    protected static ?string $model = Kriteria::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Data Master';
    // protected static ?string $navigationLabel = 'Kriteria';
    // protected static ?string $modelLabel = 'Kriteria';
    // protected static ?string $pluralModelLabel = 'Kriteria';
    protected static ?string $slug = 'kriteria';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required()
                    ->label('Nama Kriteria'),
                TextInput::make('prioritas')
                    ->numeric()
                    ->required()
                    ->label('Prioritas (Urutan)')
                    ->helperText('Masukkan angka prioritas (1 untuk prioritas tertinggi)'),
                TextInput::make('bobot')
                    ->disabled()
                    ->helperText('Bobot akan dihitung otomatis menggunakan metode SMARTER'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Kriteria')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('prioritas')
                    ->label('Prioritas')
                    ->sortable(),
                TextColumn::make('bobot')
                    ->label('Bobot')
                    ->formatStateUsing(fn ($state) => number_format($state, 4))
                    ->sortable(),
            ])
            ->defaultSort('prioritas')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKriterias::route('/'),
            'create' => Pages\CreateKriteria::route('/create'),
            'edit' => Pages\EditKriteria::route('/{record}/edit'),
        ];
    }
}
