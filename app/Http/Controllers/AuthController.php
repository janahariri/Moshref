<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail;

class AuthController extends Controller
{


/**
     * Create User
     * @param Request $request
     * @return User
*/


    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'full_name' => 'string',
                'email' => 'email|unique:users,email',
                'password' => 'required',
                'national_id' => 'required|unique:users,national_id',
                'personal_photo'=> 'image',
                'phone_number'=> 'string',
                'type'=> 'string',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'فشلت المصادقة على البيانات',
                    'errors' => $validateUser->errors()
                ], 401);
            }


            if ($request->file ('personal_photo') ){
                $file= $request->file ('personal_photo');
                $filename= date('YmdHi') .$file->getClientOriginalName () ;
                $file-> move(public_path('users_photos'), $filename);
            }

            $user = User::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'national_id' => $request->national_id,
                'personal_photo'=> config('app.url')."/users_photos/".$filename,
                'phone_number'=> $request->phone_number,
                'type'=> $request->type
            ]);


            return response()->json([
                'status' => true,
                'message' => 'تم انشاء المستخدم بنجاح',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }






    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'national_id' => 'required',
                'password' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'فشلت المصادقة على البيانات',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['national_id', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'الهوية الوطنية أو كلمة المرور لا تتطابق مع البيانات المسجلة',
                ], 401);
            }

            $user = User::where('national_id', $request->national_id)->first();

            return response()->json([
                'status' => true,
                'message' => 'تم تسجيل الدخول بنجاح',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }





    public function update(Request $request)
    {

        try {
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required',
                'NewPassword' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'فشلت المصادقة على البيانات',
                    'errors' => $validateUser->errors()
                ], 400);
            }

        $user = User::where('email', $request->email)->first();

        $user->password = Hash::make($request->NewPassword);
        $user->save();
        return response()->json([
            'status' => true,
            'message' =>"تم تحديث كلمة المرور بنجاح",
        ], 200);

    } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);

    }
}




    public function show(Request $request){

        $user = User::select("personal_photo", "full_name", "national_id", "phone_number", "email")->find(auth()->user()->id);
        return response()->json([
        'status' => true,
        'data' =>$user
    ], 200);
    }





    public function OTPpassword(Request $request){

        try {
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'فشلت المصادقة على البيانات',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            if(is_null($user)){
               return response()->json([
                'status' => false,
                'message' => 'البريد الالكتروني لا يتطابق مع البيانات المسجلة',
                'errors' => $validateUser->errors()
            ], 404);
            }

            $token =mt_rand(1000,9999);
            Mail::to($user->email)->send((new OTPMail($token,$user)));

            $user->update([
                'OTP_password' =>  $token,
                ]);

            return response()->json([
                'status' => true,
                'message' =>'تم ارسال رمز التحقق إلى البريد المسجل'
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);

            }
    }


    public function OTPpasswordVerification (Request $request){

        try {
            $validateUser = Validator::make($request->all(),
            [
                'otp' => 'required|integer',
                'email' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'الرجاء التحقق من المدخلات',
                    'errors' => $validateUser->errors()
                ], 401);
            }

        $user = User::where('email', $request->email)->first();

        if($user->OTP_password != $request->otp){
            return response()->json([
                'status' => false,
                'message' => 'الرقم المدخل غير صحيح',
            ], 403);
        }

        return response()->json([
            'status' => true,
            'message' =>"تم تجاوز رقم التحقق بنجاح",
        ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);

        }
    }

}
