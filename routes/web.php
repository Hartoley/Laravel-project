<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TourPackagesController;
use App\Http\Controllers\TravelPlanController;
use App\Http\Controllers\VisaFormController;
use App\Mail\KeenaMail;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get("/about", function () {
    return Inertia::render("About");
});

Route::get("/signup", function () {
    return Inertia::render("Signup");
});

Route::get("/signin", function () {
    return Inertia::render("Login");
});

Route::get("/visastatus", function () {
    return Inertia::render("VisaStatus");
})->name('visastatus');


Route::get("/usersDash", function () {
    return Inertia::render("Application");
})->middleware(['auth'])->name('user.application');

Route::get("/userdashboard", function () {
    return Inertia::render("UserDashboard");
})->middleware(['auth'])->name('user.dashboard');

Route::get("/travel", function () {
    return Inertia::render("Travel");
})->middleware((['auth']))->name(name: "travel");

Route::get("/adminTravel", function () {
    return Inertia::render("Admintravel");
})->middleware(['auth'])->name(name: "admin.travel");

Route::get("/keenaTravel", function () {
    return Inertia::render("Intro");
})->name('keenaTravel');

Route::get("/makePayment/{id}", function ($id) {
    $user = Auth::user();
    return Inertia::render("Payment", [
        'id' => (int)$id,
        'email' => $user ? $user->email : null,
    ]);
})->middleware(['auth'])->name(name: "keena.travel");





Route::get("/bookTour/{id}", function ($id) {
    $user = Auth::user();
    return Inertia::render("BookTour", [
        'id' => (int)$id,
        'email' => $user ? $user->email : null,
    ]);
})->middleware(['auth'])->name("bookPlan.travel");


Route::get("/visaAdmin", function () {
    return Inertia::render("VisaAdmin");
});

Route::get("/cheapFligths", function () {
    return Inertia::render("BookCheap");
})->name('cheapFligths');

Route::get("/landingPage", function () {
    return Inertia::render("Landing");
})->middleware(['auth'])->name("landing");

Route::get("sendmail", function () {
    $data = ["name" => "Keena", "subject" => "Welcome to Keena Airline"];
    Mail::to("tolanijimoh1@gmail.com")->send(new KeenaMail($data));

    return "Email sent successfully";
});
Route::get("register/{con_link", [RegisteredUserController::class, "confirm_link"]);
Route::get("get_user_applications", [VisaFormController::class, 'fetchUserApplication'])->name("user.fetch_application");
Route::post("get_user_companions", [VisaFormController::class, 'companions'])->name("user.fetch_companion");
Route::get("get_all_applications", [VisaFormController::class, 'fetchAllApplications'])->name("all.fetch_application");
Route::post("visaForm", [VisaFormController::class, 'visaForm'])->name("visa.create");
Route::post("login_user", [LoginUserController::class, 'LoginUser'])->name("users.create");
Route::post("signIn", [LoginUserController::class, 'signIn'])->name("users.signin");
Route::post("createTour", [TourPackagesController::class, 'createTour'])->name("tour.create");
Route::get("fetchTour", [TourPackagesController::class, 'fetchPackages'])->name("tour.fetch");
Route::get("fetchUserTours", [TravelPlanController::class, 'fetchUserTours'])->name("usertour.fetch");
Route::get("fetchCompanions", [TourPackagesController::class, 'fetchCompanions'])->name("fetch.Companions");
Route::post("acceptApplication", [VisaFormController::class, 'acceptApplication'])->name("accept.applications");
Route::post("rejectApplication", [VisaFormController::class, 'rejectApplication'])->name("reject.applications");
Route::post("acceptCompanion", [VisaFormController::class, 'acceptCompanion'])->name("accept.companions");
Route::post("rejectCompanion", [VisaFormController::class, 'rejectCompanion'])->name("reject.companions");
Route::post("fetchTour", [TourPackagesController::class, 'fetchTour'])->name("fetch.tour");
Route::post("createPlan", [TravelPlanController::class, 'createPlan'])->name("travelPlan.create");
Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');
Route::post('/pay', [App\Http\Controllers\PaystackController::class, 'redirectToGateway'])->name('pay');


Route::get("/createTour", function () {
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

require __DIR__ . '/auth.php';
