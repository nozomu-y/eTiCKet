<?php
use App\Enums\SeatType;
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

@section('content')
    <h1 class="h3 text-gray-800 mb-4">{{ $event->name }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('events') }}">{{ __('event_list') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $event->name }}</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-12">
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
                </div>
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="h5">{{ $event->name }}</h3>
                            <table class="mt-2">
                                <tbody>
                                    <tr>
                                        <th class="text-nowrap pr-3">{{ __('date') }}</th>
                                        <td>{{ date('Y/m/d', strtotime($event->date)) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap pr-3">{{ __('hall') }}</th>
                                        <td>{{ $event->place }}</td>
                                    </tr>
                                    @if ($event->open_at != null)
                                        <tr>
                                            <th class="text-nowrap pr-3">{{ __('open_at_abbrev') }}</th>
                                            <td>{{ date('H:i', strtotime($event->open_at)) }}</td>
                                        </tr>
                                    @endif
                                    @if ($event->start_at != null)
                                        <tr>
                                            <th class="text-nowrap pr-3">{{ __('start_at_abbrev') }}</th>
                                            <td>{{ date('H:i', strtotime($event->start_at)) }}</td>
                                        </tr>
                                    @endif
                                    @if ($event->end_at != null)
                                        <tr>
                                            <th class="text-nowrap pr-3">{{ __('end_at_abbrev') }}</th>
                                            <td>{{ date('H:i', strtotime($event->end_at)) }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th class="text-nowrap pr-3">{{ __('expire_at') }}</th>
                                        <td>{{ date('Y/m/d H:i', strtotime($event->expire_at)) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap pr-3">{{ __('seat_type') }}</th>
                                        <td>{{ SeatType::getDescription($event->seat_type) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <h4 class="h6">{{ __('collect_personal_information') }}</h4>
                            <table class="mt-2">
                                <tbody>
                                    <tr>
                                        <th class="text-nowrap pr-3">{{ __('name') }}</th>
                                        <td>{{ CollectType::getDescription($event->collect_name) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap pr-3">{{ __('email') }}</th>
                                        <td>{{ CollectType::getDescription($event->collect_email) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap pr-3">{{ __('phone_number') }}</th>
                                        <td>{{ CollectType::getDescription($event->collect_phone_number) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <canvas id="ticketIssueRatioChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <canvas id="ticketCheckInRatioChart"></canvas>
                        </div>
                    </div>
                </div>
                @if (!empty($memo_html))
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">{{ __('memo_under_ticket') }}</div>
                            <div class="card-body">
                                <?= $memo_html ?>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-lg-4">
            <div class="list-group mb-4">
                <a class="list-group-item list-group-item-action"
                    href="{{ route('tickets', ['event_id' => $event->event_id]) }}">{{ __('ticket_list') }}</a>
                <a class="list-group-item list-group-item-action"
                    href="{{ route('add_tickets', ['event_id' => $event->event_id]) }}">{{ __('add_tickets') }}</a>
                <a class="list-group-item list-group-item-action"
                    href="{{ route('issue_tickets', ['event_id' => $event->event_id]) }}">{{ __('issue_tickets') }}</a>
                <a class="list-group-item list-group-item-action"
                    href="{{ route('edit_event', ['event_id' => $event->event_id]) }}">{{ __('edit_event') }}</a>
                @if (Auth::user()->role === UserRole::ADMIN)
                    <a class="list-group-item list-group-item-action text-danger"
                        onclick="if (confirm('{{ __('message.events.delete.confirm') }}')) {event.preventDefault(); document.getElementById('delete-form').submit();}">{{ __('delete_event') }}</a>
                    <form id="delete-form" action="{{ route('delete_event', ['event_id' => $event->event_id]) }}"
                        method="POST" class="d-none">
                        @csrf
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        const data = {
            labels: ['{{ __('issued') }}', '{{ __('unissued') }}'],
            datasets: [{
                label: 'Dataset 1',
                data: [{{ $num_issued }}, {{ $num_tickets - $num_issued }}],
                backgroundColor: Object.values(['#03a9f4', '#81d4fa']),
            }]
        };

        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: '{{ __('tickets_issue_status') }}'
                    }
                }
            },
        };

        const TicketRatioChart = new Chart(
            document.getElementById('ticketIssueRatioChart'),
            config
        );
    </script>
    <script>
        const data_check_in = {
            labels: ['{{ __('checked_in') }}', '{{ __('not_checked_in') }}'],
            datasets: [{
                label: 'Dataset 1',
                data: [{{ $num_checked_in }}, {{ $num_issued - $num_checked_in }}],
                backgroundColor: Object.values(['#ff9800', '#ffcc80']),
            }]
        };

        const config_check_in = {
            type: 'pie',
            data: data_check_in,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: '{{ __('tickets_check_in_status') }}'
                    }
                }
            },
        };

        const TicketCheckInRatioChart = new Chart(
            document.getElementById('ticketCheckInRatioChart'),
            config_check_in
        );
    </script>
@endsection
