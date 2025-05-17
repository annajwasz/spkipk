<?php

namespace App\Filament\Resources\HasilResource\Pages;

use App\Filament\Resources\HasilResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\DB;
use App\Models\Parameter;

class HasilAkreditasiC extends ListRecords
{
    protected static string $resource = HasilResource::class;

    protected static ?string $title = 'Hasil Penilaian Akreditasi C';

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Action::make('setKuota')
                    ->label('Set Kuota Penerimaan')
                    ->form([
                        TextInput::make('kuota')
                            ->label('Jumlah Kuota')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->helperText('Masukkan jumlah kuota penerimaan untuk akreditasi C.'),
                    ])
                    ->action(function (array $data): void {
                        DB::beginTransaction();
                        try {
                            // Reset hasil untuk akreditasi C
                            Parameter::whereHas('mahasiswa.prodi', function ($query) {
                                $query->where('akreditasi', 'C');
                            })->update(['hasil' => 'Tidak Diterima']);

                            // Ambil data parameter yang valid dengan akreditasi C
                            $validParameters = Parameter::where('status', 'valid')
                                ->whereHas('mahasiswa.prodi', function ($query) {
                                    $query->where('akreditasi', 'C');
                                })
                                ->orderBy('total_nilai', 'desc')
                                ->get();

                            $kuota = (int) $data['kuota'];
                            $index = 0;

                            foreach ($validParameters as $parameter) {
                                if ($index < $kuota) {
                                    DB::table('parameters')
                                        ->where('id', $parameter->id)
                                        ->update(['hasil' => 'Diterima']);
                                }
                                $index++;
                            }

                            DB::commit();

                            Notification::make()
                                ->title("Berhasil mengatur kuota penerimaan untuk {$kuota} mahasiswa akreditasi C")
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            DB::rollBack();
                            Notification::make()
                                ->title('Terjadi kesalahan: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Set Kuota Penerimaan Akreditasi C')
                    ->modalDescription('Apakah Anda yakin ingin mengatur kuota penerimaan untuk akreditasi C?')
                    ->modalSubmitActionLabel('Ya, Set Kuota')
                    ->successNotificationTitle('Kuota berhasil diatur'),

                Action::make('resetKuota')
                    ->label('Reset')
                    ->color('danger')
                    ->icon('heroicon-o-arrow-path')
                    ->action(function (): void {
                        DB::beginTransaction();
                        try {
                            Parameter::whereHas('mahasiswa.prodi', function ($query) {
                                $query->where('akreditasi', 'C');
                            })->update(['hasil' => null]);

                            DB::commit();

                            Notification::make()
                                ->title('Berhasil mereset hasil kuota penerimaan')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            DB::rollBack();
                            Notification::make()
                                ->title('Terjadi kesalahan: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Reset Kuota Penerimaan')
                    ->modalDescription('Apakah Anda yakin ingin mereset hasil kuota penerimaan? Semua hasil akan dikosongkan.')
                    ->modalSubmitActionLabel('Ya, Reset Kuota')
                    ->successNotificationTitle('Kuota berhasil direset'),
            ])
            ->modifyQueryUsing(fn ($query) => $query->where('status', 'valid')
                ->whereHas('mahasiswa.prodi', function ($query) {
                    $query->where('akreditasi', 'C');
                }))
            ->columns([
                TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex(false)
                    ->alignCenter(),
                    
                TextColumn::make('mahasiswa.nama')
                    ->label('Nama Mahasiswa')
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
                \Filament\Tables\Filters\SelectFilter::make('hasil')
                    ->options([
                        'Diterima' => 'success',
                        'Tidak Diterima' => 'danger',
                    ]),
            ]);
    }
}