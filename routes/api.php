<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\RecordAnswerController;
use App\Http\Controllers\RecordQuestionController;
use App\Http\Controllers\questionsRecordsTypesController;

//-------------------------مكتملة------------------------------------

Route::post('auth/register', [AuthController::class, 'createUser']);
Route::post('auth/login', [AuthController::class, 'loginUser']);

Route::get('user/show',[AuthController::class,'show']);
Route::post('auth/OTPpassword', [AuthController::class, 'OTPpassword']);
Route::post('user/update',[AuthController::class,'update']);

Route::post('report/store',[ReportController::class,'store']);

Route::post('record/store',[RecordController::class,'store']);
Route::post('record/update',[RecordController::class,'update']);

Route::post('questionsRecordsTypes/store',[questionsRecordsTypesController::class,'store']);
Route::post('recordQuestion/store',[RecordQuestionController::class,'store']);
Route::post('recordAnswer/store',[RecordAnswerController::class,'store']);

Route::get('report/show',[ReportController::class,'show']);
Route::get('report/index/{id}',[ReportController::class,'index']);
Route::get('report/showAnalysis',[ReportController::class,'showAnalysis']);






//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  //  return $request->user();
//});
