<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    }
}
