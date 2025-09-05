<?php

namespace api\services;

use api\interfaces\WebMethodInterface;

class ByCurl implements WebMethodInterface
{

    /**
     * @param string $url
     * @return string
     */
    public function get(string $url): string
    {
        try{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, []);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $message = curl_exec($ch);
            if (curl_getinfo($ch, CURLINFO_RESPONSE_CODE) == 200) {
                $decoded = json_decode($message, true);
                return json_encode(['status' => 'success', 'message' => $decoded], JSON_PRETTY_PRINT);

            } else return json_encode(['status' => 'error', 'message' => 'Data error'], JSON_PRETTY_PRINT);

        } catch (\Exception $exception) {
            return json_encode(['status' => 'error', 'message' => 'Data error: ' . $exception->getMessage()], JSON_PRETTY_PRINT);
        }
    }

    /**
     * @param array $dataToSend
     * @param string $url
     * @return string
     */
    public function post(array $dataToSend, string $url): string
    {
        try{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataToSend);

            $message = curl_exec($ch);
            if (curl_getinfo($ch, CURLINFO_RESPONSE_CODE) == 200) {
                $decoded = json_decode($message, true);
                return json_encode(['status' => 'success', 'message' => $decoded], JSON_PRETTY_PRINT);
            } else return json_encode(['status' => 'error', 'message' => 'Data error'], JSON_PRETTY_PRINT);

        } catch (\Exception $exception) {
            return json_encode(['status' => 'error', 'message' => 'Data error: ' . $exception->getMessage()], JSON_PRETTY_PRINT);
        }
    }

}