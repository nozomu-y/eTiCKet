<?php
use App\Libs\Common;
use App\Enums\CollectType;
use App\Enums\UserRole;

$markdown = $event->memo;
$parsedown = new Parsedown();
$parsedown->setBreaksEnabled(true);
$parsedown->setSafeMode(true);
$memo_html = $parsedown->text($markdown);
?>
@extends('layouts.main')
@section('title', $event->name)
@section('style')
    <style>
        svg {
            width: calc(100% - 20px) !important;
            border-top-left-radius: calc(.25rem - 1px);
            border-top-right-radius: calc(.25rem - 1px);
            font-size: 1.125rem;
            text-anchor: middle;
            height: auto;
            margin: 10px;
        }

        .ticket {
            max-width: 400px;
            min-width: 300px;
        }

    </style>
@endsection

@section('content')
    @if (url()->current() === route('show_ticket', ['event_id' => $event->event_id, 'ticket_id' => $ticket->ticket_id]))
        <h1 class="h3 text-gray-800 mb-4">{{ __('ticket_detail') }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('events') }}">{{ __('event_list') }}</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('event_detail', ['event_id' => $event->event_id]) }}">{{ $event->name }}</a>
                </li>
                <li class="breadcrumb-item"><a
                        href="{{ route('tickets', ['event_id' => $event->event_id]) }}">{{ __('ticket_list') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('ticket_detail') }}</li>
            </ol>
        </nav>
    @endif
    <div class="row">
        <div class="col-lg-4">
            @if (session('error'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if ($ticket->is_checked_in)
                <div class="alert alert-danger" role="alert">
                    {{ __('message.tickets.already_used') }}
                </div>
            @endif
            @if (isset($personal_info_unentered) && $personal_info_unentered)
                <div class="alert alert-info" role="alert">
                    {{ __('message.personal_informations.unentered') }}
                </div>
            @endif
            <div class="d-flex justify-content-center">
                <div class="card mb-4 ticket">
                    @if ((!isset($personal_info_unentered) || !$personal_info_unentered) && $ticket->is_issued)
                        {!! QrCode::size(400)->generate(config('app.url') . '/' . $event->event_id . '/' . $ticket->ticket_id . '/' . $ticket->token) !!}
                    @endif
                    <div class="card-body">
                        <div class="text-center">
                            <?php
                            $lines = explode(' ', config('app.corporation_name'));
                            ?>
                            @foreach ($lines as $line)
                                <h2 class="h4 mb-0">{{ $line }}</h2>
                            @endforeach
                            <h3 class="h5 mt-1">{{ $event->name }}</h3>
                        </div>
                        <table class="mt-3" style="border-collapse: separate; border-spacing: 1em 0em;">
                            <tbody>
                                <tr>
                                    <th class="mr-3 text-nowrap">{{ __('date') }}</th>
                                    <td>{{ date('Y/m/d', strtotime($event->date)) }}</td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap">{{ __('hall') }}</th>
                                    <td>{{ $event->place }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="mt-3 d-flex justify-content-center"
                            style="border-collapse: separate; border-spacing: 1em 0em;">
                            <tbody>
                                <tr>
                                    @if ($event->open_at != null)
                                        <th class="text-nowrap">{{ __('open_at_abbrev') }}</th>
                                        <td>{{ date('H:i', strtotime($event->open_at)) }}</td>
                                    @endif
                                    @if ($event->start_at != null)
                                        <th class="text-nowrap">{{ __('start_at_abbrev') }}</th>
                                        <td>{{ date('H:i', strtotime($event->start_at)) }}</td>
                                    @endif
                                </tr>
                                @if ($event->end_at != null)
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <th class="text-nowrap">{{ __('end_at_abbrev') }}</th>
                                        <td>{{ date('H:i', strtotime($event->end_at)) }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <hr>
                        <table class="mt-3 d-flex justify-content-center"
                            style="border-collapse: separate; border-spacing: 1em 0em;">
                            <tbody>
                                <tr>
                                    <th class="text-nowrap">{{ __('seat_type') }}</th>
                                    <td>{{ $seat_type }}</td>
                                    <th class="text-nowrap">{{ __('price') }}</th>
                                    <td>{{ Common::format_price($ticket->price) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if ($ticket->seat != null)
                            <table class="mt-1 d-flex justify-content-center"
                                style="border-collapse: separate; border-spacing: 1em 0em;">
                                <tbody>
                                    <tr>
                                        <th class="text-nowrap">{{ __('seat_no') }}</th>
                                        <td>{{ $ticket->seat }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                        <div class="text-center mt-2">
                            <small class="text-monospace">No. {{ sprintf('%06d', $ticket->ticket_id) }}</small>
                            <br>
                            <small class="text-monospace">{{ $ticket->token }}</small>
                        </div>
                    </div>
                </div>
            </div>

            @if (!isset($personal_info_disabled) or !$personal_info_disabled)
                @if ($ticket->token != null && url()->current() === route('guest_ticket', ['event_id' => $event->event_id, 'ticket_id' => $ticket->ticket_id, 'token' => $ticket->token]))
                    @if (isset($personal_info_unentered) && $personal_info_unentered && !$ticket->is_checked_in)
                        <div class="text-center">
                            <a class="btn btn-primary mb-3"
                                href="{{ route('guest_contact', ['event_id' => $event->event_id, 'ticket_id' => $ticket->ticket_id, 'token' => $ticket->token]) }}">{{ __('register_contact') }}</a>
                        </div>
                    @else
                        <div class="card mb-3">
                            <div class="card-header">{{ __('contact') }}</div>
                            <div class="card-body">
                                <table>
                                    <tbody>
                                        @if ($event->collect_name !== CollectType::DISABLED)
                                            <tr>
                                                <th class="text-nowrap pr-3">{{ __('name') }}</th>
                                                <td>{{ ($personal_info === null or Common::is_null_or_empty($personal_info->name)) ? __('unentered') : $personal_info->name }}
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($event->collect_email !== CollectType::DISABLED)
                                            <tr>
                                                <th class="text-nowrap pr-3">{{ __('email') }}</th>
                                                <td>{{ ($personal_info === null or Common::is_null_or_empty($personal_info->email)) ? __('unentered') : Common::hide_email($personal_info->email) }}
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($event->collect_phone_number !== CollectType::DISABLED)
                                            <tr>
                                                <th class="text-nowrap pr-3">{{ __('phone_number') }}</th>
                                                <td>{{ ($personal_info === null or Common::is_null_or_empty($personal_info->phone_number)) ? __('unentered') : Common::hide_phone_number($personal_info->phone_number) }}
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if (!$ticket->is_checked_in)
                            <div class="text-center">
                                <a class="btn btn-primary mb-3"
                                    href="{{ route('guest_contact', ['event_id' => $event->event_id, 'ticket_id' => $ticket->ticket_id, 'token' => $ticket->token]) }}">{{ __('edit_contact') }}</a>
                            </div>
                        @endif
                    @endif
                @endif
            @endif

            @if (!empty($memo_html))
                <div class="card mb-3">
                    <div class="card-body">
                        <?= $memo_html ?>
                    </div>
                </div>
            @endif

            @if ($ticket->is_issued)
                <div>
                    <p>
                        <strong class="mr-1">{{ __('ticket_url') }}</strong>
                        <a href="{{ config('app.url') . '/' . $event->event_id . '/' . $ticket->ticket_id . '/' . $ticket->token }}"
                            class="text-break">{{ config('app.url') . '/' . $event->event_id . '/' . $ticket->ticket_id . '/' . $ticket->token }}</a>
                    </p>
                </div>
            @endif
        </div>

        <div class="col-lg-4 mb-3">
            @if (url()->current() === route('show_ticket', ['event_id' => $event->event_id, 'ticket_id' => $ticket->ticket_id]))
                <div class="card">
                    <div class="card-header">{{ __('memo') }} </div>
                    <div class="card-body">
                        {{ $ticket->memo }}
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4 mb-3">
            @if (url()->current() === route('show_ticket', ['event_id' => $event->event_id, 'ticket_id' => $ticket->ticket_id]))
                <div class="list-group mb-4">
                    <a class="list-group-item list-group-item-action"
                        href="{{ route('edit_ticket', ['event_id' => $event->event_id, 'ticket_id' => $ticket->ticket_id]) }}">{{ __('edit_ticket') }}</a>
                    @if (Auth::user()->role === UserRole::ADMIN)
                        @if (!$ticket->is_issued)
                            <a class="list-group-item list-group-item-action text-danger"
                                onclick="if (confirm('{{ __('message.tickets.delete.confirm') }}')) {event.preventDefault(); document.getElementById('delete-form').submit();}">{{ __('delete_ticket') }}</a>
                            <form id="delete-form"
                                action="{{ route('delete_ticket', ['event_id' => $event->event_id, 'ticket_id' => $ticket->ticket_id]) }}"
                                method="POST" class="d-none">
                                @csrf
                            </form>
                        @else
                            <a class="list-group-item list-group-item-action text-danger"
                                onclick="alert('{{ __('message.tickets.delete.disabled') }}')">{{ __('delete_ticket') }}</a>
                        @endif
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection
