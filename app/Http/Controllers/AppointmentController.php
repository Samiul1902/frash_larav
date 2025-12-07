<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the user's appointments.
     * 
     * @return \Illuminate\View\View
     * @fr FR-05: Appointment Booking (User History)
     */
    public function index()
    {
        // FR-05: Fetch authenticated user's appointments
        $appointments = Appointment::where('user_id', Auth::id())
            ->with(['service', 'staff'])
            ->orderBy('start_time', 'desc')
            ->get();
            
        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the multi-step booking wizard.
     * 
     * @return \Illuminate\View\View
     * @fr FR-05: Appointment Booking (Booking Form)
     */
    public function create()
    {
        // FR-04: Fetch all branches for selection
        $branches = \App\Models\Branch::all();
        
        // Data for dropdowns (filtered dynamically on frontend)
        $services = Service::all();
        $staff = Staff::where('is_active', true)->get();
        
        return view('appointments.create', compact('branches', 'services', 'staff'));
    }

    /**
     * Store a newly created appointment in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @fr FR-05: Appointment Booking (Submission & Validation)
     */
    public function store(Request $request)
    {
        // 1. Validate Input
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'required|exists:staff,id',
            'appointment_date' => 'required|date|after:now',
            'appointment_time' => 'required',
            'payment_method' => 'required|in:cash,online',
        ]);

        $service = Service::findOrFail($request->service_id);
        
        // 2. Calculate Start & End Time
        $start_time = Carbon::parse($request->appointment_date . ' ' . $request->appointment_time);
        $end_time = $start_time->copy()->addMinutes($service->duration_minutes);

        // 3. Check for Conflicts (Double Booking Prevention)
        // FR-06: Slot Availability (Server-side Double Check)
        $conflicts = Appointment::where('staff_id', $request->staff_id)
            ->where(function ($query) use ($start_time, $end_time) {
                $query->whereBetween('start_time', [$start_time, $end_time])
                      ->orWhereBetween('end_time', [$start_time, $end_time])
                      ->orWhere(function ($q) use ($start_time, $end_time) {
                          $q->where('start_time', '<', $start_time)
                            ->where('end_time', '>', $end_time);
                      });
            })
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($conflicts) {
            return back()->withErrors(['appointment_time' => 'This time slot is already booked for the selected staff member.'])->withInput();
        }

        // 4. Create Appointment Record
        $appointment = Appointment::create([
            'user_id' => Auth::id(),
            'service_id' => $request->service_id,
            'staff_id' => $request->staff_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
        ]);

        // 5. Notify Admins
        // FR-08: Notifications (New Appointment Alert)
        $admins = \App\Models\User::where('role', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\NewAppointment($appointment));

        // 6. Handle Payment Flow
        // FR-07: Payment Processing (Redirect if Online)
        if ($request->payment_method === 'online') {
            return redirect()->route('payment.checkout', $appointment->id);
        }

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully! Please pay at the salon.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     * 
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\View\View
     */
    public function edit(Appointment $appointment)
    {
        // Ensure user owns the appointment
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow status pending or confirmed
        if (!in_array($appointment->status, ['pending', 'confirmed'])) {
            return redirect()->route('appointments.index')->with('error', 'You cannot reschedule this appointment.');
        }

        $branches = \App\Models\Branch::all();
        $services = Service::all();
        $staff = Staff::where('is_active', true)->get();

        return view('appointments.edit', compact('appointment', 'branches', 'services', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Appointment $appointment)
    {
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'appointment_date' => 'required|date|after:now',
            'appointment_time' => 'required',
            'staff_id' => 'required|exists:staff,id', // Allow changing staff
        ]);

        $service = $appointment->service; // Service usually stays the same for reschedule
        
        // Calculate new times
        $start_time = Carbon::parse($request->appointment_date . ' ' . $request->appointment_time);
        $end_time = $start_time->copy()->addMinutes($service->duration_minutes);

        // Check for conflicts (excluding current appointment)
        $conflicts = Appointment::where('staff_id', $request->staff_id)
            ->where('id', '!=', $appointment->id)
            ->where(function ($query) use ($start_time, $end_time) {
                $query->whereBetween('start_time', [$start_time, $end_time])
                      ->orWhereBetween('end_time', [$start_time, $end_time])
                      ->orWhere(function ($q) use ($start_time, $end_time) {
                          $q->where('start_time', '<', $start_time)
                            ->where('end_time', '>', $end_time);
                      });
            })
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($conflicts) {
            return back()->withErrors(['appointment_time' => 'This time slot is already booked.'])->withInput();
        }

        $appointment->update([
            'start_time' => $start_time,
            'end_time' => $end_time,
            'staff_id' => $request->staff_id,
            'status' => 'pending', // Reset to pending if rescheduled? Or keep confirmed? Let's keep existing status or reset to pending if major change. For now, keep as is or set to pending. Let's set to pending to be safe.
        ]);

        // Notify Admin
        $admin = \App\Models\User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new \App\Notifications\AppointmentRescheduled($appointment));
        }

        // Notify User
        $appointment->user->notify(new \App\Notifications\AppointmentRescheduled($appointment));

        return redirect()->route('appointments.index')->with('success', 'Appointment rescheduled successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    /**
     * Cancel the specified appointment.
     * 
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Appointment $appointment)
    {
        // Ensure the authenticated user owns the appointment
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow cancellation if status is pending or confirmed
        if (!in_array($appointment->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'You cannot cancel an appointment that is already ' . $appointment->status . '.');
        }

        $appointment->update(['status' => 'cancelled']);

        return back()->with('success', 'Appointment cancelled successfully.');
    }
}
