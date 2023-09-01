<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
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


Route::group([
    'prefix' => '/auth',
    'controller' => AuthController::class,
], function (){
    Route::post('login','login')->name('login');
    Route::post('register','register');
});

Route::group([
    'prefix' => '/blog',
    'controller' => BlogController::class,
    'middleware' => ['auth:sanctum', 'restrictRole:User']
],function(){
    Route::get('/','index');
    Route::post('/','store');
    Route::put('/{blog_id}','update');
    Route::delete('/{blog_id}','delete');
    Route::post('/filter', 'filter');

    Route::group([
        'prefix' => '/comment'
    ], function(){
        // Route::post('/', 'indexComment');
        Route::post('/', 'storeComment');
        Route::put('/update', 'updateComment');
        Route::delete('/{comment_id}', 'deleteComment');
    });
});

