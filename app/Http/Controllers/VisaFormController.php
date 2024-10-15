<?php

namespace App\Http\Controllers;

use App\Models\TravelCompanion;
use App\Models\VisaForm;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
        $transaction_id= Str::uuid();
        // Str::class;
        Log::info($transaction_id);
        Log::info($travel_companion);

        if(count($travel_companion)> 0){
            foreach($travel_companion as $comp){
                
               TravelCompanion::create([
                    'name'=>$comp['firstName'],
                    'relationship'=>$comp['relationship'],
                    'transaction_id'=>$transaction_id,
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
         'transaction_id'=>$transaction_id
         
        ]);

       
    }

    public function fetchUserApplication()
    {
        $user = Auth::user();
        $applications = VisaForm::where('email', $user->email)->get();

        return response()->json(["applications" => $applications],200);
    }

    public function fetchAllApplications()
        {
            $applications = VisaForm::all();

            return response()->json(["applications" => $applications], 200);
        }

    public function acceptApplication(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:visa_forms,id',
        ]);

        $application = VisaForm::find($request->id);
        $application->status = 'Accepted';
        $application->save();

        return response()->json(['message' => 'Application accepted successfully'], 200);
    }

   public function companions(Request $request) {
    $request->validate([
        'id' => 'required|exists:travel_companions,transaction_id',
    ]);
    
    $companions = TravelCompanion::where('transaction_id', $request->id)->get();
    if ($companions->isEmpty()) {
        return response()->json(['message' => 'No companions found for this transaction ID.'], 404);
    }

    return response()->json(['message' => 'Application accepted successfully', 'companions' => $companions], 200);
}


    public function rejectApplication(Request $request) {
        $request->validate([
            'id' => 'required|exists:visa_forms,id',
        ]);

        $application = VisaForm::find($request->id);
        $application->status = 'Rejected';
        $application->save();

        return response()->json(['message' => 'Application Rejected successfully'], 200);
    } 

     public function rejectCompanion(Request $request) {
        $request->validate([
            'id' => 'required|exists:travel_companions,id',
        ]);

        $companion = TravelCompanion::find($request->id);
        if (!$companion) {
            return response()->json(['message' => 'Companion not found.'], 404);
        }

        $companion->status = 'Rejected';
        $companion->save();

        return response()->json(['message' => 'Companion rejected successfully.'], 200);
}


       public function acceptCompanion(Request $request) {
         $request->validate([
            'id' => 'required|exists:travel_companions,id',
        ]);

        $companion = TravelCompanion::find($request->id);
        if (!$companion) {
            return response()->json(['message' => 'Companion not found.'], 404);
        }

        $companion->status = 'Accepted';
        $companion->save();

        return response()->json(['message' => 'Companion Accepted successfully.'], 200);
    }
       
}
