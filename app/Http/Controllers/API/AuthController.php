<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\Rules\AllowedApp;


class AuthController extends Controller 
{

    public $successStatus = 200;
    public $unauthorizedStatus = 401;

    public function register(Request $request) {    

        $validator = Validator::make($request->all(), 
            [ 
                'f_name' => 'required|string',
                'l_name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',  
                'c_password' => 'required|same:password',
                'app_name' => ['required', 'string', new AllowedApp],
            ]); 

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], $this->unauthorizedStatus);
        } 

        $input = $request->all();  
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input); 
        $success['token'] =  $user->createToken($input['app_name'])->accessToken;
        return response()->json(['success'=>$success], $this->successStatus); 
    }


    public function login(Request $request){
        
        $validator = Validator::make($request->all(), 
            [ 
                'email' => 'required|email',
                'password' => 'required',
                'app_name' => ['required', 'string', new AllowedApp],
            ]);

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], $this->unauthorizedStatus);
        } 

        $input = $request->all(); 
        
        if(Auth::attempt(['email' => $input['email'], 'password' => $input['password']])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken($input['app_name'])-> accessToken; 
            return response()->json(['success' => $success], $this->successStatus); 
        } else{ 
            return response()->json(['error'=>'Unauthorised'], $this->unauthorizedStatus); 
        } 
    }

    public function logout(){  
        if (Auth::check()) {
            $user = Auth::user()->token();
            $user->revoke();
            return response()->json(['success' => 'Logged out. Until next time, friend.'], $this->successStatus);
        } else{ 
            return response()->json(['error'=>'Already Logged Out'], $this->unauthorizedStatus); 
        } 
    }

    public function getUser() {
        $user = Auth::user();
        return response()->json(['user' => $user], $this->successStatus); 
    }
} 