<?php

use App\Http\Controllers\RegController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegController::class, 'create']);
Route::put('/update', [RegController::class, 'update']);
Route::get('/list', [RegController::class, 'list']);
