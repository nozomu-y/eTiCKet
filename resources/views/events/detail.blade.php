<?php
    use App\Enums\SeatType;
?>
@extends('layouts.main')
@section('title', $event->name)

@section('content')
    <div class="container-fluid">
        <h1 class="h3 text-gray-800 mb-4">{{ $event->name }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('events') }}">{{ __('event_list') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $event->name }}</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="h5">{{ $event->name }}</h3>
                        <table class="mt-2">
                            <tbody>
                                <tr>
                                    <th class="text-nowrap pr-3">{{ __('date') }}</th>
                                    <td>{{ date('Y/m/d', strtotime($event->date)) }}</td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap pr-3">{{ __('hall') }}</th>
                                    <td>{{ $event->place }}</td>
                                </tr>
                                @if ($event->open_at != null)
                                    <tr>
                                        <th class="text-nowrap pr-3">{{ __('open_at_abbrev') }}</th>
                                        <td>{{ date('H:i', strtotime($event->open_at)) }}</td>
                                    </tr>
                                @endif
                                @if ($event->start_at != null)
                                    <tr>
                                        <th class="text-nowrap pr-3">{{ __('start_at_abbrev') }}</th>
                                        <td>{{ date('H:i', strtotime($event->start_at)) }}</td>
                                    </tr>
                                @endif
                                @if ($event->end_at != null)
                                    <tr>
                                        <th class="text-nowrap pr-3">{{ __('end_at_abbrev') }}</th>
                                        <td>{{ date('H:i', strtotime($event->end_at)) }}</td>
                                    </tr>
                                @endif
                                    <tr>
                                        <th class="text-nowrap pr-3">{{ __('expire_at') }}</th>
                                        <td>{{ date('Y/m/d H:i', strtotime($event->expire_at)) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap pr-3">{{ __('seat_type') }}</th>
                                        <td>{{ SeatType::getDescription($event->seat_type) }}</td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4">
                <div class="list-group mb-4">
                    <a class="list-group-item list-group-item-action"
                        href="{{ route('tickets', ['event_id' => $event->event_id]) }}">{{ __('ticket_list') }}</a>
                    <a class="list-group-item list-group-item-action"
                        href="{{ route('add_tickets', ['event_id' => $event->event_id]) }}">{{ __('add_tickets') }}</a>
                    <a class="list-group-item list-group-item-action"
                        href="{{ route('issue_tickets', ['event_id' => $event->event_id]) }}">{{ __('issue_tickets') }}</a>
                    <a class="list-group-item list-group-item-action">{{ __('edit_event') }}</a>
                    <a class="list-group-item list-group-item-action text-danger"
                        onclick="if (confirm('{{ __('message.events.delete.confirm') }}')) {event.preventDefault(); document.getElementById('delete-form').submit();}">{{ __('delete_event') }}</a>
                    <form id="delete-form" action="{{ route('delete_event', ['event_id' => $event->event_id]) }}"
                        method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
