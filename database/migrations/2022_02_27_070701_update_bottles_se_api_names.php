<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Bottles;

class UpdateBottlesSeApiNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('bottles')) {
            if ( ! Schema::hasColumn('bottles', 'api_name')) {
                Schema::table('bottles', function (Blueprint $table) {
                    $table->string('api_name')->nullable();
                });
            }
        }
        $bottles = Bottles::where('se_name', 'MyObjectBuilder_OxygenContainerObject/OxygenBottle')->first();
        if($bottles) {
            $bottles->api_name = 'OxygenBottle';
            $bottles->save();
        }
        $bottles = Bottles::where('se_name', 'MyObjectBuilder_GasContainerObject/HydrogenBottle')->first();
        if($bottles) {
            $bottles->api_name = 'HydrogenBottle';
            $bottles->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('bottles')) {
            if (Schema::hasColumn('bottles', 'api_name')) {
                Schema::table('bottles', function (Blueprint $table) {
                    $table->dropColumn('api_name');
                });
            }
        }
    }
}
