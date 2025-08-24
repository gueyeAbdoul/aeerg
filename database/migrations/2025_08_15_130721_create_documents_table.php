<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->boolean('is_disponible')->default(true);
            $table->date('date_ajout')->default(now());
            $table->string('chemin_fichier');
            $table->foreignId('proprietaire_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->index('titre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
