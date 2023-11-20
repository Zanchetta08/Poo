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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/anuncios', [App\Http\Controllers\HomeController::class, 'storeAnuncio']);
Route::delete('/anuncios/{id}', [App\Http\Controllers\HomeController::class,'destroyAnuncio']);
Route::put('/anuncios/update/{id}', [App\Http\Controllers\HomeController::class,'updateAnuncio']);
Route::put('/perfil/update/{id}', [App\Http\Controllers\HomeController::class,'updatePerfil']);
