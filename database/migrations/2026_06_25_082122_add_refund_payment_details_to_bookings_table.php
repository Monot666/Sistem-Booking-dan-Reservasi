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
            $table->string('refund_payment_method')->nullable()->after('refund_reason');
            $table->string('refund_payment_account')->nullable()->after('refund_payment_method');
            $table->string('refund_account_name')->nullable()->after('refund_payment_account');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['refund_payment_method', 'refund_payment_account', 'refund_account_name']);
        });
    }
};
