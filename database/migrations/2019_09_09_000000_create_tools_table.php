<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('se_name');
            $table->decimal('cobalt');
            $table->decimal('gold');
            $table->decimal('iron');
            $table->decimal('magnesium');
            $table->decimal('nickel');
            $table->decimal('platinum');
            $table->decimal('silicon');
            $table->decimal('silver');
            $table->decimal('gravel');
            $table->decimal('uranium');
            $table->decimal('naquadah');
            $table->decimal('trinium');
            $table->decimal('neutronium');
            $table->decimal('mass');
            $table->decimal('volume');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tools');
    }
}
