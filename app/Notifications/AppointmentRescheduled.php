<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentRescheduled extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $appointment)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $role = $notifiable->role ?? 'user';
        $message = ($role === 'admin')
            ? 'Appointment rescheduled by ' . $this->appointment->user->name
            : 'Your appointment has been successfully rescheduled.';

        $link = ($role === 'admin')
            ? route('admin.appointments.index')
            : route('appointments.index');

        return [
            'message' => $message,
            'appointment_id' => $this->appointment->id,
            'link' => $link,
            'old_status' => 'pending', // or whatever we want to track
            'new_start_time' => $this->appointment->start_time,
        ];
    }
}
