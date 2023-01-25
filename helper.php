<?php

use Curl\Curl;

class Helper
{
    public static function load()
    {
        require_once realpath(__DIR__ . '/vendor/autoload.php');

        //get env
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    }

    public static function curl()
    {
        $curl = new Curl();
        $curl->setHeader('apikey', $_ENV['TOKEN']);
        return $curl;
    }

    public static function checkEqual($currentVM, $ram, $processor)
    {
        if ($currentVM->memory == $ram && $currentVM->vcpu == $processor) {
            require_once 'API.php';

            API::startVM();

            throw new Exception(
                'Cannot modify VM because vcpu and RAM is not changing from initial value',
                500
            );
        }
    }
}
