<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PdfViewController;
use App\Http\Controllers\PengumumanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/view-pdf', [PdfViewController::class, 'show'])->name('pdf.view');

// Route untuk mengakses file PDF langsung
Route::get('/storage/berkas/{path}', function ($path) {
    $fullPath = storage_path('app/berkas/' . $path);
    
    if (!file_exists($fullPath)) {
        abort(404);
    }
    
    return response()->file($fullPath, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
    ]);
})->where('path', '.*');

Route::middleware(['auth'])->group(function () {
    Route::get('/pengumuman', [PengumumanController::class, 'show'])->name('pengumuman');
});
