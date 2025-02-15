<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;

Route::post('usuarios', [UserController::class, 'store'])->name('usuarios.store');

Route::resource('albuns', AlbumController::class);
Route::resource('musicas', SongController::class);

Route::post('albuns', [AlbumController::class, 'store'])->name('albuns.store');

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/', function () {
    return view('index');
});
