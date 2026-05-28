<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('pemesanans', function (Blueprint $table) {
        $table->id();
        // PASTIKAN BARIS INI ADA:
        $table->string('no_pesanan')->unique(); 
        
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('nama_pemesan');
        $table->string('no_hp');
        $table->string('email');
        $table->string('nama_pengunjung')->nullable();
        $table->text('permintaan_khusus')->nullable();
        $table->string('room_name');
        $table->string('option_type');
        $table->integer('price_per_night');
        $table->integer('tax_and_fee');
        $table->integer('total_price');
        $table->string('status')->default('pending');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};