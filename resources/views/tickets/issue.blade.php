<?php
    use App\Libs\Common;
?>
@extends('layouts.main')
@section('title', __('issue_tickets_abbrev'))

@section('content')
    <div class="container-fluid">
        <h1 class="h3 text-gray-800 mb-4">{{ __('issue_tickets_abbrev') }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('events') }}">{{ __('event_list') }}</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('event_detail', ['event_id' => $event->event_id]) }}">{{ $event->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('issue_tickets_abbrev') }}</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-12">
                @if (session('error'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form method="POST" action="{{ route('post_issue_tickets', ['event_id' => $event->event_id]) }}">
                    @csrf
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{ __('ticket_no') }}</th>
                                <th>{{ __('seat_no') }}</th>
                                <th>{{ __('door_no') }}</th>
                                <th>{{ __('price') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                @if (!$ticket->is_issued)
                                <tr>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                name="check_{{ $ticket->ticket_id }}" value="1">
                                        </div>
                                    </td>
                                    <td>{{ sprintf('%06d', $ticket->ticket_id) }}</td>
                                    <td>{{ $ticket->seat }}</td>
                                    <td>{{ $ticket->door }}</td>
                                    <td>{{ Common::format_price($ticket->price) }}</td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">{{ __('issue_tickets_abbrev') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
