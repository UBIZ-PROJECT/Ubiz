<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/12/2018
 * Time: 8:30 PM
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateSuppliersTable extends Migration
{
    public function up() {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('sup_id');
            $table->string('sup_code', 5);
            $table->string('sup_avatar', 250);
            $table->string('sup_name', 100);
            $table->char('sup_phone', 15);
            $table->char('sup_fax', 20);
            $table->string('sup_mail', 100);
            $table->string('sup_website', 100);
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
        Schema::dropIfExists('suppliers');
    }
}