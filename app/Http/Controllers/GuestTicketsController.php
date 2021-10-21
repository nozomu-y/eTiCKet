<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\Tickets;
use App\Enums\SeatType;

class GuestTicketsController extends Controller
{
    function index($event_id, $ticket_id, $token)
    {
        $event = Events::where('event_id', $event_id)->get()->first();
        $ticket = Tickets::where('event_id', $event_id)->where('ticket_id', $ticket_id)->get()->first();
        $seat_type = SeatType::getDescription($event->seat_type);
        return view('guest.index', ['event' => $event, 'ticket' => $ticket, 'seat_type' => $seat_type]);
    }
}
