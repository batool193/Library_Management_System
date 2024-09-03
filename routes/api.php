<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RatingController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Controllers\BorrowRecordController;



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

 Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('books', [BookController::class, 'index']);
    Route::get('books/{book}', [BookController::class, 'show']);
    Route::post('books/available', [BookController::class, 'available']);
    Route::post('borrowrecords/{book}', [BorrowRecordController::class, 'store']);
    Route::put('borrowrecords/{borrowRecord}', [BorrowRecordController::class, 'update']);
    Route::get('borrowrecords/not-returned', [BorrowRecordController::class, 'notReturned']);
    Route::post('/ratings', [RatingController::class, 'store']);
    Route::get('/ratings/{rating}', [RatingController::class, 'show']);
    Route::put('/ratings/{rating}', [RatingController::class, 'update']);
    Route::delete('/ratings/{rating}', [RatingController::class, 'destroy']);
});

Route::group(['middleware' => ['auth:api',EnsureUserIsAdmin::class]], function () {
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::put('users/{user}', [UserController::class, 'update']);
    Route::delete('users/{user}', [UserController::class, 'destroy']);
    Route::post('books', [BookController::class, 'store']);
    Route::put('books/{book}', [BookController::class, 'update']);
    Route::delete('books/{book}', [BookController::class, 'destroy']);
    Route::get('borrowrecords', [BorrowRecordController::class, 'index']);
    Route::get('borrowrecords/{borrowRecord}', [BorrowRecordController::class, 'show']);
    Route::delete('borrowrecords/{borrowRecord}', [BorrowRecordController::class, 'destroy']);
});
