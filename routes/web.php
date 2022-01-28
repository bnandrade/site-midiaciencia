<?php


use App\Http\Controllers\BannerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NumeroController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\RoleController;
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
Route::get('/detalhes/{produto}', [HomeController::class, 'detalhes'])->name('detalhes.produto');

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

        Route::get('banners', [BannerController::class, 'index'])->name('banners');
        Route::post('banners', [BannerController::class, 'store'])->name('banner.store');
        Route::put('banners/{banner}', [BannerController::class, 'update'])->name('banner.update');
        Route::delete('banners/{banner}', [BannerController::class, 'destroy'])->name('banner.destroy');

        Route::get('produtos', [ProdutoController::class, 'index'])->name('produtos');
        Route::post('produtos', [ProdutoController::class, 'store'])->name('produto.store');
        Route::put('produtos/{produto}', [ProdutoController::class, 'update'])->name('produto.update');
        Route::delete('produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produto.destroy');


    });
