<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
                'personal_photo'=> 'string',
                'phone_number'=> 'string',
                'type'=> 'string'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'national_id' => $request->national_id,
                'personal_photo'=> $request->personal_photo,
                'phone_number'=> $request->phone_number,
                'type'=> $request->type
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'national_id' => 'required',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['national_id', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'national_id & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('national_id', $request->national_id)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }



    public function update(Request $request, $id)
    {
        $user = new User;
        $user->password = $request->password;
        $user->save();
    }

    public function show(Request $request){
       // $id = Auth::id();
//dd($id);
return $request->user();
     $user = User::select("personal_photo", "full_name", "national_id", "phone_number", "email")->first();
     return response()->json([
        'status' => true,
        'data' =>$user
    ], 200);
    }


}
