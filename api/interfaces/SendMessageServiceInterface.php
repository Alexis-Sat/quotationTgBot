<?php

namespace api\interfaces;

interface SendMessageServiceInterface
{
    /**
     * @param string $text
     * @return string
     */
    public function send(string $text):string;
}