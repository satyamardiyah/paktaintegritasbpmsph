<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pakta extends Model
{
    protected $table = 'paktas';

    protected $fillable = [
        'ref_number', 'nama', 'jabatan', 'instansi',
        'email', 'kepentingan', 'alamat', 'signature',
        'pdf_path', 'status',
    ];
} 