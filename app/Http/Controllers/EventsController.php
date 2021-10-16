<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Events;

class EventsController extends Controller
{
    function index()
    {
        $events = Events::all();
        return view('events.list', ['events' => $events]);
    }

    function detail($id)
    {
        $event = Events::where('event_id', $id)->get()->first();
        return view('events.detail', ['event' => $event]);
    }

    function add(Request $request)
    {
        $validator = $this->validator($request->all());
        $validator->validate();

        $event = new Events();
        $event->name = $request['event_name'];
        $event->place = $request['place'];
        $event->date = $request['date'];
        if ($request['open_at'] != null) {
            $event->open_at = $request['open_at'];
        }
        if ($request['start_at'] != null) {
            $event->start_at = $request['start_at'];
        }
        if ($request['end_at'] != null) {
            $event->end_at = $request['end_at'];
        }
        $event->expire_at = $request['expire_at'];
        $event->save();

        return redirect()->route('events');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'event_name' => ['required', 'string', 'max:255'],
            'place' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'open_at' => ['date_format:H:i', 'nullable'],
            'start_at' => ['date_format:H:i', 'nullable'],
            'end_at' => ['date_format:H:i', 'nullable'],
            'expire_at' => ['required', 'date_format:Y-m-d\TH:i'],
        ]);
    }
}
