<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RecordController;
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
Route::get('user/show',[AuthController::class,'show']);
Route::post('user/update',[AuthController::class,'update']);
Route::post('report/store',[ReportController::class,'store']);
Route::get('record/show',[RecordController::class,'show']);




Route::post('auth/OTPpassword', [AuthController::class, 'OTPpassword']);

Route::get('report/show',[ReportController::class,'show']);

Route::post('record/store',[RecordController::class,'store']);

Route::get('record/showAnalysis',[RecordController::class,'showAnalysis']);

Route::post('recordAnswer/store',[RecordAnswerController::class,'store']);
Route::get('recordAnswer/show',[RecordAnswerController::class,'show']);

Route::get('recordQuestion/show',[RecordQuestionController::class,'show']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
