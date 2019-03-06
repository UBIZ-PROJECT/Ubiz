<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/31/2018
 * Time: 8:34 PM
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateAccessoryKeeperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessory_keeper', function (Blueprint $table) {
            $table->increments('acs_keeper_id');
            $table->integer('acs_id');
            $table->integer('keeper');
            $table->integer('quantity')->nullable();
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
        Schema::dropIfExists('accessory_keeper');
    }
}