@extends('layouts.main')
@section('title', __('qrcode_unreadable'))

@section('content')
    <h1 class="h3 text-gray-800 mb-4">{{ __('qrcode_unreadable') }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('qrreader') }}">{{ __('qrreader') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('qrcode_unreadable') }}</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('post_qrcode_unreadable') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="event_id"
                                class="col-md-4 col-form-label text-md-right">{{ __('event_name') }}</label>
                            <div class="col-md-6">
                                <select name="event_id" id="event_id"
                                    class="form-control @error('event_id') is-invalid @enderror"
                                    value="{{ old('event_id') }}" required>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->event_id }}">{{ $event->name }}</option>
                                    @endforeach
                                </select>
                                @error('event_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ticket_id" class="col-md-4 col-form-label text-md-right">{{ __('ticket_no') }}</label>
                            <div class="col-md-6">
                                <input id="ticket_id" type="number" class="form-control @error('ticket_id') is-invalid @enderror"
                                    name="ticket_id" value="{{ old('ticket_id') }}" required>
                                @error('ticket_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="token" class="col-md-4 col-form-label text-md-right">{{ __('token') }}</label>
                            <div class="col-md-6">
                                <input id="token" type="text" class="form-control @error('token') is-invalid @enderror"
                                    name="token" value="{{ old('token') }}" required>
                                <small id="token_help" class="form-text text-muted">{{ __('message.front.qrcode.form.token') }}</small>
                                @error('token')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('send') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        </div>
    </div>
@endsection
