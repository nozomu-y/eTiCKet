@extends('layouts.login')

@section('title', __('login'))

@section('content')
    <div class="p-5">
        <div class="text-center">
            <h1 class="h4 text-gray-900 mb-4">{{ config('app.name') }}</h1>
        </div>

        {{ Form::open(['url' => 'login', 'method' => 'post', 'class' => 'user']) }}
        <div class="form-group">
            {{ Form::text('username', null, [
                'class' => 'form-control form-control-user' . ($errors->has('username') ? ' is-invalid' : ''),
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
                'class' => 'form-control form-control-user' . ($errors->has('password') ? ' is-invalid' : ''),
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
        {{ Form::button(__('login'), ['class' => 'btn btn-primary btn-user btn-block', 'name' => 'login', 'type' => 'submit']) }}
        {{ Form::close() }}
    </div>
@endsection

