<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('type', ['candidat', 'recruteur', 'admin'])->default('candidat');
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->string('profile_type')->nullable(); // 'App\Models\Candidat' ou 'App\Models\Recruteur'
            $table->rememberToken();
            $table->timestamps();
            $table->string('prenom')->nullable();


        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};