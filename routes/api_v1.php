<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\Auth\LoginController;
use App\Http\Controllers\API\V1\Auth\RegisterController;

use App\Http\Controllers\API\V1\GenderController;
use App\Http\Controllers\API\V1\UserProfileController;

/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('sign-up', [RegisterController::class, 'signUp']);
Route::post('sign-in', [LoginController::class, 'signIn']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('genders', [GenderController::class, 'index']);
});
