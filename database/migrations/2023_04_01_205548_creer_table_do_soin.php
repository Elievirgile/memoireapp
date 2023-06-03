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
        Schema::create('administrer_soin', function (Blueprint $table) {
            $table->string('id_soin');
            $table->bigIncrements('id');
            $table->string('description_soin');
            $table->foreign('id_soin')->references('id_consultation')->on('faire_consultation')->onDelete('cascade');
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
