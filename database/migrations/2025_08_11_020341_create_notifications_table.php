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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('id_notification'); // ID unique de la notification

            $table->unsignedBigInteger('id_user'); // À qui est destinée la notification
            $table->unsignedBigInteger('id_rdv')->nullable(); // Notification liée à un RDV (optionnel)

            $table->string('type_notification'); // Exemple : confirmation, annulation, rappel, etc.
            $table->text('contenu');             // Message à afficher
            $table->boolean('lu')->default(false); // Lu ou non

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_rdv')->references('id_rdv')->on('rendez_vous')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
