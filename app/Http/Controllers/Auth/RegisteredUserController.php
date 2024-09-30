<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user_code = Str::random(5);
        $confirmation_link = route("verify_mail", ["con_link" => $user_code]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            "user_code" => $user_code
        ]);
        $data =[
            "name" => $request->name,
            "subject" => "We welcome you to danny Airline",
            "link" => $confirmation_link
        ];
        Mail::to($request->email)->send(new WelcomeMail($data));
        event(new Registered($user));

        // Auth::login($user);

        return redirect(route('login', absolute: false));
    }

    public function confirm_link(Request $request)
    {
        Log::info("I got here");
        $code = $request->route("con_link");
        $user = User::where("user_code", $code)->first();
        Log::info($code);
        Log::info($user);
        if(!$user){
            return response()->json(["error" => "Link could not be found"], 404);
        }
        if($user->email_verified_at !== NULL){
            return response()->json(["error" => "Link has expired"], 401);
        }
        
        $user->email_verified_at = Carbon::now();
        $user->save();
        return response()->json(["message" => "Email has been verified"]);
    }
}
