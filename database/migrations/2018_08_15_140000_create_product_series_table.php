<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/15/2018
 * Time: 8:34 PM
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateProductSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_series', function (Blueprint $table) {
            $table->increments('prd_series_id');
            $table->char('prd_id', 2);
            $table->char('serial_no',50)->nullable();
            $table->char('serial_sts', 1);
            $table->integer('serial_keeper')->nullable();
            $table->string('serial_note')->nullable();
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
        Schema::dropIfExists('product_series');
    }
}