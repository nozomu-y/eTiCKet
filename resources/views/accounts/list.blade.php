@extends('layouts.main')
@section('title', __('accounts_list'))

@section('content')
    <h1 class="h3 text-gray-800 mb-4">{{ __('accounts_list') }}</h1>
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <table class="table" id="accounts_table" style="min-width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-nowrap">{{ __('username') }}</th>
                            <th class="text-nowrap">{{ __('name') }}</th>
                            <th class="text-nowrap">{{ __('role') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="text-nowrap">{{ $user['username'] }}</td>
                                <td class="text-nowrap">{{ $user['name'] }}</td>
                                <td class="text-nowrap">{{ $user['role'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a class="btn btn-primary" href="{{ route('add_account') }}">{{ __('add_account') }}</a>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#accounts_table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Japanese.json"
                },
                order: [], // don't order on init
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100, "全件"]
                ],
                deferRender: false,
                autowidth: false,
                scrollX: true,
                dom: "<\'row\'<\'col-sm-6\'l><\'col-sm-6 right\'f>>" +
                    "<\'row\'<\'col-sm-12 mb-2\'tr>>" +
                    "<\'row\'<\'col-sm-6\'i><\'col-sm-6\'p>>",
            });
        });
    </script>
@endsection
