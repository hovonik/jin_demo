<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\VonageMessage;

class SendVerifySMS extends Notification
{
    public function __construct()
    {
    }

    public function via($notifiable): array
    {
        return ['vonage'];
    }

    public function toVonage($notifiable): VonageMessage
    {
        return (new VonageMessage())
            ->content("Ձեր վերիֆիկացիաի կոդն է {$notifiable->mobile_verify_code}")->unicode()->from('JINMOBILE');
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }

}
