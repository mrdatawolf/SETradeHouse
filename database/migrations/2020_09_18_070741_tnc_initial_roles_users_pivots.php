<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Roles;
use App\Models\User;

class TncInitialRolesUsersPivots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roles = new Roles();
        $adminRole = $roles->where('title','Admin')->first();
        $testerRole = $roles->where('title','Tester')->first();
        $users = new User();
        $user = $users->where('username', 'datawolf')->first();
        $user->roles()->attach($adminRole->id);
        $user = $users->where('username', 'Mci')->first();
        $user->roles()->attach($adminRole->id);
        $user = $users->where('username', 'Servovicis')->first();
        $user->roles()->attach($adminRole->id);
        $user = $users->where('username', 'hobobot')->first();
        $user->roles()->attach($adminRole->id);
        $user = $users->where('username', 'Kyneroth')->first();
        $user->roles()->attach($adminRole->id);
        $user = $users->where('username', 'R3D5H1RT')->first();
        $user->roles()->attach($testerRole->id);
        $user = $users->where('username', 'valtroth')->first();
        $user->roles()->attach($testerRole->id);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
