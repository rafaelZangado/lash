<?php

use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\AtendimentoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProcedimentoController;
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


//Rota Dashboard
   // Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/teste', [DashboardController::class, 'teste'])->name('teste');
    Route::get('/eventos', [DashboardController::class, 'eventos'])->name('eventos');
    Route::get('/checkin/{id}/checkin', [DashboardController::class, 'checkin'])->name('checkin');

//Rota clientes
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes');
    Route::post('/clientes', [ClienteController::class, 'store'])->name('salvar');

//Rota Procedimentos
    Route::get('/procedimento', [ProcedimentoController::class, 'index'])->name('procedimento');
    Route::post('/procedimentoSave', [ProcedimentoController::class, 'store'])->name('procedimentoSave');
    Route::put('/procedimentoEdite/{id}', [ProcedimentoController::class, 'up'])->name('procedimentoEdite');
    Route::get('/procedimentoDelet/{id}', [ProcedimentoController::class, 'delet'])->name('procedimentoDelet');

//Agendamento
    Route::get('/agendamento', [AgendamentoController::class, 'index'])->name('agendamento');
    Route::post('/agendamento/store', [AgendamentoController::class, 'store'])->name('agendamento-store');
    Route::put('/agendamento/{id}', [AgendamentoController::class, 'update'])->name('agendamento-update');
    Route::put('/agendamento/{id}/start', [AgendamentoController::class, 'start'])->name('agendamento-start');
    Route::get('/agendamentos/filtrar', [AgendamentoController::class, 'filtrar'])->name('agendamentos-filtrar');
    Route::put('/agendamento/{id}/close', [AgendamentoController::class, 'close'])->name('agendamento-close');
    Route::delete('/agendamento/{id}', [AgendamentoController::class, 'delete'])->name('delete');

//Atendimento
    Route::get('/', [AtendimentoController::class, 'index'])->name('atendimento');
    Route::get('/start/{id}/start', [AtendimentoController::class, 'start'])->name('start');
    Route::put('/up', [AtendimentoController::class, 'up'])->name('up');
    Route::get('/delete/{id}/delete', [AtendimentoController::class, 'delete'])->name('delete');
    Route::get('/cancel/{id}/cancel', [AtendimentoController::class, 'cancel'])->name('cancel');
    Route::post('/atendimento/store', [AtendimentoController::class, 'store'])->name('atendimentosave');
    Route::put('/agendamento/{id}/checkout', [AtendimentoController::class, 'checkout'])->name('agendamento-checkout');
