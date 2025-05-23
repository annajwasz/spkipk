<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MahasiswaResource\Pages;
use App\Filament\Resources\MahasiswaResource\RelationManagers;
use App\Models\Mahasiswa;
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

class MahasiswaResource extends Resource
{
    protected static ?string $model = Mahasiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Data Master';
    // protected static ?string $navigationLabel = 'Mahasiswa';
    // protected static ?string $modelLabel = 'Mahasiswa';
    // protected static ?string $pluralModelLabel = 'Mahasiswa';
    protected static ?string $slug = 'mahasiswa';
    protected static ?int $navigationSort = 3;//buat urutannya
    
    public static function canCreate(): bool
    {
        return false;
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('noreg_kipk')
                    ->label('No. Registrasi KIP-K')
                    ->required(),
                TextInput::make('nama')
                    ->required(),
                TextInput::make('NIM')
                    ->label('NIM')
                    ->required(),
                Select::make('jurusan_id')
                    ->label('Jurusan')
                    ->relationship('jurusan', 'nama')
                    ->required(),
                Select::make('prodi_id')
                    ->label('Program Studi')
                    ->relationship('prodi', 'nama')
                    ->required(),
                Select::make('akreditasi')
                    ->label('Akreditasi Program Studi')
                    ->relationship('prodi', 'akreditasi')
                    ->required(),
                TextInput::make('angkatan')
                    ->required(),
                TextInput::make('jalur_masuk')
                    ->required(),
                TextInput::make('ponsel')
                    ->required(),
                TextInput::make('alamat')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('noreg_kipk')
                    ->label('No. Registrasi KIP-K'),
                TextColumn::make('nama')
                    ->searchable(),
                    // ->shortable(), //biar urut berdasarkan abjad
                TextColumn::make('NIM')
                    ->label('NIM'),
                TextColumn::make('jurusan.nama')->label('Jurusan'),
                TextColumn::make('prodi.nama')->label('Program Studi'),
                TextColumn::make('prodi.akreditasi')->label('Akreditasi Prodi'),
                TextColumn::make('angkatan'),
                TextColumn::make('jalur_masuk'),
                TextColumn::make('ponsel'),
                TextColumn::make('alamat'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMahasiswas::route('/'),
            'create' => Pages\CreateMahasiswa::route('/create'),
            'edit' => Pages\EditMahasiswa::route('/{record}/edit'),
        ];
    }
}
