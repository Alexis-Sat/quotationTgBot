<?php

namespace api\interfaces;

interface QuotationServiceInterface
{
    /**
     * @return string|null
     */
    public function getQuotation():string|null;
}