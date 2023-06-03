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
        Schema::create('analyseBioMedicale', function (Blueprint $table) {
            $table->string('id_analyse')->primary();
            $table->string('type_analyse');
            $table->string('date_debut');
            $table->string('delais');
            $table->string('date_fin');
            $table->string('statut');
            $table->string('client_concerne');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyse');
    }
};
