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
Route::post('user/update',[AuthController::class,'update']);

Route::post('record/store',[RecordController::class,'store']);
Route::post('record/update',[RecordController::class,'update']);

Route::post('report/store',[ReportController::class,'store']);

Route::post('questionsRecordsTypes/store',[questionsRecordsTypesController::class,'store']);
Route::post('recordQuestion/store',[RecordQuestionController::class,'store']);
Route::post('recordAnswer/store',[RecordAnswerController::class,'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//-----------اشتغل في السيرفر بس ناقص هندلة التخزين-----------------

Route::post('auth/OTPpassword', [AuthController::class, 'OTPpassword']);

//----------اشتغل على اللوكل وباقي ما اشتغل عالسيرفر----------------

Route::get('record/show',[RecordController::class,'show']);

//-------------------------لسع ما سار----------------------------------

Route::get('report/show',[ReportController::class,'show']);
Route::get('report/showAnalysis',[ReportController::class,'showAnalysis']);

Route::get('recordAnswer/show',[RecordAnswerController::class,'show']);
Route::get('recordQuestion/show',[RecordQuestionController::class,'show']);


