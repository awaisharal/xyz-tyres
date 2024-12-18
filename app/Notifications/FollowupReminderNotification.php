<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FollowupReminderNotification extends Notification
{
    use Queueable;
    private $appointment;
    private $reminderMessage;

    /**
     * Create a new notification instance.
     */
    public function __construct($appointment, $reminderMessage)
    {
        $this->appointment = $appointment;
        $this->reminderMessage = $reminderMessage;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $appointment = $this->appointment;

        return (new MailMessage)
            ->subject('Follow-up Reminder')
            ->greeting('Hi ' )
            ->line('This is a follow-up reminder, You had an appointment with us.')
            ->line('Service: ' . $appointment->service->title)
            ->line('Date: ' . $appointment->date)
            ->line('Time: ' . $appointment->time)
            ->line('Message: ' . 'testing mail')
            ->action('View Appointment', route('customer.appointments.index'))
            ->line('Thank you for choosing our service!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    // public function toArray(object $notifiable): array
    // {
    //     return [
    //         //
    //     ];
    // }
}
