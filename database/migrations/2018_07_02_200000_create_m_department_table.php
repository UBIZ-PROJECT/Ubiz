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
            $table->increments('dep_id');
            $table->string('dep_name', 100);
            $table->char('dep_type', 2);
            $table->integer('per_id');
            $table->char('delete_flg', 1)->default('0');
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
