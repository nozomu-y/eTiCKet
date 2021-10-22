<?php
use App\Libs\Common;
?>
@extends('layouts.main')
@section('title', __('issue_tickets_abbrev'))

@section('content')
    <div class="container-fluid">
        <h1 class="h3 text-gray-800 mb-4">{{ __('issue_tickets_abbrev') }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('events') }}">{{ __('event_list') }}</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('event_detail', ['event_id' => $event->event_id]) }}">{{ $event->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('issue_tickets_abbrev') }}</li>
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
                <form method="POST" action="{{ route('post_issue_tickets', ['event_id' => $event->event_id]) }}">
                    @csrf
                    <div class="mb-3">
                        <table class="table" id="tickets_table" style="min-width: 100%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="text-nowrap">{{ __('ticket_no') }}</th>
                                    <th class="text-nowrap">{{ __('seat_no') }}</th>
                                    <th class="text-nowrap">{{ __('door_no') }}</th>
                                    <th class="text-nowrap">{{ __('price') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    @if (!$ticket->is_issued)
                                        <tr>
                                            <td>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="check_{{ $ticket->ticket_id }}" value="1">
                                                </div>
                                            </td>
                                            <td class="text-nowrap">{{ sprintf('%06d', $ticket->ticket_id) }}</td>
                                            <td class="text-nowrap">{{ $ticket->seat }}</td>
                                            <td class="text-nowrap">{{ $ticket->door }}</td>
                                            <td class="text-nowrap">{{ Common::format_price($ticket->price) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('issue_tickets_abbrev') }}</button>
                </form>
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
                    targets: 4
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
