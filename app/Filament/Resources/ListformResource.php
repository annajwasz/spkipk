<?php

// namespace App\Filament\Resources;

// use App\Filament\Resources\ListformResource\Pages;
// use App\Models\Listform;
// use Filament\Forms\Form;
// use Filament\Resources\Resource;
// use Filament\Tables;
// use Filament\Tables\Table;
// use Filament\Forms\Components\Select;
// use Filament\Forms\Components\FileUpload;
// use Filament\Forms\Components\Section;
// use Filament\Tables\Columns\TextColumn;
// use Filament\Tables\Actions\ViewAction;
// use Filament\Forms\Components\ViewField;
// use Filament\Forms\Components\TextInput;
// use Filament\Forms\Components\Placeholder;
// use Illuminate\Support\Facades\Storage;

// class ListformResource extends Resource
// {
//     protected static ?string $model = Listform::class;

//     protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
//     protected static ?string $navigationGroup = 'Penilaian';
//     protected static ?string $navigationLabel = 'Form Penilaian KIP-K';
//     protected static ?int $navigationSort = 1;

//     public static function form(Form $form): Form
//     {
//         return $form
//             ->schema([
//                 Section::make('Data Mahasiswa')
//                     ->schema([
//                         Select::make('mahasiswa_id')
//                             ->relationship('mahasiswa', 'nama')
//                             ->searchable()
//                             ->preload()
//                             ->required()
//                             ->label('Nama Mahasiswa'),
//                     ]),

//                 Section::make('Kepemilikan KIP')
//                     ->schema([
//                         Select::make('kepemilikan_kip')
//                             ->options([
//                                 'Memiliki KIP' => 'Memiliki KIP',
//                                 'Tidak Memiliki KIP' => 'Tidak Memiliki KIP',
//                             ])
//                             ->required(),
//                     ]),

//                 Section::make('Tingkatan Desil')
//                     ->schema([
//                         Select::make('tingkatan_desil')
//                             ->options([
//                                 'Desil 1' => 'Desil 1',
//                                 'Desil 2' => 'Desil 2',
//                                 'Desil 3' => 'Desil 3',
//                                 'Desil 4' => 'Desil 4',
//                                 'Desil 5' => 'Desil 5',
//                             ])
//                             ->required(),
//                     ]),

//                 Section::make('Upload Berkas Pendukung')
//                     ->schema([
//                         FileUpload::make('berkas_sktm')
//                             ->label('Upload SKTM')
//                             ->helperText('Surat Keterangan Tidak Mampu dari Kelurahan/Desa')
//                             ->directory('berkas-sktm')
//                             ->preserveFilenames()
//                             ->required()
//                             ->acceptedFileTypes(['application/pdf']),

//                         FileUpload::make('berkas_ppke')
//                             ->label('Upload PPKE')
//                             ->helperText('Pernyataan Penghasilan Keluarga')
//                             ->directory('berkas-ppke')
//                             ->preserveFilenames()
//                             ->acceptedFileTypes(['application/pdf']),

//                         FileUpload::make('berkas_pmk')
//                             ->label('Upload PMK')
//                             ->helperText('Pernyataan Mahasiswa Kurang Mampu')
//                             ->directory('berkas-pmk')
//                             ->preserveFilenames()
//                             ->acceptedFileTypes(['application/pdf']),

//                         FileUpload::make('berkas_pkh')
//                             ->label('Upload PKH')
//                             ->helperText('Kartu Program Keluarga Harapan')
//                             ->directory('berkas-pkh')
//                             ->preserveFilenames()
//                             ->acceptedFileTypes(['application/pdf']),

//                         FileUpload::make('berkas_kks')
//                             ->label('Upload KKS')
//                             ->helperText('Kartu Keluarga Sejahtera')
//                             ->directory('berkas-kks')
//                             ->preserveFilenames()
//                             ->acceptedFileTypes(['application/pdf']),
//                     ]),
//             ]);
//     }

//     public static function table(Table $table): Table
//     {
//         return $table
//             ->columns([
//                 TextColumn::make('mahasiswa.nama')
//                     ->label('Nama Mahasiswa')
//                     ->searchable()
//                     ->sortable(),
//                 TextColumn::make('kepemilikan_kip')
//                     ->label('Kepemilikan KIP'),
//                 TextColumn::make('tingkatan_desil')
//                     ->label('Tingkatan Desil'),
//                 TextColumn::make('kondisi_ekonomi')
//                     ->label('Kondisi Ekonomi'),
//                 TextColumn::make('total_nilai')
//                     ->label('Total Nilai')
//                     ->sortable(),
//                 TextColumn::make('status')
//                     ->badge()
//                     ->color(fn (string $state): string => match ($state) {
//                         'submitted' => 'success',
//                         'draft' => 'warning',
//                         default => 'gray',
//                     }),
//             ])
//             ->defaultSort('total_nilai', 'desc')
//             ->filters([])
//             ->actions([
//                 ViewAction::make()
//                     ->form([
//                         Section::make('Data Mahasiswa')
//                             ->schema([
//                                 TextInput::make('mahasiswa_name')
//                                     ->label('Nama Mahasiswa')
//                                     ->formatStateUsing(fn ($record) => $record->mahasiswa->nama)
//                                     ->disabled(),
//                                 TextInput::make('kepemilikan_kip')
//                                     ->label('Kepemilikan KIP')
//                                     ->disabled(),
//                                 TextInput::make('tingkatan_desil')
//                                     ->label('Tingkatan Desil')
//                                     ->disabled(),
//                                 TextInput::make('kondisi_ekonomi')
//                                     ->label('Kondisi Ekonomi')
//                                     ->disabled(),
//                                 TextInput::make('total_nilai')
//                                     ->label('Total Nilai')
//                                     ->disabled(),
//                             ]),
//                         Section::make('Berkas')
//                             ->schema([
//                                 Placeholder::make('berkas_sktm')
//                                     ->label('SKTM')
//                                     ->content(fn ($record) => $record->berkas_sktm ? 
//                                         view('filament.components.file-link', [
//                                             'url' => Storage::url($record->berkas_sktm),
//                                             'label' => 'SKTM'
//                                         ]) : 
//                                         'Tidak ada berkas'
//                                     ),
//                                 Placeholder::make('berkas_ppke')
//                                     ->label('PPKE')
//                                     ->content(fn ($record) => $record->berkas_ppke ? 
//                                         view('filament.components.file-link', [
//                                             'url' => Storage::url($record->berkas_ppke),
//                                             'label' => 'PPKE'
//                                         ]) : 
//                                         'Tidak ada berkas'
//                                     ),
//                                 Placeholder::make('berkas_pmk')
//                                     ->label('PMK')
//                                     ->content(fn ($record) => $record->berkas_pmk ? 
//                                         view('filament.components.file-link', [
//                                             'url' => Storage::url($record->berkas_pmk),
//                                             'label' => 'PMK'
//                                         ]) : 
//                                         'Tidak ada berkas'
//                                     ),
//                                 Placeholder::make('berkas_pkh')
//                                     ->label('PKH')
//                                     ->content(fn ($record) => $record->berkas_pkh ? 
//                                         view('filament.components.file-link', [
//                                             'url' => Storage::url($record->berkas_pkh),
//                                             'label' => 'PKH'
//                                         ]) : 
//                                         'Tidak ada berkas'
//                                     ),
//                                 Placeholder::make('berkas_kks')
//                                     ->label('KKS')
//                                     ->content(fn ($record) => $record->berkas_kks ? 
//                                         view('filament.components.file-link', [
//                                             'url' => Storage::url($record->berkas_kks),
//                                             'label' => 'KKS'
//                                         ]) : 
//                                         'Tidak ada berkas'
//                                     ),
//                             ]),
//                     ]),
//                 Tables\Actions\EditAction::make(),
//             ])
//             ->bulkActions([
//                 Tables\Actions\BulkActionGroup::make([
//                     Tables\Actions\DeleteBulkAction::make(),
//                 ]),
//             ]);
//     }

//     public static function getPages(): array
//     {
//         return [
//             'index' => Pages\ListListforms::route('/'),
//             'create' => Pages\CreateListform::route('/create'),
//             'edit' => Pages\EditListform::route('/{record}/edit'),
//         ];
//     }
//}
