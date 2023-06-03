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

        Schema::create('analyse_biomedicale', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_patient');
            $table->string('maladie_hereditaire');
            $table->string('groupe_sanguin');
            $table->string('allergie');
            $table->string('type_assurance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
