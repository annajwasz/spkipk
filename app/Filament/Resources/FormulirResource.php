<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormulirResource\Pages;
use App\Filament\Resources\FormulirResource\RelationManagers;
use App\Models\Formulir;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;

class FormulirResource extends Resource
{
    protected static ?string $model = Formulir::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $slug = 'daftar-formulir';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required(),//kolom wajib diisi
                DatePicker::make('tgl_pembuatan')
                    ->label('Tanggal')
                    ->required(),
                TextInput::make('kuota'),
                Select::make('status')
                    ->options([
                        'dibuka' => 'Dibuka',
                        'ditutup' => 'Ditutup'
                    ])
                    ->default('dibuka')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama'),
                TextColumn::make('tgl_pembuatan')
                    ->label('Tanggal'),
                TextColumn::make('kuota'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'dibuka' => 'success',
                        'ditutup' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('toggleStatus')
                    ->label(fn (Formulir $record): string => $record->status === 'dibuka' ? 'Tutup' : 'Buka')
                    ->icon(fn (Formulir $record): string => $record->status === 'dibuka' ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn (Formulir $record): string => $record->status === 'dibuka' ? 'danger' : 'success')
                    ->action(function (Formulir $record): void {
                        $record->update([
                            'status' => $record->status === 'dibuka' ? 'ditutup' : 'dibuka'
                        ]);
                    }),
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
            'index' => Pages\ListFormulirs::route('/'),
            'create' => Pages\CreateFormulir::route('/create'),
            'edit' => Pages\EditFormulir::route('/{record}/edit'),
        ];
    }
}
