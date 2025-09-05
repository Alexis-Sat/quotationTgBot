<?php

namespace api\services;

use api\interfaces\DataToSendInterface;
use api\interfaces\SendMessageServiceInterface;
use api\interfaces\WebMethodInterface;

class SendMessageService implements SendMessageServiceInterface
{
    public function __construct(
        protected WebMethodInterface $webMethod,
        protected DataToSendInterface $dataToSend
    )
    { }

    public function send(string $text): string
    {
        $dataToSend = $this->dataToSend->prepareDataToSend($text);

        return $this->webMethod->post($dataToSend['dataToSend'], $dataToSend['url']);
    }

}