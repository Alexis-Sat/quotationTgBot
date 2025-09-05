<?php

namespace api\interfaces;

interface WebMethodInterface
{
    /**
     * @param string $url
     * @return string
     */
    public function get(string $url):string;

    /**
     * @param array $dataToSend
     * @param string $url
     * @return string
     */
    public function post(array $dataToSend, string $url):string;
}

