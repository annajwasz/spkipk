<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HasilResource\Pages;
use App\Filament\Resources\HasilResource\RelationManagers;
use App\Models\Hasil;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class HasilResource extends Resource
{
    protected static ?string $model = Hasil::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Penilaian';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('mahasiswa_id')
                    ->label('Mahasiswa')
                    ->relationship('mahasiswa', 'nama')
                    ->searchable()
                    ->required(),

                TextInput::make('total_bobot')
                    ->label('Total Bobot')
                    ->numeric()
                    ->readOnly(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Layak' => 'Layak',
                        'Dipertimbangkan' => 'Dipertimbangkan',
                        'Tidak Layak' => 'Tidak Layak',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                    TextColumn::make('mahasiswa.nama')
                        ->label('Nama Mahasiswa')
                        ->sortable()
                        ->searchable(),
    
                    TextColumn::make('total_bobot')
                        ->label('Total Bobot')
                        ->sortable(),
    
                    TextColumn::make('status')
                        ->label('Status')
                        ->badge()
                        ->color(fn ($record) => match ($record->status) {
                            'Layak' => 'success',
                            'Dipertimbangkan' => 'warning',
                            'Tidak Layak' => 'danger',
                        }),
                
               
            ])
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
            'index' => Pages\ListHasils::route('/'),
            'create' => Pages\CreateHasil::route('/create'),
            'edit' => Pages\EditHasil::route('/{record}/edit'),
        ];
    }
}
