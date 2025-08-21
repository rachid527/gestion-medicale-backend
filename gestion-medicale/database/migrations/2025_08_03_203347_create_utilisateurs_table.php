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
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('mot_de_passe'); // PAS besoin de "confirmer"
            $table->string('telephone')->nullable();
            $table->string('adresse')->nullable();
            $table->enum('sexe', ['Homme', 'Femme']);
            $table->date('date_naissance')->nullable();
            $table->enum('role', ['super_admin', 'admin', 'medecin', 'patient']);
            $table->enum('statut', ['actif', 'desactive'])->default('desactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
