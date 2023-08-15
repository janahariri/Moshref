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
                    'message' => 'فشلت المصادقة على البيانات',
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
                'message' => 'تم انشاء التقرير بنجاح',
                'token' => $ReportAnswer->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }



    public function index(Request $request){

       $user = auth('sanctum')->user();
       switch ($request->header('order-status')) {

        case 'Recorded':
            if($user->isTechsupervisor()){
                $reportdata = Record::where('techsupervisor_id', $user->id )->select('id','office_number','camp_label','submit_datetime', 'order_status')
                ->where('order_status','Recorded')->get();
            }else{
                $reportdata = Record::where('fieldsupervisor_id', $user->id )->select('id','office_number','camp_label','submit_datetime', 'order_status')
                ->where('order_status','Recorded')->whereHas('recordAnswers')->get();
            }
            break;

        case 'Ignored':
            if($user->isTechsupervisor()){
                $reportdata = Record::where('techsupervisor_id', $user->id )->select('id','office_number','camp_label','submit_datetime','order_status')
                ->where('order_status','Ignored')->get();
            }else{
                return response()->json([
                    'message' =>'لا يوجد تقارير متجاهلة',
                     ]);
            }
            break;
        default:

        if($user->isTechsupervisor()){
            $reportdata = Record::where('techsupervisor_id', $user->id )->select('id','office_number','camp_label','submit_datetime', 'order_status')
            ->where('order_status','Not viewed')->get();
        }else{
            $reportdata = Record::where('fieldsupervisor_id', $user->id )->select('id','office_number','camp_label','submit_datetime', 'order_status')
            ->where('order_status','Sent ')->get();
        }

            break;
        }
        return response()->json([
        'data' =>$reportdata
         ]);
    }



    public function show($id){

        $report = Record::where('id', $id )->with('reportAnswers','recordAnswers.RecordQuestion.questionsRecordsTypes')->first();
        $data = [];
        $note='';
        $image='';
        foreach($report->reportAnswers as $key=> $reportAnswer){
           if( $reportAnswer->type == 'text'){
            $report->note = $reportAnswer->answers;
            unset($report->reportAnswers[$key]);
            }
            if($reportAnswer->type == 'image'){
                $report->image = $reportAnswer->answers;
                unset($report->reportAnswers[$key]);
            }
        }
        foreach($report->recordAnswers as $key=> $recordAnswers){
             if($recordAnswers->RecordQuestion->questionsRecordsTypes->typeName == 'text'){
              $report->recordNote = $recordAnswers->content;
              unset($report->recordAnswers[$key]);
            }
              if($recordAnswers->RecordQuestion->questionsRecordsTypes->typeName == 'image'){
                  $report->recordImage = $recordAnswers->content;
                  unset($report->recordAnswers[$key]);
                }
        }
        return response()->json([
            'data' =>$report
             ]);
    }



    public function showanalysis(){

        $all=Record::count();
        $ReportsNotViewedPercentage=round(Record::where('order_status', 'Not viewed')->count() * 100/$all);
        $ReportsIgnoredPercentage=round(Record::where('order_status', 'Ignored')->count() * 100/$all);
        $ReportsSentPercentage=round(Record::where('order_status', 'Sent')->count() * 100/$all);
        $RecordsRecordedPercentage=round(Record::where('order_status', 'Recorded')->count() * 100/$all);

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
