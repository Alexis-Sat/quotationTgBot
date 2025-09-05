<?php

namespace api\services;

class Config
{
    protected array $config;
    public static Config $instance;

    private function __construct()
    {
        $this->config = require __DIR__ . '/../../config/config.php';
    }


    public static function getInstance(): Config
    {
       return self::$instance ?? new self();
    }

    public function get(string $key): string|null
    {
        return $this->config[$key] ?? null;
    }

}