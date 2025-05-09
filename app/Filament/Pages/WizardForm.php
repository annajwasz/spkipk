<?php

namespace App\Filament\Pages;

use App\Models\Parameter;
use App\Models\Mahasiswa;
use App\Models\Jurusan;
use App\Models\Prodi;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class WizardForm extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.wizard-form';
    protected static ?string $title = 'Form Pendaftaran KIP-K';
    protected static ?string $slug = 'wizard-form';
    protected static bool $shouldRegisterNavigation = false;

    public array $data = [];

    public function mount(): void
    {
        // Cek apakah mahasiswa sudah pernah mengisi form
        $mahasiswa = Mahasiswa::where('user_id', auth()->id())->first();
        if ($mahasiswa && $mahasiswa->parameter) {
            Notification::make()
                ->warning()
                ->title('Peringatan')
                ->body('Anda sudah pernah mengisi form pendaftaran KIP-K')
                ->send();
            
            $this->redirect('/admin/');
        }

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Biodata Mahasiswa')
                        ->schema([
                            TextInput::make('noreg_kipk')->label('No. Registrasi KIP-K')->required(),
                            TextInput::make('nama')->label('Nama Lengkap')->required(),
                            TextInput::make('nim')->label('NIM')->required(),
                            Select::make('jurusan_id')
                                ->label('Jurusan')
                                ->options(Jurusan::all()->pluck('nama', 'id'))
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(fn (callable $set) => $set('prodi_id', null)),
                            Select::make('prodi_id')
                                ->label('Program Studi')
                                ->options(function (callable $get) {
                                    $jurusanId = $get('jurusan_id');
                                    if (!$jurusanId) {
                                        return [];
                                    }
                                    return Prodi::where('jurusan_id', $jurusanId)
                                        ->pluck('nama', 'id');
                                })
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, callable $get) {
                                    $prodiId = $get('prodi_id');
                                    if ($prodiId) {
                                        $prodi = Prodi::find($prodiId);
                                        $set('akreditasi', $prodi->akreditasi);
                                    }
                                }),
                            TextInput::make('akreditasi')
                                ->label('Akreditasi Prodi')
                                ->disabled()
                                ->required(),
                            TextInput::make('angkatan')->label('Angkatan')->required(),
                            TextInput::make('jalur_masuk')->label('Jalur Masuk')->required(),
                            TextInput::make('ponsel')->label('No. Handphone')->tel()->required(),
                            TextInput::make('alamat')->label('Alamat')->required(),
                        ]),

                    Wizard\Step::make('Parameter Penilaian')
                        ->schema([
                            Section::make('Kepemilikan KIP')
                                ->schema([
                                    Radio::make('kepemilikan_kip')
                                        ->options([
                                            'Memiliki KIP' => 'Memiliki KIP',
                                            'Tidak Memiliki KIP' => 'Tidak Memiliki KIP',
                                        ])
                                        ->required()
                                        ->inline()
                                        ->reactive(),
                                        
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
                                        ->required(fn (callable $get) => $get('kepemilikan_kip') === 'Memiliki KIP'),
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
                                        ->reactive(),
                                        
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
                                        ->required(fn (callable $get) => $get('terdata_dtks') === 'Terdata'),

                                    Select::make('tingkatan_desil')
                                        ->options([
                                            'Desil 1' => 'Desil 1',
                                            'Desil 2' => 'Desil 2',
                                            'Desil 3' => 'Desil 3',
                                            'Desil 4' => 'Desil 4',
                                            'Desil 5' => 'Desil 5',
                                        ])
                                        ->required(),
                                ]),
                                
                            Section::make('Upload Berkas Bukti Bantuan Pemerintah')
                                ->schema([
                                    FileUpload::make('berkas_1')
                                        ->label('Berkas Bukti 1 (Opsional)')
                                        ->disk('berkas')
                                        ->directory('ekonomi')
                                        ->visibility('public')
                                        ->preserveFilenames()
                                        ->downloadable()
                                        ->openable()
                                        ->acceptedFileTypes(['application/pdf']),
                                        
                                        
                                    FileUpload::make('berkas_2')
                                        ->label('Berkas Bukti 2 (Opsional)')
                                        ->disk('berkas')
                                        ->directory('ekonomi')
                                        ->visibility('public')
                                        ->preserveFilenames()
                                        ->downloadable()
                                        ->openable()
                                        ->acceptedFileTypes(['application/pdf']),
                                        
                                    FileUpload::make('berkas_3')
                                        ->label('Berkas Bukti 3 (Opsional)')
                                        ->disk('berkas')
                                        ->directory('ekonomi')
                                        ->visibility('public')
                                        ->preserveFilenames()
                                        ->downloadable()
                                        ->openable()
                                        ->acceptedFileTypes(['application/pdf']),
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
                                                        ->reactive(),
                                                        
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
                                                        ->required(fn (callable $get) => $get('status_ayah') === 'Wafat'),
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
                                                        ->reactive(),
                                                        
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
                                                        ->required(fn (callable $get) => $get('status_ibu') === 'Wafat'),
                                                ]),
                                        ]),
                                ]),
                        ]),
                ])
                ->submitAction(view('filament.pages.wizard-form-submit-button'))
            ])
            ->statePath('data');
    }

    public function submit()
    {
        $data = $this->form->getState();

        DB::beginTransaction();
        try {
            // Simpan data mahasiswa
            $mahasiswa = Mahasiswa::create([
                'user_id' => auth()->id(),
                'noreg_kipk' => $data['noreg_kipk'],
                'nama' => $data['nama'],
                'NIM' => $data['nim'],
                'jurusan_id' => $data['jurusan_id'],
                'prodi_id' => $data['prodi_id'],
                'akreditasi' => $data['akreditasi'] ?? Prodi::find($data['prodi_id'])->akreditasi,
                'angkatan' => $data['angkatan'],
                'jalur_masuk' => $data['jalur_masuk'],
                'ponsel' => $data['ponsel'],
                'alamat' => $data['alamat'],
            ]);
            
            // Simpan data parameter
            Parameter::create([
                'mahasiswa_id' => $mahasiswa->id,
                'kepemilikan_kip' => $data['kepemilikan_kip'],
                'berkas_kip' => $data['berkas_kip'] ?? null,
                'terdata_dtks' => $data['terdata_dtks'],
                'berkas_dtks' => $data['berkas_dtks'] ?? null,
                'tingkatan_desil' => $data['tingkatan_desil'],
                'berkas_1' => $data['berkas_1'],
                'berkas_2' => $data['berkas_2'] ?? null,
                'berkas_3' => $data['berkas_3'] ?? null,
                'status_ayah' => $data['status_ayah'],
                'bukti_wafat_ayah' => $data['bukti_wafat_ayah'] ?? null,
                'status_ibu' => $data['status_ibu'],
                'bukti_wafat_ibu' => $data['bukti_wafat_ibu'] ?? null,
                'status' => 'belum_validasi',
            ]);

            DB::commit();

            Notification::make()
                ->success()
                ->title('Berhasil')
                ->body('Data berhasil disimpan')
                ->send();

            $this->redirect('/admin/');

        } catch (\Exception $e) {
            DB::rollBack();
            Notification::make()
                ->danger()
                ->title('Error')
                ->body('Terjadi kesalahan: ' . $e->getMessage())
                ->send();
        }
    }
}
