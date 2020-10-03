<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Team;

class AddTeamsForExistingUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            if ( Schema::hasColumn('users', 'current_team_id')) {
                foreach(User::all() as $user) {
                    $personalTeamsName = $user->username . "'s Team";
                    $team = Team::firstOrCreate([
                        'user_id' => $user->id,

                    ], [
                        'name' => $personalTeamsName,
                        'personal_team' => 1
                       ]
                    );
                    $user->current_team_id = $team->id;
                    $user->save();
                }
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
        //
    }
}
