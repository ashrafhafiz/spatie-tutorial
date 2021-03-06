<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index'])->name('index');
//        Route::post('/roles/{role}/permissions', [\App\Http\Controllers\Admin\RoleController::class, 'updatePermissions'])
//            ->name('roles.permissions');
        Route::resource('/roles', \App\Http\Controllers\Admin\RoleController::class);
        Route::resource('/permissions', \App\Http\Controllers\Admin\PermissionController::class);

        Route::get('/users/{user}/roles', [\App\Http\Controllers\Admin\UserController::class, 'editUserRoles'])
            ->name('users.roles');
        Route::post('/users/{user}/roles', [\App\Http\Controllers\Admin\UserController::class, 'updateUserRoles'])
            ->name('users.roles');

        Route::get('/users/{user}/permissions', [\App\Http\Controllers\Admin\UserController::class, 'editUserPermissions'])
            ->name('users.permissions');
        Route::post('/users/{user}/permissions', [\App\Http\Controllers\Admin\UserController::class, 'updateUserPermissions'])
            ->name('users.permissions');

        Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);
    });

require __DIR__ . '/auth.php';
