<?php
use App\Libs\Common;
?>
@extends('layouts.main')
@section('title', __('ticket_list'))

@section('content')
    <div class="container-fluid">
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
                    <table class="table table-hover" id="tickets_table" style="min-width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-nowrap">{{ __('ticket_no') }}</th>
                                <th class="text-nowrap">{{ __('seat_no') }}</th>
                                <th class="text-nowrap">{{ __('door_no') }}</th>
                                <th class="text-nowrap">{{ __('price') }}</th>
                                <th class="text-nowrap">{{ __('issue') }}</th>
                                <th class="text-nowrap">{{ __('check_in') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr
                                    onclick="window.location='{{ route('show_ticket', ['event_id' => $event->event_id, 'ticket_id' => $ticket->ticket_id]) }}'">
                                    <td class="text-nowrap">{{ sprintf('%06d', $ticket->ticket_id) }}</td>
                                    <td class="text-nowrap">{{ $ticket->seat }}</td>
                                    <td class="text-nowrap">{{ $ticket->door }}</td>
                                    <td class="text-nowrap">{{ Common::format_price($ticket->price) }}</td>
                                    <td class="text-nowrap">{{ $ticket->is_issued ? __('done') : '' }}</td>
                                    <td class="text-nowrap">{{ $ticket->is_checked_in ? __('done') : '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                    targets: 3
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
