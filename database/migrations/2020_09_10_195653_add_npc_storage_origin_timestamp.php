<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNpcStorageOriginTimestamp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::connection('storage')->hasTable('npc_storage_values')) {
            if (!Schema::connection('storage')->hasColumn('npc_storage_values','origin_timestamp')) {
                Schema::connection('storage')->table('npc_storage_values', function (Blueprint $table) {
                    $table->timestamp('origin_timestamp')->nullable();
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
        if (Schema::connection('storage')->hasTable('npc_storage_values')) {
            if (Schema::connection('storage')->hasColumn('npc_storage_values','origin_timestamp')) {
                Schema::connection('storage')->table('npc_storage_values', function (Blueprint $table) {
                    $table->dropColumn('origin_timestamp');
                });
            }
        }
    }
}
