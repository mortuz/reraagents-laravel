<?php

namespace App\Notifications;

use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;
use Illuminate\Notifications\Notification;

class PropertyApprovedNotification extends Notification
{
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
        $title = 'Property id: ' . $this->property->id . ' Approved';

        $raw_data = json_decode($this->property->raw_data);

        $description = substr($raw_data->details, 0, 150);
        // dd( $notifiable->service);
        return ExpoMessage::create()
            ->badge(1)
            ->enableSound()
            ->title($title)
            ->setChannelId('property-approval')
            ->setJsonData(['my_property' => true, 'property_id' => $this->property->id, 'action' => 'approved', 'description' => $description])
            ->body($description);
    }

}
