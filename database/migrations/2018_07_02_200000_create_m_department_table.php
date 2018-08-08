<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_department', function (Blueprint $table) {
            $table->increments('id');
            $table->char('dep_code', 5);
            $table->string('dep_name', 255);
            $table->char('dep_type', 2);
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
        Schema::dropIfExists('m_department');
    }
}
