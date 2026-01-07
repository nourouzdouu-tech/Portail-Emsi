<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('recruteurs', function (Blueprint $table) {
            $table->id();
            $table->string('entreprise');
            $table->string('secteur');
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->string('site_web')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recruteurs');
    }
};