<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CurrencyOrder;

class NewOrderNotification extends Notification
{
    use Queueable;
    public CurrencyOrder $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(CurrencyOrder $order)
    {
        $this->order = $order;
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Currency Exchange Order',
            'message' => 'A new order has been placed.',
            'url' => url('exchange/requests'), // You can change this to the relevant route
            'location' => $this->order->location,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
