<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsPermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::table('permissions', function (Blueprint $table) {
            $table->text('group')->nullable()->after('name');
            $table->bigInteger('module_route_id')->unsigned()->nullable()->after('guard_name');
            $table->foreign('module_route_id')->references('id')->on('module_routes')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('group');
            $table->dropForeign('module_route_id');
            $table->dropColumn('module_route_id');
        });
    }

}
