<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Enums\SeatType;
use App\Models\Events;
use App\Models\Tickets;

class EventsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $validator = $this->add_validator($request->all());
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
        $event->seat_type = $request['seat_type'];
        $event->collect_name = $request['collect_name'];
        $event->collect_email = $request['collect_email'];
        $event->collect_phone_number = $request['collect_phone_number'];
        $event->save();

        return redirect()->route('events')->with('success', __('message.events.add.success'));
    }

    function edit($event_id)
    {
        $event = Events::where('event_id', $event_id)->get()->first();
        return view('events.edit', ['event' => $event]);
    }

    function post_edit(Request $request, $event_id)
    {
        $validator = $this->edit_validator($request->all());
        $validator->validate();

        $event = Events::where('event_id', $event_id)->get()->first();
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
        $event->collect_name = $request['collect_name'];
        $event->collect_email = $request['collect_email'];
        $event->collect_phone_number = $request['collect_phone_number'];
        $event->save();

        return redirect()->route('event_detail', ['event_id' => $event->event_id])->with('success', __('message.events.edit.success'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function add_validator(array $data)
    {
        return Validator::make($data, [
            'event_name' => ['required', 'string', 'max:255'],
            'place' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'open_at' => ['date_format:H:i', 'nullable'],
            'start_at' => ['date_format:H:i', 'nullable'],
            'end_at' => ['date_format:H:i', 'nullable'],
            'expire_at' => ['required', 'date_format:Y-m-d\TH:i'],
            'seat_type' => ['required'],
            'collect_name' => ['required'],
            'collect_email' => ['required'],
            'collect_phone_number' => ['required'],
        ]);
    }

    protected function edit_validator(array $data)
    {
        return Validator::make($data, [
            'event_name' => ['required', 'string', 'max:255'],
            'place' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'open_at' => ['date_format:H:i', 'nullable'],
            'start_at' => ['date_format:H:i', 'nullable'],
            'end_at' => ['date_format:H:i', 'nullable'],
            'expire_at' => ['required', 'date_format:Y-m-d\TH:i'],
            'collect_name' => ['required'],
            'collect_email' => ['required'],
            'collect_phone_number' => ['required'],
        ]);
    }

    function delete($id)
    {
        $result = Events::where('event_id', $id)->delete();
        if (!$result) {
            return redirect()->route('events')->with('error', __('message.events.delete.error'));
        }
        $num = Tickets::where('event_id', $id)->count();
        if ($num !== 0) {
            $result = Tickets::where('event_id', $id)->delete();
            if (!$result) {
                return redirect()->route('events')->with('error', __('message.events.delete.error'));
            }
        }
        return redirect()->route('events')->with('success', __('message.events.delete.success'));
    }
}
