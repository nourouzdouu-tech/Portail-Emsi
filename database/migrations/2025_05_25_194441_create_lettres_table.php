<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lettres', function (Blueprint $table) {
            $table->id();
            $table->string('prenom');
            $table->string('nom');
            $table->string('adresse');
            $table->string('telephone');
            $table->string('email');
            $table->string('entreprise');
            $table->string('adresseEntreprise');
            $table->string('poste');
            $table->string('objet');
            $table->text('introduction');
            $table->text('competences');
            $table->text('motivation');
            $table->text('conclusion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lettres');
    }
};
