<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PdfViewController extends Controller
{
    public function show(Request $request)
    {
        $path = $request->query('path');
        
        if (!$path) {
            abort(404);
        }

        // Ambil file dari storage
        $fullPath = storage_path('app/public/' . $path);
        
        if (!file_exists($fullPath)) {
            abort(404);
        }

        // Return file sebagai response dengan header yang sesuai
        return response()->file($fullPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
        ]);
    }
} 