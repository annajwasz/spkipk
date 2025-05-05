<?php

namespace App\Filament\Pages;

use App\Models\Parameter;
use Filament\Pages\Page;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;
use Filament\Navigation\NavigationItem;

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
        $data = Parameter::where('mahasiswa_id', $user->id)->first();

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
                                        'valid' => 'success',
                                        'tidak_valid' => 'danger',
                                        'belum_validasi' => 'warning',
                                        default => 'gray',
                                    }),
                                TextEntry::make('hasil')
                                    ->label('Hasil Seleksi')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Layak' => 'success',
                                        'Dipertimbangkan' => 'warning',
                                        'Tidak Layak' => 'danger',
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
            ->state([
                'status' => $data?->status ?? 'belum_validasi',
                'hasil' => $data?->hasil ?? 'Belum Ada Hasil',
                'keterangan' => $data?->keterangan ?? 'Data Anda sedang dalam proses validasi',
            ]);
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