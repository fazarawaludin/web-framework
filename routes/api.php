<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Consume API publik tanpa otentikasi
Route::get('/public', [QuestionController::class, 'ConsumePublicAPI']);
//Consume API public dengan otentikasi
Route::get('/token', [QuestionController::class, 'ConsumePublicAPIwToken']);


//JWT
Route::post('/login', [UserController::class, 'login']);

Route::middleware(['jwt.auth'])->group(function(){

    //Insert Data
    Route::post('/input', [ProductController::class, 'Input']);
    //Read Data
    Route::get('/show', [ProductController::class, 'showAll']);
    Route::get('/show/{id}', [ProductController::class, 'showById']);
    Route::get('/show/product_name/{product_name}', [ProductController::class, 'showByName']);
    //Update Data
    Route::put('/update/{id}', [ProductController::class, 'update']);
    //Delete Data
    Route::delete('/delete/{id}', [ProductController::class, 'delete']);
    
});
