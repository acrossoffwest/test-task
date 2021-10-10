<?php

namespace Tests;

use App\Application;
use App\Request;


class ApplicationTest extends TestCase
{
    public function testEmailSendByApplicationClass()
    {
        $__request = [
            'sendername' => 'Sender Name from Tests',
            'senderemail' => $_ENV['DEFAULT_EMAIL'],
            'eventtime' => time(),
            'eventname' => 'New event',
            'eventdescription' => 'New event description',
            'guestname' => 'Guest Name',
            'guestemail' => $_ENV['DEFAULT_EMAIL']
        ];
        $__server = [
            'REQUEST_METHOD' => 'POST',
            'SERVER_PROTOCOL' => 'HTTP/1.0'
        ];
        $request = new Request($__request, $__server);

        $app = new Application($request);

        $this->assertNull($app->process());
    }
}
