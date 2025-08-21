<?php

use Illuminate\Support\Facades\Route;
use App\Mail\MensagemTesteMail;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')->middleware('verified');
Route::resource('tarefa', 'App\Http\Controllers\TarefaController')
->middleware('verified');
Route::get('mensagem-teste', function() {return new MensagemTesteMail();});
