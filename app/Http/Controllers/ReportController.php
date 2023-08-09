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



    public function index($id){

        $reportdata = Record::where('id', $id )->with('reportAnswers','recordAnswers.RecordQuestion')->get();
        return response()->json([
            'data' =>$reportdata
             ]);
    }



    public function showanalysis(){

        $all=Record::count();
        $ReportsNotViewedPercentage=Record::where('order_status', 'Not viewed')->count() * 100/$all;
        $ReportsIgnoredPercentage=Record::where('order_status', 'Ignored')->count() * 100/$all;
        $ReportsSentPercentage=Record::where('order_status', 'Sent')->count() * 100/$all;
        $RecordsRecordedPercentage=Record::where('order_status', 'Recorded')->count() * 100/$all;

        $ReportsNotViewed=Record::where('order_status', 'Not viewed')->count();
        $ReportsIgnored=Record::where('order_status', 'Ignored')->count();
        $ReportsSent=Record::where('order_status', 'Sent')->count();
        $RecordsRecorded=Record::where('order_status', 'Recorded')->count();

        return response()->json([
            'ReportsNotViewedPercentage' =>$ReportsNotViewedPercentage,
            'ReportsIgnoredPercentage' =>$ReportsIgnoredPercentage,
            'ReportsSentPercentage' =>$ReportsSentPercentage,
            'RecordsRecordedPercentage' =>$RecordsRecordedPercentage,

            'ReportsNotViewed' =>$ReportsNotViewed,
            'ReportsIgnored' =>$ReportsIgnored,
            'ReportsSent' =>$ReportsSent,
            'RecordsRecorded' =>$RecordsRecorded,
             ]);
    }
}
