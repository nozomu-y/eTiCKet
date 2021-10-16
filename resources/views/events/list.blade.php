@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                {{-- <table class="table"> --}}
                    {{-- <thead> --}}
                        {{-- <tr> --}}
                            {{-- <th>username</th> --}}
                            {{-- <th>name</th> --}}
                            {{-- <th>role</th> --}}
                        {{-- </tr> --}}
                    {{-- </thead> --}}
                    {{-- <tbody> --}}
                        {{-- @foreach ($users as $user) --}}
                            {{-- <tr> --}}
                                {{-- <td>{{ $user['username'] }}</td> --}}
                                {{-- <td>{{ $user['name'] }}</td> --}}
                                {{-- <td>{{ $user['role'] }}</td> --}}
                            {{-- </tr> --}}
                        {{-- @endforeach --}}
                    {{-- </tbody> --}}
                {{-- </table> --}}
                <a class="btn btn-primary" href="{{ route('add_account') }}">{{ __('add_account') }}</a>
            </div>
        </div>
    </div>
@endsection
