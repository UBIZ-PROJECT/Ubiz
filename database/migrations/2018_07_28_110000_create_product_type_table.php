<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/28/2018
 * Time: 11:41 AM
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateProductTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_type', function (Blueprint $table) {
            $table->increments('prd_type_id');
            $table->char('prd_type_name', 255);
            $table->char('prd_type_flg', 1)->default('1'); // 1 is product, 2 is accessory
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
        Schema::dropIfExists('product_type');
    }
}