<?php

namespace JsonRPC\Tests\Client;

use JsonRPC\Client\Request;
use JsonRPC\Client\Notify;

class RequestTest extends \PHPUnit_Framework_TestCase
{

    public function testInstance()
    {
        $this->assertTrue(class_exists('\\JsonRPC\\Client\\Request'));
        $this->assertTrue((new Request('method.eaxmple')) instanceof Notify);
    }

    public function testJsonSerialization()
    {
        $id      = uniqid();
        $request = new Request('method.example', [], $id);
        $data    = json_decode(json_encode($request), true);

        $this->assertArrayHasKey('id', $data);
        $this->assertEquals($data['id'], $id);
    }

    public function testUniqId()
    {
        $request = new Request('method.example');
        $data    = json_decode(json_encode($request), true);

        $this->assertArrayHasKey('id', $data);
        $this->assertNotEmpty($data['id']);
    }

}