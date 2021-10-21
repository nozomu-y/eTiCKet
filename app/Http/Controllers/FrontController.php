<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\Tickets;

class FrontController extends Controller
{
    function qrreader()
    {
        return view('front.qrreader');
    }

    function post_qrreader(Request $request)
    {
        $url = $request['data'];
        $url_split = explode("/", $url);
        $event_id = $url_split[count($url_split)-3];
        $ticket_id = $url_split[count($url_split)-2];
        $token = $url_split[count($url_split)-1];
        $event = Events::where('event_id', $event_id)->get()->first();
        $ticket = Tickets::where('event_id', $event_id)->where('ticket_id', $ticket_id)->get()->first();
        if ($token !== $ticket->token) {
            dd('error');
        }
        dump($event->name);
        dump($ticket->ticket_id);
        dump($ticket->seat);
        dump($ticket->door);
        dd($token);
    }
}
