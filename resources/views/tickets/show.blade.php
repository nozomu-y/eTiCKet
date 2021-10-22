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
                        {{ $ticket->door}}
                        <br>
                        @endif
                        <strong class="mr-1">{{ __('price') }}</strong>
                        {{ $ticket->price }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
