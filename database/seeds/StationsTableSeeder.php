<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stations')->insert([
           'description' => 'Main'
        ]);
        DB::table('stations')->insert([
           'description' => 'Assistance'
        ]);
    }
}
