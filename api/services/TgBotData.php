<?php
namespace api\services;

use api\enums\TgMethods;
use api\enums\TgParseMode;
use api\interfaces\DataToSendInterface;

class TgBotData implements DataToSendInterface
{
    protected Config $config;
    protected string $botChannel;

    public function __construct()
    {
        $this->config = Config::getInstance();
    }

    public function prepareDataToSend(string $data): array
    {
        $url = $this->prepareTgBotUrl();

        $dataToSend = [
            'chat_id' => $this->getBotChannel(),
            'text' => $this->formatTgBotMessage($data),
            'parse_mode' => TgParseMode::HTML->value
        ];

        return [
            'dataToSend' => $dataToSend,
            'url' => $url
        ];

    }

    private function prepareTgBotUrl(): string
    {
        return $this->config->get('tgBotUrl').$this->config->get('tgBotKey').TgMethods::SEND_TEXT->value;
    }


    private function getBotChannel():string
    {
      return $this->botChannel = $this->config->get('tgDefaultChannel');
    }

    private function formatTgBotMessage(string $text): string
    {
        $quote = explode('*', $text);
        return "<blockquote expandable>$quote[0]</blockquote><i>$quote[1]</i>";
    }

}