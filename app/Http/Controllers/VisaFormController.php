<?php

namespace App\Http\Controllers;

use App\Models\VisaForm;
use Illuminate\Http\Request;

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
         
        ]);
    }
       
}
