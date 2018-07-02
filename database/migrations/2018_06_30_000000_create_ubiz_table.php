<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUbizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('usr_id');
            $table->char('pwd', 64);
            $table->string('name', 100);
            $table->char('phone', 15);
            $table->string('mail', 100);
            $table->string('address', 250);
            $table->date('join_date');
            $table->decimal('salary', 10, 2);
            $table->char('bhxh', 1);
            $table->char('bhyt', 1);
            $table->integer('dep_id');
            $table->char('delete_flg', 1)->default('0');
            $table->timestamps('inp_date');
            $table->integer('inp_user');
            $table->timestamps('upd_date');
            $table->integer('upd_user');
        });

        Schema::create('m_department', function (Blueprint $table) {
            $table->increments('dep_id');
            $table->string('dep_name', 100);
            $table->char('dep_type', 2);
            $table->integer('per_id');
            $table->char('delete_flg', 1)->default('0');
        });

        Schema::create('m_permission', function (Blueprint $table) {
            $table->increments('per_id');
            $table->string('per_name', 100);
            $table->char('delete_flg', 1)->default('0');
        });

        Schema::create('customer', function (Blueprint $table) {
            $table->increments('cus_id');
            $table->string('cus_name', 100);
            $table->char('cus_type', 2);
            $table->char('cus_phone', 15);
            $table->char('cus_fax', 20);
            $table->string('cus_mail', 100);
            $table->char('delete_flg', 1)->default('0');
            $table->timestamps('inp_date');
            $table->integer('inp_user');
            $table->timestamps('upd_date');
            $table->integer('upd_user');
        });

        Schema::create('customer_address', function (Blueprint $table) {
            $table->increments('cad_id');
            $table->integer('cus_id');
            $table->string('cad_address', 250);
            $table->char('delete_flg', 1)->default('0');
            $table->timestamps('inp_date');
            $table->integer('inp_user');
            $table->timestamps('upd_date');
            $table->integer('upd_user');
        });

        Schema::create('m_currency', function (Blueprint $table) {
            $table->increments('cur_id');
            $table->char('symbol', 3);
            $table->string('cur_name', 50);
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
        Schema::dropIfExists('user');
        Schema::dropIfExists('m_department');
        Schema::dropIfExists('m_permission');
        Schema::dropIfExists('customer');
        Schema::dropIfExists('customer_address');
        Schema::dropIfExists('currency');
    }
}
