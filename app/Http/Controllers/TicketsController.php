<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Events;
use App\Models\Tickets;
use App\Enums\SeatType;

class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    function issue($event_id)
    {
        $event = Events::where('event_id', $event_id)->get()->first();
        $tickets = Tickets::where('event_id', $event_id)->get();
        return view(
            'tickets.issue',
            [
                'event' => $event,
                'tickets' => $tickets
            ]
        );
    }

    function post_issue(Request $request, $event_id)
    {
        $event = Events::where('event_id', $event_id)->get()->first();
        $data = array();
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'check') === false) {
                continue;
            }
            if ($value != 1) {
                continue;
            }
            $ticket_id = (int)explode("_", $key)[1];
            $ticket = Tickets::where('event_id', $event->event_id)->where('ticket_id', $ticket_id)->get()->first();
            $ticket->token = Str::random(32);
            $ticket->is_issued = 1;
            $ticket->save();
            $data[] = array($ticket->ticket_id, $ticket->token);
        }
        return view('tickets.links', ['data' => $data, 'event' => $event])->with('success', __('message.tickets.issue.success'));
    }

    function show_ticket($event_id, $ticket_id)
    {
        $event = Events::where('event_id', $event_id)->get()->first();
        $ticket = Tickets::where('event_id', $event_id)->where('ticket_id', $ticket_id)->get()->first();
        if (!$ticket->is_issued) {
            return view('errors.404');
        }
        $seat_type = SeatType::getDescription($event->seat_type);
        return view('tickets.show', ['event' => $event, 'ticket' => $ticket, 'seat_type' => $seat_type]);
    }
}

