<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;

class UserController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api',['except'=>['login','register']]);
    }



    public function register(Request $request){

        try {


            $user = new User([
                'name' => $request->form_user_name,
                'email' => $request->form_email,
                'password' => hash::make($request->form_password),
            ]); 
            $user->save();

            $success = true;
            $message = 'ບັນທຶກຂໍ້ມູນສຳເລັດ!';

        } catch (\Illuminate\Database\QueryException $ex) {

            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);

            
    }

    public function login(Request $request){

            $user_login = [
                'email'=>$request->login_email,
                'password'=>$request->login_password
            ];

            $token = JWTAUTH::attempt($user_login); // ກວດຊອບອີເມວລ໌ ແລະ ລະຫັດຜ່ານ
            $user_data = Auth::user(); // ດຶງຂໍ້ມູນຂອງ User ທີ່ Login ຢູ່ປະຈຸບັນອອກມາ

            if($token){

                $response = [
                    'success' => true,
                    'message' => 'ສຳເລັດ!',
                    'user_data' => $user_data,
                    'token' => $token
                ];
                
            } else {

                $response = [
                    'success' => false,
                    'message' => 'ອີເມວລ໌ ຫຼື ລະຫັດຜ່ານບໍ່ຖຶກຕ້ອງ!'
                ];

            }

           
    
            return response()->json($response);
    }

    public function logout(){
        $token = JWTAuth::getToken();
        $invalidate = JWTAuth::invalidate($token);
        if($invalidate){
            $response = [
                'success' => true,
                'message' => 'ອອກຈາກລະບົບ ສຳເລັດ!',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'ອອກຈາກລະບົບ ບໍ່ສຳເລັດ!',
            ];
        }

        return response()->json($response);
    }
}
