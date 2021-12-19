<?php
use App\Enums\UserRole;
?>
@extends('layouts.main')
@section('title', __('accounts_list'))

@section('content')
    <h1 class="h3 text-gray-800 mb-4">{{ __('accounts_list') }}</h1>
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
                <table class="table" id="accounts_table" style="min-width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-nowrap">{{ __('username') }}</th>
                            <th class="text-nowrap">{{ __('name') }}</th>
                            <th class="text-nowrap">{{ __('role') }}</th>
                            <th class="text-nowrap">{{ __('delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="text-nowrap">{{ $user['username'] }}</td>
                                <td class="text-nowrap">{{ $user['name'] }}</td>
                                <td class="text-nowrap">{{ UserRole::getDescription($user['role']) }}</td>
                                @if ($user['role'] === UserRole::ADMIN)
                                    <td class="text-nowrap"></td>
                                @else
                                    <td class="text-nowrap"><a class="text-danger" data-toggle="modal"
                                            data-target="#confirmDeleteModal_{{ $user['id'] }}">{{ __('delete') }}</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a class="btn btn-primary" href="{{ route('add_account') }}">{{ __('add_account') }}</a>
        </div>
    </div>

    @foreach ($users as $user)
        @if ($user['role'] === UserRole::ADMIN)
            @continue
        @endif
        <div class="modal fade" id="confirmDeleteModal_{{ $user['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="confirmDeleteModalLabel_{{ $user['id'] }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel_{{ $user['id'] }}">
                            {{ __('delete_account') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ __('username') }}：{{ $user['username'] }}
                        <br>
                        {{ __('name') }}：{{ $user['name'] }}
                        <br>
                        {{ __('message.accounts.delete.confirm') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('close') }}</button>
                        <button type="button" class="btn btn-danger"
                            onclick="document.getElementById('delete_form_{{ $user['id'] }}').submit();">{{ __('delete') }}</button>
                    </div>
                    <form id="delete_form_{{ $user['id'] }}"
                        action="{{ route('delete_account', ['user_id' => $user['id']]) }}" class="d-none"
                        method="POST">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    @endforeach
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
