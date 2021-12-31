<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Events;
use App\Models\Tickets;
use App\Models\PersonalInformations;
use App\Enums\SeatType;
use App\Enums\CollectType;

class GuestTicketsController extends Controller
{
    function index($event_id, $ticket_id, $token)
    {
        $event = Events::where('event_id', $event_id)->get()->first();
        $ticket = Tickets::where('event_id', $event_id)->where('ticket_id', $ticket_id)->get()->first();
        if ($token !== $ticket->token) {
            return view('errors.404');
        }
        $seat_type = SeatType::getDescription($event->seat_type);
        $personal_info = PersonalInformations::where('event_id', $event_id)->where('ticket_id', $ticket_id)->get()->first();

        $personal_info_unentered = false;
        if ($personal_info == null) {
            if ($event->collect_name == CollectType::REQUIRED) {
                $personal_info_unentered = true;
            }
            if ($event->collect_email == CollectType::REQUIRED) {
                $personal_info_unentered = true;
            }
            if ($event->collect_phone_number == CollectType::REQUIRED) {
                $personal_info_unentered = true;
            }
        } else {
            if ($event->collect_name == CollectType::REQUIRED &&  $this->is_null_or_empty($personal_info->name)) {
                $personal_info_unentered = true;
            }
            if ($event->collect_email == CollectType::REQUIRED && $this->is_null_or_empty($personal_info->email)) {
                $personal_info_unentered = true;
            }
            if ($event->collect_phone_number == CollectType::REQUIRED && $this->is_null_or_empty($personal_info->phone_number)) {
                $personal_info_unentered = true;
            }
        }
        $personal_info_disabled = true;
        if ($event->collect_name != CollectType::DISABLED) {
            $personal_info_disabled = false;
        }
        if ($event->collect_email != CollectType::DISABLED) {
            $personal_info_disabled = false;
        }
        if ($event->collect_phone_number != CollectType::DISABLED) {
            $personal_info_disabled = false;
        }

        return view('tickets.show', [
            'event' => $event,
            'ticket' => $ticket,
            'personal_info' => $personal_info,
            'seat_type' => $seat_type,
            'personal_info_unentered' => $personal_info_unentered,
            'personal_info_disabled' => $personal_info_disabled,
        ]);
    }

    function contact($event_id, $ticket_id, $token)
    {
        $event = Events::where('event_id', $event_id)->get()->first();
        $ticket = Tickets::where('event_id', $event_id)->where('ticket_id', $ticket_id)->get()->first();
        if ($token !== $ticket->token) {
            return view('errors.404');
        }
        if ($ticket->is_checked_in) {
            return view('errors.404');
        }
        return view('tickets.contact', ['event' => $event, 'ticket' => $ticket]);
    }

    function post_contact(Request $request, $event_id, $ticket_id, $token)
    {
        $event = Events::where('event_id', $event_id)->get()->first();
        $ticket = Tickets::where('event_id', $event_id)->where('ticket_id', $ticket_id)->get()->first();
        if ($token !== $ticket->token) {
            return view('errors.404');
        }
        if ($ticket->is_checked_in) {
            return view('errors.404');
        }
        $validator = $this->contact_validator($request->all(), $event);
        $validator->validate();

        $personal_info = PersonalInformations::where(['event_id' => $event_id, 'ticket_id' => $ticket_id])->get()->first();
        if ($personal_info == null) {
            $personal_info = new PersonalInformations();
            $personal_info->event_id = $event->event_id;
            $personal_info->ticket_id = $ticket->ticket_id;
        }
        if ($event->collect_name !== CollectType::DISABLED) {
            $personal_info->name = $request['name'];
        }
        if ($event->collect_email !== CollectType::DISABLED) {
            $personal_info->email = $request['email'];
        }
        if ($event->collect_phone_number !== CollectType::DISABLED) {
            $personal_info->phone_number = $request['phone_number'];
        }
        $personal_info->save();

        return redirect()->route('guest_ticket', [
            'event_id' => $event->event_id,
            'ticket_id' => $ticket->ticket_id,
            'token' => $ticket->token
        ])->with('success', __('message.personal_informations.success'));
    }

    function is_null_or_empty($str)
    {
        if ($str === "0") {
            return false;
        }
        return empty($str);
    }

    protected function contact_validator(array $data, $event)
    {
        return Validator::make($data, [
            'name' => $event->collect_name === CollectType::REQUIRED ? ['required', 'string', 'max:255'] : ['nullable', 'string', 'max:255'],
            'email' => $event->collect_email === CollectType::REQUIRED ? ['required', 'string', 'email', 'max:255'] : ['nullable', 'string', 'email', 'max:255'],
            'phone_number' => $event->collect_phone_number === CollectType::REQUIRED ? ['required', 'string', 'max:255'] : ['nullable', 'string', 'max:255'],
        ]);
    }
}
