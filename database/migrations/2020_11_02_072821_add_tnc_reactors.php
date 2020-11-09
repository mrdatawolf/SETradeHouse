<?php

use Illuminate\Database\Migrations\Migration;
use \App\Models\Reactors;

class AddTncReactors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $reactor = new Reactors();
        $reactor->ship_size = 'small';
        $reactor->size = 'small';
        $reactor->type = 'naquadah';
        $reactor->watts = 4500000;
        $reactor->save();

        $reactor = new Reactors();
        $reactor->ship_size = 'large';
        $reactor->size = 'small';
        $reactor->type = 'naquadah';
        $reactor->watts = 45000000;
        $reactor->save();
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
