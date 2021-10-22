@extends('layouts.main')
@section('title', '404 Page Not Found')

@section('content')
    <div class="container-fluid">
        <div class="text-center">
            <div class="display-1" data-text="404">404</div>
            <p class="lead text-gray-800 mb-5">Page Not Found</p>
            <a href="{{route('home')}}">Take Me Home</a>
        </div>
    </div>
@endsection
