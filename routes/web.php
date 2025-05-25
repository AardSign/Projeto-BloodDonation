<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\NotificacaoController;

Route::get('/',[HomeController::class,'index']);

Route::get('/home',[HomeController::class,'redirect']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/add_donor_view',[AdminController::class,'addview']);
Route::post('/upload_donor', [AdminController::class, 'upload']);
Route::get('/administrador',[HomeController::class,'profileadmin']);
Route::get('/usuarios', [AdminController::class, 'showUsuarios']);
Route::get('/usuarios/{id}/editar', [AdminController::class, 'editarUsuario']);
Route::post('/usuarios/{id}/atualizar', [AdminController::class, 'atualizarUsuario']);
Route::get('/usuarios/{id}/excluir', [AdminController::class, 'excluirUsuario']);
Route::get('/agendamentos', [AppointmentController::class, 'index'])->name('agendamentos.index');
Route::get('/agendar', [AppointmentController::class, 'create']);
Route::post('/agendar', [AppointmentController::class, 'store']);
Route::get('/agendamento/{id}/cancelar', [AppointmentController::class, 'cancel']);
Route::get('/agendamento/{id}/editar', [AppointmentController::class, 'edit']);
Route::put('/agendamento/{id}/atualizar', [AppointmentController::class, 'update']);
//Route::get('/agendamentos-marcados', [AppointmentController::class, 'agendamentosMarcados']);
Route::get('/buscar', [SearchController::class, 'buscar']);
Route::get('/agendamento/{id}/concluir', [AppointmentController::class, 'concluir']);

Route::resource('locais-doacao', App\Http\Controllers\LocalDoacaoController::class)
    ->middleware('auth')
    ->parameters(['locais-doacao' => 'localDoacao']);

Route::get('/disponibilidade', [App\Http\Controllers\DisponibilidadeController::class, 'index'])->middleware('auth');

Route::get('/meus-agendamentos', [AppointmentController::class, 'meusAgendamentos'])->middleware('auth');

Route::get('/agendamento/{id}/remarcar', [AppointmentController::class, 'formRemarcar'])->middleware('auth');
Route::put('/agendamento/{id}/remarcar', [AppointmentController::class, 'remarcarAgendamento'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/perfil/editar', [PerfilController::class, 'edit'])->name('perfil.editar');
    Route::put('/perfil/atualizar', [PerfilController::class, 'update'])->name('perfil.atualizar');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/notificacoes', [NotificacaoController::class, 'index'])->name('notificacoes.index');
    Route::get('/notificacoes/{id}', [NotificacaoController::class, 'visualizar'])->name('notificacoes.visualizar');
    Route::post('/notificacoes/marcar-todas', [NotificacaoController::class, 'marcarTodasComoLidas'])->name('notificacoes.marcarTodas');
    Route::delete('/notificacoes/{id}', [NotificacaoController::class, 'deletar'])->name('notificacoes.deletar');
});