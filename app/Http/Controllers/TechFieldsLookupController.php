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



    public function show(Request $request){
         $user = auth('sanctum')->user();
         switch ($request->header('type')) {

     case 'Sent':
         if($user->isTechsupervisor()){
             $reportdata = Record::where('techsupervisor_id', $user->id )->where('order_status','Sent')->first();
             $fieldNames = TechFieldsLookup::where('techsupervisor_id' , 'fieldsupervisor_id');
         }else{
            return response()->json([
                'message' => 'لا يمكنك إرسال التقارير',
                 ]);
         }break;

     return response()->json([
     'data' =>$reportdata,
     'Send_to' =>$fieldNames,
      ]);
    }
  }
}


    //     $token = PersonalAccessToken::findToken($request->header("token"));

    //     $user = User::select("personal_photo", "full_name", "national_id", "phone_number", "email")->find($token->tokenable);
    //     return response()->json([
    //     'status' => true,
    //     'data' =>$user
    // ], 200);
    // }
