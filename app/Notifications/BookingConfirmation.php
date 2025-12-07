<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmation extends Notification
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
                    ->subject('Appointment Confirmed')
                    ->greeting('Hello, ' . $notifiable->name . '!')
                    ->line('Your appointment has been successfully booked.')
                    ->line('Service: ' . $this->appointment->service->title)
                    ->line('Date: ' . $this->appointment->start_time->format('F d, Y'))
                    ->line('Time: ' . $this->appointment->start_time->format('h:i A'))
                    ->action('View Appointment', route('appointments.index'))
                    ->line('Thank you for choosing us!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
