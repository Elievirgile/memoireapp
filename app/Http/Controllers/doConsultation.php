<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Illuminate\Http\Response; 
use Illuminate\Support\Facades\DB;

class doConsultation extends Controller
{
    //
    public function insertConsultationData(Request $request){
         
        
        $dr_email =$request -> validate([
           
            'id_consultation' => 'required|string',
            'dr_email' => 'required|string',
            'date' => 'required|string',
            'patient_email' => 'required|string',
            'observation_postconsultation' => 'required|string',

        ]);

        $patientEmailCheck = DB::table('users')
        ->where('email', $request['patient_email'])
        ->get();

        if(sizeof($patientEmailCheck) == 0){
          
            $response = [
                'statut'  => 'Not Ok',
            ];
    
            return response(
                $response , 405
            );
        } else {
           
            DB::table('faire_consultation')->insert([
          
                [
                    'id_consultation' => $request['id_consultation'], 
                    'dr_email' => $request['dr_email'],
                    'date' => $request['date'],
                    'patient_email' => $request['patient_email'],
                    'observation_postconsultation' => $request['observation_postconsultation'],
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
}
