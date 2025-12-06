<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Booking Routes
    Route::resource('appointments', \App\Http\Controllers\AppointmentController::class)->only(['index', 'create', 'store']);
    // Review Routes
    Route::resource('reviews', \App\Http\Controllers\ReviewController::class)->only(['create', 'store']);
});

// Public Routes
Route::get('/services', function () {
    $services = \App\Models\Service::all();
    return view('services', compact('services'));
})->name('services.index');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// AI Chat Routes
Route::get('/ai-chat', [\App\Http\Controllers\AiController::class, 'index'])->name('ai.chat');
Route::post('/ai-chat/message', [\App\Http\Controllers\AiController::class, 'message'])->name('ai.message');

// AI Image Generation Routes (Nano Banana)
Route::get('/ai-image', [\App\Http\Controllers\AiImageController::class, 'index'])->name('ai.image.index');
Route::post('/ai-image', [\App\Http\Controllers\AiImageController::class, 'generate'])->name('ai.image.generate');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
    Route::resource('staff', \App\Http\Controllers\Admin\StaffController::class);
    Route::resource('appointments', \App\Http\Controllers\Admin\AppointmentController::class)->only(['index', 'update']);
    Route::resource('invoices', \App\Http\Controllers\Admin\InvoiceController::class)->only(['create', 'store', 'show']);
});

require __DIR__.'/auth.php';
