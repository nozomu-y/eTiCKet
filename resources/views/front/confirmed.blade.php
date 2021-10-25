<?php
use App\Enums\SeatType;
?>
@extends('layouts.main')
@section('title', __('qrreader'))

@section('content')
    <div class="row">
        <div class="col-md-4 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h2 class="h4">{{ $event->name }}</h2>
                    <h3 class="h6">{{ $event->place }}</h3>
                    <h3 class="h6">{{ date('Y/m/d', strtotime($event->date)) }}</h3>
                    <p class="mb-0">
                        <strong>{{ SeatType::getDescription($event->seat_type) }}</strong>
                        <br>
                        @if ($ticket->seat != null)
                            <strong class="mr-1">{{ __('seat_no') }}</strong>
                            {{ $ticket->seat }}
                            <br>
                        @endif
                        <strong class="mr-1">{{ __('price') }}</strong>
                        {{ $ticket->price }}
                    </p>
                </div>
            </div>
            <div class="text-center">
                <p>
                    {{ __('message.front.collect.confirmed') }}
                </p>
                <a class="btn btn-secondary" href="{{ route('home') }}">{{ __('go_home') }}</a>
                <a class="btn btn-primary" href="{{ route('qrreader') }}">{{ __('scan_more') }}</a>
            </div>
        </div>
    </div>
@endsection
