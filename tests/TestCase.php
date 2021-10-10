<?php

namespace Tests;

use App\EmailClient;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Dotenv\Dotenv;


class TestCase extends PHPUnitTestCase
{
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $dotenv = Dotenv::createImmutable(realpath(__DIR__.'/..'));
        $dotenv->load();
        $_ENV['APP_ENV'] = 'testing';
    }
}
