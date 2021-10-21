<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\AccountSettingController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\GuestTicketsController;

Route::get('/', function () {
    return view('home');
});

Auth::routes(['register' => false, 'reset' => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('account_setting/change_password', function () {
    return view('account_setting.change_password');
})->name('change_password');
Route::post('account_setting/change_password', [AccountSettingController::class, 'change_password'])->name('post_change_password');

Route::get('events', [EventsController::class, 'index'])->name('events');
Route::get('events/{event_id}', [EventsController::class, 'detail'])->where('event_id', '[0-9]+')->name('event_detail');
Route::get('events/add', function() { return view('events.add'); })->name('add_event');
Route::post('events/add', [EventsController::class, 'add'])->name('post_add_event');
Route::post('events/delete/{event_id}', [EventsController::class, 'delete'])->where('event_id', '[0-9]+')->name('delete_event');
Route::get('events/{event_id}/tickets', [TicketsController::class, 'index'])->where('event_id', '[0-9]+')->name('tickets');
Route::get('events/{event_id}/tickets/add', [TicketsController::class, 'add'])->where('event_id', '[0-9]+')->name('add_tickets');
Route::post('events/{event_id}/tickets/add', [TicketsController::class, 'post_add'])->where('event_id', '[0-9]+')->name('post_add_tickets');
Route::get('events/{event_id}/tickets/issue', [TicketsController::class, 'issue'])->where('event_id', '[0-9]+')->name('issue_tickets');
Route::post('events/{event_id}/tickets/issue', [TicketsController::class, 'post_issue'])->where('event_id', '[0-9]+')->name('post_issue_tickets');

Route::group(['middleware' => 'admin'], function () {
    Route::get('accounts', [AccountsController::class, 'index'])->name('accounts');
    Route::get('accounts/add', function() {
        return view('accounts.add');
    })->name('add_account');
    Route::post('accounts/add', [AccountsController::class, 'register'])->name('post_add_account');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('{event_id}/{ticket_id}/{token}', [GuestTicketsController::class, 'index'])
        ->where(['event_id', '[0-9]+', 'ticket_id', '[0-9]+', 'token', '[0-9a-zA-Z]+'])->name('guest_ticket');
});
