<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = [
        'pakta_id',
        'kriteria',
        'catatan',
        'signature',
        'nama_penilai',
    ];

    protected $casts = [
        'kriteria' => 'array',
    ];

    public static function scoreLabel($score): string
    {
        $score = (string) $score;

        return in_array($score, ['Tinggi', 'Sedang', 'Rendah'], true)
            ? $score
            : '-';
    }

    public static function scoreValue($score): ?int
    {
        return [
            'Rendah' => 1,
            'Sedang' => 2,
            'Tinggi' => 3,
        ][self::scoreLabel($score)] ?? null;
    }

    public function isComplete(): bool
    {
        $kriteria = $this->kriteria;

        if (!is_array($kriteria) || count($kriteria) === 0) {
            return false;
        }

        foreach ($kriteria as $item) {
            if (
                !is_array($item) ||
                empty(trim((string) ($item['nama'] ?? ''))) ||
                self::scoreValue($item['skor'] ?? null) === null
            ) {
                return false;
            }
        }

        return true;
    }

    public function finalScore(): ?float
    {
        if (!$this->isComplete()) {
            return null;
        }

        $totalSkor = 0;
        $jumlahKriteria = count($this->kriteria);

        foreach ($this->kriteria as $item) {
            $totalSkor += self::scoreValue($item['skor']);
        }

        return round(
            ($totalSkor / ($jumlahKriteria * 3)) * 100,
            2
        );
    }

    public function finalCategory(): ?string
    {
        $nilai = $this->finalScore();

        if ($nilai === null) {
            return null;
        }

        if ($nilai >= 80) {
            return 'Tinggi';
        }

        if ($nilai >= 60) {
            return 'Sedang';
        }

        return 'Rendah';
    }

    public function pakta()
    {
        return $this->belongsTo(Pakta::class);
    }
}
