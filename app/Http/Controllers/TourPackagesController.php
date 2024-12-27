<?php

namespace App\Http\Controllers;

use App\Models\TourPackages;
use App\Models\TravelCompanion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TourPackagesController extends Controller
{
    //
    public function createTour(Request $request)
    {
        Log::info('CreateTour method called with data:', $request->all());
        $name = $request->input('tour_name');
        $prices = $request->input('tour_prices');
        $decs = $request->input('tour_decs');
        $duration = $request->input('tourDuration');
        $destination = $request->input('destination');
        if ($request->hasFile('images')) {
            $file = $request->file('images');
            Log::info($file);
            $fileName = time() . '' . $file->getClientOriginalName();
            $filePath = $file->storeAs('tourImages', $fileName, 'public');
            Log::info($filePath);
        };



        TourPackages::create([
            'destination' => $destination,
            'tour_decs' => $decs,
            'tourDuration' => $duration,
            'tour_name' => $name,
            'tour_prices' => $prices,
            'images' => $filePath,
            'boarding_date' => $request->boarding_date,
            'boarding_time' => $request->boarding_time,

        ]);
        return response()->json(['message' => "Package created successfully"]);
    }

    public function fetchPackages()
    {
        $packages = TourPackages::all();
        return response()->json($packages);
    }

    public function fetchTour(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tour_packages,id',
        ]);
        $applications = TourPackages::where('id', $request->id)->get();

        return response()->json(["applications" => $applications], 200);
    }

    public function fetchCompanions(Request $request)
    {
        $tranz_id = $request->input('transaction_id');
        $companions = TravelCompanion::where("transaction_id", $tranz_id)->get();
        if ($companions->isEmpty()) {
            return response()->json(["error" => "There are no companions for this package"], 404);
        }
    }
}
