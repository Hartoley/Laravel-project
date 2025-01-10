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
        Schema::table('visa_forms', function (Blueprint $table) {
            //
            Schema::table('visa_forms', function (Blueprint $table) {
                $table->string('selectedCountry')->nullable()->after('status'); // Replace 'last_column_name' with the actual last column in the table
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visa_forms', function (Blueprint $table) {
            //
            Schema::table('visa_forms', function (Blueprint $table) {
                $table->dropColumn('selectedCountry');
            });
        });
    }
};
