<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\PlotAndUnitController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserPermissionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {

    // Dashboard
    Route::controller(HomeController::class)->group(function () {
        Route::get('dashboard', 'index')->name('home');
        Route::get('settings', 'settings')->name('settings');
        Route::get('profile', 'profile')->name('profile');
    });

    // Permissions
    Route::controller(PermissionsController::class)->prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::put('{id}', 'update')->name('update');
        Route::delete('{id}/destroy', 'destroy')->name('destroy');
        Route::post('reorder', 'reorder')->name('reorder');
    });

    // Activities
    Route::controller(ActivityController::class)->prefix('activities')->name('activities.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::put('{id}', 'update')->name('update');
        Route::delete('{id}/destroy', 'destroy')->name('destroy');
    });

    // Roles
    Route::controller(RoleController::class)->prefix('roles')->name('roles.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::put('{id}', 'update')->name('update');
        Route::delete('{id}/destroy', 'destroy')->name('destroy');
    });

    // Role Permissions
    Route::controller(RolePermissionController::class)->prefix('role-permissions')->name('role-permissions.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'update')->name('update');
        Route::get('get', 'getRolePermissions')->name('get');
    });

    // User Permissions
    Route::controller(UserPermissionController::class)->prefix('user-permissions')->name('user-permissions.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('get', 'getUserPermissions')->name('get');
        Route::post('update', 'update')->name('update');
    });

    // Plot and Units
    Route::controller(PlotAndUnitController::class)->prefix('plot-and-units')->name('plot-and-units.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::put('{id}', 'update')->name('update');
        Route::delete('{id}/destroy', 'destroy')->name('destroy');
    });

});
