<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Trends;

class UpdateTrendsAddDatedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::connection('trends')->hasTable('trends')) {
            if ( ! Schema::connection('trends')->hasColumn('trends', 'dated_at')) {
                Schema::connection('trends')->table('trends', function (Blueprint $table) {
                    $table->string('dated_at')->nullable();
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
        if (Schema::connection('trends')->hasTable('trends')) {
            if (Schema::connection('trends')->hasColumn('trends', 'dated_at')) {
                Schema::connection('trends')->table('trends', function (Blueprint $table) {
                    $table->dropColumn('trends');
                });
            }
        }
    }
}
