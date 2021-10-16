@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 text-gray-800 mb-4">イベント</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('events') }}">イベント一覧</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $event->name }}</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        イベント情報
                    </div>
                    <div class="card-body">
                        <h4>{{ $event->name }}</h4>
                        <p>
                            {{ $event->date }} @ {{ $event->place }}
                            @if ($event->open_at != null)
                                <br>
                                開場：{{ $event->open_at }}
                            @endif
                            @if ($event->start_at != null)
                                <br>
                                開演：{{ $event->start_at }}
                            @endif
                            @if ($event->end_at != null)
                                <br>
                                終演：{{ $event->end_at }}
                            @endif
                            <br>
                            有効期限：{{ $event->expire_at }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4">
                <div class="list-group mb-4">
                    <a class="list-group-item list-group-item-action">{{ __('ticket_list') }}</a>
                    <a class="list-group-item list-group-item-action">{{ __('edit_event') }}</a>
                    <a class="list-group-item list-group-item-action text-danger"
                       onclick="if (confirm('{{ __('message.confirm.event.delete') }}')) {event.preventDefault(); document.getElementById('delete-form').submit();}"
                        >{{ __('delete_event') }}</a>
                    <form id="delete-form" action="{{ route('delete_event', ['id' => $event->event_id]) }}" method="POST" class="d-none">
                    @csrf
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
