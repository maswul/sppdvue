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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeC::class, 'home'])->name('home');
Route::get('lockscreen', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('login.anotheruser');

Route::get('login/locked', [App\Http\Controllers\Auth\LoginController::class,'locked'])->middleware('auth')->name('login.locked');
Route::get('/login/manual/locked.html', [\App\Http\Controllers\HomeC::class, 'locked']);
Route::post('login/locked', [App\Http\Controllers\Auth\LoginController::class,'unlock'])->name('login.unlock');
