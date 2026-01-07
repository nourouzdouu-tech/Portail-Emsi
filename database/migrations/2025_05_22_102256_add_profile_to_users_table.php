<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'profile_id')) {
                $table->unsignedBigInteger('profile_id')->nullable();
            }

            if (!Schema::hasColumn('users', 'profile_type')) {
                $table->string('profile_type')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'profile_id')) {
                $table->dropColumn('profile_id');
            }

            if (Schema::hasColumn('users', 'profile_type')) {
                $table->dropColumn('profile_type');
            }
        });
    }
};
