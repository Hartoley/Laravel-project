<?php

namespace App\Http\Controllers;

use App\Models\TravelPlan;
use Illuminate\Http\Request;

class TravelPlanController extends Controller
{
    //
        public function createPlan(Request $request){
            $first_name =$request->input('first_name');
            $surname =$request->input('surname');
            $email =$request->input('email');
            $mobileNum =$request->input('mobileNum');
            $tourName =$request->input('tourName');
            $instructions =$request->input('instructions');

        TravelPlan::create([
            'first_name' => $first_name,
            'surname' => $surname,
            'email' => $email,
            'mobileNum' => $mobileNum,
            'tourName' => $tourName,
            'instructions' => $instructions,

        ]);
            return response()->json(['message'=>"Travel Package created successfully"
        ]);
    }

}
