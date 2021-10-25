<?php
use App\Enums\CollectType;
?>
@extends('layouts.main')
@section('title', $event->name)

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST"
                        action="{{ route('post_guest_contact', ['event_id' => $event->event_id, 'ticket_id' => $ticket->ticket_id, 'token' => $ticket->token]) }}">
                        @csrf

                        @if ($event->collect_name !== CollectType::DISABLED)
                            <div class="form-group row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('name') . __('open_brackets') . CollectType::getDescription($event->collect_name) . __('close_brackets') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}"
                                        {{ CollectType::getFormAttribute($event->collect_name) }}>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        @if ($event->collect_email !== CollectType::DISABLED)
                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('email') . __('open_brackets') . CollectType::getDescription($event->collect_email) . __('close_brackets') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}"
                                        {{ CollectType::getFormAttribute($event->collect_email) }}>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        @if ($event->collect_phone_number !== CollectType::DISABLED)
                            <div class="form-group row">
                                <label for="phone_number"
                                    class="col-md-4 col-form-label text-md-right">{{ __('phone_number') . __('open_brackets') . CollectType::getDescription($event->collect_phone_number) . __('close_brackets') }}</label>
                                <div class="col-md-6">
                                    <input id="phone_number" type="text"
                                        class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                                        value="{{ old('phone_number') }}"
                                        {{ CollectType::getFormAttribute($event->collect_phone_number) }}>
                                    @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('register') }}
                                </button>
                                <a class="btn btn-secondary" href="{{ route('guest_ticket', ['event_id' => $event->event_id,'ticket_id'=>$ticket->ticket_id,'token'=>$ticket->token]) }}">{{__('go_back')}}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
