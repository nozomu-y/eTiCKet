<?php
use App\Libs\Common;
?>
@extends('layouts.main')
@section('title', __('ticket_list'))

@section('content')
    <div class="container-fluid">
        <h1 class="h3 text-gray-800 mb-4">{{ __('ticket_list') }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('events') }}">{{ __('event_list') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('event_detail', ['event_id' => $event->event_id]) }}">{{ $event->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('ticket_list') }}</li>
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
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('ticket_no') }}</th>
                            <th>{{ __('seat_no') }}</th>
                            <th>{{ __('door_no') }}</th>
                            <th>{{ __('price') }}</th>
                            <th>{{ __('issue') }}</th>
                            <th>{{ __('check_in') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td>{{ sprintf('%06d', $ticket->ticket_id) }}</td>
                                <td>{{ $ticket->seat }}</td>
                                <td>{{ $ticket->door }}</td>
                                <td>{{ Common::format_price($ticket->price) }}</td>
                                <td>{{ $ticket->is_issued ? __('done') : "" }}</td>
                                <td>{{ $ticket->is_checked_in ? __('done') : "" }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
