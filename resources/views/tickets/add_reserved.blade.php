@extends('layouts.main')
@section('title', __('add_tickets_abbrev'))

@section('content')
    <div class="container-fluid">
        <h1 class="h3 text-gray-800 mb-4">{{ __('add_tickets_abbrev') }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('events') }}">{{ __('event_list') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('event_detail', ['event_id' => $event->event_id]) }}">{{ $event->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('add_tickets_abbrev') }}</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('add_tickets_abbrev') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('post_add_tickets', ['event_id' => $event->event_id]) }}">
                            @csrf

                            <div class="form-group row">
                                <label for="price"
                                    class="col-md-4 col-form-label text-md-right">{{ __('price') }}</label>
                                <div class="col-md-6">
                                    <input id="price" type="number"
                                        class="form-control @error('price') is-invalid @enderror" name="price"
                                        value="{{ old('price') }}" required>
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="csv"
                                    class="col-md-4 col-form-label text-md-right">{{ __('csv') }}</label>
                                <div class="col-md-6">
                                    <textarea id="csv" rows="5"
                                        class="form-control @error('csv') is-invalid @enderror" name="csv"
                                        value="{{ old('csv') }}" 
                                        required>{{ __('message.tickets.form.csv') }}</textarea>
                                    @error('csv')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('add') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
