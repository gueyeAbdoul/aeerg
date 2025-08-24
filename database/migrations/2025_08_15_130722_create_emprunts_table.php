<?php

// database/migrations/xxxx_create_emprunts_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('emprunts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('date_emprunt');
            $table->dateTime('date_retour_prevue');
            $table->dateTime('date_retour_effective')->nullable();
            $table->enum('statut', ['actif', 'retard', 'rendu'])->default('actif');
            $table->timestamps();
            $table->index(['document_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emprunts');
    }
};
