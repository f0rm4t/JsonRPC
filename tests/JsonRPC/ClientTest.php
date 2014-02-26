<?php

namespace JsonRPC\Tests;

use JsonRPC\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{

    public function testInstance()
    {
        $this->assertTrue(class_exists('\\JsonRPC\\Client'));
    }

    public function testRequest()
    {
        $client   = new Client(RPC_URL);
        $response = $client->request(RPC_METHOD, json_decode(RPC_PARAMS, true));

        $this->assertInstanceOf('\\JsonRPC\\Client\\Response', $response);
    }

    /**
     * @expectedException \JsonRPC\Exception\Curl
     */
    public function testInvalidUrl()
    {
        $client = new Client('http://127.0.0.1:1234/foo/bar/rpc');
        $client->request('method.example');
    }

    public function testNotify()
    {
        $client   = new Client(RPC_URL);
        $response = $client->notify('method.example', ['foo' => 'bar']);

        $this->assertEmpty($response);
    }

}