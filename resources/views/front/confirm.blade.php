<?php
use App\Enums\SeatType;
use App\Enums\CollectType;
use App\Libs\Common;
?>
@extends('layouts.main')
@section('title', __('qrreader'))

@section('content')
    <div class="row">
        <div class="col-md-4 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h2 class="h4">{{ $event->name }}</h2>
                    <h3 class="h6">{{ $event->place }}</h3>
                    <h3 class="h6">{{ date('Y/m/d', strtotime($event->date)) }}</h3>
                    <p class="mb-0">
                        <strong>{{ SeatType::getDescription($event->seat_type) }}</strong>
                        <br>
                        @if ($ticket->seat != null)
                            <strong class="mr-1">{{ __('seat_no') }}</strong>
                            {{ $ticket->seat }}
                            <br>
                        @endif
                        <strong class="mr-1">{{ __('price') }}</strong>
                        {{ $ticket->price }}
                    </p>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">{{ __('contact') }}</div>
                <div class="card-body">
                    <table>
                        <tbody>
                            @if ($event->collect_name !== CollectType::DISABLED)
                                <tr>
                                    <th class="text-nowrap pr-3">{{ __('name') }}</th>
                                    <td>{{ Common::is_null_or_empty($personal_info->name) ? __('unentered') : $personal_info->name }}
                                    </td>
                                </tr>
                            @endif
                            @if ($event->collect_email !== CollectType::DISABLED)
                                <tr>
                                    <th class="text-nowrap pr-3">{{ __('email') }}</th>
                                    <td>{{ Common::is_null_or_empty($personal_info->email) ? __('unentered') : Common::hide_email($personal_info->email) }}
                                    </td>
                                </tr>
                            @endif
                            @if ($event->collect_phone_number !== CollectType::DISABLED)
                                <tr>
                                    <th class="text-nowrap pr-3">{{ __('phone_number') }}</th>
                                    <td>{{ Common::is_null_or_empty($personal_info->phone_number) ? __('unentered') : Common::hide_phone_number($personal_info->phone_number) }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <form method="POST" action="{{ route('post_collect_ticket') }}" class="text-center">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->event_id }}"></input>
                <input type="hidden" name="ticket_id" value="{{ $ticket->ticket_id }}"></input>
                <input type="hidden" name="token" value="{{ $token }}"></input>
                <p>
                    {{ __('message.front.collect.confirm') }}
                </p>
                <a class="btn btn-secondary" href="{{ route('qrreader') }}">{{ __('go_back') }}</a>
                <button type="submit" class="btn btn-primary">{{ __('yes') }}</button>
            </form>
        </div>
    </div>
@endsection
