<?php

namespace App\Filament\Pages;

use App\Models\Listform;
use App\Models\Mahasiswa;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
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
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make()
                    ->steps([
                Wizard\Step::make('Biodata Mahasiswa')
                    ->schema([
                                TextInput::make('noreg_kipk')->label('No. Registrasi KIP-K')->required(),
                                TextInput::make('nama')->label('Nama Lengkap')->required(),
                                TextInput::make('nim')->label('NIM')->required(),
                                TextInput::make('jurusan')->label('Jurusan')->required(),
                                TextInput::make('prodi')->label('Program Studi')->required(),
                                TextInput::make('angkatan')->label('Angkatan')->required(),
                                TextInput::make('semester')->label('Semester')->required(),
                                TextInput::make('jalur_masuk')->label('Jalur Masuk')->required(),
                                TextInput::make('ponsel')->label('No. Handphone')->tel()->required(),
                                TextInput::make('alamat')->label('Alamat')->required(),
                            ]),

                        Wizard\Step::make('Parameter Penilaian')
                    ->schema([
                                Select::make('kepemilikan_kip')
                            ->label('Kepemilikan KIP')
                            ->options([
                                'Memiliki KIP' => 'Memiliki KIP',
                                'Tidak Memiliki KIP' => 'Tidak Memiliki KIP',
                            ])
                            ->required(),

                        Select::make('tingkatan_desil')
                            ->label('Tingkatan Desil')
                            ->options([
                                'Desil 1' => 'Desil 1',
                                'Desil 2' => 'Desil 2',
                                'Desil 3' => 'Desil 3',
                                'Desil 4' => 'Desil 4',
                                'Desil 5' => 'Desil 5',
                            ])
                            ->required(),

                                FileUpload::make('berkas_sktm')
                                    ->label('Upload SKTM')
                                    ->directory('berkas-sktm')
                                    ->preserveFilenames()
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->required(),

                                FileUpload::make('berkas_ppke')
                                    ->label('Upload PPKE')
                                    ->directory('berkas-ppke')
                                    ->preserveFilenames()
                                    ->acceptedFileTypes(['application/pdf']),

                                FileUpload::make('berkas_pmk')
                                    ->label('Upload PMK')
                                    ->directory('berkas-pmk')
                                    ->preserveFilenames()
                                    ->acceptedFileTypes(['application/pdf']),

                                FileUpload::make('berkas_pkh')
                                    ->label('Upload PKH')
                                    ->directory('berkas-pkh')
                                    ->preserveFilenames()
                                    ->acceptedFileTypes(['application/pdf']),

                                FileUpload::make('berkas_kks')
                                    ->label('Upload KKS')
                                    ->directory('berkas-kks')
                                    ->preserveFilenames()
                                    ->acceptedFileTypes(['application/pdf']),
                            ]),
                    ])
                    ->submitAction('Submit') // Ubah submitAction ke string
            ])
            ->statePath('data');
    }

    public function saveData(): void
    {
        $data = $this->form->getState(); // Ambil data dari form

        DB::beginTransaction();
        try {
            // Simpan data mahasiswa
            $mahasiswa = Mahasiswa::create([
                'noreg_kipk' => $data['noreg_kipk'],
                'nama' => $data['nama'],
                'nim' => $data['nim'],
                'jurusan' => $data['jurusan'],
                'prodi' => $data['prodi'],
                'angkatan' => $data['angkatan'],
                'semester' => $data['semester'],
                'jalur_masuk' => $data['jalur_masuk'],
                'ponsel' => $data['ponsel'],
                'alamat' => $data['alamat'],
            ]);
            
            // Simpan data listform
            Listform::create([
                'mahasiswa_id' => $mahasiswa->id,
                'kepemilikan_kip' => $data['kepemilikan_kip'],
                'tingkatan_desil' => $data['tingkatan_desil'],
                'berkas_sktm' => $data['berkas_sktm'] ?? null,
                'berkas_ppke' => $data['berkas_ppke'] ?? null,
                'berkas_pmk' => $data['berkas_pmk'] ?? null,
                'berkas_pkh' => $data['berkas_pkh'] ?? null,
                'berkas_kks' => $data['berkas_kks'] ?? null,
                'status' => 'belum_divalidasi',
            ]);

            DB::commit();

            Notification::make()
                ->success()
                ->title('Berhasil')
                ->body('Data berhasil disimpan')
                ->send();

            $this->redirect('/admin/listforms');

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
