<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\URecordController;
use App\Http\Controllers\RecordAnswerController;
use App\Http\Controllers\RecordQuestionController;


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

Route::post('auth/register', [AuthController::class, 'createUser']);
Route::post('auth/login', [AuthController::class, 'loginUser']);

//Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');

Route::get('user/show',[AuthController::class,'show']);
Route::post('user/update',[AuthController::class,'update']);

Route::get('report/show',[ReportController::class,'show']);
Route::post('report/store',[ReportController::class,'store']);

Route::get('record/show',[RecordController::class,'show']);
Route::get('record/showanalysis',[RecordController::class,'showanalysis']);

Route::get('record/show',[RecordAnswerController::class,'show']);
Route::post('record/store',[RecordAnswerController::class,'store']);

Route::get('record/show',[RecordQuestionController::class,'show']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
