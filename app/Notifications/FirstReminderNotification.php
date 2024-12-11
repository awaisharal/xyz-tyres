<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FirstReminderNotification extends Notification implements ShouldQueue
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
     */
    public function via($notifiable)
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
            ->subject('Upcoming Appointment Reminder')
            ->greeting('Hi ' )
            ->line('This is a reminder for your upcoming appointment.')
            ->line('Service: ' . $appointment->service->title)
            ->line('Date: ' . $appointment->date)
            ->line('Time: ' . $appointment->time)
            ->line('Message: ' . 'testing mail')
            ->action('View Appointment', route('customer.appointments.index'))
            ->line('Thank you for choosing our service!');
    }
}
