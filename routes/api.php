<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\ContestController;
use App\Http\Controllers\API\EasypaisaController;
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
    // api/v1/easypaisa/checkout?contest_id=53
    // Authenticated user routes
    Route::group(['prefix' => 'easypaisa'], function () {
    // Route::group(['prefix' => 'easypaisa'], function () {
        Route::get('checkout', [EasypaisaController::class, 'checkout'])->middleware('auth:api');
        Route::any('checkout/confirm', [EasypaisaController::class, 'checkoutConfirm']);
        Route::any('payment-status', [EasypaisaController::class, 'paymentStatus']);
    });

    Route::group(['prefix' => 'user', 'middleware'=> 'auth:api'], function () {
        Route::get('/details', function (Request $request) {
            return $request->user();
        });

        Route::get('/contests', [ContestController::class, 'userContests']);
        Route::post('/participate', [ContestController::class, 'participate']);
        Route::put('/update-profile', [AuthController::class, 'updateProfile']);
        Route::get('/details', [AuthController::class, 'userDetails']);
    });

    // Contest-related routes
    Route::group(['prefix' => 'contests'], function() {
        Route::get('/', [ContestController::class, 'getAllContests'])->middleware('auth:api');
        Route::get('/{contest_id}', [ContestController::class, 'contestDetail']);
    });
});

