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
Route::get('events/{id}', [EventsController::class, 'detail'])->where('id', '[0-9]+')->name('event_detail');
Route::group(['middleware' => 'admin'], function () {
    Route::get('events/add', function() {
        return view('events.add');
    })->name('add_event');
    Route::post('events/add', [EventsController::class, 'add'])->name('post_add_event');
    Route::post('events/delete/{id}', [EventsController::class, 'delete'])->where('id', '[0-9]+')->name('delete_event');
});

Route::group(['middleware' => 'admin'], function () {
    Route::get('accounts', [AccountsController::class, 'index'])->name('accounts');
    Route::get('accounts/add', function() {
        return view('accounts.add');
    })->name('add_account');
    Route::post('accounts/add', [AccountsController::class, 'register'])->name('post_add_account');
});
