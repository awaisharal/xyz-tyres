<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Appointment;


class ShopkeeperConfirmation extends Notification
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
            ->subject('New Appointment Scheduled with ' . config('app.name'))
            ->greeting('Hi ' . $this->appointment->service->user->name . ',')
            ->line('A new appointment has been scheduled with you. Here are the details:')
            ->line('Appointment Date: ' . $this->appointment->date)
            ->line('Appointment Time: ' . $this->appointment->time)
            ->line('Service Booked: ' . $this->appointment->service->title)
            ->line('Customer Details:')
            ->line('Name: ' . $this->appointment->customer->name)
            ->line('Email: ' . $this->appointment->customer->email)
            ->line('*Phone:*' . $this->appointment->phone)
            ->line('Please ensure you are prepared and available for this appointment.')
            ->line('You can view and manage this appointment by visiting the link below:')
            ->action('View All Appointments', route('appointments'))
            ->line('Thank you for using our platform!')
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
