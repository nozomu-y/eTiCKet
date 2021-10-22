<?php
use App\Libs\Common;
?>
@extends('layouts.main')
@section('title', $event->name)
@section('style')
    <style>
        svg {
            width: calc(100% - 20px) !important;
            border-top-left-radius: calc(.25rem - 1px);
            border-top-right-radius: calc(.25rem - 1px);
            font-size: 1.125rem;
            text-anchor: middle;
            height: auto;
            margin: 10px;
        }

        .ticket {
            max-width: 400px;
            min-width: 300px;
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
                @if ($ticket->is_checked_in)
                    <div class="alert alert-danger" role="alert">
                        {{ __('message.tickets.already_used') }}
                    </div>
                @endif
                <div class="d-flex justify-content-center">
                    <div class="card mb-4 ticket">
                        {!! QrCode::size(400)->generate(config('app.url') . '/' . $event->event_id . '/' . $ticket->ticket_id . '/' . $ticket->token) !!}
                        <div class="card-body">
                            <div class="text-center">
                                <?php
                                $lines = explode(' ', config('app.corporation_name'));
                                ?>
                                @foreach ($lines as $line)
                                    <h2 class="h4 mb-0">{{ $line }}</h2>
                                @endforeach
                                <h3 class="h5 mt-1">{{ $event->name }}</h3>
                            </div>
                            <table class="mt-3" style="border-collapse: separate; border-spacing: 1em 0em;">
                                <tbody>
                                    <tr>
                                        <th class="mr-3 text-nowrap">{{ __('date') }}</th>
                                        <td>{{ date('Y/m/d', strtotime($event->date)) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">{{ __('hall') }}</th>
                                        <td>{{ $event->place }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="mt-3 d-flex justify-content-center"
                                style="border-collapse: separate; border-spacing: 1em 0em;">
                                <tbody>
                                    <tr>
                                        @if ($event->open_at != null)
                                            <th class="text-nowrap">{{ __('open_at_abbrev') }}</th>
                                            <td>{{ date('H:i', strtotime($event->open_at)) }}</td>
                                        @endif
                                        @if ($event->start_at != null)
                                            <th class="text-nowrap">{{ __('start_at_abbrev') }}</th>
                                            <td>{{ date('H:i', strtotime($event->start_at)) }}</td>
                                        @endif
                                    </tr>
                                    @if ($event->end_at != null)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <th class="text-nowrap">{{ __('end_at_abbrev') }}</th>
                                            <td>{{ date('H:i', strtotime($event->end_at)) }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <hr>
                            <table class="mt-3 d-flex justify-content-center"
                                style="border-collapse: separate; border-spacing: 1em 0em;">
                                <tbody>
                                    <tr>
                                        <th class="text-nowrap">{{ __('seat_type') }}</th>
                                        <td>{{ $seat_type }}</td>
                                        <th class="text-nowrap">{{ __('price') }}</th>
                                        <td>{{ Common::format_price($ticket->price) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="mt-1 d-flex justify-content-center"
                                style="border-collapse: separate; border-spacing: 1em 0em;">
                                <tbody>
                                    <tr>
                                        @if ($ticket->seat != null)
                                            <th class="text-nowrap">{{ __('seat_no') }}</th>
                                            <td>{{ $ticket->seat }}</td>
                                        @endif
                                        @if ($ticket->door != null)
                                            <th class="text-nowrap">{{ __('door_no') }}</th>
                                            <td>{{ $ticket->door }}</td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center mt-2">
                                <small class="text-monospace">No. {{ sprintf('%06d', $ticket->ticket_id) }}</small>
                                <br>
                                <small class="text-monospace">{{ $ticket->token }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
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
