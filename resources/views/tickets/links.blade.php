@extends('layouts.main')
@section('title', __('issue_tickets_abbrev'))

@section('content')
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
            @if (isset($success))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $success }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <?php
            $links = '';
            foreach ($data as $link) {
                $links .= __('ticket_no') . '：' . $link[0] . "\n";
                $links .= __('seat_no') . '：' . $link[1] . "\n";
                $links .= config('app.url') . '/' . $event->event_id . '/' . $link[0] . '/' . $link[2] . "\n\n";
            }
            ?>
            <div class="form-group">
                <textarea class="form-control" rows="10">{{ $links }}</textarea>
            </div>
            <a class="btn btn-secondary"
                href="{{ route('event_detail', ['event_id' => $event->event_id]) }}">{{ __('return_to_event_detail') }}</a>
            <a class="btn btn-primary"
                href="{{ route('issue_tickets', ['event_id' => $event->event_id]) }}">{{ __('issue_more_tickets') }}</a>
        </div>
    </div>
@endsection
