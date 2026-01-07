<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('conseils', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->json('contenu');
            $table->enum('categorie', ['cv', 'lettre', 'entretien']);
            $table->integer('ordre')->default(0);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conseils');
    }
};