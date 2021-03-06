<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Enums\CollectType;
use App\Models\Events;
use App\Models\Tickets;
use App\Models\PersonalInformations;

class FrontController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $personal_info = PersonalInformations::where(['event_id' => $event_id, 'ticket_id' => $ticket_id])->get()->first();
        $personal_info_unentered = $this->check_personal_information_unentered($personal_info, $event);
        if ($token !== $ticket->token || !$ticket->is_issued) {
            return view('front.error')->with('error', __('message.front.error.ticket_invalid'));
        }
        if ($personal_info_unentered) {
            return view('front.error')->with('error', __('message.front.error.personal_info_unentered'));
        }
        if ($ticket->is_checked_in) {
            return view('front.error')->with('error', __('message.front.error.already_checked_in'));
        }
        return view('front.confirm', ['ticket' => $ticket, 'event' => $event, 'token' => $token, 'personal_info' => $personal_info]);
    }

    function post_collect_ticket(Request $request)
    {
        $event_id = $request->all()['event_id'];
        $ticket_id = $request->all()['ticket_id'];
        $token = $request->all()['token'];
        $event = Events::where('event_id', $event_id)->get()->first();
        $ticket = Tickets::where('event_id', $event_id)->where('ticket_id', $ticket_id)->get()->first();
        $personal_info = PersonalInformations::where(['event_id' => $event_id, 'ticket_id' => $ticket_id])->get()->first();
        $personal_info_unentered = $this->check_personal_information_unentered($personal_info, $event);
        if ($token !== $ticket->token || !$ticket->is_issued) {
            return view('front.error')->with('error', __('message.front.error.ticket_invalid'));
        }
        if ($personal_info_unentered) {
            return view('front.error')->with('error', __('message.front.error.personal_info_unentered'));
        }
        if ($ticket->is_checked_in) {
            return view('front.error')->with('error', __('message.front.error.already_checked_in'));
        }
        $ticket->is_checked_in = 1;
        $ticket->check_in_at = now();
        $ticket->save();
        return view('front.confirmed', ['ticket' => $ticket, 'event' => $event, 'personal_info' => $personal_info]);
    }

    function qrcode_unreadable() {
        $events = Events::all();
        return view('front.qrcode_form', ['events' => $events]);
    }

    function post_qrcode_unreadable(Request $request)
    {
        $validator = $this->validator($request->all());
        $validator->validate();
        
        $event_id = $request['event_id'];
        $ticket_id = $request['ticket_id'];
        $token = $request['token'];

        $event = Events::where('event_id', $event_id)->get()->first();
        $ticket = Tickets::where('event_id', $event_id)->where('ticket_id', $ticket_id)->get()->first();
        
        $personal_info = PersonalInformations::where(['event_id' => $event_id, 'ticket_id' => $ticket_id])->get()->first();
        $personal_info_unentered = $this->check_personal_information_unentered($personal_info, $event);
        if ($token !== substr($ticket->token, 0, 6) || !$ticket->is_issued) {
            return view('front.error')->with('error', __('message.front.error.ticket_invalid'));
        }
        if ($personal_info_unentered) {
            return view('front.error')->with('error', __('message.front.error.personal_info_unentered'));
        }
        if ($ticket->is_checked_in) {
            return view('front.error')->with('error', __('message.front.error.already_checked_in'));
        }
        return view('front.confirm', ['ticket' => $ticket, 'event' => $event, 'token' => $ticket->token, 'personal_info' => $personal_info]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'event_id' => ['required', 'integer'],
            'ticket_id' => ['required', 'integer'],
            'token' => ['required', 'string', 'size:6'],
        ]);
    }

    function check_personal_information_unentered($personal_info, $event) {
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
        return $personal_info_unentered;
    }

    function is_null_or_empty($str)
    {
        if ($str === "0") {
            return false;
        }
        return empty($str);
    }

}
