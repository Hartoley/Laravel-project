<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TourPackagesController;
use App\Http\Controllers\VisaFormController;
use App\Mail\WelcomeMail;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Intro', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get("/about", function(){
    return Inertia::render("About");
});
Route::get("/travel", function(){
    return Inertia::render("Travel");
})->middleware(['auth'])->name(name:"travel");

Route::get("/adminTravel", function(){
    return Inertia::render("Admintravel");
});

Route::get("/keenaTravel", function(){
    return Inertia::render("Intro");
});

Route::get("/landingPage", function(){
    return Inertia::render("Landing");
})->middleware(['auth'])->name("landing");

Route::get("/user_dashboard", function(){
    return Inertia::render("UserDashboard");
})->middleware(['auth'])->name('user.dashboard');
Route::get("/user_application", function(){
    return Inertia::render("Application");
})->middleware(['auth'])->name('user.dashboard');

Route::post("visaForm", [VisaFormController::class, 'visaForm'])->name("visa.create");
Route::get("get_user_applications", [VisaFormController::class, 'fetchUserApplication'])->name("user.fetch_application");

Route::post("createTour", [TourPackagesController::class, 'createTour'])->name("tour.create");
Route::get("fetchTour", [TourPackagesController::class, 'fetchPackages'])->name("tour.fetch");

Route::get("/createTour", function(){
    return Inertia::render("Admin/CreateTour");
});
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get("send_mail", function (){
    $data = ["name" => "Daniel", "subject"=> "Welcome to Danny Airline"];
    Mail::to("boluwatifedaniell29@gmail.com")->send(new WelcomeMail($data));

    return "Email sent successfully";
});

require __DIR__.'/auth.php';
