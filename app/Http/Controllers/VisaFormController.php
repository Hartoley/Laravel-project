<?php

namespace App\Http\Controllers;

use App\Models\TravelCompanion;
use App\Models\VisaForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class VisaFormController extends Controller
{
    //
    public function visaForm(Request $request) {
        $email =$request->input('email');
        $surname =$request->input('surname');
        $first_name =$request->input('first_name');
        $residence =$request->input('residence');
        $marital_status =$request->input('marital_status');
        $national_identity_number =$request->input('national_identity_number');
        $travel_document =$request->input('travel_document');
        $journey_purpose =$request->input('journey_purpose');
        $arrival =$request->input('arrival');
        $departure =$request->input('departure');
        $travel_companion =$request->input('travel_companion');
        Log::info($travel_companion);
        // Log::info(count($travel_companion));
        $transaction_id = Str::uuid();
        // Log::info($transaction_id);
        if(count($travel_companion) > 0){
            foreach ($travel_companion as $comp) {
                Log::info($comp['firstName']);
                TravelCompanion::create([
                    'name'=> $comp['firstName'],
                    'relationship'=> $comp['relationship'],
                    'transaction_id'=> $transaction_id
                ]);
            }
        }
        VisaForm::create([
         'email'=> $email,
         'surname'=> $surname,
         'first_name'=> $first_name,
         'residence'=> $residence,
         'marital_status'=> $marital_status,
         'national_identity_number'=> $national_identity_number,
         'travel_document'=> $travel_document,
         'journey_purpose'=>$journey_purpose,
         'arrival'=> $arrival,
         'departure'=> $departure,
         'travel_companion'=> $travel_companion,
         'transaction_id'=> $transaction_id
        ]);

        return response()->json(["message" => "Your application is being processed"], 200);
    }

    public function fetchUserApplication()
    {
        $user = Auth::user();
        $applications = VisaForm::where('email', $user->email)->get();

        return response()->json(["applications" => $applications],200);
    }
       
}
