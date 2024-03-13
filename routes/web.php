<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContestController;
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
    Route::get('/', [LoginController::class,'showAdminLogin'])->name('login');
    Route::get('login', [LoginController::class,'showAdminLogin'])->name('showAdminLogin');
    Route::post('login-post', [LoginController::class,'login'])->name('loginPost');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::group(['prefix'=>'contests'], function () {
        Route::get('/', [ContestController::class,'index'])->name('listContests');
        Route::get('get-data', [ContestController::class,'getData']);
        Route::get('create', [ContestController::class,'create'])->name('createContest');
        Route::post('store', [ContestController::class,'store'])->name('contestStore');
        Route::get('edit', [ContestController::class,'edit'])->name('editContest');
        Route::put('update', [ContestController::class,'update'])->name('updateContest');
        Route::put('delete', [ContestController::class,'delete'])->name('deleteContest');
    });

    Route::post('logout', [LoginController::class,'logout'])->name('logout');
});













Route::view('/pages/slick', 'pages.slick');
Route::view('/pages/datatables', 'pages.datatables');
Route::view('/pages/blank', 'pages.blank');


