<?php

namespace Tests;

use App\Email\Client;


class EmailClientTest extends TestCase
{
    public function testEmailSend()
    {
        $client = new Client();

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
