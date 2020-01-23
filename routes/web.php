<?php

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

Route::get('/QR', function () {
    return QRCode::url(route('register'))
        ->setSize(8)
        ->setMargin(2)
        ->png();
})->name('qr');


Auth::routes(['verify' => false, 'reset' => false, 'confirm' => false]);

Route::get('/pick', 'HomeController@pick')->name('pick')->middleware('admin');
Route::get('/home', 'HomeController@index')->name('home');
