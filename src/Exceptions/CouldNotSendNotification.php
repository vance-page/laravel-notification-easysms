<?php

namespace Vance\LaravelNotificationEasySms\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($exception)
    {
        return $exception;
    }
}
