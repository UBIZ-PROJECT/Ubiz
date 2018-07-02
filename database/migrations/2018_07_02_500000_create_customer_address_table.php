<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_address');
    }
}
