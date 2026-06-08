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
        Schema::table('resources', function (Blueprint $table) {
            $table->string('size')->nullable()->after('capacity');
            $table->text('facilities')->nullable()->after('size');
            $table->integer('max_adults')->default(1)->after('capacity');
            $table->integer('max_children')->default(0)->after('max_adults');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn(['size', 'facilities', 'max_adults', 'max_children']);
        });
    }
};
