<?php

namespace api\services;

use api\interfaces\QuotationServiceInterface;
use api\interfaces\WebMethodInterface;

class QuotationService implements QuotationServiceInterface
{
    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @param WebMethodInterface $webMethod
     */
    public function __construct(protected WebMethodInterface $webMethod,)
    {
        $this->config = Config::getInstance();

    }

    /**
     * @return string|null
     */
    private function getQuotationUrl(): ?string
    {
        return $this->config->get('quotationUrl');
    }

    /**
     * @param string $response
     * @return string|null
     */
    private function transformResponse(string $response): ?string
    {
        $data = json_decode($response, true);
        return $data['message'][0]
            ? $data['message'][0]['q'] . '*' . $data['message'][0]['a']
            : null;
    }

    /**
     * @return string|null
     */
    public function getQuotation(): ?string
    {
        $url = $this->getQuotationUrl();
        $response = $this->webMethod->get($url);

        return $this->transformResponse($response);
    }
}
