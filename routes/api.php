<?php

use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RatingController;
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

Route::get('/user', [App\Http\Controllers\UserController::class, 'index']);
Route::post('/register', [App\Http\Controllers\UserController::class, 'register']);
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
Route::post('/validasi', [App\Http\Controllers\UserController::class, 'validasi']);
Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'show']);
Route::put('/user/update/{id}', [App\Http\Controllers\UserController::class, 'update']);
Route::put('/user/updateImage/{id}', [App\Http\Controllers\UserController::class, 'updateImage']);

Route::get('/cart/{id_user}', [App\Http\Controllers\CartController::class, 'index']);
Route::post('/cart', [App\Http\Controllers\CartController::class, 'store']);
Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'destroy']);
Route::get('/cart/{id_user}/{id}', [App\Http\Controllers\CartController::class, 'show']);
Route::put('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'update']);

Route::get('/car', [App\Http\Controllers\CarController::class, 'index']);
Route::post('/car', [App\Http\Controllers\CarController::class, 'store']);
Route::delete('/car/{id}', [App\Http\Controllers\CarController::class, 'destroy']);
Route::get('/car/{id}', [App\Http\Controllers\CarController::class, 'show']);
Route::put('/car/update/{id}', [App\Http\Controllers\CarController::class, 'update']);

Route::get('/review', [ReviewController::class, 'index']);
Route::post('/review', [ReviewController::class, 'store']);
Route::get('/review/{id_user}', [ReviewController::class, 'fetchAllForUser']);
Route::get('/review/{id_user}/{id}', [ReviewController::class, 'show']);
Route::put('/review/{id_user}/{id}', [ReviewController::class, 'update']);
Route::delete('/review/{id}', [ReviewController::class, 'destroy']);

Route::get('/subscriptions', [App\Http\Controllers\SubcriptionsController::class, 'index']);
Route::post('/subscriptions', [App\Http\Controllers\SubcriptionsController::class, 'store']);
Route::get('/subscriptions/{id}', [App\Http\Controllers\SubcriptionsController::class, 'show']);
Route::put('/subscriptions/update/{id}', [App\Http\Controllers\SubcriptionsController::class, 'update']);
Route::delete('/subscriptions/{id}', [App\Http\Controllers\SubcriptionsController::class, 'destroy']);

Route::get('/ratings', [RatingController::class, 'index']);
Route::post('/ratings', [RatingController::class, 'store']);
Route::get('/users/{id_user}/ratings/{id}', [RatingController::class, 'show']);
Route::put('/ratings/{id}', [RatingController::class, 'update']);
Route::delete('/ratings/{id}', [RatingController::class, 'destroy']);