<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\API\AuthController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/temperature', [\App\Http\Controllers\API\TemperatureController::class, 'index']);
// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('/tasks', TasksController::class);

    Route::get('/authors', [\App\Http\Controllers\API\AuthorsController::class, 'index']);
    Route::get('/books', [\App\Http\Controllers\API\BooksController::class, 'index']);
    Route::get('/books/{id}', [\App\Http\Controllers\API\BooksController::class, 'show']);
    Route::get('/authors/{id}', [\App\Http\Controllers\API\AuthorsController::class, 'show']);
});
Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {
    Route::post('/authors', [\App\Http\Controllers\API\AuthorsController::class, 'create']);
    Route::post('/books', [\App\Http\Controllers\API\BooksController::class, 'create']);
    Route::put('/books/{id}', [\App\Http\Controllers\API\BooksController::class, 'update']);
    Route::put('/authors/{id}', [\App\Http\Controllers\API\AuthorsController::class, 'update']);
    Route::delete('/books/{id}', [\App\Http\Controllers\API\BooksController::class, 'destroy']);
    Route::delete('/authors/{id}', [\App\Http\Controllers\API\AuthorsController::class, 'destroy']);
    Route::post('/books/delete-many/{id}', [\App\Http\Controllers\API\BooksController::class, 'delete_many']);
});
// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


