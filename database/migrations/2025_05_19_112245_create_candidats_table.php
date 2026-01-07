<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
       Schema::create('candidats', function (Blueprint $table) {
    $table->id();
    $table->string('name')->nullable();
    $table->string('phone')->nullable();
    $table->string('ville')->nullable();
    $table->text('about')->nullable();

    $table->string('cv_path')->nullable();
    $table->string('lettre_motivation')->nullable();
    $table->json('competences')->nullable();
    $table->string('niveau_etude')->nullable();
    $table->integer('annees_experience')->default(0);
    $table->timestamps();
});

    }

    public function down()
    {
        Schema::dropIfExists('candidats');
    }
};