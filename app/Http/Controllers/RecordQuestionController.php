<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\RecordQuestion;

class RecordQuestionController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validateRecord = Validator::make($request->all(),
            [
                'content'=> 'required|string',
                'type_id'=> 'required|integer',
            ]);

            if($validateRecord->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'فشلت المصادقة على البيانات',
                    'errors' => $validateRecord->errors()
                ], 401);
            }

            $Record = RecordQuestion::create([
                'content' => $request->content,
                'type_id'=> $request->type_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'تم انشاء اسئلة البلاغ بنجاح',
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

        $user = RecordQuestion::select("id", "content", "type_id",)->find(auth()->user()->id)->get();
        return response()->json([
        'data' =>$user
    ], 200);
    }
}
