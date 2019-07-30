<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 1/7/2019
 * Time: 12:37 AM
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateAccessoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessory', function (Blueprint $table) {
            $table->increments('acs_id');
            $table->integer('brd_id');
            $table->integer('acs_quantity')->default('0');
            $table->char('acs_name', 255);
            $table->string('acs_note')->nullable();
            $table->char("acs_unit", 5)->nullable();
            $table->integer('acs_type_id');
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
        Schema::dropIfExists('accessory');
    }
}