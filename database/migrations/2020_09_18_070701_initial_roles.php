<?php

use Illuminate\Database\Migrations\Migration;
use App\Roles;

class InitialRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $components = new Roles();
        $components->title      = 'Probation';
        $components->save();

        $components = new Roles();
        $components->title      = 'Registered';
        $components->save();

        $components = new Roles();
        $components->title      = 'Verified';
        $components->save();

        $components = new Roles();
        $components->title      = 'NotUsed';
        $components->save();

        $components = new Roles();
        $components->title      = 'NotUsed2';
        $components->save();

        $components = new Roles();
        $components->title      = 'Tester';
        $components->save();

        $components = new Roles();
        $components->title      = 'Moderator';
        $components->save();

        $components = new Roles();
        $components->title      = 'Admin';
        $components->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Roles::truncate();
    }
}
