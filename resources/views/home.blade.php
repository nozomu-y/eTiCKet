@extends('layouts.main')

@section('title', __('home'))

@section('content')
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
        </div>

        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">{{ __('latest_event') }}</h4>
                    <hr>
                    @if ($event !== null)
                        <h5>{{ $event->name }}</h5>
                        <p class="card-text">
                            <i class="far fa-calendar mr-1" style="font-size: 1.1rem;"></i>
                            {{ date('Y/m/d', strtotime($event->date)) }}
                            <br>
                            <i class="fas fa-map-marker-alt mr-1" style="font-size: 1.1rem;"></i> {{ $event->place }}
                        </p>
                        <a href="{{ route('event_detail', ['event_id' => $event->event_id]) }}"
                            class="btn btn-outline-mdb-color btn-md">{{ __('event_detail') }}</a>
                    @else
                        <p class="card-text">
                        {{ __('message.home.latest_event.not_found') }}
                        </p>
                    @endif
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('events') }}">{{ __('event_list') }} <i class="fas fa-chevron-right ml-2"></i></a>
                </div>
            </div>
        </div>

        <div class="col-12">
        <a class="btn btn-default btn-lg btn-block mb-3" href="{{ route('qrreader') }}">{{ __('qrreader') }}</a>
        </div>

    </div>
@endsection
