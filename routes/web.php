<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

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
Route::get('/doadores',[HomeController::class,'profiledoador']);
