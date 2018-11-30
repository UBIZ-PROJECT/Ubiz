<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_currency', function (Blueprint $table) {
            $table->increments('cur_id');
            $table->string('cur_ctr_nm', 100);
            $table->string('cur_ctr_cd_alpha_2', 2);
            $table->string('cur_ctr_cd_alpha_3', 3);
            $table->string('cur_ctr_cd_numeric', 3);
            $table->string('cur_nm', 100);
            $table->string('cur_cd_numeric_default', 3);
            $table->string('cur_cd_alpha', 3);
            $table->string('cur_cd_numeric', 3);
            $table->string('cur_minor_units', 1);
            $table->char('cur_active_flg', 1)->default('1');
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
        Schema::dropIfExists('m_currency');
    }
}
