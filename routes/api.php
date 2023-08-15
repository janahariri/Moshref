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
use App\Http\Controllers\TechFieldsLookupController;






Route::middleware('auth:sanctum')->group(function(){

Route::get('user/show',[AuthController::class,'show']);
Route::get('report/index',[ReportController::class,'index']);
Route::get('report/show/{id}',[ReportController::class,'show']);
Route::post('record/update/{report_id}',[RecordController::class,'update']);
//Route::get('techFieldsLookup/show',[TechFieldsLookupController::class,'show']);
//Route::get('techFieldsLookup/storeFieldNameSender',[TechFieldsLookupController::class,'storeFieldNameSender']);
Route::get('RecordQuestion/show',[RecordQuestionController::class,'show']);
Route::post('recordAnswer/store',[RecordAnswerController::class,'store']);
Route::get('report/showAnalysis',[ReportController::class,'showAnalysis']);
});

Route::post('auth/register', [AuthController::class, 'createUser']);
Route::post('auth/login', [AuthController::class, 'loginUser']);
Route::post('auth/OTPpassword', [AuthController::class, 'OTPpassword']);
Route::post('user/OTPpasswordVerification',[AuthController::class,'OTPpasswordVerification']);
Route::post('user/update',[AuthController::class,'update']);

Route::post('record/store',[RecordController::class,'store']);
Route::post('report/store',[ReportController::class,'store']);
Route::post('techFieldsLookup/store',[TechFieldsLookupController::class,'store']);
Route::post('recordQuestion/store',[RecordQuestionController::class,'store']);
Route::post('questionsRecordsTypes/store',[questionsRecordsTypesController::class,'store']);
