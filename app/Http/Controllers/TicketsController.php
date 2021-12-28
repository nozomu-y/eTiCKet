<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Events;
use App\Models\Tickets;
use App\Enums\SeatType;
use App\Libs\Common;
use Illuminate\Support\Facades\DB;

class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index($event_id)
    {
        $event = Events::where('event_id', $event_id)->get()->first();
        $tickets = DB::select(DB::raw('SELECT * FROM tickets left outer join (select name, email, phone_number, ticket_id as ticket_id_ from personal_informations where event_id=' . $event_id . ') as c on tickets.ticket_id = c.ticket_id_ WHERE tickets.event_id=' . $event_id));
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
        $seat_list = $request['seat_list'];
        $price = $request['price'];
        $seat_list = str_replace(array("\r\n", "\r", "\n"), "\n", $seat_list);
        $seats = explode("\n", $seat_list);
        $seat_data = array();
        foreach ($seats as $seat) {
            if (Common::is_null_or_empty($seat)) {
                continue;
            }
            $seat_data[] = $seat;
        }

        $event = Events::where('event_id', $event_id)->get()->first();

        $ticket_id = $event->ticket_id_max;
        foreach ($seat_data as $data) {
            $ticket_id = $ticket_id + 1;

            $ticket = new Tickets();
            $ticket->ticket_id = $ticket_id;
            $ticket->event_id = $event_id;
            $ticket->price = $price;
            $ticket->seat = $data;
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

    function post_confirm_issue(Request $request, $event_id)
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
            $ticket->all();
            $data[] = array(
                'ticket_id' => $ticket->ticket_id,
                'seat' => $ticket->seat,
                'price' => $ticket->price,
                'memo' => $ticket->memo
            );
        }
        if (count($data) === 0) {
            return redirect()->route('issue_tickets', ['event_id' => $event->event_id])
                ->with('error', __('message.tickets.issue.select_at_least_one_ticket'));
        }
        return view('tickets.confirm_issue', ['data' => $data, 'event' => $event])
            ->with('message', __('message.tickets.issue.confirm'));
    }

    function post_issue(Request $request, $event_id)
    {
        $event = Events::where('event_id', $event_id)->get()->first();
        $data = array();

        // check whether the tickets are already issued
        $error = -1;
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
            if ($ticket->is_issued == 1) {
                $error = $ticket_id;
                break;
            }
            $ticket->is_issued = 1;
            $ticket->save();
            $data[] = array($ticket->ticket_id, $ticket->seat, $ticket->token);
        }

        // if a ticket was already issued
        if ($error != -1) {
            // revert
            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'check') === false) {
                    continue;
                }
                if ($value != 1) {
                    continue;
                }
                $ticket_id = (int)explode("_", $key)[1];
                if ($ticket_id == $error) {
                    break;
                }
                $ticket = Tickets::where('event_id', $event->event_id)->where('ticket_id', $ticket_id)->get()->first();
                $ticket->token = null;
                $ticket->is_issued = 0;
                $ticket->memo = null;
                $ticket->save();
            }
            return redirect()->route('issue_tickets', ['event_id' => $event->event_id])->with('error', __('message.tickets.issue.error'));
        }

        return view('tickets.links', ['data' => $data, 'event' => $event])
            ->with('success', __('message.tickets.issue.success_before') . count($data) . __('message.tickets.issue.success_after'));
    }

    function show_ticket($event_id, $ticket_id)
    {
        $event = Events::where('event_id', $event_id)->get()->first();
        $ticket = Tickets::where('event_id', $event_id)->where('ticket_id', $ticket_id)->get()->first();
        // if (!$ticket->is_issued) {
        // return view('errors.404');
        // }
        $seat_type = SeatType::getDescription($event->seat_type);
        return view('tickets.show', ['event' => $event, 'ticket' => $ticket, 'seat_type' => $seat_type]);
    }

    function edit($event_id, $ticket_id)
    {
        $event = Events::where('event_id', $event_id)->get()->first();
        $ticket = Tickets::where('event_id', $event_id)->where('ticket_id', $ticket_id)->get()->first();
        return view('tickets.edit', ['event' => $event, 'ticket' => $ticket]); // , 'seat_type' => $seat_type]);
    }

    function post_edit(Request $request, $event_id, $ticket_id)
    {
        $validator = $this->edit_validator($request->all());
        $validator->validate();

        $ticket = Tickets::where('event_id', $event_id)->where('ticket_id', $ticket_id)->get()->first();
        $ticket->seat = $request['seat'];
        $ticket->price = $request['price'];
        $ticket->memo = $request['memo'];
        $ticket->save();

        return redirect()->route('show_ticket', ['event_id' => $event_id, 'ticket_id' => $ticket_id])->with('success', __('message.tickets.edit.success'));
    }

    protected function edit_validator(array $data)
    {
        return Validator::make($data, [
            'seat' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'memo' => ['nullable', 'string', 'max:255'],
        ]);
    }

    function delete($event_id, $ticket_id)
    {
        $result = Tickets::where('event_id', $event_id)->where('ticket_id', $ticket_id)->delete();
        if (!$result) {
            return redirect()->route('tickets', ['event_id' => $event_id])->with('error', __('message.tickets.delete.error'));
        }
        return redirect()->route('tickets', ['event_id' => $event_id])->with('success', __('message.tickets.delete.success'));
    }
}
