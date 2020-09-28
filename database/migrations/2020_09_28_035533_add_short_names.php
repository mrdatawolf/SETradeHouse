<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShortNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('servers')) {
            if ( ! Schema::hasColumn('servers', 'short_name')) {
                Schema::table('servers', function (Blueprint $table) {
                    $table->string('short_name')->nullable();
                });
            }
        }

        if (Schema::hasTable('worlds')) {
            if ( ! Schema::hasColumn('worlds', 'short_name')) {
                Schema::table('worlds', function (Blueprint $table) {
                    $table->string('short_name')->nullable();
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
        if (Schema::hasTable('servers')) {
            if (Schema::hasColumn('servers','short_name')) {
                Schema::table('servers', function (Blueprint $table) {
                    $table->dropColumn('short_name');
                });
            }
        }

        if (Schema::hasTable('worlds')) {
            if (Schema::hasColumn('worlds','short_name')) {
                Schema::table('worlds', function (Blueprint $table) {
                    $table->dropColumn('short_name');
                });
            }
        }
    }
}
