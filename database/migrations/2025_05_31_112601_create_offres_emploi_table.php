<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('offre_emplois', function (Blueprint $table) {
        $table->id();
        $table->string('titre');
        $table->string('entreprise');
        $table->text('description');
        $table->string('type_contrat');
        $table->string('lieu');
        $table->string('region');
        $table->string('secteur');
        $table->json('competences');
        $table->decimal('salaire_min', 10, 2)->nullable();
        $table->decimal('salaire_max', 10, 2)->nullable();
        $table->integer('experience_requise');
        $table->string('url_candidature')->nullable();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->dateTime('date_publication');
        $table->dateTime('date_expiration');
        $table->boolean('actif')->default(true);
        $table->integer('vues')->default(0);
        $table->integer('favoris')->default(0);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::dropIfExists('offre_emplois');
}

};
