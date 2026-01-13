<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('demandes_messe', function (Blueprint $table) {
            $table->id();
            $table->string('demandeur');
            $table->text('intentions');
            $table->enum('type_messe', [
                'QUOTIDIEN',
                'DOMINICAL',
                'TRIDUUM',
                'NEUVAINE',
                'TRENTAINE',
                'MARIAGE',
                'DEFUNT',
                'VEILLEE',
                'ENTERREMENT',
                'SPECIALE'
            ]);
            $table->decimal('prix', 10, 2);
            $table->decimal('montant_paye', 10, 2);
            $table->date('date_celebration');
            $table->time('heure_celebration');
            $table->string('numero_recu')->unique();
            $table->enum('statut', ['en_attente', 'celebree', 'annulee'])->default('en_attente');
            $table->timestamps();
        });

        // Table pour les célébrations multiples (TRIDUUM, NEUVAINE, TRENTAINE)
        Schema::create('celebrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demande_messe_id')->constrained('demandes_messe')->onDelete('cascade');
            $table->date('date_celebration');
            $table->time('heure_celebration');
            $table->enum('statut', ['en_attente', 'celebree'])->default('en_attente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('celebrations');
        Schema::dropIfExists('demandes_messe');
    }
};