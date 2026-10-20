<?php

namespace App\Models;
use App\Models\Penilaian;
use Illuminate\Database\Eloquent\Model;

class Pakta extends Model
{
    protected $table = 'paktas';

    protected $fillable = [
        'ref_number', 'nama', 'jabatan', 'instansi', 'no_wa',
        'email', 'kepentingan', 'alamat', 'signature',
        'pdf_path',
    ];
    public function penilaian()
{
    return $this->hasOne(Penilaian::class);
}
} 
