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
        $event_id = $url_split[count($url_split) - 3];
        $ticket_id = $url_split[count($url_split) - 2];
        $token = $url_split[count($url_split) - 1];
        $event = Events::where('event_id', $event_id)->get()->first();
        $ticket = Tickets::where('event_id', $event_id)->where('ticket_id', $ticket_id)->get()->first();
        if ($token !== $ticket->token || !$ticket->is_issued) {
            return view('front.error')->with('error', __('message.front.error.ticket_invalid'));
        }
        if ($ticket->is_checked_in) {
            return view('front.error')->with('error', __('message.front.error.already_checked_in'));
        }
        return view('front.confirm', ['ticket' => $ticket, 'event' => $event, 'token' => $token]);
    }

    function post_collect_ticket(Request $request)
    {
        $event_id = $request->all()['event_id'];
        $ticket_id = $request->all()['ticket_id'];
        $token = $request->all()['token'];
        $event = Events::where('event_id', $event_id)->get()->first();
        $ticket = Tickets::where('event_id', $event_id)->where('ticket_id', $ticket_id)->get()->first();
        if ($token !== $ticket->token || !$ticket->is_issued) {
            return view('front.error')->with('error', __('message.front.error.ticket_invalid'));
        }
        if ($ticket->is_checked_in) {
            return view('front.error')->with('error', __('message.front.error.already_checked_in'));
        }
        $ticket->is_checked_in = 1;
        $ticket->check_in_at = now();
        $ticket->save();
        return view('front.confirmed', ['ticket' => $ticket, 'event' => $event]);
    }
}
