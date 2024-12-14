<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('users', [UsersController::class, 'index']);
Route::get('users/create', [UsersController::class, 'create']);
Route::post('users', [UsersController::class, 'store']);
Route::get('users/edit/{id}', [UsersController::class, 'edit']);
Route::post('users/update/{id}', [UsersController::class, 'update']);
Route::get('users/delete/{id}', [UsersController::class, 'destroy']);
Route::post('users/delete-selected', [UsersController::class, 'destroySelected']); // Bulk delete route
