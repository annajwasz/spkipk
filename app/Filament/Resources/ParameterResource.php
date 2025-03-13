<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParameterResource\Pages;
use App\Filament\Resources\ParameterResource\RelationManagers;
use App\Models\Parameter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;

class ParameterResource extends Resource
{
    protected static ?string $model = Parameter::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    
    protected static ?string $navigationLabel = 'Form Penilaian KIP-K';
    
    protected static ?string $navigationGroup = 'Penilaian';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Mahasiswa')
                    ->schema([
                        Select::make('mahasiswa_id')
                            ->relationship('mahasiswa', 'nama')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Nama Mahasiswa')
                            ->disabled(fn ($context) => $context === 'view'),
                    ]),

                Section::make('Kepemilikan KIP')
                    ->schema([
                        Radio::make('kepemilikan_kip')
                            ->options([
                                'Memiliki KIP' => 'Memiliki KIP',
                                'Tidak Memiliki KIP' => 'Tidak Memiliki KIP',
                            ])
                            ->required()
                            ->inline()
                            ->reactive()
                            ->disabled(fn ($context) => $context === 'view'),
                            
                        FileUpload::make('berkas_kip')
                            ->label('Bukti Kepemilikan KIP')
                            ->disk('berkas')
                            ->directory('kip')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->downloadable()
                            ->openable()
                            ->acceptedFileTypes(['application/pdf'])
                            ->visible(fn (callable $get) => $get('kepemilikan_kip') === 'Memiliki KIP')
                            ->required(fn (callable $get) => $get('kepemilikan_kip') === 'Memiliki KIP')
                            ->disabled(fn ($context) => $context === 'view'),
                    ]),
                    
                Section::make('Tingkatan Desil')
                    ->schema([
                        Radio::make('terdata_dtks')
                            ->options([
                                'Terdata' => 'Terdata',
                                'Tidak Terdata' => 'Tidak Terdata',
                            ])
                            ->required()
                            ->inline()
                            ->reactive()
                            ->disabled(fn ($context) => $context === 'view'),
                            
                        FileUpload::make('berkas_dtks')
                            ->label('Bukti Terdata di DTKS')
                            ->disk('berkas')
                            ->directory('dtks')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->downloadable()
                            ->openable()
                            ->acceptedFileTypes(['application/pdf'])
                            ->visible(fn (callable $get) => $get('terdata_dtks') === 'Terdata')
                            ->required(fn (callable $get) => $get('terdata_dtks') === 'Terdata')
                            ->disabled(fn ($context) => $context === 'view'),

                        Select::make('tingkatan_desil')
                            ->options([
                                'Desil 1' => 'Desil 1',
                                'Desil 2' => 'Desil 2',
                                'Desil 3' => 'Desil 3',
                                'Desil 4' => 'Desil 4',
                                'Desil 5' => 'Desil 5',
                            ])
                            ->required()
                            ->disabled(fn ($context) => $context === 'view'),
                    ]),
                    
                Section::make('Upload Berkas Bukti Bantuan Pemerintah')
                    ->schema([
                        Hidden::make('kondisi_ekonomi')
                            ->default('Cukup Mampu'),
                            
                        FileUpload::make('berkas_1')
                            ->label('Berkas Bukti 1')
                            ->disk('berkas')
                            ->directory('ekonomi')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->downloadable()
                            ->openable()
                            ->acceptedFileTypes(['application/pdf'])
                            ->required()
                            ->disabled(fn ($context) => $context === 'view'),
                            
                        FileUpload::make('berkas_2')
                            ->label('Berkas Bukti 2 (Opsional)')
                            ->disk('berkas')
                            ->directory('ekonomi')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->downloadable()
                            ->openable()
                            ->acceptedFileTypes(['application/pdf'])
                            ->disabled(fn ($context) => $context === 'view'),
                            
                        FileUpload::make('berkas_3')
                            ->label('Berkas Bukti 3 (Opsional)')
                            ->disk('berkas')
                            ->directory('ekonomi')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->downloadable()
                            ->openable()
                            ->acceptedFileTypes(['application/pdf'])
                            ->disabled(fn ($context) => $context === 'view'),
                    ]),
                    
                Section::make('Status Orang Tua')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Fieldset::make('Status Ayah')
                                    ->schema([
                                        Radio::make('status_ayah')
                                            ->options([
                                                'Hidup' => 'Hidup',
                                                'Wafat' => 'Wafat',
                                            ])
                                            ->required()
                                            ->inline()
                                            ->reactive()
                                            ->disabled(fn ($context) => $context === 'view'),
                                            
                                        FileUpload::make('bukti_wafat_ayah')
                                            ->label('Bukti Kematian Ayah')
                                            ->disk('berkas')
                                            ->directory('wafat')
                                            ->visibility('public')
                                            ->preserveFilenames()
                                            ->downloadable()
                                            ->openable()
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->visible(fn (callable $get) => $get('status_ayah') === 'Wafat')
                                            ->required(fn (callable $get) => $get('status_ayah') === 'Wafat')
                                            ->disabled(fn ($context) => $context === 'view'),
                                    ]),
                                    
                                Fieldset::make('Status Ibu')
                                    ->schema([
                                        Radio::make('status_ibu')
                                            ->options([
                                                'Hidup' => 'Hidup',
                                                'Wafat' => 'Wafat',
                                            ])
                                            ->required()
                                            ->inline()
                                            ->reactive()
                                            ->disabled(fn ($context) => $context === 'view'),
                                            
                                        FileUpload::make('bukti_wafat_ibu')
                                            ->label('Bukti Kematian Ibu')
                                            ->disk('berkas')
                                            ->directory('wafat')
                                            ->visibility('public')
                                            ->preserveFilenames()
                                            ->downloadable()
                                            ->openable()
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->visible(fn (callable $get) => $get('status_ibu') === 'Wafat')
                                            ->required(fn (callable $get) => $get('status_ibu') === 'Wafat')
                                            ->disabled(fn ($context) => $context === 'view'),
                                    ]),
                            ]),
                            
                        // Hidden::make('status_orang_tua')
                        //     ->default('Kedua Orang Tua Masih Hidup'),
                    ]),

                Section::make('Status Validasi')
                    ->schema([
                        Radio::make('status')
                            ->options([
                                'belum_validasi' => 'Belum Validasi',
                                'valid' => 'Valid',
                                'tidak_valid' => 'Tidak Valid',
                            ])
                            ->required()
                            ->default('belum_validasi')
                            ->reactive(),

                        Textarea::make('alasan_tidak_valid')
                            ->label('Alasan Tidak Valid')
                            ->placeholder('Masukkan alasan mengapa data tidak valid...')
                            ->rows(3)
                            ->required(fn (callable $get) => $get('status') === 'tidak_valid')
                            ->visible(fn (callable $get) => $get('status') === 'tidak_valid'),
                    ])
                    ->visible(fn ($context) => $context === 'view'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.nama')
                    ->label('Nama Mahasiswa')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('kepemilikan_kip')
                    ->label('Kepemilikan KIP')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Memiliki KIP' => 'success',
                        'Tidak Memiliki KIP' => 'danger',
                    }),
                    
                Tables\Columns\TextColumn::make('terdata_dtks')
                    ->label('Terdata DTKS')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Terdata' => 'success',
                        'Tidak Terdata' => 'danger',
                    }),
                    
                Tables\Columns\TextColumn::make('tingkatan_desil')
                    ->label('Tingkatan Desil')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Desil 1' => 'success',
                        'Desil 2' => 'success',
                        'Desil 3' => 'warning',
                        'Desil 4' => 'warning',
                        'Desil 5' => 'danger',
                        default => 'gray',
                    }),
                    
                Tables\Columns\TextColumn::make('kondisi_ekonomi')
                    ->label('Kondisi Ekonomi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Sangat Kurang Mampu' => 'success',
                        'Kurang Mampu' => 'warning',
                        'Cukup Mampu' => 'danger',
                        default => 'gray',
                    }),
                    
                Tables\Columns\TextColumn::make('status_orang_tua')
                    ->label('Status Orang Tua')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Kedua Orang Tua Wafat' => 'success',
                        'Salah Satu Orang Tua Wafat' => 'warning',
                        'Kedua Orang Tua Masih Hidup' => 'danger',
                        default => 'gray',
                    }),
                    
                Tables\Columns\TextColumn::make('total_nilai')
                    ->label('Total Nilai')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('status')
                    ->label('Status Validasi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'valid' => 'success',
                        'tidak_valid' => 'danger',
                        'belum_validasi' => 'warning',
                        default => 'gray',
                    }),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('kepemilikan_kip')
                    ->options([
                        'Memiliki KIP' => 'Memiliki KIP',
                        'Tidak Memiliki KIP' => 'Tidak Memiliki KIP',
                    ]),
                    
                Tables\Filters\SelectFilter::make('terdata_dtks')
                    ->options([
                        'Terdata' => 'Terdata',
                        'Tidak Terdata' => 'Tidak Terdata',
                    ]),
                    
                Tables\Filters\SelectFilter::make('tingkatan_desil')
                    ->options([
                        'Desil 1' => 'Desil 1',
                        'Desil 2' => 'Desil 2',
                        'Desil 3' => 'Desil 3',
                        'Desil 4' => 'Desil 4',
                        'Desil 5' => 'Desil 5',
                    ]),
                    
                Tables\Filters\SelectFilter::make('kondisi_ekonomi')
                    ->options([
                        'Sangat Kurang Mampu' => 'Sangat Kurang Mampu',
                        'Kurang Mampu' => 'Kurang Mampu',
                        'Cukup Mampu' => 'Cukup Mampu',
                    ]),
                    
                Tables\Filters\SelectFilter::make('status_orang_tua')
                    ->options([
                        'Kedua Orang Tua Wafat' => 'Kedua Orang Tua Wafat',
                        'Salah Satu Orang Tua Wafat' => 'Salah Satu Orang Tua Wafat',
                        'Kedua Orang Tua Masih Hidup' => 'Kedua Orang Tua Masih Hidup',
                    ]),
                    
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'belum_validasi' => 'Belum Validasi',
                        'valid' => 'Valid',
                        'tidak_valid' => 'Tidak Valid',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('validasi')
                    ->label('Validasi')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->color('success')
                    ->form([
                        Section::make('Data Mahasiswa')
                            ->schema([
                                Select::make('mahasiswa_id')
                                    ->relationship('mahasiswa', 'nama')
                                    ->disabled()
                                    ->dehydrated(false),
                            ]),

                        Section::make('Kepemilikan KIP')
                            ->schema([
                                Radio::make('kepemilikan_kip')
                                    ->options([
                                        'Memiliki KIP' => 'Memiliki KIP',
                                        'Tidak Memiliki KIP' => 'Tidak Memiliki KIP',
                                    ])
                                    ->disabled()
                                    ->dehydrated(false),
                                    
                                FileUpload::make('berkas_kip')
                                    ->label('Bukti Kepemilikan KIP')
                                    ->disk('berkas')
                                    ->directory('kip')
                                    ->visibility('public')
                                    ->downloadable()
                                    ->openable()
                                    ->disabled()
                                    ->dehydrated(false),
                            ]),
                            
                        Section::make('Tingkatan Desil')
                            ->schema([
                                Radio::make('terdata_dtks')
                                    ->options([
                                        'Terdata' => 'Terdata',
                                        'Tidak Terdata' => 'Tidak Terdata',
                                    ])
                                    ->disabled()
                                    ->dehydrated(false),
                                    
                                FileUpload::make('berkas_dtks')
                                    ->label('Bukti Terdata di DTKS')
                                    ->disk('berkas')
                                    ->directory('dtks')
                                    ->visibility('public')
                                    ->downloadable()
                                    ->openable()
                                    ->disabled()
                                    ->dehydrated(false),

                                Select::make('tingkatan_desil')
                                    ->options([
                                        'Desil 1' => 'Desil 1',
                                        'Desil 2' => 'Desil 2',
                                        'Desil 3' => 'Desil 3',
                                        'Desil 4' => 'Desil 4',
                                        'Desil 5' => 'Desil 5',
                                    ])
                                    ->disabled()
                                    ->dehydrated(false),
                            ]),
                            
                        Section::make('Upload Berkas Bukti Bantuan Pemerintah')
                            ->schema([
                                FileUpload::make('berkas_1')
                                    ->label('Berkas Bukti 1')
                                    ->disk('berkas')
                                    ->directory('ekonomi')
                                    ->visibility('public')
                                    ->downloadable()
                                    ->openable()
                                    ->disabled()
                                    ->dehydrated(false),
                                    
                                FileUpload::make('berkas_2')
                                    ->label('Berkas Bukti 2')
                                    ->disk('berkas')
                                    ->directory('ekonomi')
                                    ->visibility('public')
                                    ->downloadable()
                                    ->openable()
                                    ->disabled()
                                    ->dehydrated(false),
                                    
                                FileUpload::make('berkas_3')
                                    ->label('Berkas Bukti 3')
                                    ->disk('berkas')
                                    ->directory('ekonomi')
                                    ->visibility('public')
                                    ->downloadable()
                                    ->openable()
                                    ->disabled()
                                    ->dehydrated(false),
                            ]),
                            
                        Section::make('Status Orang Tua')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Fieldset::make('Status Ayah')
                                            ->schema([
                                                Radio::make('status_ayah')
                                                    ->options([
                                                        'Hidup' => 'Hidup',
                                                        'Wafat' => 'Wafat',
                                                    ])
                                                    ->disabled()
                                                    ->dehydrated(false),
                                                    
                                                FileUpload::make('bukti_wafat_ayah')
                                                    ->label('Bukti Kematian Ayah')
                                                    ->disk('berkas')
                                                    ->directory('wafat')
                                                    ->visibility('public')
                                                    ->downloadable()
                                                    ->openable()
                                                    ->disabled()
                                                    ->dehydrated(false),
                                            ]),
                                            
                                        Fieldset::make('Status Ibu')
                                            ->schema([
                                                Radio::make('status_ibu')
                                                    ->options([
                                                        'Hidup' => 'Hidup',
                                                        'Wafat' => 'Wafat',
                                                    ])
                                                    ->disabled()
                                                    ->dehydrated(false),
                                                    
                                                FileUpload::make('bukti_wafat_ibu')
                                                    ->label('Bukti Kematian Ibu')
                                                    ->disk('berkas')
                                                    ->directory('wafat')
                                                    ->visibility('public')
                                                    ->downloadable()
                                                    ->openable()
                                                    ->disabled()
                                                    ->dehydrated(false),
                                            ]),
                                    ]),
                            ]),

                        Section::make('Status Validasi')
                            ->schema([
                                Radio::make('status')
                                    ->options([
                                        'belum_validasi' => 'Belum Validasi',
                                        'valid' => 'Valid',
                                        'tidak_valid' => 'Tidak Valid',
                                    ])
                                    ->required()
                                    ->default('belum_validasi')
                                    ->reactive(),

                                Textarea::make('alasan_tidak_valid')
                                    ->label('Alasan Tidak Valid')
                                    ->placeholder('Masukkan alasan mengapa data tidak valid...')
                                    ->rows(3)
                                    ->required(fn (callable $get) => $get('status') === 'tidak_valid')
                                    ->visible(fn (callable $get) => $get('status') === 'tidak_valid'),
                            ]),
                    ])
                    ->action(function (array $data, $record): void {
                        $record->update([
                            'status' => $data['status'],
                            'alasan_tidak_valid' => $data['status'] === 'tidak_valid' ? $data['alasan_tidak_valid'] : null,
                        ]);
                    })
                    ->modalSubmitActionLabel('Simpan Status Validasi')
                    ->fillForm(fn ($record) => [
                        'mahasiswa_id' => $record->mahasiswa_id,
                        'kepemilikan_kip' => $record->kepemilikan_kip,
                        'berkas_kip' => $record->berkas_kip,
                        'terdata_dtks' => $record->terdata_dtks,
                        'berkas_dtks' => $record->berkas_dtks,
                        'tingkatan_desil' => $record->tingkatan_desil,
                        'berkas_1' => $record->berkas_1,
                        'berkas_2' => $record->berkas_2,
                        'berkas_3' => $record->berkas_3,
                        'status_ayah' => $record->status_ayah,
                        'bukti_wafat_ayah' => $record->bukti_wafat_ayah,
                        'status_ibu' => $record->status_ibu,
                        'bukti_wafat_ibu' => $record->bukti_wafat_ibu,
                        'status' => $record->status,
                        'alasan_tidak_valid' => $record->alasan_tidak_valid,
                    ]),
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
            'index' => Pages\ListParameters::route('/'),
            'create' => Pages\CreateParameter::route('/create'),
            'edit' => Pages\EditParameter::route('/{record}/edit'),
        ];
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Tentukan status orang tua berdasarkan status ayah dan ibu
        if ($data['status_ayah'] === 'Wafat' && $data['status_ibu'] === 'Wafat') {
            $data['status_orang_tua'] = 'Kedua Orang Tua Wafat';
        } elseif ($data['status_ayah'] === 'Wafat' || $data['status_ibu'] === 'Wafat') {
            $data['status_orang_tua'] = 'Salah Satu Orang Tua Wafat';
        } else {
            $data['status_orang_tua'] = 'Kedua Orang Tua Masih Hidup';
        }
        
        // Tentukan kondisi ekonomi berdasarkan jumlah berkas
        $berkasCount = 0;
        if (!empty($data['berkas_1'])) $berkasCount++;
        if (!empty($data['berkas_2'])) $berkasCount++;
        if (!empty($data['berkas_3'])) $berkasCount++;
        
        if ($berkasCount >= 3) {
            $data['kondisi_ekonomi'] = 'Sangat Kurang Mampu';
        } elseif ($berkasCount >= 2) {
            $data['kondisi_ekonomi'] = 'Kurang Mampu';
        } else {
            $data['kondisi_ekonomi'] = 'Cukup Mampu';
        }
        
        return $data;
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Tentukan status orang tua berdasarkan status ayah dan ibu
        if ($data['status_ayah'] === 'Wafat' && $data['status_ibu'] === 'Wafat') {
            $data['status_orang_tua'] = 'Kedua Orang Tua Wafat';
        } elseif ($data['status_ayah'] === 'Wafat' || $data['status_ibu'] === 'Wafat') {
            $data['status_orang_tua'] = 'Salah Satu Orang Tua Wafat';
        } else {
            $data['status_orang_tua'] = 'Kedua Orang Tua Masih Hidup';
        }
        
        // Tentukan kondisi ekonomi berdasarkan jumlah berkas
        $berkasCount = 0;
        if (!empty($data['berkas_1'])) $berkasCount++;
        if (!empty($data['berkas_2'])) $berkasCount++;
        if (!empty($data['berkas_3'])) $berkasCount++;
        
        if ($berkasCount >= 3) {
            $data['kondisi_ekonomi'] = 'Sangat Kurang Mampu';
        } elseif ($berkasCount >= 2) {
            $data['kondisi_ekonomi'] = 'Kurang Mampu';
        } else {
            $data['kondisi_ekonomi'] = 'Cukup Mampu';
        }
        
        return $data;
    }
}