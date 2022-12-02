<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{loginController, passwordController, registerController};
use App\Http\Controllers\User\{userController, eleicaoController as userEleicaoController};
use App\Http\Controllers\Admin\{adminController, eleicaoController, docUserController};
use App\Http\Controllers\Perfil\perfilController;

// DEFAULT ROUTE
Route::redirect('/', '/login');

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
// END

// CRUD GERADOR DE ELEIÇÕES
    // ADMIN - CRUD
    Route::group(['as' => 'admin.', 'middleware' => ['role:admin', 'auth']], function(){
        Route::resource('admin/eleicao', eleicaoController::class);
    });

    // USER - LISTAGEM DE ELEIÇÕES
    Route::get('user/eleicoes', [userEleicaoController::class, 'index'])->name('user.eleicao.index')->middleware('role:user', 'auth');

    // USER - SHOW ELEICAO
    Route::get('user/eleicoes/{eleicao}', [userEleicaoController::class, 'show'])->name('user.eleicao.show')->middleware('role:user', 'auth');

// END

// DESENVOLVER DA ELEIÇÃO
    // PROCESSO DE INSCRIÇÃO
    Route::post('user/eleicoes/{eleicao}/inscrever', [userEleicaoController::class, 'store'])->name('user.eleicao.store')->middleware('role:user', 'auth');
    Route::delete('user/eleicoes/{eleicao}/desinscrever', [userEleicaoController::class, 'destroy'])->name('user.eleicoes.destroy')->middleware('role:user', 'auth');

    // PROCESSO DE APROVAÇÃO
    Route::put('admin/eleicao/{eleicao}/aprovar/{user}', [docUserController::class, 'approve'])->name('admin.eleicao.approve')->middleware('role:admin', 'auth');
    Route::put('admin/eleicao/{eleicao}/negar/{user}', [docUserController::class, 'deny'])->name('admin.eleicao.deny')->middleware('role:admin', 'auth');

    // IMPORTAR USUARIOS
    Route::post('admin/eleicao/{eleicao}/importar', [eleicaoController::class, 'import'])->name('admin.eleicao.import')->middleware('role:admin', 'auth');

    // VOTAR
    Route::PUT('user/eleicao/{eleicao}/votar', [userEleicaoController::class, 'vote'])->name('user.eleicao.vote')->middleware('role:user', 'auth');
// END

// EDIÇÃO
    // USER
    Route::put('user/editPerfil/{users}', [perfilController::class, 'updateUser'])->name('user.updateUser')->middleware('auth');
    Route::put('user/editSecretaria', [perfilController::class, 'updateSecretaria'])->name('user.updateSecretaria')->middleware('auth');
// END

// RESET PASSWORD
    // ENVIO
    Route::get('/forgot-password', [passwordController::class, 'forgotIndex'])->middleware('guest')->name('password.request');
    Route::post('/forgot-password', [passwordController::class, 'sendEmail'])->middleware('guest')->name('password.email');

    // REDEFINIR
    Route::get('/reset-password/{token}', [passwordController::class, 'resetIndex'])->middleware('guest')->name('password.reset');
    Route::post('/reset-password', [passwordController::class, 'updatePassword'])->middleware('guest')->name('password.update');
