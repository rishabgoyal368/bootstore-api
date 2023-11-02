<?php

use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Publication\PublicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('get-all-books', [BookController::class, 'index']);
Route::post('add-books', [BookController::class, 'add']);
Route::post('update-books', [BookController::class, 'add']);
Route::delete('delete-book', [BookController::class, 'delete']);

Route::get('get-all-publication', [PublicationController::class, 'index']);
Route::post('add-publication', [PublicationController::class, 'add']);
Route::post('update-publication', [PublicationController::class, 'add']);
Route::delete('delete-publication', [PublicationController::class, 'delete']);
