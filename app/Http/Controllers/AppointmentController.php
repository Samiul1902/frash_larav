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
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->with(['service', 'staff'])
            ->orderBy('start_time', 'desc')
            ->get();
            
        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = \App\Models\Branch::all();
        $services = Service::all();
        $staff = Staff::where('is_active', true)->get();
        return view('appointments.create', compact('branches', 'services', 'staff'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'required|exists:staff,id',
            'appointment_date' => 'required|date|after:now',
            'appointment_time' => 'required',
            'payment_method' => 'required|in:cash,online',
        ]);

        $service = Service::findOrFail($request->service_id);
        
        // Combine date and time
        $start_time = Carbon::parse($request->appointment_date . ' ' . $request->appointment_time);
        $end_time = $start_time->copy()->addMinutes($service->duration_minutes);

        // Check availability (FR-3 Validation)
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

        // Notify Admins
        $admins = \App\Models\User::where('role', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\NewAppointment($appointment));

        // Redirect based on payment method
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
