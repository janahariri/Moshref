<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TechFieldsLookup;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class TechFieldsLookupController extends Controller
{
        public function store(Request $request)
        {
            try {
                $validateRecord = Validator::make($request->all(),
                [
                    'techsupervisor_id'=> 'required|integer',
                    'fieldsupervisor_id'=> 'required|integer',
                ]);

                if($validateRecord->fails()){
                    return response()->json([
                        'status' => false,
                        'message' => 'فشلت المصادقة على البيانات',
                        'errors' => $validateRecord->errors()
                    ], 401);
                }

                $typeName = TechFieldsLookup::create([
                    'techsupervisor_id' => $request->techsupervisor_id,
                    'fieldsupervisor_id' => $request->fieldsupervisor_id,
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'تم تسجيل علاقة المسنخدمين بنجاح',
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
