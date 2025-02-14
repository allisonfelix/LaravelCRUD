<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;

Route::resource('usuarios', UserController::class);

Route::resource('albuns', AlbumController::class);
Route::resource('musicas', SongController::class);


Route::get('/', function () {
    return view('index');
});
