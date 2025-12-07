<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featured_services = \App\Models\Service::take(4)->get();
    $reviews = \App\Models\Review::with('user')->orderBy('rating', 'desc')->take(3)->get();
    $branches = \App\Models\Branch::all();
    
    return view('home', compact('featured_services', 'reviews', 'branches'));
});

Route::get('/dashboard', function () {
    $recent_appointments = \App\Models\Appointment::where('user_id', Auth::id())
        ->with('service', 'staff') // Eager load relationships
        ->orderBy('start_time', 'desc')
        ->take(5)
        ->get();

    // Calculate Total Spent based on paid invoices
    $totalSpent = \App\Models\Invoice::whereHas('appointment', function ($query) {
        $query->where('user_id', Auth::id());
    })->where('status', 'paid')->sum('amount');

    return view('dashboard', compact('recent_appointments', 'totalSpent'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Settings Routes
    Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    });

    // Booking Routes
    Route::resource('appointments', \App\Http\Controllers\AppointmentController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    Route::patch('/appointments/{appointment}/cancel', [\App\Http\Controllers\AppointmentController::class, 'cancel'])->name('appointments.cancel');
    // Review Routes
    Route::resource('reviews', \App\Http\Controllers\ReviewController::class)->only(['create', 'store']);

    // AI Chat Routes
    Route::get('/ai-chat', [\App\Http\Controllers\AiController::class, 'index'])->name('ai.chat');
    Route::post('/ai-chat/message', [\App\Http\Controllers\AiController::class, 'message'])->name('ai.message');

    // AI Image Generation Routes (Create Style)
    Route::get('/ai-image', [\App\Http\Controllers\AiImageController::class, 'index'])->name('ai.image.index');
    Route::post('/ai-image', [\App\Http\Controllers\AiImageController::class, 'generate'])->name('ai.image.generate');

    // Notification Routes
    Route::post('/notifications/mark-as-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // Payment Routes (Stripe)
    Route::get('/payment/{appointment}', [\App\Http\Controllers\PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/success/handle', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');

    // SSLCommerz Routes
    Route::post('/payment/sslcommerz/pay/{appointment}', [\App\Http\Controllers\PaymentController::class, 'payWithSslCommerz'])->name('payment.sslcommerz.pay');
    Route::post('/payment/sslcommerz/success', [\App\Http\Controllers\PaymentController::class, 'sslCommerzSuccess'])->name('payment.sslcommerz.success');
    Route::post('/payment/sslcommerz/fail', [\App\Http\Controllers\PaymentController::class, 'sslCommerzFail'])->name('payment.sslcommerz.fail');
    Route::post('/payment/sslcommerz/cancel', [\App\Http\Controllers\PaymentController::class, 'sslCommerzCancel'])->name('payment.sslcommerz.cancel');
    Route::post('/payment/sslcommerz/ipn', [\App\Http\Controllers\PaymentController::class, 'sslCommerzIpn'])->name('payment.sslcommerz.ipn');

    // Slot Availability API (Internal)
    Route::get('/api/slots', [\App\Http\Controllers\Api\SlotController::class, 'index'])->name('api.slots');
});

// Public Routes
Route::get('/services', function () {
    $services = \App\Models\Service::all();
    return view('services', compact('services'));
})->name('services.index');

Route::get('/about', function () {
    $branches = \App\Models\Branch::all();
    return view('about', compact('branches'));
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Public Routes

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('branches', \App\Http\Controllers\Admin\BranchController::class);
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
    Route::resource('staff', \App\Http\Controllers\Admin\StaffController::class);
    Route::resource('appointments', \App\Http\Controllers\Admin\AppointmentController::class)->only(['index', 'update']);
    Route::resource('invoices', \App\Http\Controllers\Admin\InvoiceController::class)->only(['create', 'store', 'show']);
});

require __DIR__.'/auth.php';
