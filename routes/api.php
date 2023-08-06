<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\LogInvoiceController;
use App\Http\Controllers\Api\LogTransantionController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SubKategoriController;
use App\Http\Controllers\Api\UserController;

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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    Route::get('/kategoris', [KategoriController::class, 'index']);
    Route::get('/kategoris/{id}', [KategoriController::class, 'show']);
    Route::post('/kategoris', [KategoriController::class, 'store']);
    Route::put('/kategoris/{id}', [KategoriController::class, 'update']);
    Route::delete('/kategoris/{id}', [KategoriController::class, 'destroy']);

    Route::get('/sub_kategoris', [SubKategoriController::class, 'index']);
    Route::get('/sub_kategoris/{id}', [SubKategoriController::class, 'show']);
    Route::post('/sub_kategoris', [SubKategoriController::class, 'store']);
    Route::put('/sub_kategoris/{id}', [SubKategoriController::class, 'update']);
    Route::delete('/sub_kategoris/{id}', [SubKategoriController::class, 'destroy']);

    Route::get('/log_invoices', [LogInvoiceController::class, 'index']);
    Route::get('/log_invoices/{id}', [LogInvoiceController::class, 'show']);
    Route::post('/log_invoices', [LogInvoiceController::class, 'store']);
    Route::put('/log_invoices/{id}', [LogInvoiceController::class, 'update']);
    Route::delete('/log_invoices/{id}', [LogInvoiceController::class, 'destroy']);

    Route::get('/log_transantions', [LogTransantionController::class, 'index']);
    Route::get('/log_transantions/{id}', [LogTransantionController::class, 'show']);
    Route::post('/log_transantions', [LogTransantionController::class, 'store']);
    Route::put('/log_transantions/{id}', [LogTransantionController::class, 'update']);
    Route::delete('/log_transantions/{id}', [LogTransantionController::class, 'destroy']);

    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/roles/{id}', [RoleController::class, 'show']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::put('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    