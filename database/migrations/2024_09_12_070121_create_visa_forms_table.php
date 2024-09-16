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
        Schema::create('visa_forms', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('surname');
            $table->string('first_name');
            $table->string('residence');
            $table->string('marital_status');
            $table->string('national_identity_number');
            $table->string('travel_document');
            $table->text('journey_purpose'); 
            $table->date('arrival');
            $table->date('departure');
            $table->json('travel_companion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_forms');
    }
};
