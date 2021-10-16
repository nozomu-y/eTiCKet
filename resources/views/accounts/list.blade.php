@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <a href="{{ route('add_account') }}">{{ __('add_account') }}</a>
            </div>
        </div>
    </div>
@endsection
