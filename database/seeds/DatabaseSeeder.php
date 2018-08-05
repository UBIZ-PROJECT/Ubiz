<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);


        DB::table('users')->delete();
        DB::unprepared(file_get_contents(database_path()."/seeds/creation-user.sql"));

        DB::table('m_currency')->delete();
        DB::unprepared(file_get_contents(database_path()."/seeds/creation-currency.sql"));
    }
}
