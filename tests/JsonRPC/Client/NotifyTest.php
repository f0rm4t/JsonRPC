<?php

namespace JsonRPC\Tests\Client;

use JsonRPC\Client\Notify;

class NotifyTest extends \PHPUnit_Framework_TestCase
{

    public function testInstance()
    {
        $this->assertTrue(class_exists('\\JsonRPC\\Client\\Notify'));
    }

    public function testJsonSerialization()
    {
        $method = 'method.example';
        $params = ['foo' => 'bar'];
        $notify = new Notify($method, $params);
        $data   = json_decode(json_encode($notify), true);

        $this->assertArrayHasKey('method', $data);
        $this->assertArrayHasKey('params', $data);
        $this->assertArrayHasKey('jsonrpc', $data);

        $this->assertEquals($data['method'], $method);
        $this->assertEquals($data['params'], $params);
        $this->assertEquals($data['jsonrpc'], '2.0');
    }

}