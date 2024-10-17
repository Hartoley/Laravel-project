<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Unicodeveloper\Paystack\Facades\Paystack;
use Illuminate\Support\Facades\Log;
// use Unicodeveloper\Paystack\Paystack;

class PaystackController extends Controller
{
    public function redirectToGateway()
    {
        try {
            $data = [
                "amount" => 700 * 100,
                "reference" => 'helolmhellololokmmknjkjkkhjknklynk568989',
                "email" => 'user@mail.com',
                "currency" => "NGN",
                "orderID" => 23456,
            ];

            $response = Paystack::getAuthorizationUrl($data); // This returns an object
            $url = $response->url; // Extract the 'url' property from the response

            // Ensure URL is valid before logging or returning
            if ($url) {
                Log::info("Paystack URL: " . $url); // Proper logging
                return response()->json(['url' => $url], 200); // Send valid JSON response
            } else {
                return response()->json(['message' => 'Unable to retrieve payment URL'], 400);
            }
        } catch (\Exception $e) {
            Log::error("Paystack Error: " . $e->getMessage());
            return Redirect::back()->with([
                'msg' => 'The Paystack token has expired. Please refresh the page and try again.',
                'type' => 'error'
            ]);
        }
    }


    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        // Log the payment details for debugging
        Log::info("Payment Details: ", $paymentDetails);

        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
        dd($paymentDetails);
    }
}
