<?php

namespace Tests\Unit;

use App\Models\Penilaian;
use PHPUnit\Framework\TestCase;

class PenilaianTest extends TestCase
{
    public function test_categorical_scores_have_a_numeric_value_for_aggregation(): void
    {
        $this->assertSame(3, Penilaian::scoreValue('Tinggi'));
        $this->assertSame(2, Penilaian::scoreValue('Sedang'));
        $this->assertSame(1, Penilaian::scoreValue('Rendah'));
        $this->assertNull(Penilaian::scoreValue('Tidak valid'));
    }

    public function test_only_the_three_categorical_scores_are_recognized(): void
    {
        $this->assertSame('Tinggi', Penilaian::scoreLabel('Tinggi'));
        $this->assertSame('Sedang', Penilaian::scoreLabel('Sedang'));
        $this->assertSame('Rendah', Penilaian::scoreLabel('Rendah'));
        $this->assertSame('-', Penilaian::scoreLabel(1));
    }
}
