<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Laravel\Sanctum\PersonalAccessToken;

class RecordController extends Controller
{

    public function index()
    {

    }



    public function store(Request $request)
    {
        try {
            $validateRecord = Validator::make($request->all(),
            [
                'submit_datetime' => 'required',
                'order_status'=> 'required|string',
                'fieldsupervisor_id'=> 'required|integer',
                'techsupervisor_id'=> 'required|integer',
                'cmap_label'=> 'required|string',
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
                'cmap_label'=> $request->cmap_label,
                'office_number'=> $request->office_number,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Report Created Successfully',
                'token' => $Record->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }


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

         elseif ($request->header('order_status') == 'Send'){
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




/*
        switch($order_status->records) {

            case('Not viewed'):
                $record=DB::table('records')->where('order_status', $order_status)->get();
                return response()->json([
                'records'=> $record
                ]);
                break;

            case('Ignored'):
                $record=DB::table('records')->where('order_status',$order_status)->get();
                return response()->json([
                'records'=> $record
                ]);
                break;

            case('Send'):
                $record=DB::table('records')->where('order_status',$order_status)->get();
                return response()->json([
                'records'=> $record
                ]);
                break;

            case('Recorded'):
                $record=DB::table('records')->where('order_status',$order_status)->get();
                return response()->json([
                'records'=> $record
                ]);
                break;

            default:
               $record = "The Enterd Order Status Are not defined";
        }

*/























    public function showanalysis($id){

    }
}
