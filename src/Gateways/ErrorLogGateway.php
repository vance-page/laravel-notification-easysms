<?php

namespace Vance\LaravelNotificationEasySms\Gateways;

use Illuminate\Support\Facades\Log;
use Overtrue\EasySms\Contracts\MessageInterface;
use Overtrue\EasySms\Contracts\PhoneNumberInterface;
use Overtrue\EasySms\Gateways\Gateway;
use Overtrue\EasySms\Support\Config;

class ErrorLogGateway extends Gateway
{
    /**
     * Send a short message.
     *
     * @param \Overtrue\EasySms\Contracts\PhoneNumberInterface $to
     * @param \Overtrue\EasySms\Contracts\MessageInterface     $message
     * @param \Overtrue\EasySms\Support\Config                 $config
     *
     * @return array
     */
    public function send(PhoneNumberInterface $to, MessageInterface $message, Config $config)
    {
        if (is_array($to)) {
            $to = implode(',', $to);
        }
        $message = sprintf(
            'to: %s | message: "%s"  | template: "%s" | data: %s',
            $to,
            $message->getContent($this),
            $message->getTemplate($this),
            json_encode($message->getData($this))
        );
        Log::channel($config->get('channel'))->error($message);

        return [];
    }
}
