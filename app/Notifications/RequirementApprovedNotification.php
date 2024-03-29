<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;

class RequirementApprovedNotification extends Notification
{
    use Queueable;

    private $requirement;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($requirement)
    {
        $this->requirement = $requirement;
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
        $title = 'Requirement id: ' . $this->requirement->id . ' is being worked by RERA Agents';

        $raw_data = json_decode($this->requirement->raw_data);

        $description = substr($raw_data->details, 0, 20);
        // dd( $notifiable->service);
        return ExpoMessage::create()
            ->badge(1)
            ->enableSound()
            ->title($title)
            ->setChannelId('requirement-approval')
            ->setJsonData(['my_requirement' => true, 'requirement_id' => $this->requirement->id, 'action' => 'approved', 'description' => $description])
            ->body($description);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // public function toArray($notifiable)
    // {
    //     return [
    //         //
    //     ];
    // }
}
