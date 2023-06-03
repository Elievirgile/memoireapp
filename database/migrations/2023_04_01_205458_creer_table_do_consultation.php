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
        //
        Schema::create('faire_consultation', function (Blueprint $table) {
            $table->string('id_consultation')->primary(); //consultation ticket value
            $table->string('dr_email');
            $table->string('patient_email');
            $table->string('observation_postconsultation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('faire_consultation');
    }
};
