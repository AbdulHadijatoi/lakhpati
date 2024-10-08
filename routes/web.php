<?php

use App\Http\Controllers\API\EasypaisaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\ParticipantController;
use Illuminate\Http\Request;
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

// Example Routes
Route::middleware('guest')->group(function () {
    
    Route::get('/', [LoginController::class,'showAdminLogin'])->name('showAdminLogin');
    Route::get('login', [LoginController::class,'showAdminLogin'])->name('showAdminLogin');
    Route::post('login-post', [LoginController::class,'login'])->name('loginPost');
});

Route::get('pay', [EasypaisaController::class, 'doCheckout']);

Route::any('checkout-confirm', function(Request $request){
    $post_data = [
        'postBackURL' => $request->postBackURL,
        'auth_token' => $request->auth_token
    ];

    return view('checkout_confirm_v',compact('post_data'));
});

Route::any('ttt/{token}', function($auth_token){
    $auth_token = $auth_token;

    return view('ttt',compact('auth_token'));
});

Route::any('paymentStatus', function(Request $request){
    return $request->all();
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::group(['prefix'=>'contests'], function () {
        Route::get('/', [ContestController::class,'index'])->name('listContests');
        Route::get('get-data', [ContestController::class,'getData']);
        Route::get('create', [ContestController::class,'create'])->name('createContest');
        Route::get('show/{id}', [ContestController::class,'show'])->name('showContest');
        Route::post('store', [ContestController::class,'store'])->name('contestStore');
        Route::get('edit/{id}', [ContestController::class,'edit'])->name('editContest');
        Route::put('update/{id}', [ContestController::class,'update'])->name('updateContest');
        Route::delete('delete/{id}', [ContestController::class, 'destroy'])->name('deleteContest');
    });
    // listContestParticipants
    Route::group(['prefix'=>'participants'], function () {
        Route::get('/', [ParticipantController::class,'index'])->name('listParticipants');
        Route::get('show/{id}', [ParticipantController::class,'show'])->name('showParticipant');
        Route::get('list-contest-participants/{id}', [ParticipantController::class,'contestParticipants'])->name('listContestParticipants');
        Route::delete('delete/{id}', [ParticipantController::class, 'destroy'])->name('deleteParticipant');
    });

    Route::post('logout', [LoginController::class,'logout'])->name('logout');
});













Route::view('/pages/slick', 'pages.slick');
Route::view('/pages/datatables', 'pages.datatables');
Route::view('/pages/blank', 'pages.blank');


