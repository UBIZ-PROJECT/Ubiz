<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/28/2018
 * Time: 11:45 AM
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('prd_id');
            $table->integer('type_id');
            $table->integer('brd_id');
            $table->char('prd_name', 255);
            $table->char('prd_model', 255)->nullable();
            $table->string('prd_note')->nullable();
            $table->char("prd_unit", 5)->nullable();
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
        Schema::dropIfExists('product');
    }
}