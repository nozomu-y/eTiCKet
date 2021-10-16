@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 text-gray-800 mb-4">イベント一覧</h1>
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>name</th>
                            <th>place</th>
                            <th>date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td><a href="{{ route('event_detail', ['id' => $event->event_id]) }}">{{ $event->name }}</a></td>
                                <td>{{ $event->place }}</td>
                                <td>{{ $event->date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (Auth::user()->role == 'admin')
                <a class="btn btn-primary" href="{{ route('add_event') }}">{{ __('add_event') }}</a>
                @endif
            </div>
        </div>
    </div>
@endsection
