<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
Use Illuminate\Http\Response; 
Use Illuminate\Support\Facades\Hash; 


class authController extends Controller
{
    //

    public function register(Request $request){

       $filled = $request -> validate([
            'name' => 'required|string', 
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string',
            'typeofuser' => 'required|string',
        ]);

       $user = User::create([
            'name' =>$filled['name'], 
            'email' =>$filled['email'], 
            'password' =>bcrypt($filled['password']), 
            'typeofuser' => $filled['typeofuser'], 
        ]);

        $token = $user -> createToken('myToken') -> plainTextToken;

        $response = [
            'user' => $user, 
            'myToken' => $token
        ]; 
        return response($response, 201);

    }






    public function Login(Request $request){

        $filled = $request -> validate([
             'email' => 'required|string',
             'password' => 'required|string', 
             'typeofuser' => 'required|string',
        ]);
 
        $user = User::where('email' , $filled['email'])->first();
        
         
        if(!$user || !Hash::check($filled['password'] , $user->password) ){
            return response([
                'message' => 'Bad credential'
            ] , 401);
        } else{
                
            $token = $user -> createToken('myToken') -> plainTextToken;
    
            $response = [
                'user' => $user, 
                'myToken' => $token
            ]; 
            return response($response, 201);
        }

   }




   public function logout(Request $request){

       auth('sanctum')->user()->tokens()->delete();
       return response([
            'message'=>'Logged out'
       ]);
   }
 
 



}
