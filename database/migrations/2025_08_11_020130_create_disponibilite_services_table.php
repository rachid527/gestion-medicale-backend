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
        Schema::create('disponibilite_services', function (Blueprint $table) {
            $table->id('id_disponibilite'); // ID unique de disponibilité

            $table->unsignedBigInteger('id_service'); // Clé étrangère vers service

            $table->enum('jour_semaine', [
                'Lundi',
                'Mardi',
                'Mercredi',
                'Jeudi',
                'Vendredi',
                'Samedi',
                'Dimanche'
            ]);

            $table->time('heure_debut'); // Heure d’ouverture (ex: 09:00)
            $table->time('heure_fin');   // Heure de fermeture (ex: 15:00)
            $table->boolean('estOuvert')->default(true); // Activer/désactiver la disponibilité ce jour-là

            // Relation avec service
            $table->foreign('id_service')->references('id_service')->on('services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disponibilite_services');
    }
};
