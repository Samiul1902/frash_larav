<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentReminder extends Notification
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Appointment Reminder')
                    ->greeting('Hello, ' . $notifiable->name)
                    ->line('This is a reminder for your upcoming appointment.')
                    ->line('Service: ' . $this->appointment->service->title)
                    ->line('Time: Tomorrow at ' . $this->appointment->start_time->format('h:i A'))
                    ->action('View Details', route('appointments.index'))
                    ->line('We look forward to seeing you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Reminder: You have an appointment tomorrow for ' . $this->appointment->service->title,
            'appointment_id' => $this->appointment->id,
            'link' => route('appointments.index'),
        ];
    }
}
