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
        $row = 10;
        $column = 20;
        $ticket_num = $row * $column;
        $event_id = DB::table('events')->insertGetId([
            'name' => 'クリスマスコンサート（デモ）',
            'place' => '講堂',
            'date' => '2021-12-25',
            'expire_at' => '2021-12-25 23:59',
            'seat_type' => SeatType::RESERVED,
            'collect_name' => CollectType::REQUIRED,
            'collect_email' => CollectType::OPTIONAL,
            'collect_phone_number' => CollectType::OPTIONAL,
            'ticket_id_max' => $ticket_num,
        ]);
        $ticket_id = 0;
        for ($i = 1; $i <= $row; $i++) {
            for ($j = 1; $j <= $column; $j++) {
                $ticket_id = $ticket_id + 1;
                DB::table('tickets')->insert([
                    'ticket_id' => $ticket_id,
                    'event_id' => $event_id,
                    'seat' => '扉L1 / 列' . $i . ' / ' . $j,
                    'price' => 1000,
                ]);
            }
        }
    }
}
