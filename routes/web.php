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

use App\Http\Controllers\AccountsController;

Route::get('/', function () {
    return view('home');
});

Auth::routes(['register' => false, 'reset' => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'admin'], function () {
    Route::get('accounts', [AccountsController::class, 'index'])->name('accounts');
    Route::get('accounts/add', function() {
        return view('accounts.add');
    })->name('add_account');
    Route::post('accounts/add', [AccountsController::class, 'register'])->name('post_add_account');
});
