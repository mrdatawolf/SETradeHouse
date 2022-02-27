<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRarityToWorlds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('worlds')) {
            if ( ! Schema::hasColumn('worlds', 'rarity_id')) {
                Schema::table('worlds', function (Blueprint $table) {
                    $table->integer('rarity_id')->default(1);
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
        if (Schema::hasTable('worlds')) {
            if (Schema::hasColumn('worlds','rarity_id')) {
                Schema::table('worlds', function (Blueprint $table) {
                    $table->dropColumn('rarity_id');
                });
            }
        }
    }
}
