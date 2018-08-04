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
            $table->string('cur_name', 50);
            $table->char('cur_code', 3);
            $table->char('cur_symbol', 11);
            $table->string('cur_state', 50);
            $table->string('cur_avatar', 250);
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
