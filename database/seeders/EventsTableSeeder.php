<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
            'name' => 'Test Concert',
            'place' => 'Test Hall',
            'date' => '2099-01-01',
            'expire_at' => '2099-01-01 23:59',
        ]);
    }
}
