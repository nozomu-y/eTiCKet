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
                            <th>{{ __('ticket_id') }}</th>
                            <th>{{ __('seat') }}</th>
                            <th>{{ __('door') }}</th>
                            <th>{{ __('price') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->ticket_id }}</td>
                                <td>{{ $ticket->seat }}</td>
                                <td>{{ $ticket->door }}</td>
                                <td>{{ $ticket->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a class="btn btn-primary" href="{{ route('add_tickets', ['event_id' => $event->event_id]) }}">{{ __('add_tickets') }}</a>
            </div>
        </div>
    </div>
@endsection
