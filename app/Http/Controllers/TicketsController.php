<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\Tickets;

class TicketsController extends Controller
{
    function index($event_id) {
        $event = Events::where('event_id', $event_id)->get()->first();
        $tickets = Tickets::where('event_id', $event_id)->get();
        return view('tickets.list', [
            'event' => $event,
            'tickets' => $tickets]
        );
    }
}
