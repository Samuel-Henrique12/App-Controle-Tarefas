<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TarefaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);


Route::get('tarefa/export/{extensao}', [TarefaController::class, 'exportacao'])->name('tarefa.export');
Route::get('tarefa/exportar', [TarefaController::class, 'exportar'])->name('tarefa.exportar');

Route::middleware(['verified'])
    ->group(function () {
        Route::get('/home', [HomeController::class, 'index'])
            ->name('home');
        Route::resource('tarefa', TarefaController::class);
    });

Route::get('/mensagem-teste', function () {
    $content = new \App\Mail\MensagemTesteMail();
    return $content;
    //\Illuminate\Support\Facades\Mail::to('rafael.soares.augusto@gmail.com')->send($content);
    // return 'Email enviado com sucesso!';
});
