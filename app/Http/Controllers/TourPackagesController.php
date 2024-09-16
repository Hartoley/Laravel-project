<?php

namespace App\Http\Controllers;

use App\Models\TourPackages;
use Illuminate\Http\Request;

class TourPackagesController extends Controller
{
    //
    public function createTour(Request $request){
        $name =$request->input('tour_name');
        $prices =$request->input('tour_prices');
        $decs =$request->input('tour_decs');
        $duration =$request->input('tourDuration');
        $destination =$request->input('destination');

        TourPackages::create([
           'destination'=>$destination,
           'tour_decs'=>$decs,
           'tourDuration'=>$duration,
           'tour_name'=> $name,
           'tour_prices'=>$prices,
           'images'=>"https://i.pinimg.com/474x/95/e9/e8/95e9e8b4d101498a6bec4551f60ff4a3.jpg",

                   ]);
            return response()->json(['message'=>"Package created successfully"]);
    }

    public function fetchPackages(){
        $packages =TourPackages::all();
        return response()->json($packages);

    }
 }
