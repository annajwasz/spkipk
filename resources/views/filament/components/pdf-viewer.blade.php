@php
    $url = $url instanceof \Closure ? $url($record ?? null) : $url;
    // Dapatkan path file dari URL
    $path = str_replace('/storage/berkas/', '', $url);
@endphp

@if($url)
<div class="w-full">
    <div class="border border-gray-300 rounded-lg overflow-hidden bg-white">
        <embed
            src="{{ asset('berkas/' . $path) }}"
            type="application/pdf"
            width="100%"
            height="800px"
            class="w-full"
        />
    </div>
    <div class="mt-2 flex justify-end">
        <a href="{{ $url }}" class="text-primary-600 hover:text-primary-500 flex items-center" target="_blank">
            <span class="mr-2">Download PDF</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
        </a>
    </div>
</div>
@endif 