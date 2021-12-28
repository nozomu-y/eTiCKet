<?php
use App\Enums\SeatType;
use App\Enums\CollectType;
?>
@extends('layouts.main')
@section('title', __('edit_event'))

@section('content')
    <h1 class="h3 text-gray-800 mb-4">{{ __('edit_event') }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('events') }}">{{ __('event_list') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('edit_event') }}</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('post_edit_event', ['event_id' => $event->event_id]) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="event_name"
                                class="col-md-4 col-form-label text-md-right">{{ __('event_name') }}</label>
                            <div class="col-md-6">
                                <input id="event_name" type="text"
                                    class="form-control @error('event_name') is-invalid @enderror" name="event_name"
                                    value="{{ $event->name }}" required>
                                @error('event_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('date') }}</label>
                            <div class="col-md-6">
                                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror"
                                    name="date" value="{{ $event->date }}" required>
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="place" class="col-md-4 col-form-label text-md-right">{{ __('place') }}</label>
                            <div class="col-md-6">
                                <input id="place" type="text" class="form-control @error('place') is-invalid @enderror"
                                    name="place" value="{{ $event->place }}" required>
                                @error('place')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="open_at"
                                class="col-md-4 col-form-label text-md-right">{{ __('open_at') }}</label>
                            <div class="col-md-6">
                                <input id="open_at" type="time" class="form-control @error('open_at') is-invalid @enderror"
                                    name="open_at"
                                    value="{{ $event->open_at == null ? '' : date('H:i', strtotime($event->open_at)) }}">
                                @error('open_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start_at"
                                class="col-md-4 col-form-label text-md-right">{{ __('start_at') }}</label>
                            <div class="col-md-6">
                                <input id="start_at" type="time"
                                    class="form-control @error('start_at') is-invalid @enderror" name="start_at"
                                    value="{{ $event->start_at == null ? '' : date('H:i', strtotime($event->start_at)) }}">
                                @error('start_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_at" class="col-md-4 col-form-label text-md-right">{{ __('end_at') }}</label>
                            <div class="col-md-6">
                                <input id="end_at" type="time" class="form-control @error('end_at') is-invalid @enderror"
                                    name="end_at"
                                    value="{{ $event->end_at == null ? '' : date('H:i', strtotime($event->end_at)) }}">
                                @error('end_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="expire_at"
                                class="col-md-4 col-form-label text-md-right">{{ __('expire_at') }}</label>
                            <div class="col-md-6">
                                <input id="expire_at" type="datetime-local"
                                    class="form-control @error('expire_at') is-invalid @enderror" name="expire_at"
                                    value="{{ date('Y-m-d\TH:i', strtotime($event->expire_at)) }}" required>
                                @error('expire_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="seat_type"
                                class="col-md-4 col-form-label text-md-right">{{ __('seat_type') }}</label>
                            <div class="col-md-6">
                                <select name="seat_type" id="seat_type"
                                    class="form-control @error('seat_type') is-invalid @enderror"
                                    value="{{ old('seat_type') }}" disabled required>
                                    <option value="{{ SeatType::RESERVED }}"
                                        {{ $event->seat_type == SeatType::RESERVED ? 'selected' : '' }}>
                                        {{ __('reserved') }}</option>
                                    <option value="{{ SeatType::UNRESERVED }}"
                                        {{ $event->seat_type == SeatType::UNRESERVED ? 'selected' : '' }}>
                                        {{ __('unreserved') }}</option>
                                </select>
                                @error('seat_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <h3 class="h5">{{ __('collect_personal_information') }}</h3>
                        <p>
                            {{ __('message.events.add.collect_personal_information') }}
                        </p>

                        <div class="form-group row">
                            <label for="seat_type"
                                class="col-md-4 col-form-label text-md-right">{{ __('name') }}</label>
                            <div class="col-md-6">
                                <select name="collect_name" id="collect_name"
                                    class="form-control @error('collect_name') is-invalid @enderror"
                                    value="{{ old('collect_name') }}" required>
                                    <option value="{{ CollectType::DISABLED }}"
                                        {{ $event->collect_name == CollectType::DISABLED ? 'selected' : '' }}>
                                        {{ __('collection_disabled') }}</option>
                                    <option value="{{ CollectType::OPTIONAL }}"
                                        {{ $event->collect_name == CollectType::OPTIONAL ? 'selected' : '' }}>
                                        {{ __('collection_optional') }}</option>
                                    <option value="{{ CollectType::REQUIRED }}"
                                        {{ $event->collect_name == CollectType::REQUIRED ? 'selected' : '' }}>
                                        {{ __('collection_required') }}</option>
                                </select>
                                @error('collect_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="seat_type"
                                class="col-md-4 col-form-label text-md-right">{{ __('email') }}</label>
                            <div class="col-md-6">
                                <select name="collect_email" id="collect_email"
                                    class="form-control @error('collect_email') is-invalid @enderror"
                                    value="{{ old('collect_email') }}" required>
                                    <option value="{{ CollectType::DISABLED }}"
                                        {{ $event->collect_email == CollectType::DISABLED ? 'selected' : '' }}>
                                        {{ __('collection_disabled') }}</option>
                                    <option value="{{ CollectType::OPTIONAL }}"
                                        {{ $event->collect_email == CollectType::OPTIONAL ? 'selected' : '' }}>
                                        {{ __('collection_optional') }}</option>
                                    <option value="{{ CollectType::REQUIRED }}"
                                        {{ $event->collect_email == CollectType::REQUIRED ? 'selected' : '' }}>
                                        {{ __('collection_required') }}</option>
                                </select>
                                @error('collect_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="seat_type"
                                class="col-md-4 col-form-label text-md-right">{{ __('phone_number') }}</label>
                            <div class="col-md-6">
                                <select name="collect_phone_number" id="collect_phone_number"
                                    class="form-control @error('collect_phone_number') is-invalid @enderror"
                                    value="{{ old('collect_phone_number') }}" required>
                                    <option value="{{ CollectType::DISABLED }}"
                                        {{ $event->collect_phone_number == CollectType::DISABLED ? 'selected' : '' }}>
                                        {{ __('collection_disabled') }}</option>
                                    <option value="{{ CollectType::OPTIONAL }}"
                                        {{ $event->collect_phone_number == CollectType::OPTIONAL ? 'selected' : '' }}>
                                        {{ __('collection_optional') }}</option>
                                    <option value="{{ CollectType::REQUIRED }}"
                                        {{ $event->collect_phone_number == CollectType::REQUIRED ? 'selected' : '' }}>
                                        {{ __('collection_required') }}</option>
                                </select>
                                @error('collect_phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <h3 class="h5">{{ __('memo_under_ticket') }}</h3>
                        <p>
                            {{ __('message.events.add.memo') }}
                        </p>

                        <div class="form-group row">
                            <label for="memo" class="col-md-4 col-form-label text-md-right">{{ __('memo') }}</label>
                            <div class="col-md-6">
                                <textarea id="memo" rows="5" class="form-control @error('memo') is-invalid @enderror"
                                    name="memo" value="{{ old('memo') }}">{{ $event->memo }}</textarea>
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
