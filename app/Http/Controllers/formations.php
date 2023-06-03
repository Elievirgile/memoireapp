<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Illuminate\Http\Response; 
use Illuminate\Support\Facades\DB;
Use Carbon\Carbon;

class formations extends Controller
{
    //

    public function createNoteId(){
        $random = random_int(0, 9000000); 
        $token = 'formation_'.$random;
        return $token;
    } 
    public function createQuestId(){
        $random = random_int(0, 9000000); 
        $token = 'question_'.$random;
        return $token;
    } 

    public function getFormations (Request $request){

        $getFormations =  DB::table('formations')
        ->get();

        $response = [
            'statut'  => 'OK',
            'formations'  => $getFormations,
        ];

        return response(
            $response , 200
        );
    }


    public function insertFormation(Request $request){

        $formation_id = $this -> createNoteId();
        $id_question_one = $this  ->  createQuestId();
        $id_question_two = $this  ->  createQuestId();
        $id_question_three = $this  ->  createQuestId();

        //insert formation pdf on server

        $file_name = $formation_id.'.pdf';
        $request -> file('image') -> move('rapport', $file_name);


        //insert Thumbnail on server
     
       
        $extension = $request -> file('thumbnail') -> getClientOriginalExtension();
        $file_name_two = $formation_id.'.'.$extension;
        $request -> file('thumbnail') -> move('Thumbnail', $file_name_two);

        // insert data in DB 

        DB::table('formations')->insert([
          
            [
                'id_formation' => $formation_id, 
                'titre' => $request['titre'],
                'description' => $request['description'],
                'duree' => $request['duree'],
                'nombreDechapitre' => $request['nombredechapitre'],
                'thumnail' => $file_name_two,
                'professeur' => $request['professeur'],
                'date_creation' =>  Carbon::now() -> toDateTimeString(),

            ],    

        ]); 
        
        //insert questions

        DB::table('evaluation')->insert([
          
            [
                'id_formation' => $formation_id, 
                'id_question' => $id_question_one,
                'question_text' => $request['question1'],

            ], 
            
            [
                'id_formation' => $formation_id, 
                'id_question' => $id_question_two,
                'question_text' => $request['question2'],

            ],  

            [
                'id_formation' => $formation_id, 
                'id_question' => $id_question_three,
                'question_text' => $request['question3'],

            ], 

        ]);  
        
        // insert answers propositions 
       
       
        DB::table('evaluation_answer')->insert([
          
            [
                
                'id_question' => $id_question_one,
                'answer' =>$request['q1R1'],
                'isCorrect' => true

            ], 
            
            [
                
                'id_question' => $id_question_one,
                'answer' => $request['q1R2'],
                'isCorrect' => false
            ],  

            [
               
                'id_question' => $id_question_one,
                'answer' => $request['q1R3'],
                'isCorrect' => false

            ], 

            [
               
                'id_question' => $id_question_two,
                'answer' => $request['q2R1'],
                'isCorrect' => true

            ], 
            [
               
                'id_question' => $id_question_two,
                'answer' => $request['q2R2'],
                'isCorrect' => false

            ], 
            [
               
                'id_question' => $id_question_two,
                'answer' => $request['q2R3'],
                'isCorrect' => false

            ], 
            [
               
                'id_question' => $id_question_three,
                'answer' => $request['q3R1'],
                'isCorrect' => true

            ], 
            [
               
                'id_question' => $id_question_three,
                'answer' => $request['q3R2'],
                'isCorrect' => false

            ], 
            [
               
                'id_question' => $id_question_three,
                'answer' => $request['q3R3'],
                'isCorrect' => false

            ], 




        ]);  
        



        $response = [
            
            'statut'  => 'Done' ,
        ];

        return response(
            $response , 200
        );


    }


    // get evaluations 

    public function getEvaluation(Request $request){

       $tab = [];
       $tab2 = [];
       $response = [$tab , $tab2];

        $userfilled =  $request -> validate([
           
            'id_formation' => 'required|string',
           
        ]);

        $questions =  DB::table('evaluation')
        ->where('id_formation', $request['id_formation'])
        ->get();

        foreach($questions as $eachquestion){
            $eachquestionAnswer =  DB::table('evaluation_answer')
            ->where('id_question', $eachquestion -> id_question)
            ->get();


           array_push($response[0] , $eachquestion -> question_text);
           array_push($response[1] , $eachquestionAnswer);
           

        }

       
       
        return response(
            $response , 200
        );


    }

    public function getFormationsVideo(Request $request){
      
        $userfilled =  $request -> validate([
           
            'chapter' => 'required|string',
           
        ]);

        $files = File::allFiles(public_path('rapport')); 
     /*    dd($files); */
        
        $response = [
            'statut'  => 'OK',
            'files'  => dd($files),
        ];

        return response(
            $response , 200
        );
        

    }
}
