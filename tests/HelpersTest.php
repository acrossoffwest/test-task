<?php

namespace Tests;

use App\Request;


class HelpersTest extends TestCase
{
    public function testDatetimetToCal()
    {
        $this->assertEquals('20211010T012349Z', datetime_to_cal('2021-10-10T01:23:49Z'));
    }
}
