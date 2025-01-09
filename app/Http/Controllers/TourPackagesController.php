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

    public function updateTour(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tour_packages,id',
            'tour_name' => 'required|string|max:255',
            'tour_prices' => 'required|numeric',
            'tour_decs' => 'required|string',
            'tourDuration' => 'required|string',
            'destination' => 'required|string',
            'boarding_date' => 'required|date',
            'boarding_time' => 'required',
        ]);

        $tour = TourPackages::find($request->id);

        if ($tour) {
            if ($request->has('existing_images') && !empty($request->input('existing_images'))) {
                $filePath = $request->input('existing_images');
            } elseif ($request->hasFile('images')) {
                $file = $request->file('images');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('tourImages', $fileName, 'public');
            } else {
                $filePath = $tour->images;
            }

            $tour->tour_name = $request->input('tour_name');
            $tour->tour_prices = $request->input('tour_prices');
            $tour->tour_decs = $request->input('tour_decs');
            $tour->tourDuration = $request->input('tourDuration');
            $tour->destination = $request->input('destination');
            $tour->boarding_date = $request->input('boarding_date');
            $tour->boarding_time = $request->input('boarding_time');
            $tour->images = $filePath;

            $tour->save();

            return response()->json(['message' => 'Tour updated successfully'], 200);
        }

        return response()->json(['error' => 'Tour not found'], 404);
    }



    public function deleteTour(Request $request, $id)
    {
        Log::info($id);
        $tour = TourPackages::find($id);
        if ($tour) {
            $tour->delete();
            return response()->json(['message' => 'Tour deleted successfully']);
        } else {
            return response()->json(['message' => 'Tour not found'], 404);
        }
    }
}
