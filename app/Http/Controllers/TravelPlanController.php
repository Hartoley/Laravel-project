<?php

namespace App\Http\Controllers;

use App\Models\TravelPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class TravelPlanController extends Controller
{
    //
    public function createPlan(Request $request)
    {
        $first_name = $request->input('first_name');
        $surname = $request->input('surname');
        $email = $request->input('email');
        $mobileNum = $request->input('mobileNum');
        $tourName = $request->input('tourName');
        $instructions = $request->input('instructions');

        $travelPlan = TravelPlan::create([
            'first_name' => $first_name,
            'surname' => $surname,
            'email' => $email,
            'mobileNum' => $mobileNum,
            'tourName' => $tourName,
            'instructions' => $instructions,
        ]);

        return response()->json([
            'message' => "Travel Package created successfully",
            'id' => $travelPlan->id,
        ]);
    }


    public function fetchUserTours()
    {
        $user = Auth::user();

        $userTours = TravelPlan::where('email', $user->email)->get();


        if ($userTours->isEmpty()) {
            return response()->json(['message' => 'No tours found for this user'], 404);
        }

        return response()->json(['tours' => $userTours], 200);
    }

    public function fetchAllTours()
    {
        $allTours = TravelPlan::all();

        if ($allTours->isEmpty()) {
            return response()->json(['message' => 'No tours available'], 404);
        }

        return response()->json(['tours' => $allTours], 200);
    }


    public function uploadPaymentProof(Request $request)
    {
        try {
            Log::info('Request received:', $request->all());

            $validated = $request->validate([
                'tourId' => 'required|exists:travel_plans,id',
                'file' => 'required|image|max:2048',
            ]);

            Log::info('Validation passed.');

            $tour = TravelPlan::find($validated['tourId']);
            Log::info('Tour found:', $tour ? $tour->toArray() : []);

            $file = $request->file('file');
            $filePath = $file->store('paymentImage', 'public');
            Log::info('File stored at:', ['path' => $filePath]);


            $tour->paymentImage = $filePath;
            $tour->isPaid = true;
            $tour->save();

            Log::info('Tour updated successfully.');

            return response()->json([
                'message' => 'Payment proof uploaded successfully!',
                'filePath' => $filePath,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error uploading payment proof:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Failed to upload payment proof. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function approvePayment(Request $request)
    {
        $tour = TravelPlan::find($request->id);

        if ($tour) {
            $tour->paymentStatus = 'approved';
            $tour->save();

            return response()->json(['message' => 'Payment approved successfully!']);
        }

        return response()->json(['message' => 'Tour not found'], 404);
    }

    public function declinePayment(Request $request)
    {
        $tour = TravelPlan::find($request->id);

        if ($tour) {
            $tour->paymentStatus = 'declined';
            $tour->save();

            return response()->json(['message' => 'Payment declined successfully!']);
        }

        return response()->json(['message' => 'Tour not found'], 404);
    }
}
