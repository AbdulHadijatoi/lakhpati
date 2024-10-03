<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\ContestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function() {
    // Authentication routes
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    // Authenticated user routes
    Route::group(['prefix' => 'user', 'middleware'=> 'auth:api'], function () {
        Route::get('/details', function (Request $request) {
            return $request->user();
        });

        Route::get('/contests', [ContestController::class, 'userContests']);
        Route::post('/participate', [ContestController::class, 'participate']);
    });

    // Contest-related routes
    Route::group(['prefix' => 'contests'], function() {
        Route::get('/', [ContestController::class, 'getAllContests']);
    });
});

