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
        Schema::create('specialites', function (Blueprint $table) {
            $table->id('id_specialite'); // ID unique de la spécialité
            $table->string('nom_specialite'); // Ex : Pédiatre, Radiologue
            $table->unsignedBigInteger('id_service'); // Clé étrangère vers service
            $table->text('description')->nullable(); // Description spécifique

            // Relation avec services
            $table->foreign('id_service')->references('id_service')->on('services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialites');
    }
};
