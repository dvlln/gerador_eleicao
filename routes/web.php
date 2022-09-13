<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{loginController, registerController};
use App\Http\Controllers\User\userController;
use App\Http\Controllers\Admin\{adminController, eleicaoController};


// AUTH
    // REGISTRO
    Route::get('register', [registerController::class, 'create'])->name('auth.register.create')->middleware('guest');
    Route::post('register', [registerController::class, 'store'])->name('auth.register.store')->middleware('guest');

    // LOGIN
    Route::get('login', [loginController::class, 'home'])->name('auth.login.home')->middleware('guest');
    Route::post('login', [loginController::class, 'in'])->name('auth.login.in')->middleware('guest');
    Route::post('logout', [loginController::class, 'destroy'])->name('auth.login.destroy')->middleware('auth');

    // ADMIN & USERS
    Route::get('user/dashboard', [userController::class, 'index'])->name('user.dashboard.index')->middleware('role:user', 'auth');
    Route::get('admin/dashboard', [adminController::class, 'index'])->name('admin.dashboard.index')->middleware('role:admin', 'auth');
// END AUTH

// CRUD GERADOR DE ELEIÇÕES
    Route::group(['as' => 'admin.', 'middleware' => ['role:admin', 'auth']], function(){
        Route::resource('admin/eleicao', eleicaoController::class);
    });
    //USER - VISUALIZAR ELEIÇÕES
    Route::get('user/eleicao', [userController::class, 'viewEleicao'])->name('user.eleicao.viewEleicao')->middleware('role:user', 'auth');
