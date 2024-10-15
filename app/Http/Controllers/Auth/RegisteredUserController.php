<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\User as AuthUser;
use Inertia\Inertia;
use Inertia\Response;
use App\Mail\KeenaMail;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

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
        $user_code =str::random(5);
        $confirmation_link = route("register", ["con_link" => Str::random(5)]);
        $confirmation_link = route("verify_mail", ["con_link" => $user_code]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            "user_code" => $user_code,
        ]);

        $data=[
            "name"=>$request->name,
            "subject"=>$request->email,
            "password"=>Hash::make($request->password),
        ];

        $data=[
            "name"=>$request->name,
            "subject"=>"Welcome to keena Airline",
            "link" => $confirmation_link
        ];
        Mail::to($request->email)->send(new KeenaMail($data));
        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
        return redirect(route('login', absolute: false));
    }

  public function confirmLink(Request $request){
        $code= $request->route('con_link');
        $query= User::where('user_code', $code)->first();
        if(!$query){
            return response()->json(['error'=> 'Link not found']);

        }
        if(!$query->email_verified_at != null){
            return response()->json(['error'=> 'Link not found']);
        }
        $query->email_verified_at= Carbon::now();
        $query->save();
    
    }
}
