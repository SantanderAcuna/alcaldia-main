<?php

use App\Http\Controllers\Api\PqrsdController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::apiResource('pqrsds', PqrsdController::class);