<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Appointment;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with(['user', 'staff', 'service'])
            ->orderBy('start_time', 'desc')
            ->get();
            
        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $appointment = Appointment::findOrFail($id);
        $previousStatus = $appointment->status;

        $appointment->update([
            'status' => $request->status
        ]);

        // Loyalty Points Earning Logic
        if ($previousStatus !== 'completed' && $request->status === 'completed') {
             $pointsEarned = \App\Models\Setting::getValue('loyalty_earn_rate', 10);
             $appointment->user->increment('loyalty_points', $pointsEarned);
             $appointment->user->loyaltyTransactions()->create([
                 'points' => $pointsEarned,
                 'type' => 'earned',
                 'description' => 'Earned from appointment #' . $appointment->id,
             ]);
        }

        // Notify User
        $appointment->user->notify(new \App\Notifications\AppointmentStatusChanged($appointment));

        return redirect()->back()->with('success', 'Appointment status updated successfully.');
    }
}
