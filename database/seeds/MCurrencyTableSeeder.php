<?php

use Illuminate\Database\Seeder;

class MCurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(file_get_contents(database_path()."/seeds/data/seed_m_currency.sql"));
    }
}
