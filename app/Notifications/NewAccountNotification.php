<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAccountNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $tempPassword;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $tempPassword, public string $loginUrl)
    {
        $this->tempPassword = $tempPassword;
        $this->loginUrl = $loginUrl;
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
            ->subject('Welcome to Jatro BPO - Your Account Credentials')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('An account has been created for you on the portal.')
            ->line('Here are your login credentials:')
            ->line('Login email: ' . $notifiable->email)
            ->line('Temporary password: ' . $this->tempPassword)
            ->action('Login Now', $this->loginUrl)
            ->line('For security reasons, you will be required to change this password upon your first login.')
            ->line('Thank you!');
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
