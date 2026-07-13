<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('paktas', function (Blueprint $table) {
        $table->id();
        $table->string('ref_number')->unique();
        $table->string('nama');
        $table->string('jabatan');
        $table->string('instansi');
        $table->string('email');
        $table->string('kepentingan');
        $table->text('alamat');
        $table->longText('signature');
        $table->string('pdf_path')->nullable();
        $table->string('status')->default('done');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paktas');
    }
};