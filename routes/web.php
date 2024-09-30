<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Presensi;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/presence', Presensi::class)->name('presence');
});
