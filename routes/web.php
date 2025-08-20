<?php

use Illuminate\Support\Facades\Route;
use App\Mail\MensagemTesteMail;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('tarefa', 'App\Http\Controllers\TarefaController');
Route::get('mensagem-teste', function() {return new MensagemTesteMail();});
