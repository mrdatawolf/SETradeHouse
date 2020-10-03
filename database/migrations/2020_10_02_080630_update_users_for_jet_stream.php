<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersForJetStream extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            if ( ! Schema::hasColumn('users', 'current_team_id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->foreignId('current_team_id')->nullable();
                });
            }
        }

        if (Schema::hasTable('users')) {
            if ( ! Schema::hasColumn('users', 'profile_photo_path')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->text('profile_photo_path')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users')) {
            if (Schema::hasColumn('users', 'current_team_id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('current_team_id');
                });
            }
        }

        if (Schema::hasTable('users')) {
            if (Schema::hasColumn('users', 'profile_photo_path')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('profile_photo_path');
                });
            }
        }
    }
}
