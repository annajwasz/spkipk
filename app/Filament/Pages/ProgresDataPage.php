<?php

namespace App\Filament\Pages;

use App\Models\Parameter;
use App\Models\Mahasiswa;
use Filament\Pages\Page;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;
use Filament\Navigation\NavigationItem;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ProgresDataPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Info';
    protected static ?string $navigationGroup = 'Mahasiswa';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.progres-data-page';
    protected static string $routePath = 'progres';

    public function getTitle(): string
    {
        return 'Info';
    }

    public function infolist(Infolist $infolist): Infolist
    {
        $user = auth()->user();
        
        // Cari data mahasiswa berdasarkan user_id
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        
        // Jika mahasiswa ditemukan, cari data parameter
        $data = $mahasiswa ? Parameter::where('mahasiswa_id', $mahasiswa->id)->first() : null;

        // Siapkan state untuk infolist
        $state = [
            'status' => 'Belum Mengisi Form',
            'hasil' => 'Belum Ada Hasil',
            'keterangan' => 'Silahkan lengkapi form pendaftaran KIP-K terlebih dahulu.'
        ];

        // Jika data ada, update state sesuai data di database
        if ($data) {
            $state['status'] = match($data->status) {
                'valid' => 'Berkas Valid',
                'tidak_valid' => 'Berkas Tidak Valid',
                'belum_validasi' => 'Belum Divalidasi',
                default => 'Belum Mengisi Form'
            };

            $state['hasil'] = match($data->hasil) {
                'Diterima' => 'Diterima',
                'Tidak Diterima' => 'Tidak Diterima',
                default => 'Belum Ada Hasil'
            };

            $state['keterangan'] = match($data->status) {
                'valid' => match($data->hasil) {
                    'Diterima' => 'Selamat! Anda telah diterima sebagai penerima KIP-K. Silahkan cek pengumuman resmi untuk informasi lebih lanjut.',
                    'Tidak Diterima' => 'Mohon maaf, Anda belum berhasil menjadi penerima KIP-K. Tetap semangat dan jangan menyerah!',
                    default => 'Berkas Anda telah divalidasi. Hasil seleksi akan diumumkan segera.'
                },
                'tidak_valid' => "Berkas Anda tidak valid. Alasan: {$data->alasan_tidak_valid}",
                'belum_validasi' => 'Berkas Anda sedang dalam proses validasi. Mohon tunggu informasi selanjutnya.',
                default => 'Silahkan lengkapi form pendaftaran KIP-K terlebih dahulu.'
            };
        }

        return $infolist
            ->schema([
                Section::make('Status Berkas')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('status')
                                    ->label('Status Berkas')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Berkas Valid' => 'success',
                                        'Berkas Tidak Valid' => 'danger',
                                        'Belum Divalidasi' => 'warning',
                                        default => 'gray',
                                    }),
                                TextEntry::make('hasil')
                                    ->label('Hasil Seleksi')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Diterima' => 'success',
                                        'Tidak Diterima' => 'danger',
                                        default => 'gray',
                                    }),
                            ]),
                    ]),
                Section::make('Keterangan')
                    ->schema([
                        TextEntry::make('keterangan')
                            ->label('Informasi Progres')
                            ->markdown()
                            ->columnSpanFull(),
                    ]),
            ])
            ->state($state);
    }

    protected function getHeaderActions(): array
    {
        $user = auth()->user();
        $mahasiswa = Mahasiswa::with(['prodi', 'jurusan'])->where('user_id', $user->id)->first();
        $data = $mahasiswa ? Parameter::where('mahasiswa_id', $mahasiswa->id)->first() : null;

        // if ($data && $data->status === 'valid' && $data->hasil === 'Diterima') {
        //     return [
        //         Action::make('exportSurat')
        //             ->label('Download Surat Keterangan')
        //             ->icon('heroicon-o-document-arrow-down')
        //             ->action(function () use ($mahasiswa) {
        //                 $pdf = PDF::loadView('surat.keterangan', [
        //                     'mahasiswa' => $mahasiswa,
        //                     'tanggal' => now()->format('Y-m-d'),
        //                 ]);

        //                 return response()->streamDownload(function () use ($pdf) {
        //                     echo $pdf->output();
        //                 }, 'surat-k`eterangan-kipk.pdf');
        //             })
        //     ];
        // }

        return [];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getNavigationItems(): array
    {
        return [
            NavigationItem::make('Info')
                ->url(fn (): string => static::getUrl())
                ->icon('heroicon-o-document-text')
                ->isActiveWhen(fn (): bool => request()->routeIs(static::getRouteName()))
                ->visible(fn (): bool => auth()->check() && auth()->user()->roles[0]->name == 'Mahasiswa'),
        ];
    }
}