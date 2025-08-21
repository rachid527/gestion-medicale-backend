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
        Schema::create('dossier_medicals', function (Blueprint $table) {
            $table->id('id_dossier');   // ID unique du dossier médical
            $table->unsignedBigInteger('id_patient')->unique(); // Relation 1:1 avec patient

            // Données médicales
            $table->string('groupe_sanguin')->nullable(); // Ex : O+, A-, B-
            $table->text('allergies')->nullable();        // Allergies connues
            $table->text('antecedents')->nullable();      // Antécédents médicaux
            $table->float('poids')->nullable();           // Dernier poids connu (kg)
            $table->text('remarques')->nullable();        // Remarques générales

            // Relation avec patient
            $table->foreign('id_patient')->references('id')->on('utilisateurs')->onDelete('cascade');
            $table->timestamps();    // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossier_medicals');
    }
};
