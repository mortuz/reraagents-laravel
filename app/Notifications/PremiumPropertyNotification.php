<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;

class PremiumPropertyNotification extends Notification
{
    use Queueable;
    private $property;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($property)
    {
        $this->property = $property;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [ExpoChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toExpoPush($notifiable)
    {
        $title = explode('::', $this->property->features)[0];

        $raw_data = json_decode($this->property->raw_data);

        $description = substr($raw_data->details, 0, 150);
        return ExpoMessage::create()
            ->badge(1)
            ->enableSound()
            ->title($title)
            ->setChannelId('property-approval')
            ->setJsonData(['my_property' => true, 'property_id' => $this->property->id, 'action' => 'premium', 'description' => $description])
            ->body($description);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
