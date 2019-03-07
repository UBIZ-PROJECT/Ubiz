<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricingProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricing_product', function (Blueprint $table) {
            $table->increments('pro_id');
			$table->integer('pri_id');
			$table->char('type', 1);
			$table->string('code', 5);
			$table->string('name', 100);
			$table->integer('price');
			$table->string('unit', 20);
			$table->integer('amount');
			$table->string('specs');
			$table->timestamp('delivery_date');
			$table->char('status', 1);
            $table->char('delete_flg', 1)->default('0');
            $table->timestamp('inp_date')->nullable();
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
        Schema::dropIfExists('pricing_product');
    }
}
