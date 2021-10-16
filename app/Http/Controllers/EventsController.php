<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;

class EventsController extends Controller
{
    function index() {
        $events = Events::all();
        return view('events.list', ['events' => $events]);
    }

    function detail($id) {
        $event = Events::where('event_id', $id)->get()->first();
        return view('events.detail', ['event' => $event]);
    }
}
