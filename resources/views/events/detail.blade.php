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
                    <div class="card-header">
                        {{ __('event_information') }}
                    </div>
                    <div class="card-body">
                        <h4>{{ $event->name }}</h4>
                        <p>
                            {{ $event->date }} @ {{ $event->place }}
                            @if ($event->open_at != null)
                                <br>
                                {{ __('open_at_abbrev') }}：{{ $event->open_at }}
                            @endif
                            @if ($event->start_at != null)
                                <br>
                                {{ __('start_at_abbrev') }}：{{ $event->start_at }}
                            @endif
                            @if ($event->end_at != null)
                                <br>
                                {{ __('end_at_abbrev') }}：{{ $event->end_at }}
                            @endif
                            <br>
                            {{ __('expire_at') }}：{{ $event->expire_at }}
                        </p>
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
                    <form id="delete-form" action="{{ route('delete_event', ['event_id' => $event->event_id]) }}" method="POST"
                        class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
