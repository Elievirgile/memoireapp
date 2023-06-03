<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon ;
Use Illuminate\Http\Response; 
use Illuminate\Support\Facades\DB;

class marquerPresence extends Controller
{
    // 

    public function getTimeStamp(Request $request){
       
       
        $userfilled =  $request -> validate([
           
            'num_matricul' => 'required',

        ]);

        DB::table('presence')->insert([
          
            [
                'id_employee' => $request['num_matricul'], 
                'date'  => Carbon::now() -> toDateTimeString()  ,
            ],    

        ]);

        $response = [
            'statut'  => 'OK',
        ];

        return response(
            $response , 200
        );


    }

    //all presence for one user 

    public function getAllPresence(){
        $userfilled =  $request -> validate([
           
            'num_matricul' => 'required|string',

        ]);

      
        $checkUserPresence =  DB::table('presence')
        ->where('id_employee', $request['num_matricul'])
        ->get();

        $response = [
            'statut'  => 'OK',
            'presence'  => $checkUserPresence
        ];

        return response(
            $response , 200
        );

    }

    //check if user was present


    public function getTimeBasedPresence(Request $request){
      
        $userfilled =  $request -> validate([
           
            'num_matricul' => 'required|string',
            'timestamp' => 'required|string',
        ]);

        $checkUserPresence =  DB::table('presence')
        ->where('id_employee', $request['num_matricul'])
        ->where('date', $request['timestamp'])
        ->get();

     

        if(sizeof($checkUserPresence) !== 0  ){
            $response = [
                'statut'  => 'OK',
                'presence'  => true
            ];
    
            return response(
                $response , 200
            );
        } else{
            $response = [
                'statut'  => 'OK',
                'presence'  => false
            ];
    
            return response(
                $response , 200
            );
        }
    }
}
