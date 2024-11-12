<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExportReadyNotification extends Notification
{
    use Queueable;

    public function __construct(protected string $file)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Exported Data is Ready')
            ->greeting('Hello,')
            ->line('The data export you requested is now ready for download.')
            ->line('Please find the exported file attached to this email.')
            ->attach($this->file);
    }
}
