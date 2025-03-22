<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Hasil Pengumuman KIP-K</h2>

                @if($pengumuman)
                    <div class="mb-4">
                        <h3 class="font-semibold">Status Berkas:</h3>
                        <div class="mt-2">
                            @if($pengumuman->status === 'valid')
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded">Valid</span>
                            @elseif($pengumuman->status === 'tidak_valid')
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded">Tidak Valid</span>
                            @else
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded">Dalam Proses Validasi</span>
                            @endif
                        </div>
                    </div>

                    @if($pengumuman->status === 'tidak_valid')
                        <div class="mt-4 p-4 bg-red-50 text-red-700 rounded">
                            <p class="font-semibold">Mohon maaf, berkas Anda dinyatakan tidak valid.</p>
                            @if($pengumuman->alasan_tidak_valid)
                                <p class="mt-2">Alasan: {{ $pengumuman->alasan_tidak_valid }}</p>
                            @endif
                        </div>
                    @elseif($pengumuman->status === 'valid')
                        <div class="mt-4">
                            <h3 class="font-semibold">Hasil Seleksi:</h3>
                            <div class="mt-4">
                                @if($pengumuman->hasil === 'Layak')
                                    <div class="p-4 bg-green-50 text-green-700 rounded">
                                        <p class="font-semibold">Selamat! Anda dinyatakan LULUS seleksi dan berhak menerima KIP-K.</p>
                                    </div>
                                @elseif($pengumuman->hasil === 'Dipertimbangkan')
                                    <div class="p-4 bg-yellow-50 text-yellow-700 rounded">
                                        <p class="font-semibold">Anda masuk dalam daftar pertimbangan. Mohon tunggu pengumuman selanjutnya.</p>
                                    </div>
                                @else
                                    <div class="p-4 bg-red-50 text-red-700 rounded">
                                        <p class="font-semibold">Mohon maaf, Anda dinyatakan TIDAK LULUS seleksi KIP-K.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="mt-4 p-4 bg-gray-50 text-gray-700 rounded">
                            <p>Berkas Anda masih dalam proses validasi. Silakan cek kembali nanti.</p>
                        </div>
                    @endif
                @else
                    <div class="p-4 bg-yellow-50 text-yellow-700 rounded">
                        <p>Anda belum mengajukan pendaftaran KIP-K.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 