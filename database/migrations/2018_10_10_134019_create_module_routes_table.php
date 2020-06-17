<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_routes', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('method'); //get post delete put patch
            $table->string('uri');
            $table->string('name');
            $table->string('controller');
            $table->string('middleware');
            $table->boolean('has_permission')->default(0);
            $table->bigInteger('module_id')->unsigned()->nullable();
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->longText('fields')->nullable();
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
        Schema::dropIfExists('module_routes');
    }
}
