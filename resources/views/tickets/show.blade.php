<?php
use App\Libs\Common;
?>
@extends('layouts.main')
@section('title', $event->name)
@section('style')
    <style>
        svg {
            width: 100% !important;
        }

    </style>
@endsection

@section('content')
    <div class="container-fluid">
        @if (url()->previous() === route('tickets', ['event_id' => $event->event_id]))
            <h1 class="h3 text-gray-800 mb-4">{{ __('ticket_detail') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('events') }}">{{ __('event_list') }}</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('event_detail', ['event_id' => $event->event_id]) }}">{{ $event->name }}</a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('tickets', ['event_id' => $event->event_id]) }}">{{ __('ticket_list') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('ticket_detail') }}</li>
                </ol>
            </nav>
        @endif
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body bg-white">
                        {!! QrCode::size(300)->generate(config('app.url') . '/' . $event->event_id . '/' . $ticket->ticket_id . '/' . $ticket->token) !!}
                    </div>
                </div>

                <div>
                    <h2 class="h4">{{ $event->name }}</h2>
                    <h3 class="h6">{{ $event->place }}</h3>
                    <h3 class="h6">{{ date('Y/m/d', strtotime($event->date)) }}</h3>
                    <p>
                        @if ($event->open_at != null)
                            <strong class="mr-1">{{ __('open_at_abbrev') }}</strong>
                            {{ date('H:i', strtotime($event->open_at)) }}
                            <br>
                        @endif
                        @if ($event->start_at != null)
                            <strong class="mr-1">{{ __('start_at_abbrev') }}</strong>
                            {{ date('H:i', strtotime($event->start_at)) }}
                            <br>
                        @endif
                        @if ($event->end_at != null)
                            <strong class="mr-1">{{ __('end_at_abbrev') }}</strong>
                            {{ date('H:i', strtotime($event->end_at)) }}
                            <br>
                        @endif
                    </p>
                    <p>
                        <strong>{{ $seat_type }}</strong>
                        <br>
                        @if ($ticket->seat != null)
                            <strong class="mr-1">{{ __('seat_no') }}</strong>
                            {{ $ticket->seat }}
                            <br>
                        @endif
                        @if ($ticket->door != null)
                            <strong class="mr-1">{{ __('door_no') }}</strong>
                            {{ $ticket->door }}
                            <br>
                        @endif
                        <strong class="mr-1">{{ __('price') }}</strong>
                        {{ Common::format_price($ticket->price) }}
                    </p>
                    <p>
                        <strong class="mr-1">{{ __('ticket_url') }}</strong>
                        <a href="{{ config('app.url') . '/' . $event->event_id . '/' . $ticket->ticket_id . '/' . $ticket->token }}"
                            class="text-break">{{ config('app.url') . '/' . $event->event_id . '/' . $ticket->ticket_id . '/' . $ticket->token }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
