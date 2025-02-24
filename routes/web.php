<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\DashboardController;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;

use Illuminate\Support\Facades\Auth;

//Route::post('usuarios', [UserController::class, 'store'])->name('usuarios.store');

Route::resource('usuarios', UserController::class);
Route::resource('albuns', AlbumController::class);
Route::resource('musicas', SongController::class);

Route::get('/usuarios.search', [UserController::class, 'search'])->name('usuarios.search');
Route::get('/albuns.search', [AlbumController::class, 'search'])->name('albuns.search');
Route::get('/musicas.search', [SongController::class, 'search'])->name('musicas.search');

Route::delete('/albuns/{id}', [AlbumController::class, 'destroy'])->name('albuns.destroy');

//Rota para atualizar banco
Route::put('usuarios/{id}', [UserController::class, 'update']);

// Rota para exibir o formulário (GET) Login
Route::get('/', [DashboardController::class, 'exibeForm'])->name('login');

// Rota para processar o login (POST)
Route::post('/login', [DashboardController::class, 'auth'])->name('login.auth');

Route::get('/cadastro', function () {
    return view('cadastro');
});

Route::post('logout', [DashboardController::class,'logout']);

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    // Dashboard Admin
    Route::get('/sgpanel/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    // É possível acrescentar aqui outras rotas administrativas caso seja criadas, então deixei esse espaço aqui como grupo mesmo.
});

Route::middleware(['auth', UserMiddleware::class])->group(function () {
    Route::get('/userdash', [DashboardController::class, 'userdash'])->name('dashboard.userdash');
});

Route::get('index', function () {
    return redirect('/');
});
