<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CollectorController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\PlotAndUnitController;
use App\Http\Controllers\PlotTypeController;
use App\Http\Controllers\RoadController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.home');
    }
    return redirect('/login');
});

Route::get('testsms', function () {
    //MSISDN with country code
    $number = "8801610440622";
    //Text Message
    $text = 'API Test Message';
    //------------------ No change Needed-------------------
    $ch = curl_init();
    $apiUrl = "http://103.230.63.50/bulksms/api";
    $requesteid = $_SERVER['REQUEST_TIME'];
    $contentType = 1;
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "authUser=Sector-03&authAccess=Sector@0309&destination=" . $number . "&text=" . urlencode($text) . "&requestId=" . $requesteid . " &contentType=" . $contentType);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close($ch);
    ////------------------ No change Needed-------------------
    //
    ////FOR DEBUG
    var_dump($server_output);
});

Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {

    // Dashboard
    Route::controller(HomeController::class)->group(function () {
        Route::get('dashboard', 'index')->name('home');
        Route::get('settings', 'settings')->name('settings');
        Route::get('profile', 'profile')->name('profile');
    });

    // Ajax Routes
    Route::controller(AjaxController::class)->prefix('ajax')->name('ajax.')->group(function () {
        Route::get('/member-details/{id}', 'memberdetails')->name('memberdetails');
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

    // Roads
    Route::controller(RoadController::class)->prefix('roads')->name('roads.')->group(function () {
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
    
    // Users
    Route::controller(UserController::class)->prefix('users')->name('users.')->group(function () {
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
        Route::get('view/{id}', 'view')->name('view');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::put('{id}', 'update')->name('update');
        Route::delete('{id}/destroy', 'destroy')->name('destroy');

        Route::get('/bulk-upload', 'bulkUpload')->name('bulk-upload');
        Route::post('/bulk-upload', 'bulkUploadStore')->name('bulk-upload.store');
    });

    // Plote Types
    Route::controller(PlotTypeController::class)->prefix('type')->name('type.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::put('{id}', 'update')->name('update');
        Route::patch('change-status/{id}', 'changeStatus')->name('change.status');
        Route::delete('{id}/destroy', 'destroy')->name('destroy');
    });

    // Collections
    Route::controller(CollectionController::class)->prefix('collection')->name('collection.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/receipt/{id}', 'receipt')->name('receipt');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::put('{id}', 'update')->name('update');
        Route::patch('change-status/{id}', 'changeStatus')->name('change.status');
        Route::delete('{id}/destroy', 'destroy')->name('destroy');
    });

    // Collectors
    Route::controller(CollectorController::class)->prefix('collectors')->name('collectors.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/receipt/{id}', 'receipt')->name('receipt');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::put('{id}', 'update')->name('update');
        Route::patch('change-status/{id}', 'changeStatus')->name('change.status');
        Route::get('assign-road/{id}', 'assignRoad')->name('assign.road');
        Route::put('assign-road/{id}', 'updateRoad')->name('update.road');
        Route::delete('{id}/destroy', 'destroy')->name('destroy');
    });

    // Settings
    Route::controller(SettingController::class)->prefix('settings')->name('settings.')->group(function () {
        Route::get('edit', 'edit')->name('edit');
        Route::put('basic-update', 'basicUpdate')->name('basic.update');
        Route::put('email-update', 'emailUpdate')->name('email.update');
        Route::put('password-update', 'passwordUpdate')->name('password.update');
    });
});
