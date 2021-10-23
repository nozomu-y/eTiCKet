@extends('layouts.main')
@section('title', __('change_password'))

@section('content')
    <h1 class="h3 text-gray-800 mb-4">{{ __('change_password') }}</h1>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('change_password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('change_password') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="current_password"
                                class="col-md-4 col-form-label text-md-right">{{ __('current_password') }}</label>

                            <div class="col-md-6">
                                <input id="current_password" type="password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    name="current_password" required>

                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('new_password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('password_confirm') }}</label>

                            <div class="col-md-6">
                                <input id="password_confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('change') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
