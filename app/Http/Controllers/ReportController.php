<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ReportAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\Record;


class ReportController extends Controller
{

    public function store(Request $request)
{
        try {
            //Validated
            $validateReportAnswer = Validator::make($request->all(),
            [
                'report_id' => 'required|integer',
                'question'=> 'required|string',
                'answers'=> 'required',
                'type'=> 'required|string',
            ]);

            if($validateReportAnswer->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateReportAnswer->errors()
                ], 401);
            }

            if ($request->file ('answers') ){
                $file= $request->file ('answers');
                $filename= date('YmdHi') .$file->getClientOriginalName () ;
                $file-> move(public_path('Reports_photos'), $filename);
                $answer = config('app.url')."/Reports_photos/".$filename;
            }else{
                $answer=$request->answers;
            }

            $ReportAnswer = ReportAnswer::create([
                'report_id' => $request->report_id,
                'question' => $request->question,
                'answers'=> $answer,
                'type'=> $request->type
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Report Created Successfully',
                'token' => $ReportAnswer->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
