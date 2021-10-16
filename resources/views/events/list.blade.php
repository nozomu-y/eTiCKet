@extends('layouts.main')
@section('title', __('event_list'))

@section('content')
    <div class="container-fluid">
        <h1 class="h3 text-gray-800 mb-4">{{ __('event_list') }}</h1>
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
                            <th>{{ __('event_name') }}</th>
                            <th>{{ __('place') }}</th>
                            <th>{{ __('date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td><a
                                        href="{{ route('event_detail', ['id' => $event->event_id]) }}">{{ $event->name }}</a>
                                </td>
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
