@if($url)
    <div>
        <a href="{{ $url }}" target="_blank" class="text-primary-600 hover:text-primary-500">
            Lihat {{ $label }}
        </a>
    </div>
@else
    <div class="text-gray-500">
        Tidak ada berkas
    </div>
@endif 