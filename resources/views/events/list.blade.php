@extends('layouts.main')
@section('title', __('event_list'))

@section('content')
    <div class="container-fluid">
        <h1 class="h3 text-gray-800 mb-4">{{ __('event_list') }}</h1>
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
                    <table class="table table-hover" id="events_table" style="min-width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-nowrap">{{ __('event_name') }}</th>
                                <th class="text-nowrap">{{ __('place') }}</th>
                                <th class="text-nowrap">{{ __('date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr
                                    onclick="window.location='{{ route('event_detail', ['event_id' => $event->event_id]) }}'">
                                    <td class="text-nowrap">{{ $event->name }}</td>
                                    <td class="text-nowrap">{{ $event->place }}</td>
                                    <td class="text-nowrap">{{ date('Y/m/d', strtotime($event->date)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a class="btn btn-primary" href="{{ route('add_event') }}">{{ __('add_event') }}</a>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#events_table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Japanese.json"
                },
                "order": [], // don't order on init
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "全件"]
                ],
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
