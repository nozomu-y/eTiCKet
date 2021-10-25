<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\SeatType;
use App\Enums\CollectType;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $event_id = DB::table('events')->insertGetId([
            'name' => 'クリスマスコンサート（デモ）',
            'place' => '講堂',
            'date' => '2021-12-25',
            'expire_at' => '2021-12-25 23:59',
            'seat_type' => SeatType::RESERVED,
            'collect_name' => CollectType::REQUIRED,
            'collect_email' => CollectType::OPTIONAL,
            'collect_phone_number' => CollectType::OPTIONAL,
        ]);
        $seats = ['A1-1','A1-2','A1-3','A1-4','A1-5'];
        $ticket_id = 0;
        foreach ($seats as $seat) {
            $ticket_id = $ticket_id + 1;
            DB::table('tickets')->insert([
                'ticket_id' => $ticket_id,
                'event_id' => $event_id,
                'seat' => $seat,
                'price' => 1200,
            ]);
        }
    }
}
