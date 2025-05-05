<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Status</h2>
            {{ $this->infolist }}
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Status Progres</h2>
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                    <span class="text-sm text-gray-600">Data Anda sedang dalam proses validasi</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="h-2 w-2 rounded-full bg-yellow-500"></div>
                    <span class="text-sm text-gray-600">Tim akan memeriksa kelengkapan dokumen Anda</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="h-2 w-2 rounded-full bg-green-500"></div>
                    <span class="text-sm text-gray-600">Hasil seleksi akan diumumkan sesuai jadwal</span>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>