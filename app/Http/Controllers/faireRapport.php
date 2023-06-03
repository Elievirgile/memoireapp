<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
Use Illuminate\Http\Response; 
use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Facades\Hash; 
Use Carbon\Carbon; 



class faireRapport extends Controller
{
    //
    public function insertRapport(Request $request){

    

       if($request-> hasFile('image') ){

            $extension = $request -> file('image') -> getClientOriginalExtension();
            $file_name = $request -> file('image') -> getClientOriginalName();
            $final_name = $file_name;
            $request -> file('image') -> move('rapport', $final_name);
           
        
            DB::table('faire_rapport')->insert([
          
                [
                    'id_employee' =>  $request -> num_matricule, 
                    'titre' =>   $request -> titre,
                    'date_enregistrement' => Carbon::now() -> toDateTimeString(),
                    'nom_fichier_rapport' => $final_name,
     
                ],    
    
            ]);
           
           
            $response = [
                'statut'  => 'Done',
            ];

            return response(
                $response , 201
            );
       } else {
            $response = [
                'statut'  => 'Not upoaded',
            ];

            return response(
                $response , 201
            );
       }


      

    }

    public function getRapport(Request $request){
        $userfilled =  $request -> validate([
           
            'num_matricul' => 'required|string',
           
        ]);

        $userRapport =  DB::table('faire_rapport')
        ->where('id_employee', $request['num_matricul'])
        ->get();

        $response = [
            'statut'  => 'OK',
            'user_rapport' => $userRapport
        ];

        return response(
            $response , 201
        );

    }


    
}
