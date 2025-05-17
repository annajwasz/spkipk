<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HasilResource\Pages;
use App\Models\Parameter;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class HasilResource extends Resource
{
    protected static ?string $model = Parameter::class;
    public static $kuota = 0;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Penilaian';
    protected static ?string $navigationLabel = 'Hasil Penilaian';
    protected static ?int $navigationSort = 2;
    protected static ?string $slug = 'hasil-penilaian';
    
    protected static ?string $modelLabel = 'Hasil Penilaian';
    protected static ?string $pluralModelLabel = 'Hasil Penilaian';
    protected static ?string $breadcrumb = 'Hasil Penilaian';

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Tables\Actions\Action::make('exportPdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('info')
                    ->action(function () {
                        $data = Parameter::with(['mahasiswa.jurusan', 'mahasiswa.prodi'])
                            ->where('status', 'valid')
                            ->orderBy('total_nilai', 'desc')
                            ->get();

                        $pdf = \PDF::loadView('exports.hasil-penilaian', [
                            'data' => $data,
                            'title' => 'Hasil Penilaian KIPK',
                            'date' => now()->format('d F Y'),
                        ]);

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'hasil-penilaian-' . now()->format('Y-m-d') . '.pdf');
                    }),

                Tables\Actions\Action::make('akreditasiA')
                    ->label('Set Akreditasi A')
                    ->url(fn () => route('filament.admin.resources.hasil-penilaian.akreditasi-a'))
                    ->color('success')
                    ->icon('heroicon-o-bookmark'),
                    
                Tables\Actions\Action::make('akreditasiB')
                    ->label('Set Akreditasi B')
                    ->url(fn () => route('filament.admin.resources.hasil-penilaian.akreditasi-b'))
                    ->color('warning')
                    ->icon('heroicon-o-bookmark'),
                    
                Tables\Actions\Action::make('akreditasiC')
                    ->label('Set Akreditasi C')
                    ->url(fn () => route('filament.admin.resources.hasil-penilaian.akreditasi-c'))
                    ->color('danger')
                    ->icon('heroicon-o-bookmark'),
            ])
            ->modifyQueryUsing(fn ($query) => $query->where('status', 'valid'))
            ->columns([
                TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex(false)
                    ->alignCenter(),
                    
                TextColumn::make('mahasiswa.nama')
                    ->label('Nama Mahasiswa')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('mahasiswa.jurusan.nama')
                    ->label('Jurusan')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('mahasiswa.prodi.nama')
                    ->label('Program Studi')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('mahasiswa.prodi.akreditasi')
                    ->label('Akreditasi Prodi')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('total_nilai')
                    ->label('Total Nilai')
                    ->formatStateUsing(fn ($state) => number_format($state, 4))
                    ->sortable(),
                    
                TextColumn::make('hasil')
                    ->label('Hasil')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Diterima' => 'success',
                        'Tidak Diterima' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('total_nilai', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('hasil')
                    ->options([
                        'Diterima' => 'Diterima',
                        'Tidak Diterima' => 'Tidak Diterima',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHasil::route('/'),
            'akreditasi-a' => Pages\HasilAkreditasiA::route('/akreditasi-a'),
            'akreditasi-b' => Pages\HasilAkreditasiB::route('/akreditasi-b'),
            'akreditasi-c' => Pages\HasilAkreditasiC::route('/akreditasi-c'),
        ];
    }
} 