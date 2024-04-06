<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\KaryawanController;
use App\Http\Controllers\API\PresenceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function() {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');

    Route::middleware('auth:sanctum')->group(function(){
        Route::apiResource('presence', PresenceController::class);
        Route::group(['prefix' => 'karyawan', 'controller' => KaryawanController::class],function(){
            Route::get('/', 'index')->name('karyawan.index');
            Route::get('/presences/{user}', 'presences')->name('karyawan.presences');
        });
    });
});
