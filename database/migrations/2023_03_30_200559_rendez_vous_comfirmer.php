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
        Schema::create('rdv_confirmed', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dr_name');
            $table->string('patient_name');
            $table->string('plage_horaire');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('rdv_confirmed');

    }
};
