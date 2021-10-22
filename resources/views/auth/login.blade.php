@extends('layouts.login')
@section('title', __('login'))

@section('style')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="p-5">
        <div class="text-center">
            <h1 class="h3 text-gray-900 mb-1">{{ config('app.name') }}</h1>
            <h2 class="h5 text-gray-900 mb-4">{{ __('administrator_login') }}</h2>
        </div>

        {{ Form::open(['url' => 'login', 'method' => 'post']) }}
        <div class="form-group">
            {{ Form::text('username', null, [
                'class' => 'form-control' . ($errors->has('username') ? ' is-invalid' : ''),
                'autocomplete' => 'username',
                'id' => 'username',
                'placeholder' => __('username'),
                'autofocus',
                'required',
            ]) }}
            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            {{ Form::password('password', [
                'class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''),
                'autocomplete' => 'current-password',
                'id' => 'password',
                'placeholder' => __('password'),
                'required',
            ]) }}
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('remember_me') }}
                </label>
            </div>
        </div>
        {{ Form::button(__('login'), ['class' => 'btn btn-primary btn-user btn-block', 'name' => 'login', 'type' => 'submit']) }}
        {{ Form::close() }}
    </div>
@endsection
