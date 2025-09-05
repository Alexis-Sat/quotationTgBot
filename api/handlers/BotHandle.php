<?php

namespace api\handlers;

use api\interfaces\DataToSendInterface;
use api\interfaces\QuotationServiceInterface;
use api\interfaces\SendMessageServiceInterface;
use api\interfaces\TranslationServiceInterface;
use api\interfaces\WebMethodInterface;
use api\services\ByCurl;
use api\services\QuotationService;
use api\services\SendMessageService;
use api\services\TgBotData;
use api\services\TranslationService;

class BotHandle
{
    /**
     * @var TranslationServiceInterface|TranslationService
     */
    protected TranslationServiceInterface $translationService;
    /**
     * @var QuotationServiceInterface|QuotationService
     */
    protected QuotationServiceInterface $quotationService;
    /**
     * @var SendMessageServiceInterface|SendMessageService
     */
    protected SendMessageServiceInterface $messageService;
    /**
     * @var WebMethodInterface|ByCurl
     */
    protected WebMethodInterface $webMethod;
    /**
     * @var DataToSendInterface|TgBotData
     */
    protected DataToSendInterface $dataToSend;

    /**
     *
     */
    public function __construct()
    {
        $this->webMethod = new ByCurl();
        $this->dataToSend = new TgBotData();
        $this->translationService = new TranslationService($this->webMethod);
        $this->quotationService = new QuotationService($this->webMethod);
        $this->messageService = new SendMessageService($this->webMethod, $this->dataToSend);
    }

    /**
     * @return string
     */
    public function handle(): string
    {
        try {
            $rawText = $this->quotationService->getQuotation();

            $translatedText = $this->translationService->translateText($rawText);

            $sender = $this->messageService->send($translatedText);

             return json_encode(['status' => 'success', 'message' =>  $sender], JSON_PRETTY_PRINT);

        } catch (\Exception $exception) {
            return json_encode(['status' => 'error', 'message' => 'Data error: ' . $exception->getMessage()], JSON_PRETTY_PRINT);

        }
    }


}