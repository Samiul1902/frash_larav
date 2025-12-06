<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Staff;
use Carbon\Carbon;

class SlotController extends Controller
{
    /**
     * Calculate and return available time slots for a specific staff and date.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @fr FR-06: Slot Availability (Real-time Calculation)
     */
    public function index(Request $request)
    {
        // 1. Validate Parameters
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'staff_id' => 'required|exists:staff,id',
            'service_id' => 'required|exists:services,id',
        ]);

        $date = Carbon::parse($request->date);
        $staff = Staff::findOrFail($request->staff_id);
        $service = Service::findOrFail($request->service_id);

        // 2. Define Business Hours (Configurable)
        // Hardcoded: 10:00 AM - 08:00 PM
        $openTime = $date->copy()->setTime(10, 0, 0); 
        $closeTime = $date->copy()->setTime(20, 0, 0);

        // 3. Fetch Existing Appointments
        // FR-06: Check staff's calendar conflicts
        $appointments = Appointment::where('staff_id', $staff->id)
            ->whereDate('start_time', $date->toDateString())
            ->where('status', '!=', 'cancelled')
            ->get();

        $durationMinutes = $service->duration_minutes;
        $interval = 30; // Slots every 30 minutes

        $availableSlots = [];

        // 4. Generate & Filter Slots
        $currentSlot = $openTime->copy();

        while ($currentSlot->lt($closeTime)) {
            $slotStart = $currentSlot->copy();
            $slotEnd = $slotStart->copy()->addMinutes($durationMinutes);

            // A. Check if service exceeds business hours
            if ($slotEnd->gt($closeTime)) {
                break;
            }

            // B. Check for overlap with existing appointments
            $isOverlap = false;
            foreach ($appointments as $appointment) {
                $apptStart = Carbon::parse($appointment->start_time);
                $apptEnd = Carbon::parse($appointment->end_time);

                // Overlap: (StartA < EndB) and (EndA > StartB)
                if ($slotStart->lt($apptEnd) && $slotEnd->gt($apptStart)) {
                    $isOverlap = true;
                    break;
                }
            }
            
            // C. Check if slot is in the past (for today)
            if ($date->isToday() && $slotStart->lt(now())) {
                $isOverlap = true;
            }

            // D. Add valid slot
            if (!$isOverlap) {
                $availableSlots[] = $slotStart->format('H:i');
            }

            // Move to next interval
            $currentSlot->addMinutes($interval);
        }

        return response()->json([
            'slots' => $availableSlots,
            'message' => count($availableSlots) > 0 ? 'Slots available' : 'No slots available for this date'
        ]);
    }
}
