@extends('layouts.main')
@section('title', __('qrreader'))

@section('content')
    <div class="container-fluid">
        <h1 class="h3 text-gray-800 mb-4">{{ __('qrreader') }}</h1>
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
                <div class="text-center">
                    <a class="btn btn-secondary" href="{{ route('home') }}">{{ __('go_home') }}</a>
                    <a class="btn btn-primary" href="{{ route('qrreader') }}">{{ __('qrreader') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
