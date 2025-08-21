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
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id('id_rdv');
            $table->date('date_rdv'); // Date du RDV
            $table->time('heure_rdv'); // Heure de début du RDV
            $table->enum('etat', ['en_attente', 'confirme', 'annule', 'reprogramme']);
            $table->text('motif')->nullable(); // Motif saisi par le patient

            // Historique des actions
            $table->enum('modifie_par', ['patient', 'medecin'])->nullable();
            $table->enum('type_action', ['prise', 'confirmation', 'annulation', 'reprogrammation'])->nullable();
            $table->dateTime('date_modification')->nullable();
            $table->dateTime('date_precedente')->nullable(); // si RDV reprogrammé

            // Clés étrangères
            $table->unsignedBigInteger('id_patient');
            $table->unsignedBigInteger('id_medecin');
            $table->unsignedBigInteger('id_specialite');

            // Relations
            $table->foreign('id_patient')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_medecin')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_specialite')->references('id_specialite')->on('specialites')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vouses');
    }
};
