<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return  $this->json_response(
            'success',
            'Invalid login credentials',
            [
                'user' => $user,
                'access_token' => $accessToken
            ]
        );
    }


    public function login(Request $request){
        $login=$request->validate([
            'email'=>'required|string',
            'password'=>'required|string',
        ]);
        if(!Auth::attempt($login)){
            return  $this->json_response('failed','Invalid login credentials',[]);
        }else{
            $accesstoken = Auth::user()->createToken('Token Name')->accessToken;
            
            return  $this->json_response(
                'success',
                'Logined Succesful !',
                [
                    'user'=> Auth::user(),
                    'accesstoken'=> $accesstoken
                ]
            );
        }
    }
}
