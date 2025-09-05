<?php

namespace api\interfaces;

interface DataToSendInterface
{
    /**
     * @param string $data
     * @return array
     */
    public function prepareDataToSend(string $data):array;
}

