@php
    $record = $getRecord();
@endphp

@if($record->status === 'tidak_valid')
    <div class="text-danger-600">
        Mohon maaf, berkas Anda dinyatakan tidak valid.
        @if($record->alasan_tidak_valid)
            <br>
            <small>Alasan: {{ $record->alasan_tidak_valid }}</small>
        @endif
    </div>
@elseif($record->status === 'valid')
    @if($record->hasil === 'Layak')
        <div class="text-success-600">
            Selamat! Anda dinyatakan LULUS seleksi dan berhak menerima KIP-K.
        </div>
    @elseif($record->hasil === 'Dipertimbangkan')
        <div class="text-warning-600">
            Anda masuk dalam daftar pertimbangan. Mohon tunggu pengumuman selanjutnya.
        </div>
    @else
        <div class="text-danger-600">
            Mohon maaf, Anda dinyatakan TIDAK LULUS seleksi KIP-K.
        </div>
    @endif
@else
    <div class="text-gray-500">
        Berkas Anda masih dalam proses validasi.
    </div>
@endif 