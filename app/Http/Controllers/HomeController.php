<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $latest_event = Events::whereDate('expire_at', '>', date('Y-m-d H:i:s'))->orderBy('date')->get()->first();
        return view('home', ['event' => $latest_event]);
    }
}
