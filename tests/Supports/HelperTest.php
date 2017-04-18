<?php

namespace Alcon\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Alcon\Supports\Helper;

class HelperTest extends TestCase
{
    public $key = 'b9514c52-5363-4364-b73f-a2ec93ae6b34';

    public $url = "b=v1&a=v2&c=v3";

    public function testGetSign()
    {
        $client_sign = Helper::getSign($this->url, $this->key, true);

        $request_url = $this->url . "&sign={$client_sign}";

        $server_sign = Helper::getSign($request_url, $this->key, false);

        $this->assertEquals($client_sign, $server_sign);
    }
}
