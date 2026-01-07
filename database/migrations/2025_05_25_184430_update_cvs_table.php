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
    Schema::table('cvs', function (Blueprint $table) {
        if (!Schema::hasColumn('cvs', 'address')) {
            $table->string('address')->nullable()->after('job_title');
        }
        
        if (!Schema::hasColumn('cvs', 'city')) {
            $table->string('city')->nullable()->after('address');
        }
        
        if (!Schema::hasColumn('cvs', 'formations')) {
            $table->json('formations')->nullable()->after('skills');
        }
        
        // Pour modifier le type de colonne existante
        if (Schema::hasColumn('cvs', 'experiences')) {
            $table->json('experiences')->change();
        }
    });
}

public function down()
{
    Schema::table('cvs', function (Blueprint $table) {
        // Ici vous pouvez choisir de supprimer ou garder les colonnes en rollback
        // $table->dropColumn(['address', 'city', 'formations']);
    });
}
};
