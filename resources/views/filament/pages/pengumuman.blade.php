<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Pengumuman Hasil Seleksi KIP-K</h2>
            <p class="text-gray-600 mb-4">
                Berikut adalah status pengajuan dan hasil seleksi KIP-K Anda. Silakan periksa secara berkala untuk mendapatkan informasi terbaru.
            </p>

            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page> 