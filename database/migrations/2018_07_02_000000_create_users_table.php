<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 5);
            $table->string('name', 100);
            $table->string('avatar', 250);
            $table->char('password', 64);
            $table->char('phone', 15);
            $table->string('email', 100);
            $table->string('address', 250);
            $table->date('join_date');
            $table->decimal('salary', 10, 2);
            $table->char('bhxh', 1)->default('0');
            $table->char('bhyt', 1)->default('0');
            $table->integer('dep_id');
            $table->rememberToken();
            $table->char('delete_flg', 1)->default('0');
            $table->timestamp('inp_date')->useCurrent();
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
        Schema::dropIfExists('users');
    }
}
