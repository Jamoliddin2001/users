<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/


Route::group([
    'middleware' => []
], function () {

    Route::prefix('/user')->group(function () {

        Route::post('/register', [\App\Http\Controllers\API\User\UserController::class, 'register']);
        Route::get('/{id}', [\App\Http\Controllers\API\User\UserController::class, 'getUserById']);

    });

    Route::get('/users', [\App\Http\Controllers\API\User\UserController::class, 'getAllUsers']);
    Route::get('/docs', [\App\Http\Controllers\API\Swagger\SwaggerController::class, 'index']);
});
