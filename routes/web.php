<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [DonationController::class, 'index'])->name('dashboard');

    // User Donations
    Route::get('/users/{id}/donations', [DonationController::class, 'getUserDonations'])->name('users.donations');

    // Create Donation
    Route::get('/donations/create', [DonationController::class, 'create'])->name('donations.create');
    Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');

    // Edit Donation
    Route::get('/donations/{donation}/edit', [DonationController::class, 'edit'])->name('donations.edit');
    Route::patch('/donations/{donation}', [DonationController::class, 'update'])->name('donations.update');

    // Contribute to Donation
    Route::get('/donations/{donation}/contribute', [DonationController::class, 'createContributionForm'])->name('donations.form');
    Route::post('/donations/{donation}/contribute', [DonationController::class, 'contribute'])->name('donations.contribute');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::apiResource('donations', DonationController::class);

require __DIR__ . '/auth.php';
