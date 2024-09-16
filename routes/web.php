<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TourPackagesController;
use App\Http\Controllers\VisaFormController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
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
})->name(name:"travel");
Route::get("/adminTravel", function(){
    return Inertia::render("Admintravel");
});

Route::get("/keenaTravel", function(){
    return Inertia::render("Intro");
});

Route::get("/landingPage", function(){
    return Inertia::render("Landing");
})->middleware(['auth'])->name("landing");

Route::post("visaForm", [VisaFormController::class, 'visaForm'])->name("visa.create");
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

require __DIR__.'/auth.php';
