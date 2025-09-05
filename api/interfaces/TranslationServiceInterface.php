<?php

namespace api\interfaces;

interface TranslationServiceInterface
{
    /**
     * @param string $text
     * @return string|null
     */
    public function translateText(string $text):string|null;
}