<?php

// namespace App\Filament\Resources;

// use App\Filament\Resources\PengumumanResource\Pages;
// use App\Models\Parameter;
// use Filament\Forms\Form;
// use Filament\Resources\Resource;
// use Filament\Tables;
// use Filament\Tables\Table;
// use Filament\Tables\Columns\TextColumn;
// use Filament\Tables\Columns\ViewColumn;
// use Illuminate\Database\Eloquent\Builder;

// class PengumumanResource extends Resource
// {
//     protected static ?string $model = Parameter::class;

//     protected static ?string $navigationIcon = 'heroicon-o-document-text';
//     protected static ?string $navigationGroup = 'Penilaian';
//     protected static ?string $navigationLabel = 'Pengumuman';
//     protected static ?int $navigationSort = 3;
//     protected static ?string $slug = 'pengumuman';

//     protected static ?string $modelLabel = 'Pengumuman';
//     protected static ?string $pluralModelLabel = 'Pengumuman';
//     protected static ?string $breadcrumb = 'Pengumuman';

//     public static function table(Table $table): Table
//     {
//         return $table
//             ->columns([
//                 TextColumn::make('mahasiswa.nama')
//                     ->label('Nama Mahasiswa')
//                     ->searchable()
//                     ->sortable(),

//                 TextColumn::make('status')
//                     ->label('Status Berkas')
//                     ->badge()
//                     ->color(fn (string $state): string => match ($state) {
//                         'valid' => 'success',
//                         'tidak_valid' => 'danger',
//                         'belum_validasi' => 'warning',
//                         default => 'gray',
//                     }),

//                 TextColumn::make('hasil')
//                     ->label('Hasil Seleksi')
//                     ->badge()
//                     ->color(fn (string $state): string => match ($state) {
//                         'Layak' => 'success',
//                         'Dipertimbangkan' => 'warning',
//                         'Tidak Layak' => 'danger',
//                         default => 'gray',
//                     }),

//                 ViewColumn::make('keterangan')
//                     ->label('Keterangan')
//                     ->view('filament.tables.columns.keterangan-pengumuman'),
//             ])
//             ->defaultSort('total_nilai', 'desc')
//             ->modifyQueryUsing(function (Builder $query): Builder {
//                 $user = auth()->user();
//                 if ($user->roles[0]->name == 'Mahasiswa') {
//                     return $query->where('mahasiswa_id', $user->id);
//                 }
//                 return $query;
//             });
//     }

//     public static function getPages(): array
//     {
//         return [
//             'index' => Pages\ListPengumuman::route('/'),
//         ];
//     }
// }
