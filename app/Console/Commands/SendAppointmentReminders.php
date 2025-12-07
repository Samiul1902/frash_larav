<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for appointments scheduled for tomorrow';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Find appointments starting between 24 hours from now
        // Let's say we want to remind exactly 24h before, or roughly for the next day.
        // Simple strategy: Specific time window tomorrow.
        // Better: Pending/Confirmed appointments start_time between now+23h and now+25h that haven't been reminded.
        
        $startWindow = \Carbon\Carbon::now()->addHours(23);
        $endWindow = \Carbon\Carbon::now()->addHours(25);
        
        $appointments = \App\Models\Appointment::with('user', 'service')
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereNull('reminded_at')
            ->whereBetween('start_time', [$startWindow, $endWindow])
            ->get();

        $count = 0;
        foreach ($appointments as $appointment) {
            $appointment->user->notify(new \App\Notifications\AppointmentReminder($appointment));
            $appointment->update(['reminded_at' => now()]);
            $count++;
        }

        $this->info("Sent {$count} appointment reminders.");
    }
}
