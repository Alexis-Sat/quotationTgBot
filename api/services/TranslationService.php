<?php

namespace api\services;

use api\interfaces\TranslationServiceInterface;
use api\interfaces\WebMethodInterface;

class TranslationService implements TranslationServiceInterface
{
    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @param WebMethodInterface $webMethod
     */
    public function __construct(protected WebMethodInterface $webMethod)
    {
        $this->config = Config::getInstance();

    }

    /**
     * @param string $text
     * @return string|null
     */
    private function getTranslationUrl(string $text): ?string
    {
        $isEnglish = $this->checkIfEnglish($text);

        if ($isEnglish) {
            $queryData = [
                'q' => $text,
                'langpair' => 'en|ru'
            ];

            $url = $this->config->get('translationUrl') . '?' . http_build_query($queryData);
        } else return null;

        return $url;
    }


    /**
     * @param string $textData
     * @return bool
     */
    private function checkIfEnglish(string $textData): bool
    {
        return boolval(preg_match('/[A-Za-z]/iu', $textData));
    }


    /**
     * @param string $response
     * @return string|null
     */
    public function transformResponse(string $response):?string
    {
        $data = json_decode($response, true);
        return $data['message']['responseData']['translatedText'] ?? null;
    }

    /**
     * @param string $text
     * @return string|null
     */
    public function translateText(string $text): ?string
    {
        $url = $this->getTranslationUrl($text);
        $response = $this->webMethod->get($url);

        return $this->transformResponse($response);
    }
}
