<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id_specialite')->nullable()->after('role');

            // 🔗 clé étrangère vers la table specialites
            $table->foreign('id_specialite')
                ->references('id_specialite')
                ->on('specialites')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_specialite']);
            $table->dropColumn('id_specialite');
        });
    }
};
