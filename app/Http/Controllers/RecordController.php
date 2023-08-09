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


    public function update(Request $request){
        $token = PersonalAccessToken::findToken($request->header("token"));
        $Record = Record::find($token->tokenable->id);
        $Record->order_status = $request->order_status;
        $Record->save();
        return response()->json([
            'status' => true,
            'message' =>"Order Status updated Successfully",
        ], 200);
    }



    public function show(Request $request){

        $user = auth()->user();

        switch ($request->header('type')) {

        case 'Recorded':
            if($user->isTechsupervisor()){
                $reportdata = Record::where('techsupervisor_id', $user->id )->select('id','office_number','camp_label','submit_datetime')
                ->where('order_status','Sent')->get();
            }else{
                $reportdata = Record::where('fieldsupervisor_id', $user->id )->select('id','office_number','camp_label','submit_datetime')
                ->where('order_status','Sent')->whereHas('recordAnswers')->get();
            }
            break;

        case 'Ignored':
            if($user->isTechsupervisor()){
                $reportdata = Record::where('techsupervisor_id', $user->id )->select('id','office_number','camp_label','submit_datetime')
                ->where('order_status','Ignored')->get();
            }

            break;
        default:

        if($user->isTechsupervisor()){
            $reportdata = Record::where('techsupervisor_id', $user->id )->select('id','office_number','camp_label','submit_datetime')
            ->where('order_status','Not viewed')->get();
        }else{
            $reportdata = Record::where('fieldsupervisor_id', $user->id )->select('id','office_number','camp_label','submit_datetime')
            ->where('order_status','Sent ')->get();
        }

            break;
    }
            return response()->json([
            'data' =>$reportdata
             ]);
    }




    public function index(Request $request){


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



    public function showanalysis($id){

    }

*/
