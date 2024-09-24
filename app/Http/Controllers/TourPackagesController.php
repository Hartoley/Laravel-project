<?php

namespace App\Http\Controllers;

use App\Models\TourPackages;
use App\Models\TravelCompanion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TourPackagesController extends Controller
{
    //
    public function createTour(Request $request){
        $name =$request->input('tour_name');
        $prices =$request->input('tour_prices');
        $decs =$request->input('tour_decs');
        $duration =$request->input('tourDuration');
        $destination =$request->input('destination');
        if($request->hasFile('tourImg')){
            $file = $request->file("tourImg");
            Log::info($file);
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('tourImages', $fileName, 'public');
            Log::info($filePath);
        }

        TourPackages::create([
           'destination'=>$destination,
           'tour_decs'=>$decs,
           'tourDuration'=>$duration,
           'tour_name'=> $name,
           'tour_prices'=>$prices,
           'images'=>$filePath,

                   ]);
            return response()->json(['message'=>"Package created successfully"]);
    }

    public function fetchPackages(){
        $packages =TourPackages::all();
        return response()->json($packages);

    }

    public function fetchCompanions(Request $request)
    {
        $tranz_id = $request->input('transaction_id');
        $companions = TravelCompanion::where("transaction_id", $tranz_id)->get();
        if($companions->isEmpty()){
            return response()->json(["error" => "There are nno companions for this package"],404);
        }

        return response()->json($companions, 200);
    }
 }
