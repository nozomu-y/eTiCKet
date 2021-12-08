<?php
use App\Enums\SeatType;
use App\Enums\CollectType;
?>
@extends('layouts.main')
@section('title', __('edit_event'))

@section('content')
    <h1 class="h3 text-gray-800 mb-4">{{ __('edit_ticket') }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('events') }}">{{ __('event_list') }}</a></li>
            <li class="breadcrumb-item"><a
                    href="{{ route('event_detail', ['event_id' => $event->event_id]) }}">{{ $event->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tickets', ['event_id' => $event->event_id]) }}">
                    {{ __('ticket_list') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('show_ticket', ['event_id' => $event->event_id, 'ticket_id' => $ticket->ticket_id]) }}">
                    {{ __('ticket_detail') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('edit') }}</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('post_edit_ticket', ['event_id' => $event->event_id, 'ticket_id' => $ticket->ticket_id]) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="ticket_id"
                                class="col-md-4 col-form-label text-md-right">{{ __('ticket_no') }}</label>
                            <div class="col-md-6">
                                <input id="ticket_id" type="text" class="form-control" name="ticket_id"
                                    value="{{ sprintf('%06d', $ticket->ticket_id) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="seat" class="col-md-4 col-form-label text-md-right">{{ __('seat_no') }}</label>
                            <div class="col-md-6">
                                <input id="seat" type="text" class="form-control @error('seat') is-invalid @enderror"
                                    name="seat" value="{{ $ticket->seat }}" required>
                                @error('seat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('price') }}</label>
                            <div class="col-md-6">
                                <input id="price" type="number" class="form-control @error('price') is-invalid @enderror"
                                    name="price" value="{{ $ticket->price }}" required>
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="memo" class="col-md-4 col-form-label text-md-right">{{ __('memo') }}</label>
                            <div class="col-md-6">
                                <input id="memo" type="text" class="form-control @error('memo') is-invalid @enderror"
                                    name="memo" value="{{ $ticket->memo }}">
                                @error('memo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('edit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
