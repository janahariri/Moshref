<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\ReportAnswer;

class RecordController extends Controller
{

    public function store(Request $request)
    {
        try {
            $validateRecord = Validator::make($request->all(),
            [
                'submit_datetime' => 'required',
                'order_status'=> 'required|string',
                'fieldsupervisor_id'=> 'required|integer',
                'techsupervisor_id'=> 'required|integer',
                'camp_label'=> 'required|string',
                'office_number'=> 'required|integer',
            ]);

            if($validateRecord->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateRecord->errors()
                ], 401);
            }

            $Record = Record::create([
                'submit_datetime' => $request->submit_datetime,
                'order_status'=> $request->order_status,
                'fieldsupervisor_id'=> $request->fieldsupervisor_id,
                'techsupervisor_id'=> $request->techsupervisor_id,
                'camp_label'=> $request->camp_label,
                'office_number'=> $request->office_number,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'تم انشاء التقرير بنجاح',
                'token' => $Record->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }



    public function update(Request $request, $report_id){
        $Record = Record::where('id', $report_id)->first();

        $Record->order_status = $request->order_status;


        $Record->save();
        return response()->json([
            'status' => true,
            'message' =>"تم تغيير حالة التقرير بنجاح",
        ], 200);
    }
}








/*

    public function show(Request $request){

        if ($request->header('order_status') == 'Not viewed'){
            $record=DB::table('records')->where('order_status', $request->header('order_status'))->get();
            return response()->json([
            'records'=> $record
            ]);
         }

         elseif ($request->header('order_status') == 'Ignored'){
            $record=DB::table('records')->where('order_status',$request->header('order_status'))->get();
            return response()->json([
            'records'=> $record
            ]);
         }

         elseif ($request->header('order_status') == 'Sent'){
            $record=DB::table('records')->where('order_status',$request->header('order_status'))->get();
            return response()->json([
            'records'=> $record
            ]);
         }
         elseif ($request->header('order_status') == 'Recorded') {
            $record=DB::table('records')->where('order_status',$request->header('order_status'))->get();
            return response()->json([
            'records'=> $record
            ]);
         }
         else {
              return ("The Enterd Order Status Are not defined");
         }
     }
*/
