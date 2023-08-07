<?php

namespace App\Http\Controllers;

use App\Models\ReportAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        try {
            //Validated
            $validateReportAnswer = Validator::make($request->all(),
            [
                'report_id' => 'required|integer',
                'question'=> 'required|string',
                'answers'=> 'required|string',
                'type'=> 'required|string',
            ]);

            if($validateReportAnswer->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateReportAnswer->errors()
                ], 401);
            }

            $ReportAnswer = ReportAnswer::create([
                'report_id' => $request->report_id,
                'question' => $request->question,
                'answers'=> $request->answers,
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function show($id){

        return ReportAnswer::all();
    }


}
