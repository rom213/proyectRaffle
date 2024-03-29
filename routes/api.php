<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\clienteController;
use App\Http\Controllers\ProgressbarController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get', [clienteController::class, 'oneRef']);

Route::get('/progressbar/{id}', [ProgressbarController::class, 'show']);

Route::post('/post', [clienteController::class, 'create']);

Route::patch('/patch/{id}', [clienteController::class, 'update']);

Route::post('/wompi-webhook', [clienteController::class, 'handleWebhook']);