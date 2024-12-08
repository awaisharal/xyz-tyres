<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Appointment;

class AppointmentConfirmation extends Notification
{
    use Queueable;
    protected $appointment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;  
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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Confirmation for Booking with ' . config('app.name') . '. PLEASE CHECK.')
            ->greeting('Hi ' . $this->appointment->customer->name . ',')
            ->line('Thank you for booking with us today! This is a confirmation of the appointment you just booked.')
            ->line('Your appointment is scheduled for ' . $this->appointment->date . ' at ' . $this->appointment->time . '.')
            ->line('You booked the following service: ' . $this->appointment->service->title)
            ->line('Please arrive at least 10 minutes before our meeting so that we can get settled in and help you fill out the additional paperwork.')
            ->line('Your details:')
            ->line('First Name: ' . $this->appointment->customer->name)
            ->line('Email: ' . $this->appointment->customer->email)
            ->line('If you want to view your appointment details, you can do so by visiting this link:')
            ->action('Manage Appointment', route('customer.appointments.index'))
            ->line('Kind regards,')
            ->line(config('app.name') . ' team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'service_title' => $this->appointment->service->title,
            'date' => $this->appointment->date,
            'time' => $this->appointment->time,
        ];
    }
}
