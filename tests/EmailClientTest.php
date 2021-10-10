<?php

namespace Tests;

use App\EmailClient;
use Dotenv\Dotenv;


class EmailClientTest extends TestCase
{
    public function testEmailSend()
    {
        $client = new EmailClient();

        $this->assertTrue($client->sendEmail(
            $_ENV['DEFAULT_EMAIL'],
            'Sender Name from EmailClientTest',
            $_ENV['DEFAULT_EMAIL'],
            'Also I am',
            'Test',
            'Body',
            'storage/test.ics'
        ));
    }
}
