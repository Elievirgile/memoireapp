<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Illuminate\Http\Response; 
use Illuminate\Support\Facades\DB;

class doSoins extends Controller
{
    //
    public function doSoin(Request $request){
        $soins =  $request -> validate([
           
            'id_consultation' => 'required|string',
            'observation_postconsultation' => 'required|string',

        ]);

      
        DB::table('administrer_soin')->insert([
          
            [
                'id_consultation' => $request['id_consultation'], 
                'description_soin' => $request['observation_postconsultation'],
            ],    

        ]);

        $response = [
            'statut'  => 'OK',
        ];

        return response(
            $response , 201
        );


    }
}
