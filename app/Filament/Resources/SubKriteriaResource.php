<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubKriteriaResource\Pages;
use App\Filament\Resources\SubKriteriaResource\RelationManagers;
use App\Models\SubKriteria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;


class SubKriteriaResource extends Resource
{
    protected static ?string $model = SubKriteria::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Data Master';
    
    // Tambahkan ini untuk mengubah label navigasi
    // protected static ?string $navigationLabel = 'Sub Kriteria';
    
    // // Tambahkan ini untuk mengubah label model
    // protected static ?string $modelLabel = 'Sub Kriteria';
    
    // // Tambahkan ini untuk mengubah label plural
    // protected static ?string $pluralModelLabel = 'Sub Kriteria';
    protected static ?string $slug = 'sub-kriteria';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('kriteria_id')
                    ->relationship('kriteria', 'nama')
                    ->label('Kriteria')
                    ->required()
                    ->searchable(),
                TextInput::make('nama')
                    ->label('Sub Kriteria')
                    ->required(),
                TextInput::make('deskripsi')
                    ->required(),
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
            ->defaultSort('kriteria_id', 'prioritas')
            ->filters([
                //
            ])
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
            'index' => Pages\ListSubKriterias::route('/'),
            'create' => Pages\CreateSubKriteria::route('/create'),
            'edit' => Pages\EditSubKriteria::route('/{record}/edit'),
        ];
    }
}
