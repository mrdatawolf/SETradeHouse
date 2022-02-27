<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Ammo;

class UpdateAmmoSeApiNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('ammo')) {
            if ( ! Schema::hasColumn('ammo', 'api_name')) {
                Schema::table('ammo', function (Blueprint $table) {
                    $table->string('api_name')->nullable();
                });
            }
        }
        $ammo = Ammo::where('se_name', 'MyObjectBuilder_AmmoMagazine/NATO_5p56x45mm')->first();
        if($ammo) {
            $ammo->api_name = 'NATO_5p56x45mm';
            $ammo->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('ammo')) {
            if (Schema::hasColumn('ammo', 'api_name')) {
                Schema::table('ammo', function (Blueprint $table) {
                    $table->dropColumn('api_name');
                });
            }
        }
    }
}
