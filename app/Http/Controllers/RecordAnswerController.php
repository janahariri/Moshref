<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\RecordAnswer;

class RecordAnswerController extends Controller
{


    public function store(Request $request){
        foreach($request->answers as $answer){
             RecordAnswer::create([
                'record_id' =>$request->record_id,
                'question_id' =>$answer["question_id"],
                'content' =>$answer["content"],
            ]);
        }
        return response()->json([
            'message' => 'تم تسجيل البلاغ بنجاح',
            ],200);
    }
}











/*





    public function store(Request $request)
    {
        try {
            $validateRecord = Validator::make($request->all(),
            [
                'content'=> 'required',
                'question_id'=> 'required|integer',
                'record_id'=> 'required|integer',
            ]);

            if($validateRecord->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateRecord->errors()
                ], 401);
            }

            if ($request->file ('content') ){
                $file= $request->file ('content');
                $filename= date('YmdHi') .$file->getClientOriginalName () ;
                $file-> move(public_path('Reports_photos'), $filename);
                $content = config('app.url')."/Reports_photos/".$filename;
            }else{
                $content=$request->content;
            }

            $Record = RecordAnswer::create([
                'content' => $content,
                'question_id'=> $request->question_id,
                'record_id'=> $request->record_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Record Answer Created Successfully',
                'token' => $Record->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
*/
