<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recettes', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->decimal('montant', 10, 2);
            $table->date('date');
            $table->foreignId('demande_messe_id')->nullable()->constrained('demandes_messe');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recettes');
    }
};