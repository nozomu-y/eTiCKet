<?php
use App\Libs\Common;
use App\Enums\UserRole;
use App\Enums\SeatType;
?>
@extends('layouts.main')
@section('title', __('ticket_list'))

@section('style')
    <style>
        table tbody tr.tr-hover {
            background-color: rgba(0, 0, 0, 0.025);
        }

        table tbody tr.tr-hover:hover {
            background-color: rgba(0, 0, 0, 0.1);
            -webkit-transition: 0.5s;
            transition: 0.5s;
        }

        table tbody tr.tr-hover-issued {
            background-color: rgba(57, 192, 237, 0.05);
        }

        table tbody tr.tr-hover-issued:hover {
            background-color: rgba(57, 192, 237, 0.1);
            -webkit-transition: 0.5s;
            transition: 0.5s;
        }

        table tbody tr.tr-hover-used {
            background-color: rgba(0, 183, 74, 0.05);
        }

        table tbody tr.tr-hover-used:hover {
            background-color: rgba(0, 183, 74, 0.1);
            -webkit-transition: 0.5s;
            transition: 0.5s;
        }

    </style>
@endsection

@section('content')
    <h1 class="h3 text-gray-800 mb-4">{{ __('ticket_list') }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('events') }}">{{ __('event_list') }}</a></li>
            <li class="breadcrumb-item"><a
                    href="{{ route('event_detail', ['event_id' => $event->event_id]) }}">{{ $event->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ticket_list') }}</li>
        </ol>
    </nav>
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
            <div class="mb-3">
                <table class="table" id="tickets_table" style="min-width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-nowrap">{{ __('ticket_no') }}</th>
                            @if ($event->seat_type == SeatType::RESERVED)
                                <th class="text-nowrap">{{ __('seat_no') }}</th>
                            @endif
                            <th class="text-nowrap">{{ __('price') }}</th>
                            <th class="text-nowrap">{{ __('issue') }}</th>
                            <th class="text-nowrap">{{ __('check_in') }}</th>
                            <th class="text-nowrap">{{ __('memo') }}</th>
                            <th class="text-nowrap">{{ __('name') }}</th>
                            <th class="text-nowrap">{{ __('email') }}</th>
                            <th class="text-nowrap">{{ __('phone_number') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            @if ($ticket->is_checked_in)
                                <tr class="tr-hover-used"
                                    onclick="window.location='{{ route('show_ticket', ['event_id' => $event->event_id, 'ticket_id' => $ticket->ticket_id]) }}'">
                                @elseif ($ticket->is_issued)
                                <tr class="tr-hover-issued"
                                    onclick="window.location='{{ route('show_ticket', ['event_id' => $event->event_id, 'ticket_id' => $ticket->ticket_id]) }}'">
                                @else
                                <tr class="tr-hover"
                                    onclick="window.location='{{ route('show_ticket', ['event_id' => $event->event_id, 'ticket_id' => $ticket->ticket_id]) }}'">
                            @endif
                            <td class="text-nowrap">{{ sprintf('%06d', $ticket->ticket_id) }}</td>
                            @if ($event->seat_type == SeatType::RESERVED)
                                <td class="text-nowrap">{{ $ticket->seat }}</td>
                            @endif
                            <td class="text-nowrap">{{ Common::format_price($ticket->price) }}</td>
                            <td class="text-nowrap">{{ $ticket->is_issued ? __('done') : '' }}</td>
                            <td class="text-nowrap">{{ $ticket->is_checked_in ? __('done') : '' }}</td>
                            <td class="text-truncate" style="max-width: 20rem;">{{ $ticket->memo }}</td>
                            @if (Auth::user()->role == UserRole::ADMIN)
                                <td class="text-nowrap">{{ $ticket->name }}</td>
                                <td class="text-nowrap">{{ $ticket->email }}</td>
                                <td class="text-nowrap">{{ $ticket->phone_number }}</td>
                            @else
                                <td class="text-nowrap">{{ empty($ticket->name) ? '' : __('entered') }}
                                </td>
                                <td class="text-nowrap">{{ empty($ticket->email) ? '' : __('entered') }}
                                </td>
                                <td class="text-nowrap">
                                    {{ empty($ticket->phone_number) ? '' : __('entered') }}</td>
                            @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#tickets_table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Japanese.json"
                },
                "order": [], // don't order on init
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "全件"]
                ],
                "columnDefs": [{
                    type: "currency",
                    targets: 2
                }],
                "deferRender": false,
                "autowidth": false,
                "scrollX": true,
                "dom": "<\'row\'<\'col-sm-6\'l><\'col-sm-6 right\'f>>" +
                    "<\'row\'<\'col-sm-12 mb-2\'tr>>" +
                    "<\'row\'<\'col-sm-6\'i><\'col-sm-6\'p>>",
            });
        });
    </script>
@endsection
