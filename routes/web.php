<?php


use App\Http\Controllers\AvisoController;
use App\Http\Controllers\CardapioController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\UserController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

/*Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});*/

Route::get('/', [HomeController::class, 'index'])->name('home');

/* ROTAS ADMINISTRATIVAS */
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('users', [UserController::class, 'index'])->name('users');
        Route::put('users/{user}', [UserController::class, 'update'])->name('user.update');

        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions');
        Route::post('permissions', [PermissionController::class, 'store'])->name('permission.store');
        Route::put('permissions/{permission}', [PermissionController::class, 'update'])->name('permission.update');
        Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permission.destroy');

        Route::get('roles', [RoleController::class, 'index'])->name('roles');
        Route::post('roles', [RoleController::class, 'store'])->name('role.store');
        Route::put('roles/{role}', [RoleController::class, 'update'])->name('role.update');
        Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('role.destroy');

        Route::get('setores', [SetorController::class, 'index'])->name('setores');
        Route::post('setores', [SetorController::class, 'store'])->name('setor.store');
        Route::put('setores/{setor}', [SetorController::class, 'update'])->name('setor.update');
        Route::delete('setores/{setor}', [SetorController::class, 'destroy'])->name('setor.destroy');

        Route::get('projetos', [ProjetoController::class, 'index'])->name('projetos');
        Route::post('projetos', [ProjetoController::class, 'store'])->name('projeto.store');
        Route::put('projetos/{projeto}', [ProjetoController::class, 'update'])->name('projeto.update');
        Route::delete('projetos/{projeto}', [ProjetoController::class, 'destroy'])->name('projeto.destroy');


    });
