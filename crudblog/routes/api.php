<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;

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
Route::group([

    'middleware' => 'api',
], function ($router) {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/me', [AuthController::class, 'me']);

});
Route::post('/signup', [AuthController::class, 'signup']);


Route::get('/articles', [ArticleController::class, 'getLatestArticles']);
Route::post('/article/create', [ArticleController::class, 'createArticle'])->middleware('auth');
Route::get('/article/{id}', [ArticleController::class, 'getArticle']);
Route::delete('/article/{id}', [ArticleController::class, 'deleteArticle'])->middleware('auth');
Route::put('/article/{id}', [ArticleController::class, 'editArticle'])->middleware('auth');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
