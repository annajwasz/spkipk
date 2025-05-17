<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;

// class Pengumuman extends Model
// {
//     use HasFactory;

//     protected $table = 'pengumumans';

//     protected $fillable = [
//         'parameter_id',
//         'user_id',
//         'keterangan'
//     ];

//     public function parameter(): BelongsTo
//     {
//         return $this->belongsTo(Parameter::class);
//     }

//     public function user(): BelongsTo
//     {
//         return $this->belongsTo(User::class);
//     }
// } 