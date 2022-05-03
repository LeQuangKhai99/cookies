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

Route::get('login', function() {
    return 'Login page';
});

Route::get('buy/{cookies}', function ($cookies) {
    if(!is_numeric($cookies)) {
        return 'Error, param is not a number';
    }

    $user = Auth::user();
    $wallet = $user->wallet;

    if($wallet < $cookies) {
        return "You don't have enough money";
    }

    $user->update(['wallet' =>$wallet - $cookies * 1]);
    Log:info('User ' . $user->email . ' have bought ' . $cookies . ' cookies'); // we need to log who ordered and how much
    return 'Success, you have bought ' . $cookies . ' cookies!';
})->middleware('check-auth');
