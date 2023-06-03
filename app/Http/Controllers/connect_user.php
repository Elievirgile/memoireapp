<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
Use Illuminate\Http\Response; 
use Illuminate\Support\Facades\DB;

class connect_user extends Controller
{
    //
public function insertUser(Request $request){

    $filled = $request -> validate([
        'user_email' => 'required|string',
        'password' => 'required|string', 
        'typeofuser' => 'required|string',
        'nom_complet' => 'required|string',
    ]);


   //check if already user

    $checkIfUser =  DB::table('users_list')
    ->where('user_email', $request['user_email'])
    ->get();

    if(sizeof($checkIfUser) == 0 ){
        //if not user
      
        if( $request['typeofuser'] == 'etudiant'){
           //if etudiant
            DB::table('users_list')->insert([
      
                [
                    'user_email' => $request['user_email'], 
                    'password' => $request['password'],
                    'typeofuser' => $request['typeofuser'],
                    'nom_complet' => $request['nom_complet'],
                ],    
    
            ]);

            $response = [
                'statut'  => 'OK',
            ];
    
            return response(
                $response , 201
            );
    
        } else if( $request['typeofuser'] == 'professeur'){

            //else if artist check if already waiting

            $checkIfUser =  DB::table('liste_attente')
            ->where('user_email', $request['user_email'])
            ->get();
    
            if(sizeof($checkIfUser) == 0){
                DB::table('liste_attente')->insert([
      
                    [
                        'user_email' => $request['user_email'], 
                        'password' => $request['password'],
                        'accepted' => 'NO',
                        'nom_complet' => $request['nom_complet'],
                    ],    
        
                ]);


                $response = [
                    'statut'  => 'OK',
                ];
        
                return response(
                    $response , 201
                );


            } else {
                $response = [
                    'statut'  => 'Déjà en attente',
                ];
        
                return response(
                    $response , 201
                );
            }

          

        }
       
       

    } else {
          
        $response = [
            'statut'  => 'User already registred',
        ];

        return response(
            $response , 201
        );
    }

}


  // get prof a cconfirmer 

  public function getProf(Request $request){
  
    $checkUser =  DB::table('liste_attente')
    ->where('accepted', 'NO')
    ->get();

   if(sizeof($checkUser) == 0){
        $response = [
            'statut'  => 'No user',
        ];

        return response(
            $response , 201
        );
    } else {
        $response = [
            'statut'  => 'OK',
            'users'   =>  $checkUser
        ];

        return response(
            $response , 201
        );
    }


  }

  //Delete pro 

  public function deleteProf(Request $request){
    $filled = $request -> validate([
        'user_email' => 'required|string',
    ]);

 

        DB::table('liste_attente')
        ->where('user_email', $request['user_email'])
        ->delete();

        $response = [
            'statut'  => 'OK',
        ];

        return response(
            $response , 201
        );
   

  }
 
  //get users

  public function getUsers(Request $request){
   
    $getUsers =  DB::table('users_list')
    ->get();

    $response = [
        'statut'  => 'OK',
        'users'  => $getUsers,
    ];

    return response(
        $response , 200
    );
  }

  //Delete etudiant

  public function deleteUsers(Request $request){
    $filled = $request -> validate([
        'user_email' => 'required|string',
    ]);

 

        DB::table('users_list')
        ->where('user_email', $request['user_email'])
        ->delete();

        $response = [
            'statut'  => 'OK',
        ];

        return response(
            $response , 201
        );
   
  }


   // confirm professeur

   public function confirmProf(Request $request){

    $filled = $request -> validate([
        'user_email' => 'required|string',
    ]);

    //check if pro is in waiting 
    $checkUser =  DB::table('liste_attente')
    ->where('user_email', $request['user_email'])
    ->get();

    if(sizeof($checkUser) !== 0 ){

        DB::table('liste_attente')
        ->where('user_email', $request['user_email'])
        ->update([
            
          'accepted' => 'YES',   

        ]);

        DB::table('users_list')->insert([
      
            [
                'user_email' => $request['user_email'], 
                'password' =>  $checkUser[0] -> password,
                'typeofuser' => 'professeur',
                'nom_complet' =>  $checkUser[0] -> nom_complet,
               
            ],    

        ]);

        $response = [
            'statut'  => 'OK',
        ];

        return response(
            $response , 201
        );
    }  else {
        $response = [
            'statut'  => 'No users ',
        ];

        return response(
            $response , 201
        );
    }


  }


    //Connect users

    public function connectMyUsers(Request $request){
      
        $filled = $request -> validate([
            'user_email' => 'required|string',
            'password' => 'required|string',
        ]);


        $checkNumMatri =  DB::table('users_list')
        ->where('user_email', $request['user_email'])
        ->where('password', $request['password'])
        ->get();

        if(sizeof($checkNumMatri) !== 0 ){
          
            $response = [
                'statut'  => 'OK',
                'user' => $checkNumMatri,
            ];  
    
            return response(
                $response , 201
            );
        } else {
          
            $response = [
                'statut'  => 'Bad credentials',
            ];
    
            return response(
                $response , 405
            );
        }


    }

    //Modify user password



    public function modifyUserPassword(){
       
        $filled = $request -> validate([
            'user_email' => 'required|string',
            'password' => 'required|string',
            'new_password' => 'required|string',
        ]);

        $checkNumMatri =  DB::table('users_list')
        ->where('user_email', $request['user_email'])
        ->where('password', $request['password'])
        ->get();


        if(sizeof($checkNumMatri) !== 0){
          
            $response = [
                'statut'  => 'Password changed',
                'user' => $checkNumMatri,
            ];

            DB::table('users_list')
            ->where('user_email', $request['user_email'])
            ->update([
          
                [
                    'password' => $request['new_password'],
                ],    
    
            ]);
    
            return response(
                $response , 201
            );
        } else {
          
            $response = [
                'statut'  => 'Bad password',
            ];
    
            return response(
                $response , 401
            );
        }


    }
}
