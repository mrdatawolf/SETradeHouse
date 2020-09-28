<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeStampsToServersAndWorlds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('servers')) {
            if ( ! Schema::hasColumn('servers', 'updated_at')) {
                Schema::table('servers', function (Blueprint $table) {
                    $table->timestamps();
                });
            }
            $server =\App\Servers::where('title', 'The Nebulon Cluster')->first();
            $server->created_at = now();
            $server->save();
            $server->touch();
        }

        if (Schema::hasTable('worlds')) {
            if ( ! Schema::hasColumn('worlds', 'updated_at')) {
                Schema::table('worlds', function (Blueprint $table) {
                    $table->timestamps();
                });
            }
            $server = \App\Worlds::where('title', 'Nebulon')->first();
            $server->created_at = now();
            $server->save();
            $server->touch();
            $server = \App\Worlds::where('title', 'Nebulon-test')->first();
            $server->created_at = now();
            $server->save();
            $server->touch();
            $server = \App\Worlds::where('title', 'AAITN')->first();
            $server->created_at = now();
            $server->save();
            $server->touch();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('servers')) {
            if (Schema::hasColumn('servers','updated_at')) {
                Schema::table('servers', function (Blueprint $table) {
                    $table->dropColumn('updated_at');
                });
            }
        }
        if (Schema::hasTable('servers')) {
            if (Schema::hasColumn('servers','created_at')) {
                Schema::table('servers', function (Blueprint $table) {
                    $table->dropColumn('created_at');
                });
            }
        }

        if (Schema::hasTable('worlds')) {
            if (Schema::hasColumn('worlds','updated_at')) {
                Schema::table('worlds', function (Blueprint $table) {
                    $table->dropColumn('updated_at');
                });
            }
        }
        if (Schema::hasTable('worlds')) {
            if (Schema::hasColumn('worlds','created_at')) {
                Schema::table('worlds', function (Blueprint $table) {
                    $table->dropColumn('created_at');
                });
            }
        }
    }
}
