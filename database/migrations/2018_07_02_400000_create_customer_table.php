<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
}
