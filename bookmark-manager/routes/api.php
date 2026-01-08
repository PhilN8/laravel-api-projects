<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', Auth\LoginController::class);
Route::post('/register', Auth\RegistrationController::class);

// Route::middleware('auth:sanctum')->group(function() {
//     Route::apiResource('bookamrks', Bookmark)
// });
