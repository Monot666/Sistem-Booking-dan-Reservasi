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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('no_pesanan')->unique()->after('id')->nullable();
            $table->string('nama_pemesan')->after('user_id')->nullable();
            $table->string('no_hp')->after('nama_pemesan')->nullable();
            $table->string('email')->after('no_hp')->nullable();
            $table->string('nama_pengunjung')->after('email')->nullable();
            $table->text('permintaan_khusus')->after('nama_pengunjung')->nullable();
            $table->decimal('tax_and_fee', 12, 2)->after('total_price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'no_pesanan',
                'nama_pemesan',
                'no_hp',
                'email',
                'nama_pengunjung',
                'permintaan_khusus',
                'tax_and_fee'
            ]);
        });
    }
};
