<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('se_name');
            $table->decimal('cobalt')->default(0);
            $table->decimal('gold')->default(0);
            $table->decimal('iron')->default(0);
            $table->decimal('magnesium')->default(0);
            $table->decimal('nickel')->default(0);
            $table->decimal('platinum')->default(0);
            $table->decimal('silicon')->default(0);
            $table->decimal('silver')->default(0);
            $table->decimal('gravel')->default(0);
            $table->decimal('uranium')->default(0);
            $table->decimal('naquadah')->default(0);
            $table->decimal('trinium')->default(0);
            $table->decimal('neutronium')->default(0);
            $table->decimal('mass')->default(0);
            $table->decimal('volume')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('components');
    }
}
