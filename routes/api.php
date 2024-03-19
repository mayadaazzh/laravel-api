<?php

use App\Http\Controllers\API\CommentsController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PostsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);

Route::get('posts', [PostsController::class, 'index']);
Route::get('posts/{id}', [PostsController::class, 'show']);
Route::post('posts', [PostsController::class, 'store']);
Route::patch('posts/{id}', [PostsController::class, 'update']);
// Route::delete('posts/{id}', [PostsController::class, 'destroy']);

Route::post('comment', [CommentsController::class, 'store']);




