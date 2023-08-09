<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\QuestionsRecordsTypes;

class questionsRecordsTypesController extends Controller
{
        public function store(Request $request)
        {
            try {
                $validateRecord = Validator::make($request->all(),
                [
                    'typeName'=> 'required|string',
                ]);

                if($validateRecord->fails()){
                    return response()->json([
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validateRecord->errors()
                    ], 401);
                }

                $typeName = QuestionsRecordsTypes::create([
                    'typeName' => $request->typeName,
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'typeName Created Successfully',
                    'token' => $typeName->createToken("API TOKEN")->plainTextToken
                ], 200);

            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage()
                ], 500);
            }
        }
}
