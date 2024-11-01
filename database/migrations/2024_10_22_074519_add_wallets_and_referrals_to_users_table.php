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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->decimal('profit_wallet', 12, 2)->default(0.00);
            $table->decimal('investment_wallet', 12, 2)->default(0.00);
            $table->decimal('main_wallet', 12, 2)->default(0.00);
            $table->string('referral_code')->nullable();
            $table->string('referral_link')->nullable();
            $table->string('referred_by')->nullable();
            $table->boolean('activate_investment')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //

        });
    }
};
