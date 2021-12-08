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

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountSettingController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\GuestTicketsController;
use App\Http\Controllers\FrontController;

Auth::routes(['register' => false, 'reset' => false]);

Route::get('/home', function () { return redirect()->route('home'); });
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('front/qrreader', [FrontController::class, 'qrreader'])->name('qrreader');
Route::post('front/qrreader', [FrontController::class, 'post_qrreader'])->name('post_qrreader');
Route::get('front/qrreader/form', [FrontController::class, 'qrcode_unreadable'])->name('qrcode_unreadable');
Route::post('front/qrreader/form', [FrontController::class, 'post_qrcode_unreadable'])->name('post_qrcode_unreadable');
Route::post('front/collect', [FrontController::class, 'post_collect_ticket'])->name('post_collect_ticket');

Route::get('account_setting/change_password', function () {
    return view('account_setting.change_password');
})->name('change_password');
Route::post('account_setting/change_password', [AccountSettingController::class, 'change_password'])->name('post_change_password');

Route::get('events', [EventsController::class, 'index'])->name('events');
Route::get('events/{event_id}', [EventsController::class, 'detail'])->where('event_id', '[0-9]+')->name('event_detail');
Route::get('events/add', function () { return view('events.add'); })->name('add_event');
Route::post('events/add', [EventsController::class, 'add'])->name('post_add_event');
Route::get('events/{event_id}/edit', [EventsController::class, 'edit'])->where('event_id', '[0-9]+')->name('edit_event');
Route::post('events/{event_id}/edit', [EventsController::class, 'post_edit'])->where('event_id', '[0-9]+')->name('post_edit_event');
Route::post('events/{event_id}/delete', [EventsController::class, 'delete'])->where('event_id', '[0-9]+')->name('delete_event');
Route::get('events/{event_id}/tickets', [TicketsController::class, 'index'])->where('event_id', '[0-9]+')->name('tickets');
Route::get('events/{event_id}/tickets/add', [TicketsController::class, 'add'])->where('event_id', '[0-9]+')->name('add_tickets');
Route::post('events/{event_id}/tickets/add', [TicketsController::class, 'post_add'])->where('event_id', '[0-9]+')->name('post_add_tickets');
Route::get('events/{event_id}/tickets/issue', [TicketsController::class, 'issue'])->where('event_id', '[0-9]+')->name('issue_tickets');
Route::post('events/{event_id}/tickets/issue/confirm', [TicketsController::class, 'post_confirm_issue'])->where('event_id', '[0-9]+')->name('post_confirm_issue_tickets');
Route::post('events/{event_id}/tickets/issue', [TicketsController::class, 'post_issue'])->where('event_id', '[0-9]+')->name('post_issue_tickets');
Route::get('events/{event_id}/tickets/{ticket_id}', [TicketsController::class, 'show_ticket'])->where('event_id', '[0-9]+')->where('ticket_id', '[0-9]+')->name('show_ticket');
Route::get('events/{event_id}/tickets/{ticket_id}/edit', [TicketsController::class, 'edit'])->where('event_id', '[0-9]+')->where('ticket_id', '[0-9]+')->name('edit_ticket');
Route::post('events/{event_id}/tickets/{ticket_id}/edit', [TicketsController::class, 'post_edit'])->where('event_id', '[0-9]+')->where('ticket_id', '[0-9]+')->name('post_edit_ticket');
Route::post('events/{event_id}/tickets/{ticket_id}/delete', [TicketsController::class, 'delete'])->where('event_id', '[0-9]+')->where('ticket_id', '[0-9]+')->name('delete_ticket');

Route::group(['middleware' => 'admin'], function () {
    Route::get('accounts', [AccountsController::class, 'index'])->name('accounts');
    Route::get('accounts/add', function () { return view('accounts.add'); })->name('add_account');
    Route::post('accounts/add', [AccountsController::class, 'register'])->name('post_add_account');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('{event_id}/{ticket_id}/{token}', [GuestTicketsController::class, 'index'])
        ->where(['event_id', '[0-9]+', 'ticket_id', '[0-9]+', 'token', '[0-9a-zA-Z]+'])->name('guest_ticket');
    Route::get('{event_id}/{ticket_id}/{token}/contact', [GuestTicketsController::class, 'contact'])
        ->where(['event_id', '[0-9]+', 'ticket_id', '[0-9]+', 'token', '[0-9a-zA-Z]+'])->name('guest_contact');
    Route::post('{event_id}/{ticket_id}/{token}/contact', [GuestTicketsController::class, 'post_contact'])
        ->where(['event_id', '[0-9]+', 'ticket_id', '[0-9]+', 'token', '[0-9a-zA-Z]+'])->name('post_guest_contact');
});
