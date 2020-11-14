<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserStorageOriginTimestamp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::connection('storage')->hasTable('user_storage_values')) {
            if (!Schema::connection('storage')->hasColumn('user_storage_values','origin_timestamp')) {
                Schema::connection('storage')->table('user_storage_values', function (Blueprint $table) {
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
        if (Schema::connection('storage')->hasTable('user_storage_values')) {
            if (Schema::connection('storage')->hasColumn('user_storage_values','origin_timestamp')) {
                Schema::connection('storage')->table('user_storage_values', function (Blueprint $table) {
                    $table->dropColumn('origin_timestamp');
                });
            }
        }
    }
}
