<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gender')->default('male');
            $table->string('name')->unique();
            $table->string('base_folder')->unique();
            $table->string('base_route')->unique();
            $table->string('base_route_name')->unique();
            $table->string('class')->unique();
            $table->string('controller')->unique();
            $table->string('singular_name');
            $table->string('plural_name');
            $table->text('description');
            $table->longText('fillables');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
