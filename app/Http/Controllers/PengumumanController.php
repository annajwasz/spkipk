<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function show()
    {
        $pengumuman = Parameter::where('mahasiswa_id', auth()->user()->mahasiswa->id)
            ->first();

        return view('pengumuman', compact('pengumuman'));
    }
} 