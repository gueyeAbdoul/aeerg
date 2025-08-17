<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotisations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->float('montant');
            $table->date('date_paiement')->nullable();
            $table->enum('statut', ['payé', 'en_attente'])->default('en_attente');
            $table->enum('methode', ['cash', 'mobile_money', 'virement'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotisations');
    }
};
