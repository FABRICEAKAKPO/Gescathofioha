<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('depenses', function (Blueprint $table) {
            $table->id();
            $table->string('motif');
            $table->decimal('montant', 10, 2);
            $table->string('nom_encaisseur');
            $table->string('prenom_encaisseur');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('depenses');
    }
};