<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Events;
use App\Models\Tickets;
use App\Enums\SeatType;

class TicketsController extends Controller
{
    function index($event_id)
    {
        $event = Events::where('event_id', $event_id)->get()->first();
        $tickets = Tickets::where('event_id', $event_id)->get();
        return view(
            'tickets.list',
            [
                'event' => $event,
                'tickets' => $tickets
            ]
        );
    }

    function add($event_id)
    {
        $event = Events::where('event_id', $event_id)->get()->first();
        if ($event->seat_type == SeatType::RESERVED) {
            return view('tickets.add_reserved', ['event' => $event]);
        }
    }

    function post_add(Request $request, $event_id)
    {
        $validator =  Validator::make($request->all(), [
            'price' => ['required', 'integer', 'min:0'],
        ]);
        $validator->validate();
        $csv = $request['csv'];
        $price = $request['price'];
        $csv = str_replace(array("\r\n", "\r", "\n"), "\n", $csv);
        $csv_lines = explode("\n", $csv);
        $csv_data = array();
        foreach ($csv_lines as $line) {
            $data = str_getcsv($line);
            if ($data[0] == 'seat_number' && $data[1] == 'door_number') {
                continue;
            }
            if (count($data) != 2) {
                continue;
            }
            $csv_data[] = $data;
        }

        $event = Events::where('event_id', $event_id)->get()->first();

        $ticket_id = $event->ticket_id_max;
        foreach ($csv_data as $data) {
            $ticket_id = $ticket_id + 1;

            $ticket = new Tickets();
            $ticket->ticket_id = $ticket_id;
            $ticket->event_id = $event_id;
            $ticket->price = $price;
            if ($data[0] != "") {
                $ticket->seat = $data[0];
            }
            if ($data[1] != "") {
                $ticket->door = $data[1];
            }
            $ticket->save();
        }
        $event->ticket_id_max = $ticket_id;
        $event->save();
        return redirect()->route('tickets', ['event_id' => $event_id])->with('success', __('message.tickets.add.success'));
    }
}
