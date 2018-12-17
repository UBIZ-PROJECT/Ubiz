<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_company', function (Blueprint $table) {
            $table->increments('com_id');
            $table->string('com_nm', 250);
            $table->text('com_address');
            $table->string('com_phone', 50);
            $table->string('com_fax', 50);
            $table->string('com_web', 100);
            $table->string('com_email', 100);
            $table->string('com_hotline', 50);
            $table->string('com_mst', 20);
            $table->char('delete_flg', 1)->default('0');
            $table->timestamp('inp_date');
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
        Schema::dropIfExists('m_company');
    }
}
