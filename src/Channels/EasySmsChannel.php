<?php

namespace Vance\LaravelNotificationEasySms\Channels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Vance\LaravelNotificationEasySms\Exceptions\CouldNotSendNotification;

class EasySmsChannel
{
    /**
     * Send the given notification.
     *
     * @param $notifiable
     * @param Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        if ($notifiable instanceof Model) {
            $to = $notifiable->routeNotificationForEasySms($notification);
        } elseif ($notifiable instanceof AnonymousNotifiable) {
            $to = $notifiable->routes[__CLASS__];
        }

        $message = $notification->toEasySms($notifiable);

        try {
            app()->make('easysms')->send($to, $message);
        } catch (\Exception $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }
    }
}
