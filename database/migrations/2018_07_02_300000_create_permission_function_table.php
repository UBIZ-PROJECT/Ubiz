<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionFunctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_function', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dep_id');
            $table->integer('screen_id');
            $table->integer('function_id');
            $table->string('function_name', 255);
            $table->char('delete_flg', 1)->default('0');
            $table->timestamp('inp_date')->useCurrent();;
            $table->integer('inp_user');
            $table->timestamp('upd_date')->useCurrent();
            $table->integer('upd_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_function');
    }
}
