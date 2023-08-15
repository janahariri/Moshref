<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TechFieldsLookup;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\User;
use App\Models\Record;

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



    // public function show(Request $request){

    //     $user = auth('sanctum')->user();
    //      if($user->isTechsupervisor()){
    //          $fieldIds = TechFieldsLookup::where('techsupervisor_id' , $user->id)->pluck('fieldsupervisor_id');
    //          $fieldNames = User::whereIn('id',  $fieldIds)->select('id', 'full_name')->get();

    //         }else{
    //         return response()->json([
    //             'message' => 'لا يمكنك إرسال التقارير',
    //              ]);
    //         }
    //  return response()->json([
    //  'data' =>$fieldNames,
    //   ]);
    // }





//   public function storeFieldNameSender(Request $request){

//          Record::where('id', $request->report_id)->update([
//             'fieldsupervisor_id' => $request->id,
//         ]);

//         return response()->json([
//             'message' => 'تم ارسال التقرير بنجاح',
//             ],200);
//     }

}
